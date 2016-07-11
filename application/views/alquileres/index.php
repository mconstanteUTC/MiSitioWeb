
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
    

    <div class="well">
        <b>LISTADO DE ALQUILERES</b>
		
		<a href="<?php echo site_url('/alquileres/nuevo
        '); ?> " class="btn btn-primary pull-right"> Gestionar Alquileres</a>		
		<br>
		<br>
		
		<div class="row">
		    
		    <?php echo $output; ?>
		    
		</div>
		
	    </div>

    </body>

</html>




