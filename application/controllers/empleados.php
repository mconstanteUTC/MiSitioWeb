<?php 
class Empleados extends CI_Controller{
 
    function __construct(){
        parent::__construct(); 
        $this->load->model('empleado');
        $this->load->model('sucursal');

    }
     
   function index(){

     if($this->session->userdata('perfil')=='ADMINISTRADOR') {
        $crud = new grocery_crud();        
        $crud->set_theme('datatables'); 
        $crud->set_table('usuario'); 
        $crud->unset_export();
        $crud->unset_print(); 
        $crud->set_subject('Mis Clientes');

        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('ID_SUC','ID_PER','USERNAME_USU','PASSWORD_USU','NOMBRE_USU','APELLIDO_USU');
        $crud->columns('ID_SUC','ID_PER','USERNAME_USU','NOMBRE_USU','APELLIDO_USU');



       //Titulos
       $crud->display_as('NOMBRE_USU','Nombre');
       $crud->display_as('APELLIDO_USU','Apellido');
       $crud->display_as('ID_SUC','Sucursal');  
        $crud->display_as('ID_PER','Perfil');
       $crud->display_as('USERNAME_USU','Usuario');                
        $crud->display_as('PASSWORD_USU','Contraseña'); 
         $crud->set_relation('ID_SUC','sucursal','Ciudad: {CIUDAD_SUC}');
         $crud->set_relation('ID_PER','perfil','{DESCRIPCION_PER}');
        $crud->field_type('PASSWORD_USU', 'password');                
        $output = $crud->render();
        $this->load->view('encabezado'); 
        $this->load->view('/empleados/admin',$output); 
       $this->load->view('pie'); 
    
    
    }else{

            redirect('/usuarios/login');

        }

        

    }

  
 
}
?>