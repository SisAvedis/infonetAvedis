<?php
	
	class connectionParams {
	}
	
	class DatabaseP{
		private $con;
		function __construct(){
			$this->connect_db();
		}
		public function connect_db(){
			$param = new connectionParams;
			
			// 'host' for the PostgreSQL server
			$param->host = "10.10.0.231";
			
			// default port for PostgreSQL is "5432"
			$param->port = 5432;
			
			// set the database name for the connection
			$param->dbname = "AVEDISTEST";
			
			// set the username for PostgreSQL database
			$param->user = "calipso";
			
			// password for the PostgreSQL database
			$param->password = ".javalli94";
			
			// declare a new string for the pgconnect method
			$hostString = "";
		
			// use an iterator to concatenate a string to connect to PostgreSQL
			foreach ($param as $key => $value) {
			
			// concatenate the connect params with each iteration
			$hostString = $hostString . $key . "=" . $value . " ";
			}
			
			$this->con = pg_connect($hostString);
			
			return $this->con;
		}

		
		public function get_prov($id){
			$sql = "SELECT CASE WHEN PROV.DENOMINACION <> '' THEN PROV.DENOMINACION ELSE PERS.NOMBRE END, PROV.CUIT, 
				CASE WHEN SUBSTRING(IMPUESTO.CODIGORESOLUCION,1,2) = '78' THEN '78'
				ELSE IMPUESTO.CODIGORESOLUCION END AS IMP_CODIGORESOLUCION, 
				CASE WHEN POSICION.CODIGO = 'RI' THEN 1 ELSE 0 END AS POSICION
				FROM V_PROVEEDOR PROV 
				LEFT OUTER JOIN V_PERSONA PERS
				ON PROV.ENTEASOCIADO_ID = PERS.ID
				INNER JOIN V_POSICIONADORIMPUESTOS POSICIONADOR 
				ON POSICIONADOR.ID = PROV.POSICIONADORIMPUESTOS_ID 
				INNER JOIN V_ITEMPOSICIONADORIMPUESTOS ITEMPOSICIONADOR 
				ON ITEMPOSICIONADOR.BO_PLACE_ID = POSICIONADOR.ITEMSPOSICIONADORIMPUESTOS_ID 
				INNER JOIN V_DEFINICIONIMPUESTO DEF_IMPUESTO 
				ON DEF_IMPUESTO.ID = ITEMPOSICIONADOR.DEFINICIONIMPUESTO_ID 
				INNER JOIN V_IMPUESTO IMPUESTO ON IMPUESTO.ID = DEF_IMPUESTO.IMPUESTO_ID 
				INNER JOIN V_POSICIONIMPUESTO POSICION 
				ON POSICION.ID = ITEMPOSICIONADOR.POSICIONIMPUESTO_ID 
				WHERE IMPUESTO.CALCULOAUTO = 'T' AND IMPUESTO.TIPO = 'RET' AND IMPUESTO.SUBTIPO LIKE 'IG%' AND POSICION.CODIGO <> 'EX' 
				AND POSICION.CODIGO <> 'NA' AND PROV.CODIGO <> '' AND PROV.CUIT = '$id'
				ORDER BY IMPUESTO.CODIGO";
			$res = pg_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		
		public function get_prov2(){
			$sql = "SELECT * FROM ARBA_PERCEPCION_2014 WHERE CUIT IN('20000000028','20000000990','20000021742','20000033481','20000035891','30646512952')";
			$res = pg_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		
		
		
		
}
?>