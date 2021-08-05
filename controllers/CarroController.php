<?php
    namespace controllers;
   use Conexion\Conexion;
   use PDO;
    require_once('conexion.php');
    
    
    class CarroController extends Conexion{
        private $strMarca;
        private $strColor;
        private $intPuertas;
        private $intYear;

        public $conexion;

        function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conect();
        }

        function read():array{
            $sql = "SELECT * FROM carro.carros";
            $query = $this->conexion->query($sql);
            $res = $query->fetchall(PDO::FETCH_ASSOC);
            return $res;
        }

        function readById(int $id):array{
            $sql = "SELECT * FROM carro.carros WHERE id = $id";
            $query = $this->conexion->query($sql);
            $res = $query->fetchall(PDO::FETCH_ASSOC);
            return $res;
        }

        function create(string $marca, string $color, int $puertas, int $year):bool{
            $this->strMarca = $marca;
            $this->strColor = $color;
            $this->intPuertas = $puertas;
            $this->intYear = $year;

            $sql = "INSERT INTO carro.carros  (marca, color, puertas, year) VALUES (?,?,?,?)";
            $query = $this->conexion->prepare($sql);
            $arrDatos = array(
                $this->strMarca,
                $this->strColor,
                $this->intPuertas,
                $this->intYear 
            );
            $res = $query->execute($arrDatos);
            return $res;
        }

        function update(int $id, string $marca, string $color, int $puertas, int $year):bool{
            $this->strMarca = $marca;
            $this->strColor = $color;
            $this->intPuertas = $puertas;
            $this->intYear = $year;

            $sql = "UPDATE carro.carros SET marca = ?, color = ?, puertas = ?, year = ? WHERE id = $id";
            $prepare = $this->conexion->prepare($sql);
            $arrDatos = array(
                $this->strMarca,
                $this->strColor,
                $this->intPuertas,
                $this->intYear 
            );
            $res = $prepare->execute($arrDatos);
            return $res;
        }

        function delete(int $id):bool{
            $sql = "DELETE FROM carro.carros WHERE id = ?";
            $query = $this->conexion->prepare($sql);
            $res = $query->execute([$id]);
            
            return $res; // 
        }

        
    }

?>