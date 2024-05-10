<?php
    require '../config/conexion.php';

    Class Archivo 
    {
        public function __construct()
        {

        }
		
		function insert_img($title, $folder, $image){
			$con = con();
			$con->query("insert into image (title, folder,src,created_at) value (\"$title\",\"$folder\",\"$image\",NOW())");
		}
		
		
		
        public function insertar($iddocumento, $carpeta, $archivo)
        {
            
			$sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			
			
			$sql = "INSERT INTO archivo (
                    iddocumento,
                    carpeta,
					fuente,
                    fecha_hora
                   ) 
                    VALUES (
						'$iddocumento',
                        '$carpeta',
						'$archivo',
                        '$fecha_hora[fechahora]'
                        )";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		//METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($iddocumento)
        {
            $sql = "SELECT CONCAT('../../procs/',
            SUBSTRING(carpeta, 4)), fuente FROM archivo 
                                WHERE iddocumento='$iddocumento'";

            //echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function eliminar($iddocumento)
        {
            $sql= "DELETE FROM archivo 
                   WHERE iddocumento='$iddocumento'";
            
            return ejecutarConsulta($sql);
        }
		
		

    }

?>