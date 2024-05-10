<?php include("include/info.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo($titulo.$seccion); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/material-icons.css">
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
</head>

<body>
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("include/headerPadrones.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Cálculo de Retenciones IIBB ARBA</h2></div>
                </div>
            </div>
            <?php
			$cuit = isset($_POST['cuit']) ? $_POST['cuit'] : null;
			$iva = isset($_POST['iva']) ? $_POST['iva'] : null;
			$importe = isset($_POST['importe']) ? $_POST['importe'] : null;
			$resultado = 0;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if((validaCampo($cuit)) && (validaNumero($iva)) && (validaNumero($importe))){
				include ("database_p.php");
				$clientes= new Database();
				$nombres = $clientes->sanitize($_POST['cuit']);
				$tabla = "ret_arba";
				$id = 1;
				$res = $clientes->single_record($nombres,$tabla);
				$row_cnt = mysqli_num_rows($res);
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
					$resultado = itera($alic,$iva,$importe);
					$message= "El C.U.I.T. del proveedor es: ".$cuit.".";
					$message= $message."<br>";
					$message= $message."El Monto Sujeto a Retención es : ".$resultado[2]."$.";
					$message= $message."<br>";
					$message= $message."La Retención Calculada es : ".$resultado[1]."$ (".$alic." %).";
					$message= $message."<br>";
					$message= $message."El Coeficiente % I.V.A. y Otros: ".$iva.".";
					$message= $message."<br>";
					$message= $message."El Importe Ingresado es: ".$importe."$.";
					$message= $message."<br>";
					$message= $message."El Importe Calculado es: ".$resultado[0]."$.";
					$message= $message."<br>";
										
					$class="alert alert-success";
					
					
				} else{
						$message="No se encontró el CUIT en el padrón.";
						$class="alert alert-danger";
				}
				} else{
					$message="Valor Ingresado Inválido.";
					$class="alert alert-danger";
				} 
				
				?>
				<div class="<?php echo $class?>">
				  <?php echo $message;?>
				</div>	
					<?php
		}
			?>
			<div class="row">
				<form method="post" action="pruebaRT.php">
				<div class="col-md-6">
									
				<table class="table table-bordered" id="tabla2">
					<thead>
						<tr>
							<th>CUIT (Sin Guiones)</th>
							<th>Coeficiente (IVA y Otros)</th>
							<th>Importe</th>
						</tr>
						<tr>
							<th><input type="text" name="cuit" id="cuit" class='form-control' maxlength="100" required value="<?php $cuit ?>" /></th>
							<th><input type="text" name="iva" id="iva" class='form-control' maxlength="6" required /><?php $iva ?></th>
							<th><input type="text" name="importe" id="importe" class='form-control' maxlength="12" required /><?php $importe ?></th>
						</tr>
					</thead>
				</table>
				
				</div>
			
				<div class="col-md-12 pull-right">
				<hr>
					<button type="submit" class="btn btn-success">Calcular</button>
				</div>
				
				</form>
			</div>
        </div>
    </div>     


<?php 
/*existen dos formas de pasar parámetros: por valor o por referencia. 
En este caso se hizo por referencia, esto significa 
que las funciones no podrán alterar el código externo
Utilización de la variable $epsilon:
Para comprobar la igualdad de valores de punto flotante, se utiliza 
un límite superior en el error relativo debido al redondeo. Este valor 
se conoce como el epsilon de la máquina o unidad de redondeo y es la 
menor diferencia aceptable en los cálculos.*/

function itera($retencion,$iva,$importe){
	
	$importe = dotperiod($importe,0);
	$iva = dotperiod($iva,0);
	$retencion = dotperiod($retencion,0);
	$res_uno = $importe /$iva;
	$res_dos = $res_uno * $retencion / 100;
	$res_tres = $importe + $res_dos;
	$matriz = array(
					array($res_uno,$res_dos,$res_tres,0),
			);
	for ($i=1;$i < 15 ;$i++){
		$matriz[$i][0] = $matriz[$i-1][2] / $iva;
		$matriz[$i][1] = $matriz[$i][0] * $retencion / 100;
		$matriz[$i][2] = $importe + $matriz[$i][1];
		$matriz[$i][3] = $i;
		$epsilon = 0.000000001;
		if (abs($matriz[$i][2] - $matriz[$i-1][2]) < $epsilon){
			$acuenta = $matriz[$i][2];
			$aretencion = $matriz[$i][1];
			$netosujeto = $matriz[$i][0];
			break;
		}
	}
	/*Muestra el array en el formulario web - Solo para fines de control
	foreach($matriz as $mat){
		foreach($mat as $m){
			echo ' || '.dotperiod($m,1).' || ';
		}
		echo '<br>';
	}
	*/
	return array(round($acuenta,2), round($aretencion,2), round($netosujeto,2));
}

function dotperiod($value, $tipo)
{
    switch($tipo){
		case 0:
		$value = str_replace(',', '.',$value);
		break;
		case 1:
		$value = str_replace('.', ',',$value);
		break;
	}
	return ($value);
}

?>
	
	
	
	
</body>
</html>

