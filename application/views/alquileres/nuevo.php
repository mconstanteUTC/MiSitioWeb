
<!Doctype html>
 
<html lang="es">
 
  <head>
      <meta charset='utf8'>
    <title>Nueva</title> 
     <!-- Importamos las librerias de html de grocery_CRUD, de lo contrario no funcionará -->
     <?php 
        if(!empty($css_files) && !empty($js_files)):
        foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file ?>" />
        <?php endforeach; ?>
        <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file ?>"></script>
        <?php endforeach; ?>                
    <?php endif; ?>                     
     <link rel="stylesheet" href="<?php echo base_url('style.css'); //Esto generará http://localhost/style.css, dependiendo del valor colocado en el config.php ?>">
  </head>
 
  <body>  
     <div class="container well">
                    <div class="row">
                    
                    <div class="col-md-9">
                        
                        
                        <?php $clientes=$data['clientes']; ?>
                      
                        <form action="<?php echo site_url().'/alquileres/guardarCliente';?>" method="post">
                            <table class="table">
                                <tr>
                                    <td><b class="pull-left">Seleccione el cliente:</b></td>

                                    <td>
                                        <input type="hidden" name="ID_ALQ" value="<?php echo $data['alquiler']->ID_ALQ; ?>">
                                        <select name="ID_CLI" id="" class="form-control" required>
                                               <option value="">-- Seleccione --</option>
                                            <?php foreach($clientes->result() as $cli) { ?>                                
                                                   <?php echo '<option value="'.$cli->ID_CLI.'"> '.$cli->NOMBRE_CLI.' '.$cli->APELLIDO_CLI.' </option>'; ?>
                                            <?php }  ?>                                        
                                        </select>

                                    </td>
                                    <td><button class="btn btn-primary"> Guardar Cliente</button></td>                                                                    </tr>

                            </table>
                        </form>
                        
                    <?php  
                        if($this->session->flashdata('clienteGuardado')){

                      ?>
                        <div class="alert alert-success">

                            <b>Cliente Guardado Exitosamente</b>

                        </div>


                     <?php         
                        }
                    ?>
                        
                        <table class="table">
                            <tr>
                                <td class="alert-info"><b>Cliente:</b></td>
                                <td class="alert-info"  colspan="3"><?php if (isset($data['cliente']->NOMBRE_CLI)){ echo $data['cliente']->NOMBRE_CLI.' '.$data['cliente']->APELLIDO_CLI; } ?></td>
                            </tr>
                             <tr>
                                <td class="alert-info"><b>Telefono:</b></td>
                                <td class="alert-info" ><?php if (isset($data['cliente']->TELEFONO_CLI)){ echo $data['cliente']->TELEFONO_CLI; } ?></td>
                                <td class="alert-info"><b>RUC:</b></td>
                                <td class="alert-info"><?php if (isset($data['cliente']->RUC_CLI)){ echo $data['cliente']->RUC_CLI; } ?></td>
                            </tr>
                            <tr>
                               <td class="alert-info"><b>Direccion:</b></td>
                                <td class="alert-info" colspan="3"><?php if (isset($data['cliente']->DIRECCION_CLI)){ echo $data['cliente']->DIRECCION_CLI; } ?></td>                              
                            </tr>
                            
                        </table>
                        
                        
                        

       
                    </div>
                    

                   <div class="col-md-3 alert alert-warning text-center">
                            <br>
                           <h4> <b>Factura No. 000<?php echo $data['alquiler']->ID_ALQ
                    ; ?> </b></h4>
                           <b><?php echo $data['alquiler']->FECHA_ALQ; ?></b>           
                           <br><br><br>
                           
                       </div>
                   </div>
                   <div class="row">
                       
                    <!-- PROMOCIONES         -->
                        <?php $promociones=$data['promociones']; ?>
                      
                        <form action="<?php echo site_url().'/alquileres/guardarPromocion';?>" method="post">
                            <table class="table">
                                <tr>
                                    <td ><b class="pull-left">Seleccione una promocion:</b></td>

                                    <td>
                                        <input type="hidden" name="ID_ALQ" value="<?php echo $data['alquiler']->ID_ALQ; ?>">
                                        <select name="ID_PRO" id="" class="form-control" required>
                                               <option value="">-- Seleccione --</option>
                                            <?php foreach($promociones->result() as $pro) { ?>                                
                                                   <?php echo '<option value="'.$pro->ID_PRO.'"> '.$pro->DESCRIPCION_PRO.' </option>'; ?>
                                            <?php }  ?>                                        
                                        </select>

                                    </td>
                                    <td><button class="btn btn-success"> Guardar Promocion</button></td>                                                                    </tr>

                            </table>
                        </form>
                        
                    <?php  
                        if($this->session->flashdata('promocionGuardada')){

                      ?>
                        <div class="alert alert-success">

                            <b>Promocion Guardada Exitosamente</b>

                        </div>


                     <?php         
                        }
                    ?>
                        
                        <table class="table">
                            <tr>
                                <td class="alert-success"><b>Promocion Seleccionada:</b></td>
                                <td class="alert-success"><?php if (isset($data['promocion']->DESCRIPCION_PRO)){ echo $data['promocion']->DESCRIPCION_PRO; } ?></td>
                            </tr>
                            
                             <tr>
                                <td class="alert-success"><b>Porcentaje Descuento:</b></td>
                                <td class="alert-success"><?php if (isset($data['promocion']->DESCUENTO_PRO)){ echo $data['promocion']->DESCUENTO_PRO.'%'; } ?></td>
                            </tr>
  
                        </table>
                        
                        
                        

       
                    </div>
                       
                   </div>
            </div>
        </div>
 
       <div class="container">
                
     <div class="row well">
            
         <?php echo $output ?>
    </div>   
    
    
    <div class="row">
        <div class="col-md-6"></div>
        <div class="alert alert-success col-md-6">
            <div class="col-md-6">
               <button class="btn btn-success btn-block" onclick="location.reload();"><i class="glyphicon glyphicon-refresh"> </i> Calcular y Actualizar</button>
           </div>
            <div class="col-md-6">
                <div >
                          
                           SUBTOTAL: $.<?php echo $data['total']->total; ?> <br>
                           DESCUENTO: <?php if (isset($data['promocion']->DESCUENTO_PRO)){ 
                        echo    $data['total']->total*$data['promocion']->DESCUENTO_PRO/100;
                        
                        $data['total']->total=$data['total']->total-$data['total']->total*$data['promocion']->DESCUENTO_PRO/100;
                        
                        echo '<br>SUBTOTAL-DESC: $.'. $data['total']->total;
                        
                    }else{ echo '$. 0'; } ?>
                            <br>
                          IVA (12%): &nbsp; &nbsp; $.<?php echo $data['total']->total*0.12; ?> <br>
                          
                         
                        <b>TOTAL: &nbsp; &nbsp; $.<?php echo $data['total']->total*0.12+$data['total']->total; ?></b>    
                        
                                
                </div>
            </div>
            <br> <br> <br>
            
            
            <?php  $valor= $data['alquiler']->ID_ALQ; ?>
            
            <br><br>

            <a href="<?php echo site_url('/alquileres/finalizarAlquiler').'/'.$valor; ?>" class="btn btn-warning btn-block" onclick="return confirm('Esta seguro que desa finalizar el alquiler?');">  <i class="glyphicon glyphicon-check"> </i> Finalizar Venta</a>
        </div>        
    </div>

    
</div>
 
  </body>
 
</html>
  
 






    