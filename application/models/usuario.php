<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuario extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }


    function consultaUsuario($data){
        
        $this->db->join("perfil","perfil.id_per=usuario.id_per");
        $this->db->join("sucursal","sucursal.id_suc=usuario.id_suc");
        $query = $this -> db -> get_where("usuario", $data);
        if($query -> num_rows() > 0)
        {
            return $query -> row();
        }else{
            return false;
        }
            
    }

}