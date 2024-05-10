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
	<div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_p.php"); ?>
			<?php include ("include/header.php"); ?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-6"><h4>Internos de Telefonía</h4></div>
                </div>
            </div>
            
			<?php
				$DB= new Database();
				$res = $DB->internos();
				$row_cnt = mysqli_num_rows($res);
			?>		
			<div class="row">
				<div class="col-md-6">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Sector</th>
							<th>Interno</th>
						</tr>
					</thead>
			<?php
				if(!empty($res)){
					while ($row=mysqli_fetch_object($res)){
								
			?>
				<tbody>
					<tr>
						<td><?php if(isset($row->nombre)){echo $row->nombre;}else{echo "Error";}?></td>
						<td><?php if(isset($row->sector)){echo $row->sector;}else{echo "Error";}?></td>
						<td><?php if(isset($row->numero)){echo $row->numero;}else{echo "Error";}?></td>
					</tr>
			<?php
				}
			?>
				</tbody>	
				</table>
				</div>
			</div>
			
			<?php
				}else{
					$message= "La consulta arrojó un error.";
					$class="alert alert-warning";
				?>
					<div class="<?php echo $class;?>" id="rows">
						<?php echo $message;?>
					</div>
				<?php		
					}
				?>
			
        </div>
    </div>     
	</body>
</html>

