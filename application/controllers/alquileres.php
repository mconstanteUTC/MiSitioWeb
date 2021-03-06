<?php 
class Alquileres extends CI_Controller{
 
    function __construct(){
        parent::__construct(); 
        $this->load->model('empleado');
        $this->load->model('alquiler');
        $this->load->model('detalle');
        $this->load->model('cliente');
        $this->load->model('libro');
        $this->load->model('promocion');

    }
     
   function index(){

     if($this->session->userdata('perfil')=='EMPLEADO') {
       
        $crud = new grocery_crud();        
        $crud->set_theme('datatables'); 
        $crud->set_table('alquiler'); 
        $crud->set_subject('Alquiler');
        $crud->where('alquiler.ID_SUC',  $this->session->userdata('idSucursal'));         
        $crud->columns('ID_ALQ','FECHA_ALQ','ESTADO_ALQ','ID_USU','ID_CLI');
        $crud->unset_export();
         $crud->unset_print();
        
       
       
       $crud->display_as('ID_CLI','Cliente');
       $crud->display_as('FECHA_ALQ','Fecha');
       $crud->display_as('ESTADO_ALQ','Estado');
       $crud->field_type('ESTADO_ALQ','dropdown',array('0' => 'En proceso', '1' => 'Finalizada'));
       $crud->unset_add();
       $crud->unset_edit();
       $crud->unset_read();
        $crud->unset_delete();
        
        $crud->display_as('ID_USU','Bibliotecaria');       
        $crud->set_relation('ID_USU','usuario','{NOMBRE_USU} {APELLIDO_USU}');
        $crud->set_relation('ID_CLI','cliente','{NOMBRE_CLI} {APELLIDO_CLI}');
        $output= $crud->render();
      
       $this->load->view('encabezado'); 
       $this->load->view('/alquileres/index',$output); 
       $this->load->view('pie'); 
         
     }else{
         
         redirect('/usuarios/login');
     }
    
    }
    
     function nuevo(){
      //setlocale(LC_ALL,"es_ES");
      $fecha=date('Y-m-d');
         if($this->session->userdata('perfil')=='EMPLEADO') {
         $ultimoAlquiler=$this->alquiler->consultarEstadoUltimoAlquiler($this->session->userdata('id'));
         $data['clientes']=$this->cliente->consultarClientes();
         $data['promociones']=$this->promocion->consultarPromociones();
         
       
        if($ultimoAlquiler){
            if($ultimoAlquiler->ESTADO_ALQ){
                $parametros=array(
                    "FECHA_ALQ" => $fecha,
                    "ID_USU" => $this->session->userdata('id'),
                    "ID_SUC" => $this->session->userdata('idSucursal')            
                );                 
                $alquiler=$this->alquiler->crearAlquiler($parametros); 
                $output=$this->cargarProductos($alquiler);
                $output->content_view='/alquileres/nueva'; 
                $data['alquiler']=$alquiler;
                $data['cliente']=$this->alquiler->consultarCliente($ultimoAlquiler->ID_ALQ);
                $data['total']=$this->detalle->consultarTotalPorAlquiler($alquiler->ID_ALQ);
                $data['promocion']=$this->alquiler->consultarPromocion($ultimoAlquiler->ID_ALQ);
                $output->data=$data;
                
            }else{
                $output=$this->cargarProductos($ultimoAlquiler);
                $output->content_view='/alquileres/nuevo'; 
                $data['alquiler']=$ultimoAlquiler;
                $data['cliente']=$this->alquiler->consultarCliente($ultimoAlquiler->ID_ALQ);
                $data['promocion']=$this->alquiler->consultarPromocion($ultimoAlquiler->ID_ALQ);
                $data['total']=$this->detalle->consultarTotalPorAlquiler($ultimoAlquiler->ID_ALQ);
                $output->data=$data;
            }
        }else{
          $parametros=array(
                "FECHA_ALQ" => $fecha,
                "ID_USU" => $this->session->userdata('id'),
                "ID_SUC" => $this->session->userdata('idSucursal')            
            ); 
                $alquiler=$this->alquiler->crearAlquiler($parametros); 
                $output=$this->cargarProductos($alquiler);
                $output->content_view='/alquileres/nuevo'; 
                $data['alquiler']=$alquiler;
                $data['total']=$this->detalle->consultarTotalPorAlquiler($alquiler->ID_ALQ);
                $data['cliente']=$this->alquiler->consultarCliente($alquiler->ID_ALQ);
          
                $output->data=$data;
        }
                                                                
       $this->load->view('encabezado'); 
       $this->load->view('/alquileres/nuevo',$output); 
       $this->load->view('pie'); 
         
     }else{
         redirect('/empleados/login');
     }
    
    }
    
    
    

