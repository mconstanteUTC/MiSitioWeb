<?php 
class Versiones extends CI_Controller{
 
    function __construct(){
        parent::__construct();                    
    }
     
   function index(){

     if($this->session->userdata('perfil')=='ADMINISTRADOR') {
        $crud = new grocery_crud();
        $crud->set_theme('datatables'); 
         $crud->unset_export();
        $crud->unset_print(); 
        $crud->set_table('version'); 
        $crud->set_subject('Versiones de Libros'); 
        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('DESCRIPCION_VER');
       
       //Titulos
        $crud->display_as('DESCRIPCION_VER','Descripción');
        $crud->display_as('PRECIO_VER','Precio');
        
        $output = $crud->render();
        $this->load->view('encabezado'); 
        $this->load->view('/versiones/admin',$output); 
       $this->load->view('pie'); 
    }else{

            redirect('/usuarios/login');

        }

    }
  
    
}
?>
