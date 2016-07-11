<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ventaproducto extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }


    //SELECT sum(precioProducto * cantidadVentaProducto) FROM ventaproducto WHERE idVenta=26;
    function consultarTotalPorVenta($idVenta){
        
        $this -> db ->select('sum(precioProducto * cantidadVentaProducto) as total');
        //$this->db->from('ventaproductos');
        $this->db->where('idVenta',$idVenta);
        $query = $this->db->get('ventaproducto');
        return $query->row();
   
    }
    
     




}