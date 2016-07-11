<?php 
class Clientes extends CI_Controller{
 
    function __construct(){
        parent::__construct(); 
  

    }
     
   function index(){

     if($this->session->userdata('perfil')=='EMPLEADO') {
        $crud = new grocery_crud(); 
        $crud->unset_export();
        $crud->unset_print(); 
        $crud->set_theme('datatables'); 
        $crud->set_table('cliente'); 
        $crud->set_subject('Mis Clientes');

        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('NOMBRE_CLI','APELLIDO_CLI','DIRECCION_CLI','RUC_CLI','TELEFONO_CLI');
        $crud->columns('NOMBRE_CLI','APELLIDO_CLI','DIRECCION_CLI','RUC_CLI','TELEFONO_CLI');



       //Titulos
         
         
       $crud->display_as('NOMBRE_CLI','Nombre');
       $crud->display_as('APELLIDO_CLI','Apellido');
       $crud->display_as('DIRECCION_CLI','Direccion');  
        $crud->display_as('RUC_CLI','RUC');
       $crud->display_as('TELEFONO_CLI','Telefono');                
  

        $output = $crud->render();
        $this->load->view('encabezado'); 
        $this->load->view('/clientes/admin',$output); 
       $this->load->view('pie'); 
    
    
    }else{

            redirect('/usuarios/login');

        }
 }


}
?>