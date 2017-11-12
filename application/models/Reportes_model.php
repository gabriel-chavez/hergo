<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reportes_model extends CI_Model  ////////////***** nombre del modelo 
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
	public function mostrarNEporFac($ini=null,$fin=null,$alm="") ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="SELECT e.nmov n,e.idEgresos,t.sigla, e.fechamov, c.nombreCliente, SUM(d.total) total,  e.estado,e.fecha, CONCAT(u.first_name,' ', u.last_name) autor, a.almacen, m.sigla monedasigla			FROM egresos e
			INNER JOIN egredetalle d
			ON e.idegresos=d.idegreso
			INNER JOIN tmovimiento t 
			ON e.tipomov = t.id 
			INNER JOIN clientes c 
			ON e.cliente=c.idCliente
			INNER JOIN users u 
			ON u.id=e.autor 
			INNER JOIN almacenes a 
			ON a.idalmacen=e.almacen 
			INNER JOIN moneda m 
			ON e.moneda=m.id 
            INNER JOIN tipocambio tc
            ON e.tipocambio=tc.id
			WHERE
			e.`estado`=0
			AND t.id = 7
			AND e.fechamov 
			BETWEEN '$ini' AND '$fin'
			AND e.almacen LIKE '%$alm'
			GROUP BY e.idegresos
			ORDER BY c.nombreCliente";
		
		$query=$this->db->query($sql);		
		return $query;
	}


}