<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ingresos_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set("America/La_Paz");
	}
	public function retornar_tabla($tabla)
	{
		$sql="SELECT * from $tabla";

		$query=$this->db->query($sql);
		return $query;
	}
    public function retornar_tablaMovimiento($tipo)
    {
        $sql="SELECT * from tmovimiento where operacion='$tipo'";

		$query=$this->db->query($sql);
		return $query;
    }
	public function mostrarIngresos($id=null,$ini=null,$fin=null,$alm="",$tin="")
	{
		if($id==null) //no tiene id de entrada 
        {
		  /*$sql="SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov, i.fechamov, p.nombreproveedor, i.nfact,
				(SELECT SUM(d.total) from ingdetalle d where  d.idIngreso=i.idIngresos) as total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, a.almacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio, tc.tipocambio valorTipoCambio, total*valorTipoCambio totalsus*/
            $sql="SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov, i.fechamov, p.nombreproveedor, i.nfact,
            SUM(id.total) total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, a.almacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio, tc.tipocambio valorTipoCambio, SUM(id.total)/tc.tipoCambio totalsus, t.sigla, a.ciudad

			FROM ingresos i
            INNER JOIN ingdetalle id
            on i.idingresos=id.idingreso
			INNER JOIN tmovimiento  t
			ON i.tipomov = t.id
			INNER JOIN provedores p
			ON i.proveedor=p.idproveedor
			INNER JOIN users u
			ON u.id=i.autor
			INNER JOIN almacenes a
			ON a.idalmacen=i.almacen
			INNER JOIN moneda m
			ON i.moneda=m.id
            INNER JOIN tipocambio tc
            ON i.tipocambio=tc.id
            WHERE DATE(i.fechamov) BETWEEN '$ini' AND '$fin' and i.almacen like '%$alm' and t.id like '%$tin'
            Group By i.idIngresos 
			ORDER BY i.nmov DESC
            ";
            
        }
        else
        {
            $sql="SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov,t.id as idtipomov, i.fechamov, p.nombreproveedor,p.idproveedor, i.nfact,
				SUM(id.total) total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, m.id as idmoneda, a.almacen, a.idalmacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio, tc.tipocambio valorTipoCambio, SUM(id.total)/tc.tipoCambio totalsus
			FROM ingresos i
            INNER JOIN ingdetalle id
            on i.idingresos=id.idingreso
			INNER JOIN tmovimiento  t
			ON i.tipomov = t.id
			INNER JOIN provedores p
			ON i.proveedor=p.idproveedor
			INNER JOIN users u
			ON u.id=i.autor
			INNER JOIN almacenes a
			ON a.idalmacen=i.almacen
			INNER JOIN moneda m
			ON i.moneda=m.id
            INNER JOIN tipocambio tc
            ON i.tipocambio=tc.id
            WHERE idIngresos=$id
			ORDER BY i.idIngresos DESC
            LIMIT 1
            ";
            

        }
        
		$query=$this->db->query($sql);
		return $query;
	}
    public function mostrarIngresosTraspasos($id=null,$ini=null,$fin=null,$alm="",$tin="")
    {
        if($id==null) //no tiene id de entrada
        {
          /*$sql="SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov, i.fechamov, p.nombreproveedor, i.nfact,
                (SELECT SUM(d.total) from ingdetalle d where  d.idIngreso=i.idIngresos) as total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, a.almacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio, tc.tipocambio valorTipoCambio, total*valorTipoCambio totalsus*/
            $sql="SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov, i.fechamov, p.nombreproveedor, i.nfact, 
            SUM(id.total) total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, a.almacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio, tc.tipocambio valorTipoCambio, SUM(id.total)/tc.tipoCambio totalsus, a1.almacen origen

            FROM ingresos i
            INNER JOIN ingdetalle id
            on i.idingresos=id.idingreso
            INNER JOIN tmovimiento  t
            ON i.tipomov = t.id
            INNER JOIN provedores p
            ON i.proveedor=p.idproveedor
            INNER JOIN users u
            ON u.id=i.autor
            INNER JOIN almacenes a
            ON a.idalmacen=i.almacen
            INNER JOIN moneda m
            ON i.moneda=m.id
            INNER JOIN tipocambio tc
            ON i.tipocambio=tc.id
              INNER JOIN traspasos t1
              ON t1.idIngreso=i.idIngresos
              INNER JOIN egresos e
              ON t1.idEgreso=e.idegresos
              INNER JOIN almacenes a1
              ON a1.idalmacen=e.almacen
            WHERE DATE(i.fechamov) BETWEEN '$ini' AND '$fin' and i.almacen like '%$alm' and t.id like '%$tin'
            Group By i.idIngresos 
            ORDER BY i.idIngresos DESC
            ";
            
        }
        else
        {
            $sql="SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov,t.id as idtipomov, i.fechamov, p.nombreproveedor,p.idproveedor, i.nfact,
                SUM(id.total) total as total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, m.id as idmoneda, a.almacen, a.idalmacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio, tc.tipocambio valorTipoCambio, SUM(id.total)/tc.tipoCambio totalsus
            FROM ingresos i
            INNER JOIN ingdetalle id
            on i.idingresos=id.idingreso
            INNER JOIN tmovimiento  t
            ON i.tipomov = t.id
            INNER JOIN provedores p
            ON i.proveedor=p.idproveedor
            INNER JOIN users u
            ON u.id=i.autor
            INNER JOIN almacenes a
            ON a.idalmacen=i.almacen
            INNER JOIN moneda m
            ON i.moneda=m.id
            INNER JOIN tipocambio tc
            ON i.tipocambio=tc.id
            WHERE idIngresos=$id
            ORDER BY i.idIngresos DESC
            LIMIT 1
            ";
        }
        
        $query=$this->db->query($sql);
        return $query;
    }
    public function mostrarIngresosDetalle($id=null,$ini=null,$fin=null,$alm="",$tin="")
    {       
        $sql="SELECT *
                FROM (SELECT i.nmov n,i.idIngresos, i.fechamov, p.nombreproveedor, i.nfact, CONCAT(u.first_name,' ', u.last_name) autor, i.fecha,t.tipomov,a.almacen, m.sigla monedasigla, i.ordcomp,i.ningalm FROM ingresos i INNER JOIN tmovimiento t ON i.tipomov = t.id INNER JOIN provedores p ON i.proveedor=p.idproveedor INNER JOIN users u ON u.id=i.autor INNER JOIN almacenes a ON a.idalmacen=i.almacen INNER JOIN moneda m ON i.moneda=m.id WHERE DATE(i.fechamov) BETWEEN '$ini' AND '$fin' and i.almacen like '%$alm' and t.id like '%$tin' ORDER BY i.idIngresos DESC) tabla
                INNER JOIN ingdetalle id
                ON tabla.idIngresos=id.idIngreso
                INNER JOIN articulos ar
                ON ar.idArticulos=id.articulo                
                ";
    
        $query=$this->db->query($sql);
        return $query;
    }
	public function mostrarDetalle($id)
	{
		$sql="SELECT a.CodigoArticulo, a.Descripcion, i.cantidad,i.totaldoc, i.punitario punitario, i.total total, u.Unidad
		FROM ingdetalle i
		INNER JOIN articulos a
		ON i.articulo = a.idArticulos
        INNER JOIN unidad u
        on u.idUnidad = a.idUnidad
        WHERE idIngreso=$id
        ORDER BY a.CodigoArticulo";
		$query=$this->db->query($sql);
		return $query;
	}
	public function editarestado_model($d, $id)
	{
		$sql="UPDATE ingresos SET estado='$d'WHERE idIngresos=$id";
		$query=$this->db->query($sql);
		return $query;
	}
	public function esTraspaso($id)
    {
        $sql="SELECT * FROM ingresos where idIngresos=$id"; 
        //die($sql)       ;
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $fila=$query->row();
            if($fila->tipomov==3)
                return $fila;
            else
                return false;
        }
        else
        {

            return false;
        }        
    }
    public function retornarArticulosBusqueda($b)
    {
		$sql="SELECT a.CodigoArticulo, a.Descripcion, u.Unidad
        FROM articulos a
        INNER JOIN unidad u
        ON a.idUnidad=u.idUnidad
        where CodigoArticulo like '$b%' 
        ORDER By CodigoArticulo asc
        limit 5
        ";
        //where CodigoArticulo like '$b%' or Descripcion like '$b%' ORDER By CodigoArticulo asc
		
		$query=$this->db->query($sql);
		return $query;
    }
    public function retornarArticulos()
    {
        $sql="SELECT a.CodigoArticulo, a.Descripcion, u.Unidad
        FROM articulos a
        INNER JOIN unidad u
        ON a.idUnidad=u.idUnidad       
        ";
        //where CodigoArticulo like '$b%' or Descripcion like '$b%' ORDER By CodigoArticulo asc
        
        $query=$this->db->query($sql);
        return $query;
    }
     public function retornarClienteBusqueda($b)
    {
        $sql="SELECT *
        FROM clientes a        
        where nombreCliente like '$b%' or documento like '$b%' ORDER By nombreCliente asc";
        
        $query=$this->db->query($sql);
        return $query;
    }
    public function retornarcostoarticulo_model($id,$idAlmacen)
    {
        // quitar desc de la consulta para los ultimos datos de la tabla costoarticulo
        $sql="SELECT c.*
            FROM costoarticulos c
            WHERE c.idArticulo=$id AND c.idAlmacen=$idAlmacen
            ORDER By c.idtabla desc 
            limit 1 
            ";
 
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {                   
            return $query;    
        }
        else
        {
            return false;
        }
        
    }
    public function guardarmovimiento_model($datos)
    {

		$almacen_imp=$datos['almacen_imp'];
        $tipomov_imp=$datos['tipomov_imp'];
     
    	$fechamov_imp=$datos['fechamov_imp'];
    	$moneda_imp=$datos['moneda_imp'];
    	$proveedor_imp=$datos['proveedor_imp'];
    	$ordcomp_imp=$datos['ordcomp_imp'];
    	$nfact_imp=$datos['nfact_imp'];
    	$ningalm_imp=$datos['ningalm_imp'];
        
    	$obs_imp=$datos['obs_imp'];
        $tipocambio=$this->retornarValorTipoCambio();
        $tipocambioid=$tipocambio->id;
        $tipocambiovalor=$tipocambio->tipocambio;
        
        $gestion= date("Y", strtotime($fechamov_imp));
       // echo $almacen_imp;
    	$autor=$this->session->userdata('user_id');
		$fecha = date('Y-m-d H:i:s');
        if(date("Y-m-d",strtotime($fecha))==$fechamov_imp) //si son iguales le agrega la hora
            $fechamov_imp=$fecha;            
        $nummov=$this->retornarNumMovimiento($tipomov_imp,$gestion,$almacen_imp);
    	$sql="INSERT INTO ingresos (almacen,tipomov,nmov,fechamov,proveedor,moneda,nfact,ningalm,ordcomp,obs,fecha,autor,tipocambio) 
        VALUES('$almacen_imp','$tipomov_imp','$nummov',STR_TO_DATE('$fechamov_imp','%d-%m-%Y, %h:%i:%s %p'),'$proveedor_imp','$moneda_imp','$nfact_imp','$ningalm_imp','$ordcomp_imp','$obs_imp','$fecha','$autor','$tipocambioid')";
    	$query=$this->db->query($sql);
    	$idIngreso=$this->db->insert_id();
        

    	if($idIngreso>0)/**Si se guardo correctamente se guarda la tabla*/
    	{            
    		foreach ($datos['tabla'] as $fila) {
    			//print_r($fila);
    			$idArticulo=$this->retornar_datosArticulo($fila[0]);
                $totalbs=$fila[6];
                $punitariobs=$fila[5];
                $totaldoc=$fila[4];
                if($moneda_imp==2) //convertimos en bolivianos si la moneda es dolares
                {
                    $totalbs=$totalbs*$tipocambiovalor;
                    $punitariobs=$punitariobs*$tipocambiovalor;
                    $totaldoc=$totaldoc*$tipocambiovalor;
                }
    			if($idArticulo)
    			{
    				$sql="INSERT INTO ingdetalle(idIngreso,nmov,articulo,moneda,cantidad,punitario,total,totaldoc) VALUES('$idIngreso','$nummov','$idArticulo','$moneda_imp','$fila[2]','$punitariobs','$totalbs','$totaldoc')";
    				$this->db->query($sql);

               /*     $costoArticulo=new stdclass();
                    
                    $costoArticulo->idArticulo=$idArticulo
                    $costoArticulo->idAlmacen=$almacen_imp;
                    $costoArticulo->cantidad=;
                    $costoArticulo->precioUnitario= calcular;
                    $costoArticulo->total=;
                    $costoArticulo->idEgresoDetalle= ;
                    $costoArticulo->idIngresoDetalle= ;
                    $costoArticulo->anulado= 0;*/
    			}
    		}
    		//return true;
            return $idIngreso;
    	}
    	else
    	{
    		return false;
    	}
    }
    public function actualizarmovimiento_model($datos)
    {
		$idingresoimportacion=$datos['idingresoimportacion'];
        $almacen_imp=$datos['almacen_imp'];
    	$tipomov_imp=$datos['tipomov_imp'];
    	$fechamov_imp=$datos['fechamov_imp'];
    	$moneda_imp=$datos['moneda_imp'];
    	$proveedor_imp=$datos['proveedor_imp'];
    	$ordcomp_imp=$datos['ordcomp_imp'];
    	$nfact_imp=$datos['nfact_imp'];
    	$ningalm_imp=$datos['ningalm_imp'];
    	$obs_imp=$datos['obs_imp'];

    	$autor=$this->session->userdata('user_id');
		$fecha = date('Y-m-d H:i:s');

        //$idtipocambio=$this->retornaridtipocambio($idingresoimportacion);
        $tipocambio=$this->retornarValorTipoCambio();
        $tipocambioid=$tipocambio->id;
        $tipocambiovalor=$tipocambio->tipocambio;
        //$sql="UPDATE ingresos SET almacen='$almacen_imp',tipomov='$tipomov_imp',fechamov='$fechamov_imp',proveedor='$proveedor_imp',moneda='$moneda_imp',nfact='$nfact_imp',ningalm='$ningalm_imp',ordcomp='$ordcomp_imp',obs='$obs_imp',fecha='$fecha',autor='$autor' where idIngresos='$idingresoimportacion'";
        $sql="UPDATE ingresos SET proveedor='$proveedor_imp',nfact='$nfact_imp',ningalm='$ningalm_imp',ordcomp='$ordcomp_imp',obs='$obs_imp',fecha='$fecha',autor='$autor' where idIngresos='$idingresoimportacion'";
    	$query=$this->db->query($sql);

        $sql="DELETE FROM ingdetalle where idIngreso='$idingresoimportacion'";

        $this->db->query($sql);
       /* echo "<pre>";
        print_r($datos['tabla']);
        echo "</pre>";*/
       // die($tipocambiovalor);
        foreach ($datos['tabla'] as $fila)
        {
            $idArticulo=$this->retornar_datosArticulo($fila[0]);
            if($idArticulo)
            {
               // $sql="INSERT INTO ingdetalle(idIngreso,articulo,moneda,cantidad,punitario,total) VALUES('$idingresoimportacion','$idArticulo','$moneda_imp','$fila[2]','$fila[3]','$fila[4]')";
                $totalbs=$fila[6];
                $punitariobs=$fila[5];
                $totaldoc=$fila[4];
                if($moneda_imp==2) //convertimos en bolivianos si la moneda es dolares
                {
                    $totalbs=$totalbs*$tipocambiovalor;
                   // echo $totalbs." ";
                    $punitariobs=$punitariobs*$tipocambiovalor;
                   // echo $punitariobs." ";
                    $totaldoc=$totaldoc*$tipocambiovalor;
                  //  echo $totaldoc." ";
                }
         
                $sql="INSERT INTO ingdetalle(idIngreso,nmov,articulo,cantidad,punitario,total,totaldoc) VALUES('$idingresoimportacion','0','$idArticulo','$fila[2]','$punitariobs','$totalbs','$totaldoc')";
                $this->db->query($sql);
            }
        }
        return true;

    }
    public function anularRecuperarMovimiento_model($datos,$anuladorecuperado)
    {
        $idingresoimportacion=$datos['idingresoimportacion'];
        //$almacen_imp=$datos['almacen_imp'];
        $tipomov_imp=$datos['tipomov_imp'];
        //$fechamov_imp=$datos['fechamov_imp'];
        $moneda_imp=$datos['moneda_imp'];
        $proveedor_imp=$datos['proveedor_imp'];
        $ordcomp_imp=$datos['ordcomp_imp'];
        $nfact_imp=$datos['nfact_imp'];
        $ningalm_imp=$datos['ningalm_imp'];
        $obs_imp=$datos['obs_imp'];
        $autor=$this->session->userdata('user_id');
        $fecha = date('Y-m-d H:i:s');
        $sql="UPDATE ingresos SET proveedor='$proveedor_imp',moneda='$moneda_imp',nfact='$nfact_imp',ningalm='$ningalm_imp',ordcomp='$ordcomp_imp',obs='$obs_imp',fecha='$fecha',autor='$autor', anulado='$anuladorecuperado', estado=0 where idIngresos='$idingresoimportacion'";
        $query=$this->db->query($sql);
        
        return true;

    }
    public function retornar_datosArticulo($dato)
    {
    	$sql="SELECT idArticulos from articulos where CodigoArticulo='$dato' LIMIT 1";

    	$query=$this->db->query($sql);
    	if($query->num_rows()>0)
    	{
    		$fila=$query->row();
    		return $fila->idArticulos;
    	}
    	else
    	{

    		return false;
    	}
    }
    public function retornarNumMovimiento($tipo,$gestion,$almacen)
    {
        $sql="SELECT nmov from ingresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        //echo $sql;
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->nmov)+1;
        }
        else
        {

            return 1;
        }
    }
    public function retornarTipoCambio()/*retorna el ultimo tipo de cambio ANTIGUO!!!!!**/
    {
        //$sql="SELECT nmov from ingresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        $sql="SELECT id from tipocambio ORDER BY id DESC LIMIT 1";

        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->id);
        }
        else
        {
            return 1;
        }
    }
    public function retornarValorTipoCambio($id=null)/*retorna el ultimo tipo de cambio*/
    {
        //$sql="SELECT nmov from ingresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        if($id==null)//si es null retorna el ultimo tipo de cambio
            $sql="SELECT * from tipocambio ORDER BY id DESC LIMIT 1";
        else//si no retorna segun el id
            $sql="SELECT * from tipocambio where id = '$id' ORDER BY id DESC LIMIT 1";
        //die($sql);
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila);
        }
        else
        {
            return 1;
        }
    }
    public function actualizartablacostoarticulo($idArticulo,$cantidad,$costou,$idalmacen)
    {
        $sql="INSERT INTO costoarticulos(idArticulo,idAlmacen,cantidad,precioUnitario) VALUES('$idArticulo','$idalmacen','$cantidad','$costou')";
        //die($sql);
        $this->db->query($sql);
    }
    public function retornaridtipocambio($id)
    {
        $sql="SELECT tipoCambio from ingresos where idIngresos=$id LIMIT 1";
        
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->tipoCambio);
        }
        else
        {
            return 0;
        }
    }
    public function retornarIngresosTabla($idIngreso)
    {
         $sql="SELECT * FROM ingdetalle WHERE idIngreso=$idIngreso";
 
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {                   
            return $query;    
        }
        else
        {
            return false;
        }
    }
     /*consulta procedure con parametros de salida @out_param*/
   /* public function retornarSaldo1($idArticulo,$idAlmacen)
    {
        $this->db->trans_start();

        $success = $this->db->query("call consultar_saldo1('idAlmacen','$idArticulo',@out_param);");
        $out_param_query = $this->db->query('select @out_param as out_param;');

        $this->db->trans_complete();

        if($out_param_query->num_rows()>0)
        {
            $fila=$out_param_query->row(); 
            return $fila->out_param;      
        }
        else
        {
            return 0;
        }

     
    }*/
    //retorna tabla
 /*   public function retornarSaldo2($idArticulo,$idAlmacen) 
    {
        $this->db->trans_start();
        $sql="call consultar_saldo1($idAlmacen,$idArticulo)";

        $success = $this->db->query($sql);       

        $this->db->trans_complete();
      
        if($success->num_rows()>0)
        {
            $fila=$success->row();             
            return $fila;      
        }
        else
        {
            return false;
        }

    }*/
    public function retornarCosto($idArticulo) /*retorna tabla*/
    {
        /***************************/
        /*** LLAMAR PROCEDIMIENTO**/
        /*YA NO ES NECESARIO POR AHORA*/
        /* $sql="call consultarCostoArticulo($idArticulo)";        
        $query= $this->db->query($sql);
        mysqli_next_result($this->db->conn_id);
        if($query->num_rows()>0)
        {
            $fila=$query->row();             
            return $fila;      
        }
        else
        {
            return false;
        }*/
        /*********************************/
        $sql="SELECT costoPromedioPonderado from articulos where idArticulos=$idArticulo LIMIT 1";        
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->costoPromedioPonderado);
        }
        else
        {
            return 0;
        }
        
    }
    public function retornarSaldo($idArticulo,$idAlmacen) /*retorna tabla*/
    {
        /***************************/
        /*** LLAMAR PROCEDIMIENTO**/
        /*YA NO ES NECESARIO POR AHORA*/
      /*  $this->db->trans_start();
        $sql="call consultarSaldoArticulo($idArticulo,$idAlmacen)";

        $success = $this->db->query($sql);       

        $this->db->trans_complete();
      
        if($success->num_rows()>0)
        {
            $fila=$success->row();             
            return $fila;      
        }
        else
        {
            return false;
        }*/

        /*$sql="call consultarSaldoArticulo($idArticulo,$idAlmacen)";
        $query= $this->db->query($sql);
        mysqli_next_result($this->db->conn_id);
        if($query->num_rows()>0)
        {
            $fila=$query->row();             
            return $fila;      
        }
        else
        {
            return false;
        }*/
        $sql="SELECT saldo from saldoarticulos where idArticulo=$idArticulo and idAlmacen=$idAlmacen LIMIT 1";
        
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->saldo);
        }
        else
        {
            return 0;
        }
        
    }
    
}
