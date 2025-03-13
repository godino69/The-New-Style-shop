<?php
include_once ('./db/conexion.php');

class Usuarios {
    private $dbh;

    public function __construct() {
        $this->dbh = Conexion::conectar();
    }

    public function verificarUsuario($usuario, $password) {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM usuario WHERE username = :usuario");
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($user && $user->password === $password) {
                return $user;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }
    
}
?>