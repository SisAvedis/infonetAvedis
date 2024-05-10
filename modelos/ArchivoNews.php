<?php
    require '../config/conexionNews.php';

    Class Archivo 
    {
        public function __construct()
        {

        }
		
		function insert_img($title, $folder, $image){
			$con = con();
			$con->query("insert into image (title, folder,src,created_at) value (\"$title\",\"$folder\",\"$image\",NOW())");
		}
		
		
		
        public function insertar($idnoticia,  $carpeta, $archivo)
        {
            
			$sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			
			
			$sql = "INSERT INTO archivo (
                    idnoticia,
                    carpeta,
					fuente,
                    fecha_hora
                   ) 
                    VALUES (
						'$idnoticia',
                        '$carpeta',
						'$archivo',
                        '$fecha_hora[fechahora]'
                        )";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		//METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idnoticia)
        {
            $sql = "SELECT * FROM archivo 
                    WHERE idnoticia='$idnoticia'";

            //echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function eliminar($idnoticia)
        {
            $sql= "DELETE FROM archivo 
                   WHERE idnoticia='$idnoticia'";
            
            return ejecutarConsulta($sql);
        }
		
		

    }

?>