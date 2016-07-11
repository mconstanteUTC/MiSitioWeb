<html lang="es">
    <head>
        <title>Consecionario</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"> </script>
        <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"> </script>   
        <link rel=icon href='<?php  echo base_url('assets/img/logo.png'); ?>' sizes="16x16" type="image/png">
    </head>
<body  >

  <div class="container">
      <br>
      <div class="row">
          <div class="col-md-6 well">              
              <b style="font-size:25px;">Concecionario de Vehiculos</b> 
          </div>  
           <div class="col-md-6">     
           <?php if($this->session->userdata('sucursal')) { ?>

             <h5 class="pull-right well"><b>Sucursal (<?php echo $this->session->userdata('sucursal'); ?>)</b></h5> 

          <?php }else{ ?>

             <img src="<?php echo base_url('assets/img/tecnologia2.png'); ?>" alt="" class="pull-right" height="80px;">

          <?php }  ?>
          </div>     
      </div>
  </div>
  
  
  <nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url(); ?>">Inicio</a>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
     
    <?php  if ( $this->session->userdata('perfil')=="ADMINISTRADOR"){ ?>
          
    
 <li><a href="<?php echo site_url('/sucursales'); ?>">Sucursales</a></li>
    
 <li><a href="<?php echo site_url('/empleados'); ?>">Empleados</a></li>
     
<li><a href="<?php echo site_url('/versiones'); ?>">Versiones</a></li>
      
      
      
<li><a href="<?php echo site_url('/vehiculos/index'); ?>">Vehículos</a></li>
      
<li><a href="<?php echo site_url('/promociones'); ?>">Promociones</a></li>
      
      
      
<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
         
 Reportes<b class="caret"></b>
  
      </a>
        <ul class="dropdown-menu">
    
     <li><a href="<?php echo site_url('/alquileres/consultarClase'); ?>">Clase/Versión Más Solicitada</a></li>              
          <li><a href="<?php echo site_url('/alquileres/consultarFechas'); ?>">Ventas por Fechas</a></li>    
         
 <li><a href="<?php echo site_url('/alquileres/consultarMes'); ?>"> Mes con Mayor Cantidad de Alquileres </a></li>              
          <li><a href="<?php echo site_url('/alquileres/consultarSucursal'); ?>"> Sucursal que mas Vende </a></li>              
        </ul>
      </li>
    
    <?php }   ?>
     
     
     
     
 <?php  if ( $this->session->userdata('perfil')=="EMPLEADO"){ ?>
         
 <li><a href="<?php echo site_url('/clientes'); ?>">Clientes</a></li>
      
    <li><a href="<?php echo site_url('/alquileres'); ?>">Gestionar Alquiler de Vehiculos</a></li>
      
    
      <?php }   ?>
      
    </ul>

    <ul class="nav navbar-nav navbar-right">
    
      <?php  if ($this->session->userdata('username')){ ?>        

       <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
         <b><?php echo $this->session->userdata('perfil'); ?> CONECTADO:</b> <?php echo $this->session->userdata('nombre'); ?> <?php                echo $this->session->userdata('apellido'); ?> <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('/usuarios/cerrarsesion'); ?>">Salir del Sistema</a></li>              
        </ul>
      </li>


      <?php } else { ?> 

         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Ingresar al Sistema <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php  echo site_url('/usuarios/login'); ?>">Login</a></li>

                
          </ul>
        </li>

      <?php }  ?>


    </ul>
  </div>
</nav>


  