       //Titulos
       $crud->display_as('DIAS_DET','Numero de Días');
       $crud->display_as('ID_LIB','Libro');
       $crud->display_as('NOMBRE_CLI','Nombre Cliente');
       $crud->display_as('APELLIDO_CLI','Apellido Cliente');
       $crud->set_relation('ID_LIB','libro','ID: VE_00{ID_LIB} - TIPO: {TIPO_LIB} - TITULO: {TITULO_LIB} - EDITORIAL: {EDITORIAL_LIB} - AÑO: {ANIO_LIB} - AUTOR: {AUTOR_LIB} - PAGINAS: {PAGINAS_LIB}  ',array('ID_SUC' => $this->session->userdata('idSucursal')));  
       return $crud->render();
    }

    function guardarCliente(){
        $data=array(
        'ID_CLI'=> $this->input->post('ID_CLI'),         
        );
       $id=$this->input->post('ID_ALQ');
       $this->alquiler->guardarCliente($data,$id);
       $this -> session -> set_flashdata('clienteGuardado','Datos del cliente guardados exitosamente!');
       redirect('/alquileres/nuevo');
     }
     
     function finalizarAlquiler($ID_ALQ){
        $data=array(
            'ESTADO_ALQ' => 1
        );
        
        $this->alquiler->finalizarAlquiler($data,$ID_ALQ);
         redirect('/alquileres/');
      }
    
    
    function consultarClase(){
       $data['clase']=$this->detalle->consultarMasSolicitado();
       $this->load->view('encabezado'); 
       $this->load->view('/alquileres/clase',$data); 
       $this->load->view('pie'); 
     }
    
      function consultarFechas(){
        $crud = new grocery_crud();        
        $crud->set_theme('datatables'); 
        $crud->set_table('alquiler'); 
        $crud->set_subject('Alquiler');
        //$crud->where('alquiler.ID_SUC',  $this->session->userdata('idSucursal'));         
        $crud->columns('ID_ALQ','FECHA_ALQ','ESTADO_ALQ','ID_USU','ID_CLI');
        $crud->unset_export();
        $crud->unset_print();        
       $crud->display_as('ID_CLI','Cliente');
       $crud->display_as('FECHA_ALQ','Fecha');
       $crud->display_as('ESTADO_ALQ','Estado');
       $crud->field_type('ESTADO_ALQ','dropdown',array('0' => 'En proceso', '1' => 'Finalizada'));
       $crud->unset_add();
       $crud->unset_edit();
       $crud->unset_read();
        $crud->unset_delete();
        
         $crud->display_as('ID_USU','Bibliotecaria');       
        $crud->set_relation('ID_USU','usuario','{NOMBRE_USU} {APELLIDO_USU}');
         $crud->set_relation('ID_CLI','cliente','{NOMBRE_CLI} {APELLIDO_CLI}');
        $output= $crud->render();
 
        $this->load->view('encabezado'); 
       $this->load->view('/alquileres/fecha',$output); 
       $this->load->view('pie'); 
        
        
    }
    
    
    public function  consultarMes(){
       $data['mes']=$this->alquiler->consultarMes();
       $this->load->view('encabezado'); 
       $this->load->view('/alquileres/mes',$data); 
       $this->load->view('pie'); 
      }
    
    
     public function  consultarSucursal(){
       $data['sucursal']=$this->alquiler->consultarSucursal();
       $this->load->view('encabezado'); 
       $this->load->view('/alquileres/sucursal',$data); 
       $this->load->view('pie'); 
        
        
    }
 }
?>
