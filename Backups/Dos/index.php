<?php include("include/info.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo($titulo.$seccion); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
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
                    <div class="col-sm-8"><h3>Listado de  <b>Clientes</b></h3></div>
                    <!--<div class="col-sm-4">
                        <a href="create.php" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar cliente</a>
                    </div>-->
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombres</th>
                        <th>Dirección</th>
						<th>Localidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                 
                <tbody>    
                <?php 
				include ('database.php');
				$clientes = new Database();
				$listado=$clientes->read();
				?>
				<?php 
				while ($row=mysqli_fetch_object($listado)){
				$id=$row->id;
				$nombres=$row->nombres." ".$row->apellidos;
				$codigo=$row->codigo;
				$direccion=$row->direccion;
				$localidad=$row->localidad;
				?>
				<tr>
					<td><?php echo $codigo;?></td>
					<td><?php echo $nombres;?></td>
					<td><?php echo $direccion;?></td>
					<td><?php echo $localidad;?></td>
					<td>
						<a href="create.php?id=<?php echo $id;?>" class="edit" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE171;</i></a>
						<a href="update.php?id=<?php echo $id;?>" class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
						<a href="delete.php?id=<?php echo $id;?>" class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
					</td>
				</tr>	
<?php
}
?>

				
                </tbody>
            </table>
        </div>
    </div>     
</body>
</html>