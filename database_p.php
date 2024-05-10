<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	class Database{
		private $con;
		private $dbhost="localhost";
		private $dbuser="root";
		private $dbpass="";
		private $dbname="csv_db";
		function __construct(){
			$this->connect_db();
		}
		public function connect_db(){
			$this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
			if(mysqli_connect_error()){
				die("Error al conectar a la base de datos... " . mysqli_connect_error() . mysqli_connect_errno());
			}
			//Encoding
			mysqli_set_charset($this->con,'utf8');
		}

		
		public function sanitize($var){
			$return = mysqli_real_escape_string($this->con, $var);
			return $return;
		}
		
		public function single_record($id,$tbl){
			$sql = "SELECT `Col 3` AS Col3, `Col 4` AS Col4, `Col 5` AS Col5, `Col 9` AS Col9 FROM ".$tbl." where `Col 5`='$id'";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function single_recordA($id,$tbl){
			$sql = "SELECT `Col 2` AS Col2, `Col 3` AS Col3, `Col 4` AS Col4, `Col 8` AS Col8, `Col 9` AS Col9 FROM ".$tbl." where `Col 4`='$id'";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function multi_rfce(){
			$sql = "SELECT sei.`Col 2` AS Codigo , sei.`Col 3` AS Cliente, sei.`Col 4` AS CUIT from clie_sei sei 
			inner join rfce on rfce.`Col 1` = sei.`Col 4` where rfce.`Col 1` = sei.`Col 4` group by sei.`Col 4` order by sei.`Col 2`";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function ret_gan($id){
			$sql = "SELECT prov.`Col 1` AS Codigo , prov.`Col 3` AS CUIT, tbl_g.`Col 1` AS Regimen, tbl_g.`Col 2` AS Nombre,
			tbl_g.`Col 3` AS PoE, tbl_g.`Col 4` AS InscNinsc, tbl_g.`Col 5` AS MinimoNI, tbl_g.`Col 6` AS RetMin, tbl_g.`Col 7` AS Porcentaje 
			from prov_gecom prov inner join tbl_ganancias tbl_g on prov.`Col 6` = tbl_g.`Col 1` 
			where prov.`Col 5` = tbl_g.`Col 4` and prov.`Col 3`='$id'";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function ret_gan_v2($cuit,$regimen,$posicion){
			$sql = "SELECT tbl_g.`Col 1` AS Regimen, tbl_g.`Col 2` AS Nombre, tbl_g.`Col 3` AS PoE, tbl_g.`Col 4` AS InscNinsc, 
					tbl_g.`Col 5` AS MinimoNI, tbl_g.`Col 6` AS RetMin, tbl_g.`Col 7` AS Porcentaje 
					FROM tbl_ganancias tbl_g 
					WHERE tbl_g.`Col 1` = '$regimen' 
					AND tbl_g.`Col 4` = '$posicion'";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function esc_gan(){
			$sql = "SELECT esc.`Col 1` AS desde , esc.`Col 2` AS hasta, esc.`Col 3` AS fijoIns, esc.`Col 4` AS percent from tbl_escala_gan esc ";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function internos(){
			$sql = "SELECT numero, nombre, sector FROM interno WHERE condicion = 1";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		public function printernov1($id){
			$sql = "CALL printernov1('".$id."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
}
?>