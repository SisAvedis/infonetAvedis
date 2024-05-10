<?php
    require '../config/conexionNews.php';

    Class Permiso 
    {
        public function __construct()
        {

        }

        
        public function listar()
        {
            $sql = "SELECT * FROM permiso";

            return ejecutarConsulta($sql);
        }

    }

?>