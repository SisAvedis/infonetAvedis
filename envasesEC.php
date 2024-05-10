<?php include("include/info.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo($titulo.$seccion); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<link rel="stylesheet" href="css/material-icons.css">
<script type="text/javascript" src="js/bootstrap.js"></script>
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
                    <div class="col-sm-8"><h3>Administración de Envases</b></h3></div>
                </div>
            </div>
            
			<?php
			$message= "Página en Construcción";
			$class="alert alert-success";
			?>
			
			<div class="<?php echo $class?>">
				  <?php echo $message;?>
			</div>
			
        </div>
    </div>     
</body>
</html>