<?php
    require '../config/conexion.php';

    Class Consultas
    {
        public function __construct()
        {

        }

        public function consultadocumento($idsector)
        {
            $sql = "SELECT 
                        s.nombre as sector,
					CONCAT(td.codigo,'-00',d.iddocumento) AS codigo,
                    d.iddocumento,
                        d.nombre,
						d.descripcion,
						d.vigencia,
						d.condicion
                    FROM
                        documento d
					INNER JOIN sector s
					ON d.idsector = s.idsector
                    INNER JOIN tipo_documento td 
				    ON d.idtipo_documento = td.idtipo_documento
					WHERE 
						d.idsector IN ( '$idsector')
                        AND d.nombre LIKE '%PON%'
					AND
                        d.condicion = 1
					
                    
                    ";
			//echo $sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		public function muestradocumentos($iddocumento)
        {
            $sql = "CALL prTraerArchivos('".$iddocumento."')";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
        public function consultadocumentoExcel($idsector)
        {
            $sql = "CALL `prListarDocumentosExcel`('$idsector')
                    ";
			//echo $sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		public function listarDetalle($iddocumento)
        {
            $sql = "CALL prTraerArchivos('".$iddocumento."')";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function totalProcedimiento()
        {
            $sql= "SELECT 
                        IFNULL(COUNT(iddocumento),0) as cantidad_procedimiento
                    FROM
                        documento
                    WHERE
                        idtipo_documento = 1";
            
            return ejecutarConsulta($sql);
        }
		
		public function totalInstructivo()
        {
            $sql= "SELECT 
                        IFNULL(COUNT(iddocumento),0) as cantidad_instructivo
                    FROM
                        documento
                    WHERE
                        idtipo_documento = 2";
            
            return ejecutarConsulta($sql);
        }
		
		public function procedimientos12meses()
        {$sql = "SET lc_time_names = es_ES";
            ejecutarConsulta($sql);
            $sql= "SELECT 
                        CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora,'%M'), 1)), 
                             LCASE(SUBSTRING(DATE_FORMAT(fecha_hora,'%M'), 2))) as fecha,
                        COUNT(iddocumento) as total
                    FROM
                        documento
                    WHERE
						idtipo_documento = 1 
					GROUP BY
                        MONTH(fecha_hora) 
                    ORDER BY
                        fecha_hora
                    DESC limit 0,12";
            
            return ejecutarConsulta($sql);
        }
		
		public function instructivos12meses()
        {$sql = "SET lc_time_names = es_ES";
            ejecutarConsulta($sql);

            $sql= "SELECT 
                        CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora,'%M'), 1)), 
                             LCASE(SUBSTRING(DATE_FORMAT(fecha_hora,'%M'), 2))) as fecha,
                        COUNT(iddocumento) as total
                    FROM
                        documento
                    WHERE
						idtipo_documento = 2 
					GROUP BY
                        MONTH(fecha_hora) 
                    ORDER BY
                        fecha_hora
                    DESC limit 0,12";
            
            return ejecutarConsulta($sql);
        }

    }

?>