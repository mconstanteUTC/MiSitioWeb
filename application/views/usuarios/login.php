<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4"> </div>
        <div class="col-md-4 well">
            <h4 class="text-center"><b>ACCESO AL SISTEMA</b></h4>
            <h6 class="text-center"><b>Usuarios</b></h6>
            <?php
            if($this -> session -> flashdata("errorLogin")){
                echo '<div class="alert alert-danger">' . $this -> session -> flashdata("errorLogin").'</div>';
            }
            ?>
                             
                <?php
                
                $username=array(
                        'name'=>'USERNAME_USU',
                        'placelhoder' => 'Ingrese el username',
                        'id'=>'username',
                        'class'=>'form-control',
                        'autofocus' => 'autofocus',
                        'required'=>'required'
                );
            
               $password=array(
                        'name'=>'PASSWORD_USU',
                        'placelhoder' => 'Ingrese la contraseña',
                        'id'=>'password',
                        'class'=>'form-control',
                        'type'=>'password',
                        'required'=>'required'
                );
            
                $formulario=array(
                        'id'=>'formulario',
                        'class'=>'form-horizontal',
                        
                );
            
                
                $boton=array(
                    'class'=>'btn btn-primary',
                    'type'=>'submit',
                    'value'=>'Ingresar'
                );
        
             ?>
             
             <?php echo form_open('/usuarios/validarDatos',$formulario) ?> 
             
                   
            <?php echo form_label('Usuario:','username');?>          
            <?php echo form_input($username) ?>
           
            <br>
            <br>

                <?php echo form_label('Contraseña:','password');?> 
                <?php echo form_input($password) ?>

            <br>
            <center>
            <?php echo form_submit($boton); ?>
            </center>
            <?php echo form_close(); ?>
            
        </div>
        <div class="col-md-4"> </div>
    </div>
    
    <br>
    <br>
