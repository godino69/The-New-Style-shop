<?php

include ('db/conexion.php');


class ProductosTienda{

    private $dbh;

    public function __construct(){
        $this->dbh=Conexion::conectar();
    }
    

    public function getProductos(){
        try{
            
            $dbh=Conexion::conectar();
            
            $stmt = $this->dbh->prepare("SELECT * FROM productos");
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function insertarProducto($imagen,$nombre,$descripcion_corta,$descripcion,$precio,$cantidad){
        try{
            $dbh=Conexion::conectar();
            $stmt = $this->dbh->prepare("INSERT INTO productos (imagen,nombre_producto,descripcion_producto,descripcion_completa,precio,cantidad) VALUES (:imagen,:nombre,:descripcion_corta,:descripcion,:precio,:cantidad)");
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion_corta', $descripcion_corta);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':cantidad', $cantidad);

            return $stmt->execute();
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function eliminarProducto($id) {
        try {
            $stmt = $this->dbh->prepare("DELETE FROM productos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getProductoPorId($id) {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM productos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    


}
?>