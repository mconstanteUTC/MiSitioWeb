

<script>
    
function consultarMes(numeroMes){
        var meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        
        valor=parseInt(numeroMes);
       
        document.write(meses[valor-1]);
        
    }
    
    

</script>


<?php  if ($mes){ ?>


<div class="container">
    <div class="row well">
            
            <div class="col-md-12">
                
                <h3><b>Mes con mayor cantidad libros solicitados: </b>
                
                <?php 
                 
                  $partes= explode("-",$mes->FECHA_ALQ);                
                    
                ?>
                
                <script>
                    
                    consultarMes('<?php echo $partes[1]?>');
                    
                </script>
                
                
                
                </h3>
                
                <b>Cantidad Total de Alquileres: <?php  echo $mes->NUMERO; ?>  </b>
                
                
                
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







