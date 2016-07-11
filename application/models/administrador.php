<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Administrador extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }




    
    function consultaUsuario($data){
        $query = $this -> db -> get_where("administrador", $data);
        if($query -> num_rows() > 0)
        {
            return $query -> row();
        }else{
            return false;
        }
            
    }


}