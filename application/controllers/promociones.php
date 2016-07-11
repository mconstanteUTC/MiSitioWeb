<?php 
class Promociones extends CI_Controller{
 
    function __construct(){
        parent::__construct();                    
    }
     
   function index(){

     if($this->session->userdata('perfil')=='ADMINISTRADOR') {
        $crud = new grocery_crud(); 
        $crud->unset_export();
        $crud->unset_print(); 
        $crud->set_theme('datatables'); 
        $crud->set_table('promociones'); 
        $crud->set_subject('Mis Promociones');        
        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('DESCRIPCION_PRO','ESTADO_PRO','DESCUENTO_PRO');
        $crud->columns('DESCRIPCION_PRO','ESTADO_PRO','DESCUENTO_PRO');

       //Titulos
       
       $crud->display_as('DESCRIPCION_PRO','Descripción');
       $crud->display_as('ESTADO_PRO','Activa');
       $crud->display_as('DESCUENTO_PRO','% Descuento');       
       //$crud->set_relation('idSucursal','sucursal','{direccionSucursal}');
        //$crud->field_type('office_id', 'hidden', $office_id);
       

        $output = $crud->render();
        $this->load->view('encabezado'); 
        $this->load->view('/promociones/admin',$output); 
       $this->load->view('pie'); 
    
    
    }else{

            redirect('/usuarios/login');

        }

        

    }

  
  


}
?>