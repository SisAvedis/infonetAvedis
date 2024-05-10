<?php
    require '../config/conexionNews.php';

    Class Noticia
    {
        public function __construct()
        {

        }

        public function insertar($idsector,$idusuario,$titulo,$descripcion,$fechahora)
        {
            global $conexion;
            $sw = true;
            $sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_creacion = ejecutarConsultaSimpleFila($sql);
			
			
			$sql = "INSERT INTO 
                        intranetNews.noticias (
							idusuario,
                            idsector,
							fecha_creacion,
                            fecha_hora,
                            titulo,
                            descripcion,
                            condicion
                        ) 
                    VALUES (
						'$idusuario',
						'$idsector',
						'$fecha_creacion[fechahora]',
						'$fechahora',
                        '$titulo',
                        '$descripcion',
                        '1')";
            //echo 'Variable sql -> '.$sql.'</br>';
			$idnoticianew=ejecutarConsulta_retornarID($sql) or $sw = false;
			
            if(!$sw)
            {
                echo $conexion->error;
            }
			$sql= "SELECT idnoticia FROM noticias 
                   WHERE idnoticia='$idnoticianew'";
			return ejecutarConsulta($sql);

           
        }

        public function editar($idnoticia,$idsector,$idusuario,$titulo,$descripcion)
        {
            $sql = "UPDATE noticias SET 
                    idsector ='$idsector',
                    idusuario ='$idusuario',
                    titulo = '$titulo', 
                    descripcion = '$descripcion' 
                    WHERE idnoticia='$idnoticia'";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		
        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivar($idnoticia)
        {
            $sql= "UPDATE noticias SET condicion='0' 
                   WHERE idnoticia='$idnoticia'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idnoticia)
        {
            $sql= "UPDATE noticias SET condicion='1' 
                   WHERE idnoticia='$idnoticia'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idnoticia)
        {
            $sql = "SELECT 
					n.idnoticia,
					n.idusuario,
					n.titulo as titulo,
					n.idsector,
					n.descripcion,
					a.fuente as nombrearchivo,
					a.carpeta,
                    DATE(n.fecha_hora) as fecha,
					n.condicion
					FROM intranetNews.noticias n
					LEFT JOIN intranetNews.archivo a
					ON n.idnoticia = a.idnoticia
					WHERE n.idnoticia='$idnoticia'";
			
            return ejecutarConsultaSimpleFila($sql);
        }
		
		public function listarDetalle($idnoticia)
        {
            $sql = "SELECT 
					a.idnoticia,
					a.carpeta,
					a.fuente
					FROM intranetNews.archivo a
					WHERE a.idnoticia='$idnoticia'";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function ver($idnoticia)
        {
            $sql = "SELECT 
					a.idnoticia,
					a.carpeta,
					a.fuente
					FROM archivo a
					WHERE a.idnoticia='$idnoticia'";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsultaSimpleFila($sql);
        }
		
		
        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT 
            n.idnoticia, 
            n.idsector as sector,
            n.fecha_hora as fecha,
            n.titulo,
            n.descripcion,
            n.condicion 
            FROM intranetNews.noticias n 
            ORDER BY n.fecha_hora DESC";

            return ejecutarConsulta($sql);
        }
				
		public function listarInstructivos($idsector)
		{
			$sql="SELECT 
					d.idnoticia,
					d.codigo,
					d.nombre,
					d.descripcion,
					d.idsector,
					s.nombre as sector,
					d.condicion 
				FROM noticia d 
				INNER JOIN sector s
				ON d.idsector=s.idsector
				WHERE d.idtipo_noticia=2
				AND d.idsector='$idsector'
				ORDER by d.idnoticia desc";
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
            $sql = "SELECT * FROM noticia 
					WHERE idtipo_noticia = 1
					AND idsector='$idsector'";

            return ejecutarConsulta($sql);
        }
		
       
		//METODO PARA LISTAR LOS REGISTROS
        public function listarSimple()
        {
            $sql = "SELECT idnoticia,codigo,nombre, descripcion FROM noticia";

            return ejecutarConsulta($sql);
        }

    }

?>