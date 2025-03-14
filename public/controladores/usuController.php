<?php
/*
  Controlador de Usuarios
  
  Este controlador gestiona todas las operaciones relacionadas con la autenticación
  de usuarios, incluyendo mostrar el formulario de login, verificar credenciales
  y cerrar sesión.
 */
include_once './models/usuarios.php';
include_once './vistas/view.php';

class UsuariosController {
    /*
      Muestra el formulario de inicio de sesión
      
      Renderiza la vista del formulario de login para que el usuario
      pueda introducir sus credenciales.
     */
    public function login() {
        View::show('login');
    }
    
    /*
      Verifica las credenciales de inicio de sesión
      
      Valida que se hayan proporcionado el usuario y contraseña,
      verifica que coincidan con registros en la base de datos,
      e inicia la sesión si son correctos. Muestra errores si hay problemas.
     */
    public function verificarLogin() {
        $errores = array();
        
        if(isset($_POST['enviar'])) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            
            if(empty($usuario)) {
                $errores['usuario'] = "El usuario no puede estar vacío";
            }
            
            if(empty($password)) {
                $errores['password'] = "La contraseña no puede estar vacía";
            }
            
            if(empty($errores)) {
                $usuariosDAO = new Usuarios();
                $user = $usuariosDAO->verificarUsuario($usuario, $password);
                
                if($user) {
                    if(session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id_usuario'] = $user->id;
                    $_SESSION['rol'] = $user->rol;
                    
                    header('Location: index.php');
                    exit;
                } else {
                    $errores['login'] = "Usuario o contraseña incorrectos";
                    View::show('login', $errores);
                }
            } else {
                View::show('login', $errores);
            }
        } else {
            View::show('login', null);
        }
    }
    
    /*
      Cierra la sesión del usuario
      
      Inicia la sesión si no está activa, vacía el array de sesión,
      destruye la sesión y redirige al usuario a la página principal.
     */
    public function logout() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();
        
        session_destroy();
        
        header('Location: index.php');
        exit;
    }
}
?>