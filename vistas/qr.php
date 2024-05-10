<?php include("../include/info.php"); //Activacion de almacenamiento en buffer
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
    <form method="post" action="qr.php" id="frm">
	<div class="content-wrapper">
		<!-- HEADER (start) -->
			<?php require_once '../include/validacion.php';?>
		<!-- HEADER (end) -->
		<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border"><h4>Verificar Comprobante Fiscal</h4></div>
					<div class="box-tools pull-right">
                          </div>
			<?php
			$qrstr = isset($_POST['qrstr']) ? $_POST['qrstr'] : null;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$qrinistr = 'https://www.afip.gob.ar/fe/qr/?p=';
				if (strpos($qrstr, $qrinistr) !== false) {
					atob();
					$message="La cadena ingresada es válida.";
					$class="alert alert-success";
				}else{
					$message="La cadena ingresada es inválida.";
					$class="alert alert-danger";
				} 
				//echo "<pre>";
				//echo $qrstr;
				//echo "</pre>";
				
				?>
				
				<div class="<?php echo $class?>">
				  <?php echo $message;?>
				</div>	
					<?php
				}
	
			?>
			<div class="panel-body">
				<div class="col-md-5">
					<label><pre class="lx-pre">URL (Pegue la URL)</pre></label></br>
					<pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="500" autocomplete="off" required value="<?php $nremito; ?>" /></pre>
				</div>
				
				<div class="col-md-2" id="lblComprobante">
				</div>	
				<div class="col-md-2" id="lblComprobante2">
				</div>
				<div class="col-md-1" id="lblComprobante3">
				</div>
				<div class="col-md-1" id="lblComprobante4">
				</div>
				<div class="col-md-8" id="lblComprobante5">
				</div>
				
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<hr>
					<button type="submit" id="abutton" class="btn btn-sm btn-success">Consultar</button>
					<hr>
				</div>
			</div>
        </div>
			</section>
    </div>     
	
	
