<?php
    namespace Conexion;
    use PDO;
    class Conexion {
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $db = "inventario";

        private $conect;

        function __construct(){
            $conexionString = "mysql:host:" . $this->host . "; dbname:" . $this->db . ";";
            $this->conect = new PDO($conexionString, $this->user, $this->pass);
        }

        public function conect(){
            return $this->conect;
        }
    }

?>