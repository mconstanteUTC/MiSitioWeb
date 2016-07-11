<?php 
class Vehiculos extends CI_Controller{
 
    function __construct(){
        parent::__construct(); 
        $this->load->model('empleado');
        $this->load->model('sucursal');

    }
     
   function index(){

     if($this->session->userdata('perfil')=='ADMINISTRADOR') {
        $crud = new grocery_crud();        
        $crud->set_theme('datatables');
         $crud->unset_export();
        $crud->unset_print(); 
        $crud->set_table('vehiculo'); 
        $crud->set_subject('Mis Vehículos');

        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('ID_SUC','ID_VER','ANIO_VEH','MOTOR_VEH','PLACA_VEH','MARCA_VEH','COLOR_VEH','ACCESORIOS_VEH','FOTO_VEH');
        $crud->columns('ID_SUC','ID_VER','ANIO_VEH','MOTOR_VEH','PLACA_VEH','MARCA_VEH','COLOR_VEH','ACCESORIOS_VEH');



       //Titulos
       $crud->display_as('ID_VER','Version');
       $crud->display_as('ANIO_VEH','Año');
       $crud->display_as('ID_SUC','Sucursal');  
       $crud->display_as('ID_VEH','Version');
       $crud->display_as('MOTOR_VEH','Motor');          
       $crud->display_as('PLACA_VEH','Placa');          
       $crud->display_as('MARCA_VEH','Marca'); 
       $crud->display_as('COLOR_VEH','Color'); 
       $crud->display_as('ACCESORIOS_VEH','Accesorios');
     
         
       $crud->set_relation('ID_SUC','sucursal','Ciudad: {CIUDAD_SUC}');
       $crud->set_relation('ID_VER','version','Descripcion. {DESCRIPCION_VER} - Precio: {PRECIO_VER}');       
         
       $crud->field_type('PASSWORD_USU', 'password');                
       $output = $crud->render();
       $this->load->view('encabezado'); 
       $this->load->view('/vehiculos/admin',$output); 
       $this->load->view('pie'); 
    
    
    }else{

            redirect('/usuarios/login');

        }

        

    }

  
 
}
?>