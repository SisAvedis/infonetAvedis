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
	<form method="post" action="pruebaRTIBG3.php">
    <div class="content-wrapper">
		<!-- HEADER (start) -->
			<?php require_once '../include/validacion.php';?>
		<!-- HEADER (end) -->
		<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div id="tit" class="box-header with-border"><h4>Cálculo de Retenciones - Seleccione una opción</h4></div>
			<div class="box-tools pull-right">
                          </div>
            
			<div class="panel-body">
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
			$message = '';
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
				include ("../database_p.php");
				$clientes= new Database();
				include ("../database2.php");
				$prov= new DatabaseP();
				$cuit = $_POST['cuit'];
				$getprov = $prov->get_prov($cuit);
				$row_cntprov = pg_num_rows($getprov);
				if($row_cntprov == 1){
					$bcntga = 1;
					while ($row=pg_fetch_object($getprov)){
						$cuitP=$row->cuit;
						$regimenP=$row->imp_codigoresolucion;
						$inscP=$row->posicion;
					}
				}else{
					$bcntga = 0;
				}
				
				if (($ibga == "ga" && $bcntga == 1) || ($ibga == "ig" && $bcntga == 1)){
					$resga = $clientes->ret_gan_v2($cuitP,$regimenP,$inscP);
					$resesc = $clientes->esc_gan();
					$row_cntga = mysqli_num_rows($resga);
					$row_cntesc = mysqli_num_rows($resesc);
				}
				
				if ($ibga == "ib" || $ibga == "ig"){
					$tabla = "ret_arba";
					$resib = $clientes->single_record($cuit,$tabla);
					$row_cntib = mysqli_num_rows($resib);
						
				}
				
				//if ($row_cntga > 0 && $row_cntib >= 0 && $row_cntesc > 0){
				if (($ibga == "ga" && $bcntga == 1) || ($ibga == "ig" && $bcntga == 1)){
					while ($row=mysqli_fetch_object($resga)){
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
					
					if ($poe == "P" && $bcntga == 1){
							$resultado = iteraP($porcentaje, $alic, $minimo, $iva, $importe);
					}
					
					if ($poe == "E" && $bcntga == 1){
						$resultado = iteraE($alic, $minimo, $iva, $importe);
					}
					
					if ($poe == "Z" && $bcntga == 1){
						$resultado = iteraP(0, $alic, 0, $iva, $importe);
					}
					
					if ($poe == "Z" && $bcntga == 0){
						$resultado = iteraP(0, $alic, 0, $iva, $importe);
					}
					
					
					$message= "<span style='color:#000000;'>"."El C.U.I.T. del proveedor es: "."</span><span style='color:#0000FF;'>".$cuit."."."</span>";
					$message= $message."<br>";
					
					if (($ibga == "ga" && $bcntga == 1) || ($ibga == "ig" && $bcntga == 1)){
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
					}elseif (($ibga == "ga" && $bcntga == 0) || ($ibga == "ig" && $bcntga == 0)){
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
				<div class="<?php //echo $class?>" id="msg">
				  <?php //echo $message;?>
				</div>	
					<?php
		}
			?>
			<div class="panel-body">
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
			<div class="row" id="msg">
				<div class="col-md-6">
					<div class="<?php echo $class?>" >
						<?php echo $message;?>
				</div>
				</div>
			</div>
        </div>
		</section>
    </div> <!--.Content Wrapper -->    


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
	//22-04-2023 (Se comentó el bloque)
	/*
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
	*/
	//22-04-2023 - Fin
	
	//22-04-2023
	$i=0;
	$acuenta = $matriz[$i][4];
	$retencionib = $matriz[$i][3];
	$retencionga = $matriz[$i][2];
	$netosujetoga = $matriz[$i][1];
	$netosujetoib = $matriz[$i][0];
	$porcentaje = $porcentaje;
	
	//22-04-2023 - Fin
	
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
	
	
	//22-04-2023 (Se comentó el bloque)
	/*
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
	
	*/
	//22-04-2023 - Fin
	
	//22-04-2023
	$i=0;
	$acuenta = $matriz[$i][4];
	$retencionib = $matriz[$i][3];
	$retencionga = $matriz[$i][2];
	$netosujetoga = $matriz[$i][1];
	$netosujetoib = $matriz[$i][0];
	$porcentaje = $porcentaje;
	
	//22-04-2023 - Fin
	
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
		
		//var smessage = "<?php echo $message; ?>";
		
		$("input[name=ibga]").click(function () {
			$('#msg').remove();
			var divHeader = "<div>"+"</div>";
			
			$('h4').remove();	
			$('#tit').append(divHeader);
			// $('#tit').addClass('col-sm-8');
			$('#tit').children().each(function (index) {
				$(this).remove();
			});
			
			if (this.value == 'ib') {
				$('#msg').remove();
				$('#tit').append("<h4>Cálculo de Retenciones de IIBB</h4>");
					
				var tds=$("#tabla2 tr:first th").length;
				if (tds==4){
					$("#tabla2 thead tr th:last").remove();
					$("#tabla2 tbody tr th:last").remove();
				}
			}
			else if (this.value == 'ga') {
				$('#msg').remove();
				$('#tit').append("<h4>Cálculo de Retenciones de Ganancias</h4>");
					
				var tds=$("#tabla2 tr:first th").length;
					
				if (tds==3){
					var nTh="<th></th>";
					var nInput=	"<th><input type='checkbox'/></th>";
					$('#tabla2 thead tr').append(nTh);
					$('#tabla2 tbody tr').append(nInput);
					$('#tabla2 thead tr th:last').html('MNI');
					$('input:checkbox').attr('id', 'primera');
					$('input:checkbox').attr('name', 'primera');
					$('#primera').val('clk');
					//$('#primera' ).prop('checked', true );
				}
		}
		else if (this.value == 'ig') {
			$('#msg').remove();
			$('#tit').append("<h4>Cálculo de Retenciones de IIBB y Ganancias</h4>");
		
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

	<?php

/*else
{
  require 'noacceso.php';
}*/

require 'footer.php';

?>


<?php

  //}
  ob_end_flush(); //liberar el espacio del buffer
?>