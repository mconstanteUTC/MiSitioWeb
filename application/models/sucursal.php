<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sucursal extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }



    
    function consultarSucursalPorAdministrador($idAdministrador){
        
     $this->db->select('idSucursal,direccionSucursal');
     $this->db->from('sucursal');
     $this->db->join('administrador', 'sucursal.idAdministrador = administrador.idAdministrador');
     $this->db->where('sucursal.idAdministrador',$idAdministrador);
     $query = $this->db->get();     
     return $query -> row();
    }


    function consultarSucursalPorEmpleado($idEmpleado){        
     $this->db->select('sucursal.idSucursal,direccionSucursal');
     $this->db->from('sucursal');
     $this->db->join('empleado', 'sucursal.idSucursal =  empleado.idSucursal');
     $this->db->where('empleado.idEmpleado',$idEmpleado);
     $query = $this->db->get();     
     return $query -> row();
    }



}