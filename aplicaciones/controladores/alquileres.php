<?php 
class Alquileres extends CI_Controller{
 
    function __construct(){
        parent::__construct(); 
        $this->load->model('empleado');
        $this->load->model('alquiler');
        $this->load->model('detalle');
        $this->load->model('cliente');
        $this->load->model('vehiculo');
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
        $crud->add_action('imprimir', base_url().'/assets/img/impresora.png', '/alquileres/imprimirFactura');
       
       $crud->display_as('ID_ALQ','Factura No');
       $crud->display_as('ID_CLI','Cliente');
       $crud->display_as('FECHA_ALQ','Fecha');
       $crud->display_as('ESTADO_ALQ','Estado');
       $crud->field_type('ESTADO_ALQ','dropdown',array('0' => 'En proceso', '1' => 'Finalizada'));
       $crud->unset_add();
       $crud->unset_edit();
       $crud->unset_read();
        $crud->unset_delete();
        
        
        $crud->display_as('ID_USU','Vendedor');       
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
    
    function imprimirFactura($ID_ALQ){
        $this->load->library('pdf');
        $ventas = $this->alquiler->consultarDetalle($ID_ALQ);
        
        $v=$ventas[0];
        $this->pdf= new Pdf();
        
         $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Factura No.".$v->ID_ALQ);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
 
        $this->pdf->SetFont('Arial','B',11);
            $this->pdf->Cell(30);
            $this->pdf->Cell(120,10,utf8_decode($v->CIUDAD_SUC),0,0,'C');
            $this->pdf->Ln(7);
        
        $descuento=$this->alquiler->consultarDescuento($v->ID_ALQ);
        
        if($descuento){
             $this->pdf->Cell(30);
            $this->pdf->Cell(120,10,'Alquiler con el '.utf8_decode($descuento->DESCUENTO_PRO).'% de descuento',0,0,'C');
            $this->pdf->Ln(13);
        }
        
        
        $this->pdf->SetFillColor(200,200,200);
        
        $this->pdf->Ln(1);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(15,7,'Cliente: ',1,0,'R',1);
         $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(85,7,utf8_decode($v->NOMBRE_CLI).' '.utf8_decode($v->APELLIDO_CLI),1,0,'L',0);
         $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(17,7,utf8_decode('Teléfono: '),1,0,'R',1);
         $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(25,7,$v->TELEFONO_CLI,1,0,'L',0);
        $this->pdf->SetFont('Arial', 'B', 8 );
         $this->pdf->Cell(18,7,'Factura No.','1',0,'C','1');
        $this->pdf->SetFont('Arial', 'I', 10);
        $this->pdf->Cell(25,7,'000'.$v->ID_ALQ,'1',0,'C','0');
        $this->pdf->SetFont('Arial', 'B', 8);
        
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(15,7,utf8_decode('Dirección: '),1,0,'R',1);
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(85,7,utf8_decode($v->DIRECCION_CLI),1,0,'L',0);
        
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(17,7,utf8_decode('RUC/C.I.: '),1,0,'R',1);
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(25,7,$v->RUC_CLI,1,0,'L',0);
        $this->pdf->SetFont('Arial', 'B', 8);
         $this->pdf->Cell(18,7,'Fecha','1',0,'C','1');
        $this->pdf->SetFont('Arial', '', 8);
        
        $this->pdf->Cell(25,7,$v->FECHA_ALQ,'1',0,'C','0');
        $this->pdf->Ln(7);
        
        
 
 
        $this->pdf->Cell(15,7,'Cantidad','1',0,'C','1');
        $this->pdf->Cell(120,7,utf8_decode('Descripción'),1,0,'C','1');
        $this->pdf->Cell(25,7,'Precio(USD)','1',0,'C','1');
        $this->pdf->Cell(25,7,'Importe','1',0,'C','1');
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','',8);
 
        
        $iva=0;
        $total=0;
        foreach ($ventas as $venta) {
            // se imprime el numero actual y despues se incrementa el valor de $x en uno
          //  $this->pdf->Cell(15,5,$x++,'BL',0,'C',0);
            // Se imprimen los datos de cada alumno
            $this->pdf->Cell(15,5,$venta->DIAS_DET,1,0,'C',0);
            $this->pdf->Cell(120,5,$venta->DESCRIPCION_DET,1,0,'C',0);
            $this->pdf->Cell(25,5,'$. '.$venta->PRECIO_DET,1,0,'C',0);            
            $total+=$venta->PRECIO_DET*$venta->DIAS_DET;
            $this->pdf->Cell(25,5,'$. '.($venta->PRECIO_DET*$venta->DIAS_DET),1,0,'C',0);          
            //Se agrega un salto de linea
            $this->pdf->Ln(5);
            
           
        }
        
        
           
        if($descuento){
            
            $this->pdf->Cell(15,7,'','0',0,'C','');
            $this->pdf->Cell(120,7,'',0,0,'C','');
            $this->pdf->SetFont('Arial','B',8);
            $this->pdf->Cell(25,7,'Subtotal ','1',0,'C','1');
            
        
            $this->pdf->SetFont('Arial','',8);
            $this->pdf->Cell(25,7,'$. '.$total,'1',0,'C','0');
            $this->pdf->Ln(8);
            
            
            
            
            
            $this->pdf->Cell(15,7,'','0',0,'C','');
            $this->pdf->Cell(120,7,'',0,0,'C','');
            $this->pdf->SetFont('Arial','B',8);
            $this->pdf->Cell(25,7,'Descuento '.$descuento->DESCUENTO_PRO.'% ','1',0,'C','1');
                    
            $this->pdf->SetFont('Arial','',8);
            $this->pdf->Cell(25,7,'$. '.$total*$descuento->DESCUENTO_PRO/100,'1',0,'C','0');
            $this->pdf->Ln(8);
            
            
            
            
            
            
            
            $this->pdf->Cell(15,7,'','0',0,'C','');
            $this->pdf->Cell(120,7,'',0,0,'C','');
            $this->pdf->SetFont('Arial','B',8);
            $this->pdf->Cell(25,7,'S - D  ','1',0,'C','1');
            $total-=$total*$descuento->DESCUENTO_PRO/100;
            $this->pdf->SetFont('Arial','',8);
            $this->pdf->Cell(25,7,'$. '.$total,'1',0,'C','0');
            $this->pdf->Ln(8);
            
        }
           
        
            
            $iva=$total*0.12;
            $this->pdf->Cell(15,7,'','0',0,'C','');
            $this->pdf->Cell(120,7,'',0,0,'C','');
            $this->pdf->SetFont('Arial','B',8);
            $this->pdf->Cell(25,7,'IVA(12%)','1',0,'C','1');
            
        
            $this->pdf->SetFont('Arial','',8);
            $this->pdf->Cell(25,7,'$. '.$iva,'1',0,'C','0');
            $this->pdf->Ln(7);                
      
            $this->pdf->Cell(68,2,'________________________________________','0',0,'C','');
            $this->pdf->Cell(67,2,'________________________________________',0,0,'C','');
            
            $this->pdf->Ln(2);
            
            $this->pdf->Cell(68,7,'Recibi Conforme','0',0,'C','');
            $this->pdf->Cell(67,7,utf8_decode($v->NOMBRE_USU).' '.utf8_decode($v->APELLIDO_USU),0,0,'C','');
            $this->pdf->SetFont('Arial','B',8);
            $this->pdf->Cell(25,7,'TOTAL:','1',0,'C','1');
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->Cell(25,7,'$. '.($total+$iva),'1',0,'C','0');
            $this->pdf->Ln(7);
      
        $this->pdf->Output("comprobante_alquiler.pdf", 'I');
        
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
            $data['promocion']=$this->alquiler->consultarPromocion($alquiler->ID_ALQ);
                $output->data=$data;
            
        }
                                                                
       $this->load->view('encabezado'); 
       $this->load->view('/alquileres/nuevo',$output); 
       $this->load->view('pie'); 
         
     }else{
         redirect('/empleados/login');
     }
    
    }
    
    
    
    function cargarProductos($alquiler){
        
        $crud = new grocery_crud();  
        $crud->unset_export();
        $crud->unset_print();        
       //$crud->unset_operations();
        $crud->set_theme('datatables'); 
        $crud->set_table('detalle'); 
        $crud->set_subject('Vehiculo');
        $crud->where('ID_ALQ', $alquiler->ID_ALQ); 
        $crud->required_fields('DIAS_DET','ID_VEH');
        $crud->columns('DIAS_DET','DESCRIPCION_DET','PRECIO_DET','Importe');
        $crud->callback_column('Importe',array($this,'calcularImporte'));
        $crud->field_type('ID_ALQ', 'hidden', $alquiler->ID_ALQ); 
        $crud->field_type('DESCRIPCION_DET', 'hidden'); 
        $crud->field_type('PRECIO_DET', 'hidden'); 
       //Titulos
       $crud->display_as('DIAS_DET','Numero de Días');
       $crud->display_as('ID_VEH','Vehiculo');
       $crud->display_as('DESCRIPCION_DET','Concepto/Descripcion');
       $crud->display_as('PRECIO_DET','Precio');
      $crud->set_relation('ID_VEH','vehiculo','ID: VE_00{ID_VEH} - MARCA: {MARCA_VEH} - PLACA: {PLACA_VEH} - COLOR: {COLOR_VEH} - AÑO: {ANIO_VEH} - MOTOR: {MOTOR_VEH} ',array('ID_SUC' => $this->session->userdata('idSucursal')));  
        
       

       $crud->callback_before_insert(array($this,'consultarDescripcionPrecioVehiculo'));
      $crud->callback_before_update(array($this,'consultarDescripcionPrecioVehiculo'));
        
        return $crud->render();
    }

    
    function calcularImporte($value,$row)
    {
        
        return '$. '.$row->DIAS_DET*$row->PRECIO_DET;
    }
    
    function consultarDescripcionPrecioVehiculo($post_array) {
        $vehiculo=$this->vehiculo->consultarVehiculoPorId($post_array['ID_VEH']);
        $post_array['DESCRIPCION_DET']=$vehiculo->PLACA_VEH;
        $post_array['PRECIO_DET']=$vehiculo->PRECIO_VER;
        return $post_array;
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
    
    
    
       function guardarPromocion(){
        
         $data=array(
        'ID_PRO'=> $this->input->post('ID_PRO'),         
        );
 
        
        $id=$this->input->post('ID_ALQ');
        
       $this->alquiler->guardarPromocion($data,$id);
        
        $this -> session -> set_flashdata('promocionGuardada','Datos de la promocion seleccionada exitosamente!');
        
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
       
       $crud->display_as('ID_ALQ','Factura No');
       $crud->display_as('ID_CLI','Cliente');
       $crud->display_as('FECHA_ALQ','Fecha');
       $crud->display_as('ESTADO_ALQ','Estado');
       $crud->field_type('ESTADO_ALQ','dropdown',array('0' => 'En proceso', '1' => 'Finalizada'));
       $crud->unset_add();
       $crud->unset_edit();
       $crud->unset_read();
        $crud->unset_delete();
        
        
        $crud->display_as('ID_USU','Vendedor');       
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
