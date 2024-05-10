<?php
    require '../config/conexion_db_csv.php';

    Class Interno 
    {
        public function __construct()
        {

        }

        public function insertar($nombre,$sector)
        {global $conexion;
            $sw = true;
            $sql = "INSERT INTO interno (
                    numero,
                    nombre,
                    sector,
                    condicion
                   ) 
                    VALUES (
                        (SELECT MAX(numero)+1 FROM interno),
                        '$nombre',
                        '$sector',
						'1'
                        )";
            
             ejecutarConsulta($sql) or $sw = false;
             if(!$sw){
                echo $conexion->error;
             }

                return $sw;
        }

        public function editar($numero,$nombre,$sector)
        {
            $sql = "UPDATE interno SET 
                    nombre='$nombre',
                    sector='$sector'
                    WHERE numero='$numero'";
            
            return ejecutarConsulta($sql);
        }

        
        public function eliminar($idpersona)
        {
            $sql= "DELETE FROM persona 
                   WHERE idpersona='$idpersona'";
            
            return ejecutarConsulta($sql);
        }
        public function desactivar($numero)
        {
            $sql= "UPDATE interno SET condicion='0' 
                   WHERE numero='$numero'";
            
            return ejecutarConsulta($sql);
        }
        public function activar($numero)
        {
            $sql= "UPDATE interno SET condicion='1' 
                   WHERE numero='$numero'";
            
            return ejecutarConsulta($sql);
        }


        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($numero)
        {
            $sql = "SELECT * FROM interno 
                    WHERE numero='$numero'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT * FROM interno
                    ";

            return ejecutarConsulta($sql);
        }

        public function listarc()
        {
            //$sql = "SELECT * FROM persona 
            //        WHERE tipo_persona='Cliente'";
			
			$sql= "SELECT 
					p.idpersona,
					p.tipo_persona,
					p.nombre,
					p.tipo_documento,
					p.num_documento,
					p.direccion,
					p.telefono,
					p.email,
					s.idsector,
					s.nombre as sector
					FROM
						persona p
					INNER JOIN
						sector s
					ON
						p.idsector = s.idsector
					WHERE p.tipo_persona='Cliente'";
			
			
            return ejecutarConsulta($sql);
        }

    }

?>