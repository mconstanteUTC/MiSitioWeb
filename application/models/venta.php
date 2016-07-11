<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Venta extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        
    }



//select * from venta,empleado where empleado.idEmpleado=2 and venta.idSucursal=empleado.idSucursal and venta.idEmpleado = empleado.idEmpleado and estadoVenta=0;    
//$this->db->select('id')->order_by('id','desc')->limit(1)->get('table_name')->row('id');
    function consultarEstadoUltimaVenta($idEmpleado){
        
        //$this->db->select('estadoVenta');
        $this->db->from('venta');
        $this->db->join('sucursal', 'venta.idSucursal =  sucursal.idSucursal');
        $this->db->join('empleado', 'venta.idEmpleado =  empleado.idEmpleado');    
        $this->db->where('empleado.idEmpleado',$idEmpleado);
        $this->db->order_by('idVenta','desc');
        $this->db->limit(1);    
        $query = $this->db->get(); 
        
        if($query -> num_rows() > 0)
        {
           return $query -> row();
        }else{
            return false;
        }
                  
        
        
    }
    
         function crearVenta($data){
        
         $parametros=array(
            "fechaVenta" => $data['fechaVenta'],
             "idEmpleado" => $data['idEmpleado'],
             "idSucursal" => $data['idSucursal']         
         );     
         
        $this -> db -> insert("venta",$parametros);
         
        $id=mysql_insert_id();
        
             $consulta=array(
                "idVenta" => $id
             );
       $query = $this -> db -> get_where("venta",$consulta );       
        
         return  $query ->row();
         
    }
    
    
    
    function guardarCliente($data,$idVenta){
        
        $this->db->where('idVenta', $idVenta);
        $this->db->update('venta', $data); 
        
    }
    
     function finalizarVenta($data,$idVenta){
        
        $this->db->where('idVenta', $idVenta);
        $this->db->update('venta', $data); 
        
    }

//SELECT * from sucursal,empleado,venta,ventaproducto,producto WHERE sucursal.idSucursal=venta.idSucursal and empleado.idEmpleado=venta.idEmpleado and venta.idVenta =ventaproducto.idVenta and producto.idProducto=ventaproducto.idProducto and venta.idVenta=26;
    function consultarDetalle($idVenta){
        
  $sql = "SELECT * from sucursal,empleado,venta,ventaproducto,producto WHERE sucursal.idSucursal=venta.idSucursal and empleado.idEmpleado=venta.idEmpleado and venta.idVenta =ventaproducto.idVenta and producto.idProducto=ventaproducto.idProducto and venta.idVenta=?"; 

        $query = $this->db->query($sql, array($idVenta));
                                  
        return $query->result();
        
    }


}