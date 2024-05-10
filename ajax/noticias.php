<?php
    
    require_once '../modelos/Noticias.php';
	require_once '../classes/class.upload.php';
	require_once "../modelos/ArchivoNews.php";
	//header('Content-Type: text/html; charset=utf-8');
	
	if(strlen(session_id()) < 1){
        session_start();
    }

	$noticia = new Noticia();

    $idnoticia=isset($_POST["idnoticia"])? limpiarCadena($_POST["idnoticia"]):"";
    $idsector=isset($_POST["idsector"])? limpiarCadena($_POST["idsector"]):"";
	$idusuario= $_SESSION['idusuario'];
    $titulo=isset($_POST["titulo"])? limpiarCadena($_POST["titulo"]):"";
    $fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
    $descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
    	
    switch($_GET["op"])
    {
        case 'guardaryeditar':
			
			if (empty($idnoticia)){
                $rspta=$noticia->insertar($idsector,$idusuario,$titulo,$descripcion,$fecha);
                if($rspta){
					while ($reg = $rspta->fetch_object())
						{
							$idnoticia = $reg->idnoticia;
						}
				}
				echo $rspta ? "Noticia registrada"."</br>" : "Noticia no se pudo registrar"."</br>";
            }
            else {
                $rspta=$noticia->editar($idnoticia,$idsector,$idusuario,$titulo,$descripcion);
                echo $rspta ? "Noticia actualizada"."</br>" : "Noticia no se pudo actualizar"."</br>";
            }
					
			
			if(file_exists($_FILES["archivo"]['tmp_name']) || is_uploaded_file($_FILES["archivo"]['tmp_name']))
			{
				$handle = new Upload($_FILES["archivo"],'es_ES');
				$handle->file_auto_rename = false;
				if ($handle->uploaded) {
					$handle->Process("../uploads/");
					if ($handle->processed) {
						$archivo = new Archivo();
						$rspta = $archivo->insertar($idnoticia,"../uploads/",$handle->file_dst_name);
						echo $rspta ? "Archivo subido" : "Archivo no se pudo subir";
					} else {
					echo 'Error: ' . $handle->error . '</br>';
					}
				} else {
					echo 'Error: ' . $handle->error . '</br>';
				}
			
			}	
			
			
            
        break;
		
		case 'eliminar':
			$archivo = new Archivo();
			$rspta = $archivo->mostrar($idnoticia);
			if($rspta){
				while ($reg = $rspta->fetch_object())
					{
						$ruta = $reg->carpeta.$reg->fuente;
					}
			}
			
			$rspta = $archivo->eliminar($idnoticia);
			if($rspta){
				unlink($ruta);
			}
			
			
			$rspta = $noticia->mostrar($idnoticia);
			echo json_encode($rspta);
			//echo $rspta ? "noticia eliminado" : "noticia no se pudo eliminar";
        break;
		
		
        case 'desactivar':
                $rspta = $noticia->desactivar($idnoticia);
                echo $rspta ? "Noticia desactivada" : "Noticia no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $noticia->activar($idnoticia);
            echo $rspta ? "Noticia activada" : "Noticia no se pudo activar";
        break;
		
		case 'subir':
			require_once '../classes/class.upload.php';
			require_once "../modelos/ArchivoNews.php";
            
			$handle = new Upload($_FILES["archivo"]);
			if ($handle->uploaded) {
				$handle->Process("../uploads/");
				if ($handle->processed) {
					$archivo = new archivo();
					$rspta = $archivo->insertar($idnoticia,"","../uploads/",$handle->file_dst_name);
					echo $rspta ? "Noticia subida" : "Noticia no se pudo subir";
					
					//insert_img("","uploads/",$handle->file_dst_name);
				} else {
				echo 'Error: ' . $handle->error;
				}
			} else {
				echo 'Error: ' . $handle->error;
			}
			unset($handle);
			
        break;
		
        case 'mostrar':
            $rspta = $noticia->mostrar($idnoticia);
            echo json_encode($rspta);
        break;
		
		case 'listarDetalle':
			//Recibimos el idingreso
			$id=$_GET['id'];
	
			$rspta = $noticia->listarDetalle($id);
			
			if($rspta){
				if($rspta->num_rows === 0){
					
					//echo '<thead><th><label id="lblarchivo">Archivo a subir:</label></th></thead>';
					//echo '<tbody><tr class="filas"><td><input type="file" class="form-control" name="archivo" id="archivo"></td></tr></tbody>';
					
				
				}
				else{
				
					while ($reg = $rspta->fetch_object())
						{
							//<input type="text" class="form-control" name="nombrearchivo" id="nombrearchivo" maxlength="256" placeholder="Nombre">
							//'<button class="btn btn-warning" onclick="mostrar('.$reg->idrelproins.')"><li class="fa fa-eye"></li></button>'.
							//' <button class="btn btn-danger" onclick="anular('.$reg->idrelproins.')"><li class="fa fa-close"></li></button>'
							//echo '<tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'></td></tr><tr><td>'.$reg->idnoticia.'</td><td>'.htmlspecialchars($reg->carpeta).'</td><td>'.htmlspecialchars($reg->fuente).'</td><td>';
							
							/*
							echo '<tbody><tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'></td></tr><tr><td><a target="_blank" href="'.htmlspecialchars($reg->carpeta).htmlspecialchars($reg->fuente).'"><button class="btn btn-success" onclick="bostrar('.$reg->idnoticia.')"><li class="fa fa-eye"></li></button></a>'.'<button class="btn btn-danger" onclick="eliminar('.$reg->idnoticia.')"><li class="fa fa-eye"></li></button></td></tr></tbody>';
							*/
							/*
							echo '<tbody><tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'></td></tr><tr><td><button class="btn btn-success" onclick="ver('.htmlspecialchars($reg->carpeta).htmlspecialchars($reg->fuente).')"><li class="fa fa-eye"></li></button>'.'<button class="btn btn-danger" onclick="ver('.$reg->idnoticia.')"><li class="fa fa-eye"></li></button></td></tr></tbody>';
							*/
							echo '<thead><th><label id="lblarchivosubido">Archivo subido:</label></th></thead>';
							echo '<tbody><tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'><input type="hidden" name="rutaarchivo" id="rutaarchivo" value="'.htmlspecialchars($reg->carpeta).htmlspecialchars($reg->fuente).'"></td></tr></tbody>';
						}
					}	
				}
		break;
		
        case 'listar':
            $rspta = $noticia->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion == 1) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idnoticia.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idnoticia.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idnoticia.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idnoticia.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->fecha,
					"2"=>$reg->titulo,
					"3"=>'<td>'.htmlspecialchars($reg->descripcion).'</td>',
                    "4"=>'<td>'.htmlspecialchars($reg->sector).'</td>',
					"5"=>($reg->condicion == 1) ?
                         '<span class="label bg-green">Activado</span>'
                         :      
                         '<span class="label bg-red">Desactivado</span>'
				);
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);
        break;

		case 'listarParaBlog':
            $rspta = $noticia->listar();
            while ($reg = $rspta->fetch_object()) {
                echo($reg->condicion == 1) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idnoticia.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idnoticia.')"><li class="fa fa-close"></li></button>'
                        
                    .'<div>'.$reg->fecha.'</div>'
					.'<div>'.htmlspecialchars($reg->titulo).'</div>'
					.'<div>'.htmlspecialchars($reg->descripcion).'</div>'
                    .'<div>'.htmlspecialchars($reg->sector).'</div>'
					:'';
            }
           
        break;
	
        case 'selectSector':
            require_once "../modelos/Sector.php";
            $sector = new Sector();

            $rspta = $sector->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idsector.'>'
                        .$reg->nombre.
                      '</option>';
            }
        break;
		
	/*	case 'selectTiponoticia':
            require_once "../modelos/TipoNoticia.php";
            $tiponoticia = new TipoNoticia();

            $rspta = $tiponoticia->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtipo_noticia.'>'
                        .$reg->descripcion.
                      '</option>';
            }
        break;
*/
		case 'selectNoticia':
            $rspta = $noticia->listarSimple();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idnoticia.'>'
                        .$reg->codigo.' - '.$reg->nombre.' - '.$reg->descripcion.
                      '</option>';
            }
        break;
		
		case 'selectNoticiaSector':
            $rspta = $noticia->listarNoticiaSector($idsector);

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idnoticia.'>'
                        .$reg->codigo.' - '.$reg->nombre.' - '.$reg->descripcion.
                      '</option>';
            }
        break;

    }

?>