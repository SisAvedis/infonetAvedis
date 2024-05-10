<?php include("../include/info.php");

//Activacion de almacenamiento en buffer
ob_start();
//iniciamos las variables de session
//session_start();
  
/*if(!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}

else  //Agrega toda la vista
{*/
  require 'header.php';
 // print_r($_SESSION);
 ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo($titulo.$seccion); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
<script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>

	
	<div class="content-wrapper">
			<!-- HEADER (start) -->
			<?php include ("../database_p.php"); ?>
		<!-- HEADER (end) -->
			<section class="content">
			<div class="row" >
                <div class="col-md-12" >
                <div class="box" style="position:static; overflow-y: auto;">
                    <div id="tit" class="box-header with-border">  
						 <h4 class="box-title">Internos de Telefonía</h4>
						 <div class="box-tools pull-right">
                          </div>
						  </div>
            
			
			
			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<div class="panel-body table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover" id="tabla1">
					<thead>
						<tr>
							<th class="text-center" colspan=2 >Ordenado Por</th>
						</tr>
						<tr>
							<th class="text-center">Nombre</th>
							<th class="text-center">Interno</th>
						</tr>
						<tr>
							<!--<th class="text-center"><input type="radio" checked="checked" name="orden" value="N" required <?php //echo ($orden=='N')?'checked':'' ?>/></th>--> 
							<!--<th class="text-center"><input type="radio" name="orden" value="I" required <?php //echo ($orden=='I')?'checked':'' ?>/></th>-->
							<th class="text-center"><input type="radio" checked="checked" name="orden" value="N" required /></th>
							<th class="text-center"> <input type="radio" name="orden" value="I" required /></th>
						</tr>
					</thead>
				</table>
				</div>
			</div>
			
			<?php
				$DB= new Database();
				$orden = isset($_POST['orden']) ? $_POST['orden'] : 'N';
				
				if($orden == 'N'){
					$sorden = 'nombre';
				}else{
					$sorden = 'numero';
				}
				$res = $DB->printernov1($sorden);
			?>
			
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<table class="table table-striped table-bordered table-condensed table-hover" id="tablainternos">
				</table>
			</div>
			
			
			<?php
				if ($orden){
			?>		
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<div class="panel-body table-responsive" id="tablainternosfija">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<tr>
							<th class='text-center'>Nombre</th>
							<th class='text-center'>Interno</th>
							<th class='text-center'>Sector</th>
						</tr>
					</thead>
					<tbody>
			<?php
				if(!empty($res)){
					while ($row=mysqli_fetch_object($res)){
								
			?>
				
					<tr style="max-height:16px">
						<td style="font-size:15px" class='text-left'><?php if(isset($row->nombre)){echo $row->nombre;}else{echo "Error";}?></td>
						<td style="font-size:15px" class='text-center'><?php if(isset($row->numero)){echo $row->numero;}else{echo "Error";}?></td>
						<td style="font-size:15px" class='text-left'><?php if(isset($row->sector)){echo $row->sector;}else{echo "Error";}?></td>
					</tr>
			<?php
				}
			?>
				</tbody>	
				</table>
				</div>
			</div>
			
			<?php
				}else{
					$message= "La consulta arrojó un error.";
					$class="alert alert-warning";
				?>
					<div class="<?php echo $class;?>" id="rows">
						<?php echo $message;?>
					</div>
				<?php		
					}
				}
				?>
		</div>			
			</div><!-- /.box -->   
			</div><!-- /.col -->
            </div><!-- /.row -->
		</section><!-- /.content -->
		<div style="position:relative">
	<?php

  /*else
  {
    require 'noacceso.php';
  }*/

  require 'footer.php';
  
?>
	</div>

    </div> 

	
<script type="text/javascript">
	$(document).ready(function(){
		var orden =  '<?php echo $orden; ?>';
		//funciones
		$.fn.consulta = function(stipoe){
			$('#tablainternosfija').children().each(function (index) {
				$(this).remove();
			});
			
			$.ajax({
				url:"../ajax6full.php",
				dataType: "json",
				data: {"orden": sorden},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var tabla = response[i].tabla;
						$("#tablainternos").html(tabla);	
					}
				}
			});
		}
		
		//funciones
		
		
		
		//Option Button Ordenado Por
		$("input[name=orden]").click(function () {
			var orden = $(this).val();
			if(orden == 'N'){
				sorden = 'nombre';
			}else{
				sorden = 'numero';
			}
			$.fn.consulta(sorden);
		});
		
				
});
</script>
	
	


  







<?php

  //}
  ob_end_flush(); //liberar el espacio del buffer
?>