<?php
    namespace controllers;
    use Conexion\Conexion;
    use PDO;
    require_once('config/conexion.php');
    
    
    class ProductController extends Conexion{
        private $strNombre;
        private $strPrecio;
        private $strStock;

        public $conexion;

        function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conect();
        }

        function read():array{
            $sql = "SELECT * FROM inventario.products ORDER BY id DESC";
            $query = $this->conexion->query($sql);
            $res = $query->fetchall(PDO::FETCH_ASSOC);
            return $res;
        }

        function readById(int $id):array{
            $sql = "SELECT * FROM inventario.products WHERE id = $id";
            $query = $this->conexion->query($sql);
            $res = $query->fetchall(PDO::FETCH_ASSOC);
            return $res;
        }

        function create(string $nombre, int $precio, int $stock){
            $this->strNombre = $nombre;
            $this->strPrecio = $precio;
            $this->strStock = $stock;

            $sql = "INSERT INTO inventario.products  (nombre, precio, stock) VALUES (?,?,?)";
            $query = $this->conexion->prepare($sql);
            $arrDatos = array(
                $this->strNombre,
                $this->strPrecio,
                $this->strStock
            );
            $res = $query->execute($arrDatos);
            return $this->conexion->lastInsertId();
        }

        function update(int $id, string $nombre, int $precio, int $stock):bool{
            $this->strNombre = $nombre;
            $this->strPrecio = $precio;
            $this->strStock = $stock;

            $sql = "UPDATE inventario.products SET nombre = ?, precio = ?, stock = ? WHERE id = $id";
            $prepare = $this->conexion->prepare($sql);
            $arrDatos = array(
                $this->strNombre,
                $this->strPrecio,
                $this->strStock
            );
            $res = $prepare->execute($arrDatos);
            return $res;
        }

        function delete(int $id):bool{
            $sql = "DELETE FROM inventario.products WHERE id = ?";
            $query = $this->conexion->prepare($sql);
            $res = $query->execute([$id]);
            
            return $res; // 
        }

        
    }

?>