<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Producto extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }





    function consultarProductoPorId($idProducto){        
     $this->db->select('descripcionProducto,precioProducto');
     $this->db->from('producto');     
     $this->db->where('idProducto',$idProducto);
     $query = $this->db->get();     
     return $query -> row();
    }



}