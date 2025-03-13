<?php
class Conexion {
    public static function conectar() {
        try {
            $host = 'entornophp3_mariadb_1';
            $dbnname = 'tienda';
            $user = 'root';
            $pass = 'changepassword';
            
            $dns = "mysql:host=$host;dbname=$dbnname";
            $dbh = new PDO($dns, $user, $pass);
            
            return $dbh;
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>