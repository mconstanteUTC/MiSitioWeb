<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detalle extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }


    //SELECT sum(precioProducto * cantidadVentaProducto) FROM ventaproducto WHERE idVenta=26;
    function consultarTotalPorAlquiler($idAlquiler){
        
        
        $this -> db ->select('sum(PRECIO_DET * DIAS_DET) as total');
        //$this->db->from('ventaproductos');
        $this->db->where('ID_ALQ',$idAlquiler);
        $query = $this->db->get('detalle');
        return $query->row();
        
   
    }
    
    
    function consultarMasSolicitado(){
     
        
  $sql = "SELECT SUM(DIAS_DET ) as TOTAL , DESCRIPCION_VER FROM detalle, vehiculo, version WHERE detalle.ID_VEH = vehiculo.ID_VEH AND vehiculo.ID_VER = version.ID_VER GROUP BY DESCRIPCION_DET ORDER BY SUM( DIAS_DET ) DESC LIMIT 1;"; 

        $query = $this->db->query($sql);
                                  
        return $query->row();
        
    }
     




}