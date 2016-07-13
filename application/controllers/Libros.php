<?php 
class Libros extends CI_Controller{
 
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
        $crud->set_table('libro'); //vehiculo
        $crud->set_subject('Libros');

        //Campos Obligatorios al momento de guardar/editar
        $crud->required_fields('ID_SUC','ID_VER','ANIO_LIB','TIPO_LIB','TITULO_LIB','EDITORIAL_LIB','AUTOR_LIB','PAGINAS_LIB','FOTO_LIB' );
        $crud->columns('ID_SUC','ID_VER','ANIO_LIB','TIPO_LIB','TITULO_LIB','EDITORIAL_LIB','AUTOR_LIB','PAGINAS_LIB');



       //Titulos
       $crud->display_as('ID_VER','Version');//Version
       $crud->display_as('ANIO_LIB','Año');
       $crud->display_as('ID_SUC','Sucursal');  
       $crud->display_as('ID_LIB','Libro');//Version
       $crud->display_as('TIPO_LIB','Tipo'); //Motor         
       $crud->display_as('TITULO_LIB','Titulo');  //Placa 
       $crud->display_as('EDITORIAL_LIB','Editorial');  //Marca  

      
       $crud->display_as('AUTOR_LIB','Autor'); //Color
        $crud->display_as('PAGINAS_LIB','Paginas');  //Accesorios
     
         
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
