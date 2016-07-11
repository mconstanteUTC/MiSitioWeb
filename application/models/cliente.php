<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cliente extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }




    
    function consultarCliente($data){
        $query = $this -> db -> get_where("cliente", $data);
        if($query -> num_rows() > 0)
        {
            return $query -> row();
        }else{
            return false;
        }
            
    }
    
    
      function consultarClientes(){
        $query = $this -> db -> get('cliente');
        if($query -> num_rows() > 0)
        {
            return $query;
        }else{
            return false;
        }
            
    }


}