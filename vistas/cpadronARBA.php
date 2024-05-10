<?php include("../include/info.php"); ?>
<?php
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
		switch ($id) {
			case 1;
			$tipo="Retenciones";
			$tabla = "ret_arba";
			break;
			case 2;
			$tipo="Percepciones";
			$tabla = "per_arba";
			break;
		}
	} 
	 

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

    <div class="content-wrapper">
		<!-- HEADER (start) -->
			<?php require_once '../include/validacion.php';?>
		<!-- HEADER (end) -->
		<section class="content">
                <div class="row">
				<div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border"><h4>Padrón ARBA <?php echo $tipo?> IIBB</h4></div>
				<div class="box-tools pull-right">
                          </div>
            <?php
			$cuit = isset($_POST['cuit']) ? $_POST['cuit'] : null;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(validaCampo($cuit)){
				include ("../database_p.php");
				$clientes= new Database();
				$nombres = $clientes->sanitize($_POST['cuit']);
				//$res = $clientes->single_record($nombres,$tabla);
				$res = $clientes->single_record($nombres,$tabla);
				$row_cnt = mysqli_num_rows($res);
				//echo "<pre>";
				//echo $row_cnt."</br>";
				//echo "</pre>";
				if ($row_cnt > 0){
					while ($row=mysqli_fetch_object($res)){
					$alic=$row->Col9;
					$cuit=$row->Col5;
					$dated=$row->Col3;
					$dateh=$row->Col4;
					$cuit=substr($cuit,0,2)."-".substr($cuit,2,8)."-".substr($cuit,-1,1); 
					$dated="0".substr($dated,0,1)."/".substr($dated,1,2)."/".substr($dated,3,4);
					$dateh=substr($dateh,0,2)."/".substr($dateh,2,2)."/".substr($dateh,4,4);
					}
					$message= "La alícuota correspondiente al CUIT ".$cuit." es ".$alic." %."." Vigencia: ".$dated." - ".$dateh.".";
					$class="alert alert-success";
				} else{
						$message="No se encontró el CUIT en el padrón.";
						$class="alert alert-danger";
				}
				} else{
					$message="Debe ingresar 11 (once) dígitos.";
					$class="alert alert-danger";
				} 
				
				?>
				<div style="font-size:15px" class="<?php echo $class?>">
				  <?php echo $message;?>
				</div>	
					<?php
		}
			?>
			<div class="panel-body">
				<form method="post" action="cpadronARBA.php?id=<?php echo $id?>">
				<div class="col-md-3">
					<label>C.U.I.T.: (Sin guiones)</label>
					<input type="text" name="cuit" id="cuit" class="form-control input-sm" maxlength="100" required value="<?php $cuit ?>" />
				</div>
				
				
				<div class="col-md-12 pull-right">
				<hr>
					<button type="submit" class="btn btn-success">Buscar</button>
				</div>
				
				
				</form>
			</div>
        </div>
    </div>     
	</section>
	</div>   

<?php

/*else
{
  require 'noacceso.php';
}*/

require 'footer.php';

?>


<?php

 // }
  ob_end_flush(); //liberar el espacio del buffer
?>