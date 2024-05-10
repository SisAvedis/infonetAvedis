<?php
    require '../config/conexion.php';

    Class Documento 
    {
        public function __construct()
        {

        }

        public function insertar($idsector,$idtipo_documento,$idusuario,$codigo,$nombre,$descripcion)
        {
            $sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			
			
			$sql = "INSERT INTO 
                        documento (
                            idsector,
							idtipo_documento,
							idusuario,
							fecha_hora,
                            codigo,
                            nombre,
                            descripcion,
                            condicion
                        ) 
                    VALUES (
                        '$idsector',
						'$idtipo_documento',
						'$idusuario',
						'$fecha_hora[fechahora]',
                        '$codigo',
                        '$nombre',
                        '$descripcion',
                        '1')";
            //echo 'Variable sql -> '.$sql.'</br>';
			$iddocumentonew=ejecutarConsulta_retornarID($sql);
			
			$sql= "SELECT iddocumento FROM documento 
                   WHERE iddocumento='$iddocumentonew'";
			return ejecutarConsulta($sql);
        }

        public function editar($iddocumento,$idsector,$idtipo_documento,$idusuario,$codigo,$nombre,$descripcion)
        {
            $sql = "UPDATE documento SET 
                    idsector ='$idsector',
					idtipo_documento ='$idtipo_documento',
                    idusuario ='$idusuario',
					codigo = '$codigo', 
                    nombre = '$nombre', 
                    descripcion = '$descripcion' 
                    WHERE iddocumento='$iddocumento'";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		
        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivar($iddocumento)
        {
            $sql= "UPDATE documento SET condicion='0' 
                   WHERE iddocumento='$iddocumento'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($iddocumento)
        {
            $sql= "UPDATE documento SET condicion='1' 
                   WHERE iddocumento='$iddocumento'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($iddocumento)
        {
            $sql = "SELECT 
					d.iddocumento,
					d.idusuario,
					d.nombre as nombre,
					d.idsector,
					d.idtipo_documento,
					d.descripcion,
					a.fuente as nombrearchivo,
					a.carpeta,
					d.condicion
					FROM documento d
					LEFT JOIN archivo a
					ON d.iddocumento = a.iddocumento
					WHERE d.iddocumento='$iddocumento'";
			
            return ejecutarConsultaSimpleFila($sql);
        }
		
		public function listarDetalle($iddocumento)
        {
            $sql = "SELECT 
					a.iddocumento,
					CONCAT('../../procs/',
                    SUBSTRING(a.carpeta, 4)),
					a.fuente
					FROM archivo a
					WHERE a.iddocumento='$iddocumento'";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function ver($iddocumento)
        {
            $sql = "SELECT 
					a.iddocumento,
					CONCAT('../../procs/',
                    SUBSTRING(a.carpeta, 4)),
					a.fuente
					FROM archivo a
					WHERE a.iddocumento='$iddocumento'";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsultaSimpleFila($sql);
        }
		
		
        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT 
                    d.iddocumento, 
                    d.idsector,
					d.fecha_hora as fecha,
                    s.nombre as sector,
                    d.idtipo_documento, 
                    td.descripcion as tipodocumento,
					d.codigo,
                    d.nombre,
                    d.descripcion,
                    d.imagen,
                    d.condicion 
                    FROM documento d 
                    INNER JOIN sector s 
                    ON d.idsector = s.idsector
					INNER JOIN tipo_documento td
					ON d.idtipo_documento = td.idtipo_documento";

            return ejecutarConsulta($sql);
        }
				
		public function listarInstructivos($idsector)
		{
			$sql="SELECT 
					d.iddocumento,
					d.codigo,
					d.nombre,
					d.descripcion,
					d.idsector,
					s.nombre as sector,
					d.condicion 
				FROM documento d 
				INNER JOIN sector s
				ON d.idsector=s.idsector
				WHERE d.idtipo_documento=2
				AND d.idsector='$idsector'
				ORDER by d.iddocumento desc";
			//echo 'Variable sql -> '.$sql.'</br>';	
			return ejecutarConsulta($sql);		
		}
		
		public function listarInstructivosUno($iddocsec)
        {
            $sql = "CALL prParseArrayv2('".$iddocsec."')";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		
		
		//METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function selectPro($idsector)
        {
            $sql = "SELECT * FROM documento 
					WHERE idtipo_documento = 1
					AND idsector='$idsector'";

            return ejecutarConsulta($sql);
        }
		
       
		//METODO PARA LISTAR LOS REGISTROS
        public function listarSimple()
        {
            $sql = "SELECT iddocumento,codigo,nombre, descripcion FROM documento";

            return ejecutarConsulta($sql);
        }

    }

?>