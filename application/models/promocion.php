<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Promocion extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }


 
    
    
      function consultarPromociones(){
          $this->db->where("ESTADO_PRO",TRUE);
        $query = $this -> db -> get('promociones');
        if($query -> num_rows() > 0)
        {
            return $query;
        }else{
            return false;
        }
            
    }


}