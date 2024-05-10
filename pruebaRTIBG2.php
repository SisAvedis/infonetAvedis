<?php include("include/info.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo($titulo.$seccion); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/custom2.css">
<link rel="stylesheet" href="css/material-icons.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
</head>

<body>
	<form method="post" action="pruebaRTIBG2.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("include/header.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Cálculo de Retenciones - Seleccione una opción</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-1">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">IIBB</th>
							<th class="text-center">Ganancias</th>
							<th class="text-center">Ambas</th>
						</tr>
						<tr>
							<td class="text-center"><input type="radio" name="ibga" value="ib" required /> </td><td class="text-center"> <input type="radio" name="ibga" value="ga" required /> </td> <td class="text-center"><input type="radio" name="ibga" value="ig" required /></td>
						</tr>
					</thead>
				</table>
				</div>
			</div>
			
		   <?php
			
			$cuit = isset($_POST['cuit']) ? $_POST['cuit'] : null;
			$iva = isset($_POST['iva']) ? $_POST['iva'] : null;
			$importe = isset($_POST['importe']) ? $_POST['importe'] : null;
			//$primera = isset($_POST['primera']) ? $_POST['primera'] : null;
			if (isset($_POST['primera']) && $_POST['primera'] == 'clk'){
				$primera = $_POST['primera'] == 'clk';
			}else{
				$primera = '';
			}
			
			$ibga = isset($_POST['ibga']) ? $_POST['ibga'] : null;
			$poe = "Z";
			$resultado = 0;
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if((validaCampo($cuit)) && (validaNumero($iva)) && (validaNumero($importe))){
				include ("database_p.php");
				$clientes= new Database();
				$nombres = $clientes->sanitize($_POST['cuit']);
				
				if ($ibga == "ga" || $ibga == "ig"){
					$resga = $clientes->ret_gan($nombres);
					$resesc = $clientes->esc_gan();
					$row_cntga = mysqli_num_rows($resga);
					$row_cntesc = mysqli_num_rows($resesc);
					if($row_cntga = 1){
						$bcntga = true;
					}else{
						$bcntga = false;
					}
					echo $row_cntga;
				}
				
				if ($ibga == "ib" || $ibga == "ig"){
					$tabla = "ret_arba";
					$resib = $clientes->single_record($nombres,$tabla);
					$row_cntib = mysqli_num_rows($resib);
						
				}
				
				//if ($row_cntga > 0 && $row_cntib >= 0 && $row_cntesc > 0){
				if (($ibga == "ga" && $bcntga) || ($ibga == "ig" && $bcntga)){
					while ($row=mysqli_fetch_object($resga)){
					$codigo=$row->Codigo;
					$regimen=$row->Regimen;
					$nombre=$row->Nombre;
					$poe=$row->PoE;
					$insc=$row->InscNinsc;
					$minimo=$row->MinimoNI;
					$retmin=$row->RetMin;
					$porcentaje=$row->Porcentaje;
					}
					
					$zeta = 0;
					while ($row=mysqli_fetch_object($resesc)){
					$aescala[$zeta][0] = $row->desde;
					$aescala[$zeta][1] = $row->hasta;
					$aescala[$zeta][2] = $row->fijoIns;
					$aescala[$zeta][3] = $row->percent;
					$zeta++;
					}
					$alic = 0;
					if ($primera == ''){
						$minimo = 0;
					}
				}
					
					if ($ibga == "ib" || $ibga == "ig"){
					
						//Si el contribuyente no aparece en el padrón de IIBB ARBA
						if ($row_cntib > 0){
							while ($row=mysqli_fetch_object($resib)){
								$alic=$row->Col9;
								$alic=dotperiod($alic,0);
								$salic="Padrón";
							}
						}else{
							$alic=4;
							$salic="Grupo General";
						}
					}
					
					if ($poe == "P" && $bcntga){
							$resultado = iteraP($porcentaje, $alic, $minimo, $iva, $importe);
					}
					
					if ($poe == "E" && $bcntga){
						$resultado = iteraE($alic, $minimo, $iva, $importe);
					}
					
					if ($poe == "Z"){
						$resultado = iteraP(0, $alic, 0, $iva, $importe);
					}
					
					
					$message= "<span style='color:#000000;'>"."El C.U.I.T. del proveedor es: "."</span><span style='color:#0000FF;'>".$cuit."."."</span>";
					$message= $message."<br>";
					
					if ($ibga == "ga" || $ibga == "ig" && $bcntga){
						$message= $message."<span style='color:#000000;'>"."El Monto Sujeto a Retención de Ganancias es : "."</span><span style='color:#0000FF;'>".number_format($resultado[4], 2, '.', '')."$."."</span>";
						$message= $message."<br>";
						$message= $message."<span style='color:#000000;'>"."La Base de Cálculo de Retención de Ganancias es : "."</span><span style='color:#0000FF;'>"."</span><span style='color:#0000FF;'>".number_format($resultado[3], 2, '.', '')."$."."</span>";
						$message= $message."<br>";
						$message= $message."<span style='color:#000000;'>"."El Minimo No Imponible de Ganancias Aplicado es: "."</span><span style='color:#0000FF;'>".number_format($minimo, 2, '.', '')."$."."</span>";
						$message= $message."<br>";
						$message= $message."<span style='color:#000000;'>"."La Retención de Ganancias Calculada es: "."</span><span style='color:#0000FF;'>".number_format($resultado[1], 2, '.', '')."$ (".number_format($resultado[5], 2, '.', '')." %)."."</span>";
						$message= $message."<br>";
						$message= $message."<span style='color:#000000;'>"."El Régimen de Retención de Ganancias es: "."</span><span style='color:#0000FF;'>".$regimen." - ".$nombre.". (".$poe.")."."</span>";
						$message= $message."<br>";
					}elseif ($ibga == "ga" || $ibga == "ig" && !$bcntga){
						$message= $message."<span style='color:#FF00FF;'>"."No se puede calcular Retención de Ganancias."."</span>"."<br>";
					}
					if ($ibga == "ib" || $ibga == "ig"){
						$message= $message."<span style='color:#000000;'>"."El Monto Sujeto a Retención de IIBB es : "."</span><span style='color:#0000FF;'>".number_format($resultado[4], 2, '.', '')."$."."</span>";
						$message= $message."<br>";
						$message= $message."<span style='color:#000000;'>"."La Base de Cálculo de Retención de IIBB es : "."</span><span style='color:#0000FF;'>"."</span><span style='color:#0000FF;'>".number_format($resultado[3], 2, '.', '')."$."."</span>";
						$message= $message."<br>";
						$message= $message."<span style='color:#000000;'>"."La Retención de IIBB Calculada es: "."</span><span style='color:#0000FF;'>"."</span><span style='color:#0000FF;'>".$resultado[2]."$ (".number_format($alic, 2, '.', '')." %). (".$salic.")."."</span>";
						$message= $message."<br>";
						
					}
					
					$message= $message."<span style='color:#000000;'>"."El Monto Calculado (A Cuenta) es: "."</span><span style='color:#9D00FF;font-weight:bold;'>".number_format($resultado[0], 2, '.', '')."$."."</span>";
					$message= $message."<br>";
					$message= $message."<span style='color:#000000;'>"."El Importe Ingresado es: "."</span><span style='color:#9D00FF;font-weight:bold;'>".number_format($importe, 2, '.', '')."$."."</span>";
					$message= $message."<br>";
					
					$class="alert alert-success";
					
					
				//} else{
				//		$message="No se encontró el CUIT en el padrón.";
				//		$class="alert alert-danger";
				//}
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
				<div class="col-md-6">
									
				<table class="table table-bordered" id="tabla2">
					<thead>
						<tr>
							<th class="text-center">CUIT (Sin Guiones)</th>
							<th class="text-center">Coeficiente (IVA y Otros)</th>
							<th class="text-center">Importe</th>
							<th class="text-center">MNI</th>
						</tr>
					</thead>
					<tbody>	
						<tr>
							<th><input type="text" name="cuit" id="cuit" class='form-control input-sm' maxlength="100" required value="<?php $cuit ?>" /></th>
							<th><input type="text" name="iva" id="iva" class='form-control input-sm' maxlength="6" required /><?php $iva ?></th>
							<th><input type="text" name="importe" id="importe" class='form-control input-sm' maxlength="12" required /><?php $importe ?></th>
							<th class="text-center"><input type="checkbox" name="primera" id="primera" value="clk" /></th>
						</tr>
					</tbody>
				</table>
				
				
				
				</div>
			
				<div class="col-md-12 pull-right">
					<button type="submit" class="btn btn-success">Calcular</button>
				</div>
				
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

function iteraP($porcentaje,$retencion,$minimo,$iva,$importe){
	
	$importe = dotperiod($importe,0);
	$iva = dotperiod($iva,0);
	$porcentaje = dotperiod($porcentaje,0);
	$retencion = dotperiod($retencion,0);
	$minimo = dotperiod($minimo,0);
	$res_uno = $importe /$iva;
	$res_dos = $res_uno - $minimo;
	$res_tres = $res_dos * $porcentaje / 100;
	$res_cuatro = $res_uno * $retencion / 100;
	$res_cinco = $importe + $res_tres + $res_cuatro;
	
	$matriz = array(
					array($res_uno,$res_dos,$res_tres,$res_cuatro,$res_cinco,0),
			);
	
	for ($i=1;$i < 15 ;$i++){
		$matriz[$i][0] = $matriz[$i-1][4] / $iva;
		$matriz[$i][1] = $matriz[$i][0] - $minimo;
		$matriz[$i][2] = $matriz[$i][1] * $porcentaje / 100;
		$matriz[$i][3] = $matriz[$i][0] * $retencion / 100;
		$matriz[$i][4] = $importe + $matriz[$i][2] + $matriz[$i][3];
		$matriz[$i][5] = $i;
		
		$epsilon = 0.000000001;
		if (abs($matriz[$i][4] - $matriz[$i-1][4]) < $epsilon){
			$acuenta = $matriz[$i][4];
			$retencionib = $matriz[$i][3];
			$retencionga = $matriz[$i][2];
			$netosujetoga = $matriz[$i][1];
			$netosujetoib = $matriz[$i][0];
			$porcentaje = $porcentaje;
			break;
		}
	}
	
	/*Muestra el array en el formulario web - Solo para fines de control*/
	/*
	foreach($matriz as $mat){
		foreach($mat as $m){
			echo ' || '.dotperiod($m,1).' || ';
		}
		echo '<br>';
	}
	*/
	return array(round($acuenta,2), round($retencionga,2), round($retencionib,2), round($netosujetoga,2), round($netosujetoib,2), round($porcentaje,2));
}


function iteraE($retencion,$minimo,$iva,$importe){
	
	global $aescala;
	global $zeta;
	
	$importe = dotperiod($importe,0);
	$iva = dotperiod($iva,0);
	$minimo = dotperiod($minimo,0);
	$retencion = dotperiod($retencion,0);
	$res_uno = $importe /$iva;
	$res_dos = $res_uno - $minimo;
	$res_cuatro = $res_uno * $retencion / 100;
	
	
	for ($i=0;$i < $zeta -1 ;$i++){
		if ($res_dos >= $aescala[$i][0] && $res_dos < $aescala[$i][1]){
		$res_tres = $aescala[$i][2] + ($res_dos - $aescala[$i][0]) * $aescala[$i][3] / 100;	
		break;
	}
	}
	
	$res_cinco = $importe + $res_tres + $res_cuatro;
	
	$matriz = array(
					array($res_uno,$res_dos,$res_tres,$res_cuatro,$res_cinco,0),
			);
	
	/*Muestra el array en el formulario web - Solo para fines de control*/
	/*
	foreach($matriz as $mat){
		foreach($mat as $m){
			echo ' || '.dotperiod($m,1).' || ';
		}
		echo '<br>';
	}
	*/
	
	for ($i=1;$i<50;$i++){
		$matriz[$i][0] = $matriz[$i-1][4] / $iva;
		$matriz[$i][1] = $matriz[$i][0] - $minimo;
		$matriz[$i][3] = $matriz[$i][0] * $retencion / 100;
		
		for ($j=1;$j<$zeta-1;$j++){
			if ($matriz[$i][1] >= $aescala[$j][0] && $matriz[$i][1] < $aescala[$j][1]){
				$matriz[$i][2] = $aescala[$j][2] + ($matriz[$i][1] - $aescala[$j][0]) * $aescala[$j][3] / 100;	
				break;
			}
		}
		
		$matriz[$i][4] = $importe + $matriz[$i][2] + $matriz[$i][3];
		$matriz[$i][5] = $i;
		
		$epsilon = 0.000000001;
		if (abs($matriz[$i][4] - $matriz[$i-1][4]) < $epsilon){
			
			$acuenta = $matriz[$i][4];
			$netosujetoib = $matriz[$i][0];
			$netosujetoga = $matriz[$i][1];
			$retencionib = $matriz[$i][3];
			$retencionga = $matriz[$i][2];
			$porcentaje = $aescala[$j][3];
			break;
		}
	}
	
	/*Muestra el array en el formulario web - Solo para fines de control*/
	/*
	foreach($matriz as $mat){
		foreach($mat as $m){
			echo ' || '.dotperiod($m,1).' || ';
		}
		echo '<br>';
	}
	*/
	return array(round($acuenta,2), round($retencionga,2), round($retencionib,2), round($netosujetoga,2), round($netosujetoib,2), round($porcentaje,2));
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
	


	<script type="text/javascript">
		$(document).ready(function(){
	
			//$('#tit').children().each(function (index) {
			//	alert('Index: ' + index + ', html: ' + $(this).html());
			//});
			//-------------------------------------------------
		
		$("input[name=ibga]").click(function () {
		
			var divHeader = "<div>"+"</div>";
			
			$('h2').remove();	
			$('#tit').append(divHeader);
			$('#tit').addClass('col-sm-8');
			$('#tit').children().each(function (index) {
						$(this).remove();
					});
			
			if (this.value == 'ib') {
					$('#tit').append("<h2>Cálculo de Retenciones de IIBB</h2>");
					
					var tds=$("#tabla2 tr:first th").length;
					if (tds==4){
						$("#tabla2 thead tr th:last").remove();
						$("#tabla2 tbody tr th:last").remove();
					}
			}
			else if (this.value == 'ga') {
					$('#tit').append("<h2>Cálculo de Retenciones de Ganancias</h2>");
					
					var tds=$("#tabla2 tr:first th").length;
					
					if (tds==3){
						var nTh="<th></th>";
						var nInput=	"<th><input type='checkbox'/></th>";
						$('#tabla2 thead tr').append(nTh);
						$('#tabla2 tbody tr').append(nInput);
						$('#tabla2 thead tr th:last').html('Aplica MNI');
						$('input:checkbox').attr('id', 'primera');
						$('input:checkbox').attr('name', 'primera');
						$('#primera').val('clk');
						//$('#primera' ).prop('checked', true );
					}
					
		}
		else if (this.value == 'ig') {
				$('#tit').append("<h2>Cálculo de Retenciones de IIBB y Ganancias</h2>");
		
					var tds=$("#tabla2 tr:first th").length;
					
					if (tds==3){
						var nTh="<th></th>";
						var nInput=	"<th><input type='checkbox'/></th>";
						$('#tabla2 thead tr').append(nTh);
						$('#tabla2 tbody tr').append(nInput);
						$('#tabla2 thead tr th:last').html('Aplica MNI');
						$('input:checkbox').attr('id', 'primera');
						$('input:checkbox').attr('name', 'primera');
						$('#primera').val('clk');
						//$('#primera' ).prop('checked', true );
					}
		
		
		
		}
		})
		
	});
	</script>

	</form>
	</body>
</html>
