<?php include("include/info.php"); ?>
<?php
	if (isset($_GET['id'])){
		$id=intval($_GET['id']);
	} else {
		/*header("location:index.php");*/
	}
?>
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
			<?php include ("include/header.php"); ?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Consultar Padrón ARBA</h2></div>
                </div>
            </div>
            <?php
				include ("database_p.php");
				$clientes= new Database();
				if(isset($_POST) && !empty($_POST)){
					$nombres = $clientes->sanitize($_POST['cuit']);
					$res = $clientes->single_record($nombres);
					$row_cnt = mysqli_num_rows($res);
					
					if ($row_cnt > 0){
						/*printf("El resultado tiene %d filas.\n", $row_cnt);*/
						while ($row=mysqli_fetch_object($res)){
						$id=$row->Col9;
						$cuit=$row->Col5;
						$dated=$row->Col3;
						$dateh=$row->Col4;
						$cuit=substr($cuit,0,2)."-".substr($cuit,2,8)."-".substr($cuit,-1,1); 
						$dated="0".substr($dated,0,1)."/".substr($dated,1,2)."/".substr($dated,3,4);
						$dateh=substr($dateh,0,2)."/".substr($dateh,2,2)."/".substr($dateh,4,4);
					}
						$message= "La alícuota correspondiente al CUIT ".$cuit." es ".$id." %."." (Vigencia: ".$dated." - ".$dateh.").";
						$class="alert alert-success";
					}
					else{
						/*printf("El resultado tiene %d filas.\n", $row_cnt);*/
						$message="No se encontró el CUIT en el padrón.";
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
				<form method="post">
				<div class="col-md-6">
					<label>C.U.I.T.: (Sin guiones)</label>
					<input type="text" name="cuit" id="cuit" class='form-control' maxlength="100" required >
				</div>
				
				
				<div class="col-md-12 pull-right">
				<hr>
					<button type="submit" class="btn btn-success">Buscar</button>
				</div>
				
				
				</form>
			</div>
        </div>
    </div>     
</body>
</html>