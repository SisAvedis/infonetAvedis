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
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>-->
<script type="text/javascript" src="js/mqttws31.min.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/datepicker-es.js"></script>
<script type="text/javascript" src="js/bootbox.min.js"></script>
</head>

<body>
	<div class="container">
		<!-- HEADER (start) -->
			<?php include ("include/header.php"); ?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-6"><h4>Análisis de Impurezas</h4></div>
                </div>
            </div>
        </div>    
	
			
		<div class="row">
			<div class="col-md-4">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center" colspan=4 id="lblServerTitle">Servidor</th>
						</tr>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Hora</th>
							<th class="text-center">CO</th>
							<th class="text-center">CO2</th>
						</tr>
						
					</thead>
					<tbody>
						<tr>
							<th class="text-center" id="lblFecha"></th>
							<th class="text-center" id="lblHora"></th>
							<th class="text-center" id="lblCO"></th>
							<th class="text-center" id="lblCO2"></th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>			
			 
	</div>
</body>	



<script type="text/javascript">

	
	var jq = jQuery.noConflict();
	
	jq(document).ready(function(){
		
		jq.fn.parseJSON = function(str) {
			try {
				//data = str.replace(/("ptoVta":)0+(?![\. ])/,"\"ptoVta\":");
				//data = data.replace(/("tipoCmp":)0+(?![\. ])/,"\"tipoCmp\":");
				//data = data.replace(/("nroCmp":)0+(?![\. ])/,"\"nroCmp\":");
				//data = data.replace(/("fecha":)0+(?![\. ])/,"\"fecha\":");
				data = JSON.parse(str);
			} catch (e) {
				return false;
			}
			return true;
		}
		
		var mqtt;
		var reconnectTimeout = 2000;
		var host = "10.10.0.180";
		var port = 8083;
		
		function onSuccess(){
			jq('#lblServerTitle').css("background-color","#92FF8A");
			jq('#lblServerTitle').css("color","#000333");
			jq("#lblServerTitle").text("ServoMex Conectado");
			//console.log("Conectado");
			mqtt.subscribe("test");
			connected_flag = 1;
		}
		
		function onFailure(errmsg){
			console.log(errmsg.errorMessage);
			jq('#lblServerTitle').css("background-color","#EE2C25");
			jq('#lblServerTitle').css("color","#FFFFFF");
			jq("#lblServerTitle").text("ServoMex Desconectado");
			setTimeout(MQTTconnect, reconnectTimeout); 
		}
		
		function onConnectionLost(errmsg){
			console.log(errmsg.errorMessage);
			jq('#lblServerTitle').css("background-color","#A605FA");
			jq('#lblServerTitle').css("color","#000333");
			jq("#lblServerTitle").text("ServoMex Desconectado");
			connected_flag = 0; 
		}
		
		function onMessageArrived(msg){
			
			bdata = jq.fn.parseJSON(msg.payloadString);
			console.log("Valor de bdata -> " + bdata);
			if(bdata == true){
				jq("#lblFecha").text(data.fecha);
				jq("#lblHora").text(data.hora);
				jq("#lblCO").text(data.vCO + ' ' + data.un01);
				jq("#lblCO2").text(data.vCO2 + ' ' + data.un02);
			}
		}
		
		
		function MQTTconnect(){
			console.log("Conectando a " + host + ":" + port);
			mqtt = new Paho.MQTT.Client(host,port,"clientjs");
			var options = {
				timeout:3,
				userName: 'luix',
				password: '1234',
				onSuccess: onSuccess,
				onFailure: onFailure,
			};
			
			mqtt.onConnectionLost = onConnectionLost;
			mqtt.onMessageArrived = onMessageArrived;
			
			mqtt.connect(options);
			return false;
		}
		
		MQTTconnect();		
});
</script>
	
	
	
	
	</body>
</html>

