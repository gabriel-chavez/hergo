<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Almacen_model extends CI_Model
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
	public function agregarAlmacen_model($alm,$dir,$ciu,$enu)
	{
		
		$autor=$this->session->userdata('user_id');
		$fecha = date('Y-m-d H:i:s');
		$sql="INSERT INTO almacenes (almacen, direccion, ciudad, uso, autor, fecha) VALUES('$alm','$dir','$ciu',$enu,'$autor','$fecha')";
		$query=$this->db->query($sql);		
	}
	public function editarAlmacen_model($alm,$dir,$ciu,$enu,$cod)
	{
		$autor=$this->session->userdata('user_id');
		$fecha = date('Y-m-d H:i:s');
		$sql="UPDATE almacenes SET almacen='$alm', direccion='$dir', ciudad='$ciu', uso=$enu, autor='$autor', fecha='$fecha' WHERE idalmacen=$cod";
		$query=$this->db->query($sql);		
	}
}
