<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Alquiler extends CI_Model{
    function __construct (){
        parent :: __construct();
        
        $this->load->model('detalle');
        
    }


    function consultarEstadoUltimoAlquiler($idUsuario){
        
        //$this->db->select('estadoVenta');
        $this->db->from('alquiler');
        //$this->db->join('promociones', 'promociones.ID_PRO =  alquiler.ID_PRO');
        $this->db->join('usuario', 'usuario.ID_USU =  alquiler.ID_USU');    
      //  $this->db->join('cliente', 'alquiler.ID_CLI = cliente.ID_CLI');       
        $this->db->where('alquiler.ID_USU',$idUsuario);
        //$this->db->where('alquiler.ID_CLI != ','NULL',FALSE);
        $this->db->order_by('ID_ALQ','desc');
        $this->db->limit(1);    
       $query=  $this -> db -> get();
        if($query -> num_rows() > 0)
        {
           return $query -> row();
        }else{
            return false;
        }
                  
        
        
    }
    
    function consultarCliente($idAlquiler){
        $this->db->from('alquiler');
        $this->db->join('cliente', 'alquiler.ID_CLI = cliente.ID_CLI');    
        $this->db->where('alquiler.ID_ALQ',$idAlquiler);
        $query=  $this -> db -> get();
        if($query -> num_rows() > 0)
        {
           return $query -> row();
        }else{
            return false;
        }
               
    }
    
    
       function consultarPromocion($idAlquiler){
        $this->db->from('alquiler');
        $this->db->join('promociones', 'promociones.ID_PRO = alquiler.ID_PRO');    
        $this->db->where('alquiler.ID_ALQ',$idAlquiler);
        $query=  $this -> db -> get();
        if($query -> num_rows() > 0)
        {
           return $query -> row();
        }else{
            return false;
        }
               
    }
    
    function crearAlquiler($data){
        
         $parametros=array(
            "FECHA_ALQ" => $data['FECHA_ALQ'],
             "ID_USU" => $data['ID_USU'],
             "ID_SUC" => $data['ID_SUC']         
         );     
         
        $this -> db -> insert("alquiler",$parametros);
         
        $id=mysql_insert_id();
        
             $consulta=array(
                "ID_ALQ" => $id
             );
       $query = $this -> db -> get_where("alquiler",$consulta );       
        
         return  $query ->row();
         
    }
    
    
    
    function guardarCliente($data,$idAlquiler){
        
        $this->db->where('ID_ALQ', $idAlquiler);
        $this->db->update('alquiler', $data); 
        
    }
    
    
       function guardarPromocion($data,$idAlquiler){
        
        $this->db->where('ID_ALQ', $idAlquiler);
        $this->db->update('alquiler', $data); 
        
    }
     function finalizarAlquiler($data,$idAlquiler){
        
        $this->db->where('ID_ALQ', $idAlquiler);
        $this->db->update('alquiler', $data); 
        
    }

//SELECT * from sucursal,empleado,venta,ventaproducto,producto WHERE sucursal.idSucursal=venta.idSucursal and empleado.idEmpleado=venta.idEmpleado and venta.idVenta =ventaproducto.idVenta and producto.idProducto=ventaproducto.idProducto and venta.idVenta=26;
    function consultarDetalle($idVenta){
        
  $sql = "SELECT * from sucursal,usuario,alquiler,detalle,vehiculo,cliente WHERE cliente.ID_CLI=alquiler.ID_CLI and sucursal.ID_SUC=alquiler.ID_SUC and usuario.ID_USU=alquiler.ID_USU and alquiler.ID_ALQ =detalle.ID_ALQ and vehiculo.ID_VEH=detalle.ID_VEH and alquiler.ID_ALQ=?"; 

        $query = $this->db->query($sql, array($idVenta));
                                  
        return $query->result();
        
    }
    
    
    function consultarDescuento($idAlquiler){
        
        
        $sql = "select DESCUENTO_PRO from alquiler,promociones where alquiler.ID_PRO = promociones.ID_PRO and alquiler.ID_ALQ=?";                     $query = $this->db->query($sql, array($idAlquiler));                    
        return $query->row();

    }
   
        
        
    function consultarMes(){
        
        $sql = "SELECT COUNT( ID_ALQ ) AS NUMERO, FECHA_ALQ FROM alquiler GROUP BY MONTH( FECHA_ALQ ) ORDER BY COUNT( ID_ALQ ) DESC LIMIT 1";         $query = $this->db->query($sql);                    
        return $query->row();
        
    }
    
    
      function consultarSucursal(){
        
        $sql = "SELECT COUNT( ID_ALQ ) AS NUMERO, CIUDAD_SUC FROM alquiler,sucursal where alquiler.ID_SUC = sucursal.ID_SUC GROUP BY alquiler.ID_SUC ORDER BY COUNT( ID_ALQ ) DESC LIMIT 1";
        $query = $this->db->query($sql);                    
        return $query->row();
        
    }
  
    



}