<script type="text/javascript" >
	
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var bRes = false;
		var sRemito = '';
		var bkeyPressed = false;
		var data = '';
		
		jq.fn.chkPattern = function(sRemito){
			//var pattern = new RegExp('^[0-9]{4}$|^[0-9]{6}$');
			var pattern = new RegExp('^.*$');
			if (pattern.test(sRemito)) {
				jq('#nremito').css("background-color","#92FF8A");
				jq('#nremito').css("color","#A605FA");
				bRes = true;
			}else{
				if(jq('#nremito').val() !== ''){
					jq('#nremito').css("background-color","#FAE605");
					jq('#nremito').css("color","#A605FA");
					jq("#nremito").focus();
				}
				bRes = false;
			}
		}
		
		jq.fn.GetFormattedDate = function(sDate){
			//var today = new Date();	//Today...
			var today = new Date(sDate);
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();
			today =  dd + '/' + mm + '/' + yyyy;
			return today;
		}
		
		jq.fn.parseJSON = function(str) {
			try {
				data = str.replace(/("ptoVta":)0+(?![\. ])/,"\"ptoVta\":");
				data = data.replace(/("tipoCmp":)0+(?![\. ])/,"\"tipoCmp\":");
				data = data.replace(/("nroCmp":)0+(?![\. ])/,"\"nroCmp\":");
				data = JSON.parse(data);
			} catch (e) {
				return false;
			}
			return true;
		}
		
		
		jq.fn.procesaRemito = function(sRemito){
			jq('#lblComprobante').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblComprobante2').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblComprobante3').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblComprobante4').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblComprobante5').children().each(function (index) {
				jq(this).remove();
			});
			
			var sDataBGColor = "#F7CA14";
			var sLabeBGColor = "#F5F5F5";
			var sTextColor = "#000333";
			
			//console.log(aRemito[1]);
			// Decode the String
			var decodedStr = atob(aRemito[1]);
			console.log(decodedStr);
			bdata = jq.fn.parseJSON(decodedStr);
			
			if(bdata == true){
			
				var scolmod0 = "col-md-2";
				var sMsgUno = "Fecha";
				var fecha = data.fecha.replace('-','/');
				var sMSGDos = jq.fn.GetFormattedDate(fecha);
				var sMsgTre = "Importe";
				var sMSGCua = data.importe;
				var sMSGCin = "CUIT";
				var sMSGSei = data.nroDocRec;
				var sMSGSie = "Comprobante";
				var sMSGOch = data.tipoCodAut+"-"+data.ptoVta+"-"+data.nroCmp;
				var sMSGNue = "CAE";
				var sMSGDie = data.codAut;
				
				jq("#lblComprobante").removeClass();
				jq("#lblComprobante").addClass(scolmod0);
				jq("#lblComprobante2").removeClass();
				jq("#lblComprobante2").addClass(scolmod0);
				jq("#lblComprobante3").removeClass();
				jq("#lblComprobante3").addClass(scolmod0);
				jq("#lblComprobante4").removeClass();
				jq("#lblComprobante4").addClass(scolmod0);
				jq("#lblComprobante5").removeClass();
				jq("#lblComprobante5").addClass(scolmod0);
				var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
				var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
				var sLblTre = "<label id='tre'><pre class='lx-pre'></pre></label></br>";
				var sLblCua = "<label id='cua'><pre class='lx-pre'></pre></label></br>";
				var sLblCin = "<label id='cin'><pre class='lx-pre'></pre></label></br>";
				var sLblSei = "<label id='sei'><pre class='lx-pre'></pre></label></br>";
				var sLblSie = "<label id='sie'><pre class='lx-pre'></pre></label></br>";
				var sLblOch = "<label id='och'><pre class='lx-pre'></pre></label></br>";
				var sLblNue = "<label id='nue'><pre class='lx-pre'></pre></label></br>";
				var sLblDie = "<label id='die'><pre class='lx-pre'></pre></label></br>";
				
							
				jq("#lblComprobante").append(sLblUno);
				jq("#uno pre").attr('id', 'msgUNO');
				jq("#lblComprobante").append(sLblDos);
				jq("#dos pre").attr('id', 'msgDOS');
				jq('#msgUNO').css("background-color",sLabeBGColor);
				jq('#msgUNO').css("color",sTextColor);
				jq("#msgUNO").text(sMsgUno);
				jq('#msgDOS').css("background-color",sDataBGColor);
				jq('#msgDOS').css("color",sTextColor);
				jq("#msgDOS").text(sMSGDos);
				
				jq("#lblComprobante2").append(sLblTre);
				jq("#tre pre").attr('id', 'msgTRE');
				jq("#lblComprobante2").append(sLblCua);
				jq("#cua pre").attr('id', 'msgCUA');
				jq('#msgTRE').css("background-color",sLabeBGColor);
				jq('#msgTRE').css("color",sTextColor);
				jq("#msgTRE").text(sMsgTre);
				jq('#msgCUA').css("background-color",sDataBGColor);
				jq('#msgCUA').css("color",sTextColor);
				jq("#msgCUA").text(sMSGCua);
				
				jq("#lblComprobante3").append(sLblCin);
				jq("#cin pre").attr('id', 'msgCIN');
				jq("#lblComprobante3").append(sLblSei);
				jq("#sei pre").attr('id', 'msgSEI');
				jq('#msgCIN').css("background-color",sLabeBGColor);
				jq('#msgCIN').css("color",sTextColor);
				jq("#msgCIN").text(sMSGCin);
				jq('#msgSEI').css("background-color",sDataBGColor);
				jq('#msgSEI').css("color",sTextColor);
				jq("#msgSEI").text(sMSGSei);
				
				jq("#lblComprobante4").append(sLblSie);
				jq("#sie pre").attr('id', 'msgSIE');
				jq("#lblComprobante4").append(sLblOch);
				jq("#och pre").attr('id', 'msgOCH');
				jq('#msgSIE').css("background-color",sLabeBGColor);
				jq('#msgSIE').css("color",sTextColor);
				jq("#msgSIE").text(sMSGSie);
				jq('#msgOCH').css("background-color",sDataBGColor);
				jq('#msgOCH').css("color",sTextColor);
				jq("#msgOCH").text(sMSGOch);
				
				jq("#lblComprobante5").append(sLblNue);
				jq("#nue pre").attr('id', 'msgNUE');
				jq("#lblComprobante5").append(sLblDie);
				jq("#die pre").attr('id', 'msgDIE');
				jq('#msgNUE').css("background-color",sLabeBGColor);
				jq('#msgNUE').css("color",sTextColor);
				jq("#msgNUE").text(sMSGNue);
				jq('#msgDIE').css("background-color",sDataBGColor);
				jq('#msgDIE').css("color",sTextColor);
				jq("#msgDIE").text(sMSGDie);
			}else{
				var scolmod0 = "col-md-8";
				var sMsgUno = "Atención";
				var sMSGDos = "Error al procesar el código ingresado";
				jq("#lblComprobante").removeClass();
				jq("#lblComprobante").addClass(scolmod0);
				var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
				var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
				jq("#lblComprobante").append(sLblUno);
				jq("#uno pre").attr('id', 'msgUNO');
				jq("#lblComprobante").append(sLblDos);
				jq("#dos pre").attr('id', 'msgDOS');
				jq('#msgUNO').css("background-color",sLabeBGColor);
				jq('#msgUNO').css("color",sTextColor);
				jq("#msgUNO").text(sMsgUno);
				jq('#msgDOS').css("background-color",sDataBGColor);
				jq('#msgDOS').css("color",sTextColor);
				jq("#msgDOS").text(sMSGDos);
			}
			
		}

		
		jq("#nremito").focusout('input', function(){
			sRemito = jq(this).val();
			aRemito = sRemito.split('https://www.afip.gob.ar/fe/qr/?p=');
		});
		
		
		jq('#nremito').keypress(function(e) {
			sRemito = jq(this).val();
			if(e.which == 13) {
				jq.fn.chkPattern(sRemito);
				if(bRes == true){
					bkeyPressed = true;
					jq.fn.procesaRemito(sRemito);
				}
			}
		});
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			sClick = jq(this).val();
			jq.fn.chkPattern(sRemito);
			if(bRes == true && bkeyPressed == false){
				jq.fn.procesaRemito(sRemito);
			}
			bkeyPressed = false;
		});

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