<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  //iniciamos las variables de session
  session_start();

  if(!isset($_SESSION["nombre"]))
  {
    header("Location: login.html");
  }

  else  //Agrega toda la vista
  {
    require 'header.php';

    if($_SESSION['noticias'] == 1)
    {

?>

  <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">        
          <!-- Main content -->
          <section class="content">
              <div class="row">
                <div class="col-md-12">
                    <div class="box">
                      <div class="box-header with-border">
                            <h1 class="box-title">Internos 
                              <button class="btn btn-success"  id="btnagregar" onclick="mostrarform(true);limpiar();">
                                <i class="fa fa-plus-circle"></i> 
                                Agregar
                              </button>
                           
                            </h1>
                          <div class="box-tools pull-right">
                          </div>
                      </div>
                      <!-- /.box-header -->
                      <!-- centro -->
                      <div class="panel-body table-responsive" id="listadoregistros">
                          <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                              <th>Opciones</th>
                              <th>Número</th>
                              <th>Nombre</th>
                              <th>Sector</th>
                              <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                              <th>Número</th>
                              <th>Nombre</th>
                              <th>Sector</th>
                              <th>Estado</th>
                            </tfoot>
                          </table>
                      </div>
                      <div class="panel-body"  id="formularioregistros">
                          <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Nombre:</label>
                              <input type="hidden" name="numero" id="numero">
                              <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Sector:</label>
                              <input type="text" class="form-control" name="sector" id="sector" maxlength="100" placeholder="Sector" required>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                              <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                          </form>
                      </div>
                      <!--Fin centro -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->


  <?php


     } //Llave de la condicion if de la variable de session

     else
     {
       require 'noacceso.php';
     }

     
    require 'footer.php';
  ?>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
  <script src="./scripts/maestroInternos.js"></script>

<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>