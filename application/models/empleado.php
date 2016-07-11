<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empleado extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }




    
    function consultaEmpleado($data){
        $query = $this -> db -> get_where("empleado", $data);
        if($query -> num_rows() > 0)
        {
            return $query -> row();
        }else{
            return false;
        }
            
    }


}