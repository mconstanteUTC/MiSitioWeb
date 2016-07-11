

<?php  if ($clase){ ?>


<div class="container">
    <div class="row well">
            
            <div class="col-md-12">
                
                <h3><b>Clase/Libro mas Solicitada: </b>
                
                <?php  echo $clase->DESCRIPCION_VER; ?> - Ha sido alquilado
                <?php  echo $clase->TOTAL; ?> dias.
                </h3>
                
                
            </div>
        
    </div>
</div>



<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>



<?php  }else{  ?>






<?php  } ?>