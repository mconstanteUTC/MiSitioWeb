<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehiculo extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }



    function consultarVehiculoPorId($idVehiculo){        
     //$this->db->select('descripcionProducto,precioProducto');
    $this->db->from('vehiculo');    
     $this->db->join("version","version.ID_VER=vehiculo.ID_VER");
     $this->db->where('ID_VEH',$idVehiculo);
     $query = $this->db->get();     
     return $query -> row();
    }
    
    
    
    
    function consultarVersionVehiculo(){    
        
        
     $this->db->join("version","version.ID_VER=vehiculo.ID_VER");     
     $query = $this->db->get("vehiculo");     
       if($query -> num_rows() > 0)
        {
            return $query;
        }else{
            return false;
        }
    }
    
    



}