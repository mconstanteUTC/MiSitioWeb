

<?php  if ($sucursal){ ?>


<div class="container">
    <div class="row well">
            
            <div class="col-md-12">
                
                <h3><b>Sucursal que mas vende: </b>                
                <?php  echo $sucursal -> CIUDAD_SUC; ?>                
                </h3>
                
                <b>
                Total: <?php  echo $sucursal -> NUMERO; ?> Ventas.
                </b>
                
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