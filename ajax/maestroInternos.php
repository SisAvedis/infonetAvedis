<?php
    
    require_once '../modelos/Internos.php';

    $interno = new Interno();

    $numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
	$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
	$sector=isset($_POST["sector"])? limpiarCadena($_POST["sector"]):"";
	$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($numero)){
                $rspta=$interno->insertar($nombre,$sector);
                echo $rspta ? "Interno registrado" : "Interno no se pudo registrar";
            }
            else {
                $rspta=$interno->editar($numero,$nombre,$sector);
                echo $rspta ? "Interno actualizado" : "Interno no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $interno->desactivar($numero);
                echo $rspta ? "Interno desactivado" : "Interno no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $interno->activar($numero);
            echo $rspta ? "Interno activado" : "Interno no se pudos activar";
        break;

        case 'mostrar':
            $rspta = $interno->mostrar($numero);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $interno->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->numero.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->numero.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->numero.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->numero.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->numero,
                    "2"=>$reg->nombre,
                    "3"=>$reg->sector,
                    "4"=>($reg->condicion) ?
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
    }

?>