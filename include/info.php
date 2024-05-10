<?php
session_start();

define('root_path', '/');

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

$curPage = curPageName();

$titulo = "AVEDIS | ";

$activo = "activo";

switch ($curPage){
	case 'index.php':
		$seccion = "Inicio";
		$home = $activo;
	break;
	case 'envasesEC.php':
		$seccion = "Envases";
		$home = $activo;
	break;
	case 'cpadronARBA.php':
		$seccion = "Padrón ARBA";
		$home = $activo;
	break;
	case 'cpadronAGIP.php':
		$seccion = "Padrón AGIP";
		$update = $activo;
	break;
	case 'consultapadron.php':
		$seccion = "Padrones";
		$create = $activo;
	break;
	case 'abmEnvases.php':
		$seccion = "ABM Envases";
		$create = $activo;
	break;
	case 'pruebaJQ.php':
		$seccion = "JQuery";
		$create = $activo;
	break;
	case 'rfce.php':
		$seccion = "RFCE";
		$create = $activo;
	break;
	case 'procs.php':
		$seccion = "Procedimientos";
		$create = $activo;
	break;
	case 'pruebaRTIBG.php':
		$seccion = "Cálculo Retenciones";
		$create = $activo;
	break;
	case 'internos.php':
		$seccion = "Internos";
		$create = $activo;
	break;
	case 'internos-v2.php':
		$seccion = "Internos";
		$create = $activo;
	break;
	case 'qr.php':
		$seccion = "Leer QR";
		$create = $activo;
	break;
}

?>
