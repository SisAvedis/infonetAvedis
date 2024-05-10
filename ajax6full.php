<?php

include ("database_p.php");
$orden = isset($_POST['orden']) ? $_POST['orden'] : false;; //Operador ternario -> if línea

$return_arr = array();

$tdheader = "";
$DB= new Database();
$res = $DB->printernov1($orden);
$row_cnt = mysqli_num_rows($res);

$tdheader = $tdheader."<td class='text-center'>"."<b>Nombre</b>"."</td><td class='text-center'>"."<b>Interno</b>"."</td><td class='text-center'>"."<b>Sector</b>"."</td>";

$header1 = "<table class='table table-bordered'>";
$header1 = $header1."<tbody>"."<tr>".$tdheader;


while($row = mysqli_fetch_array($res)){

	$header1 = $header1."<tr>"."<td class='text-left'>".$row['nombre']."</td>"."<td class='text-center'>".$row['numero']."<td class='text-left'>".$row['sector']."</td>"."</tr>";
}
		
				$return_arr[] = array("tabla" => $header1);
				echo json_encode($return_arr);
			
			
?>
