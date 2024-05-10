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
		
		public function single_record($id){
			$sql = "SELECT `Col 3` AS Col3, `Col 4` AS Col4, `Col 5` AS Col5, `Col 9` AS Col9 FROM tbl_name where `Col 5`='$id'";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
}
?>