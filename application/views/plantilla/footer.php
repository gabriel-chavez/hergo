<!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <strong>Sistema Diseñado por Luis Chavez y Willy Salas</strong> 
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Hergo Ltda.</a> Pruebas</strong> 
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- CARGANDO - MODAL ERROR CORRECTO -->
<div class="espera" id="cargando" style="display: none">
    <div class="centro">
        <img src="<?php echo base_url("assets/imagenes/loading_2.gif") ?> ">
    </div>
</div>
<div id="mensaje" style="display:none">
    <div class="centro">
        <div class="bloque">
            <div class="textocentrado">
           <!--     Correcto <span class="ok"><img src="<?php //echo base_url("assets/imagenes/ok.jpg") ?> "></span>-->
            </div>
        </div>
    </div>
</div>


<!--MODAL-->
<div id="modal_error" class="modal fade" role="dialog">
    <div class="modal-dialog" id="modaltamanio">
        
           <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>       
                <strong>ERROR!</strong><span class="mensaje_error"></span>
            </div>        
    </div>
</div>
<div id="modal_ok" class="modal fade" role="dialog">
    <div class="modal-dialog" id="modaltamanio">
        
           <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong>Correcto!</strong><span class="mensaje_ok"></span>
            </div>        
    </div>
</div>



</body>
</html>

