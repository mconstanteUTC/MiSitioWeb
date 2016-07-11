<?php 
class Sucursales extends CI_Controller{
 
    function __construct(){
        parent::__construct();                    
    }
     
   function index(){

     if($this->session->userdata('perfil')=='ADMINISTRADOR') {
        $crud = new grocery_crud();
        $crud->set_theme('datatables');
         $crud->unset_export();
        $crud->unset_print(); 
        $crud->set_table('sucursal'); 
        $crud->set_subject('Mis Sucursales'); 
        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('NOMBRE_SUC','CIUDAD_SUC','NUMERO_SUC');
         $crud->columns('NOMBRE_SUC','CIUDAD_SUC','NUMERO_SUC');
       $crud->field_type('ID_VEH', 'hidden', 0); 
       //Titulos
        $crud->display_as('NOMBRE_SUC','Nombre');
        $crud->display_as('CIUDAD_SUC','Ciudad');
        $crud->display_as('NUMERO_SUC','Número');
        $crud->columns('NOMBRE_SUC','CIUDAD_SUC');
        $output = $crud->render();
        $this->load->view('encabezado'); 
        $this->load->view('/sucursales/admin',$output); 
       $this->load->view('pie'); 
    }else{

            redirect('/usuarios/login');

        }

    }
  
    
}
?>