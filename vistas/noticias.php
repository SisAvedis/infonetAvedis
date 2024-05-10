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

//print_r($_SESSION);
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
                            <h1 class="box-title">Editor de Noticias 
							  <button class="btn btn-success" id="btnagregar" onclick="mostrarform('A')">
                                <i class="fa fa-plus-circle"></i> 
                                Agregar
                              </button>
                              
							  <a id="ver" target="_blank" href="#">
                                <button class="btn btn-success" id="btnver">Ver Imagen</button>
                              </a>
							  
							  <!--<a id="eliminar" target="_blank" href="#">-->
                                <button class="btn btn-danger" id="btneliminar">Eliminar</button>
                              <!--</a>-->
							  
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
                              <th>Fecha</th>
							                <th>Titulo</th>
							                <th>Descripcion</th>
                              <th>Categoria</th>
							                <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
							                <th>Opciones</th>
							                <th>Fecha</th>
                              <th>Titulo</th>
							                <th>Descripcion</th>
                              <th>Categoria</th>
                              <th>Estado</th>
                            </tfoot>
                          </table>
                      </div>
                      <div class="panel-body"  id="formularioregistros">
                          <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Titulo:</label>
                              <input type="hidden" name="idnoticia" id="idnoticia">
                              <input type="text" class="form-control" name="titulo" id="titulo" maxlength="100" placeholder="Titulo" required>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Sector:</label>
                              <select title="--<b>Seleccione un Sector</b>--" name="idsector" id="idsector" data-live-search="true" class="form-control selectpicker" required></select>
							</div>  
							<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="archivoba">
                              <label id="lblarchivo">Imagen a Subir:</label>
                              <input type="file" class="form-control" name="archivo" id="archivo">
							</div>

              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="archivoab">
                            </div>

              <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" >
                              <label id="lblfecha">Fecha:</label>
                              <input type="date" class="form-control" name="fecha" id="fecha">
							</div>
              
              <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-12">
                              <label>Descripción:</label>
                              <textarea  class="form-control" name="descripcion" id="descripcion" maxlength="512" rows="12" placeholder="Descripción"></textarea>
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
       header("Location: login.html");
     }

     
    require 'footer.php';
  ?>
  <!--<script src="../public/js/JsBarcode.all.min.js"></script>-->
  <!--<script src="../public/js/jquery.PrintArea.js"></script>-->
  <script src="./scripts/noticias.js"></script>

<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>