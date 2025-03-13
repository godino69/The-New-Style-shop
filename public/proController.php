<?php

include 'productos.php';
include './vistas/view.php';
    class ProductosController{

        
        public function showProductos(){
            View::show('addProduct',null);

        }
        public function verDetalleProducto() {
            if(isset($_GET['id'])) {
                $productoId = $_GET['id'];
                
                $productos = new ProductosTienda();
                $producto = $productos->getProductoPorId($productoId);
                
                if($producto) {
                    View::show('detalleProducto', $producto);
                } else {
                    header('Location: index.php?controller=ProductosController&action=getProductos');
                }
            } else {
                header('Location: index.php?controller=ProductosController&action=getProductos');
            }
        }
        public function aniadirProduct (){
            $errores=array();
            if(isset($_POST['insertar'])){
                if(!isset($_POST['imagen']) || strlen($_POST['imagen']) == 0){
                    $errores['imagen']="El campo imagen no puede estar vacio";
                }
                if(!isset($_POST['nombre']) || strlen($_POST['nombre']) == 0){
                    $errores['nombre']="El campo nombre no puede estar vacio";
                }
                if (!isset($_POST['descripcion_corta']) || strlen($_POST['descripcion_corta']) < 10) {
                    $errores['descripcion_corta']="La descripción debe tener al menos 10 caracteres";   
                }
                if (!isset($_POST['descripcion']) || strlen($_POST['descripcion']) < 20) {
                    $errores['descripcion']="La descripción debe tener al menos 20 caracteres";   
                } 
                if (!isset($_POST['precio']) || strlen($_POST['precio']) == 0){
                    $errores['precio']="El precio no puede estar vacío.";
                }
                if (!isset($_POST['cantidad']) || strlen($_POST['cantidad']) == 0){
                    $errores['cantidad']="La cantidad no puede estar vacía.";
                }

                if (empty($errores)){
                    $productosDAO=new ProductosTienda();
                    
                    if ($productosDAO->insertarProducto($_POST['imagen'], $_POST['nombre'], $_POST['descripcion_corta'], $_POST['descripcion'], $_POST['precio'], $_POST['cantidad'])) {
                        header('Location: index.php');
                        exit;
                    } else {
                        View::show("addProduct", $errores);  
                    }
                }else{ 
                    View::show('addProduct',$errores);
                }

            }else{
                View::show('addProduct',null);
            }
                
        }
        public function mostrarProductosAdmin() {
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
                header('Location: index.php');
                exit;
            }
            
            $productos = new ProductosTienda();
            $data = $productos->getProductos();
            
            View::show('delPorduct', $data);
        }
        public function eliminarProducto() {
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
                header('Location: index.php');
                exit;
            }
            
            if(isset($_GET['id'])) {
                $productoId = $_GET['id'];
                
                $productos = new ProductosTienda();
                if($productos->eliminarProducto($productoId)) {
                    header('Location: index.php?controller=ProductosController&action=mostrarProductosAdmin');
                } else {
                    // Error al eliminar
                    header('Location: index.php?controller=ProductosController&action=mostrarProductosAdmin&error=1');
                }
            } else {
                header('Location: index.php?controller=ProductosController&action=mostrarProductosAdmin');
            }
        }
        public function login() {
            View::show('login');
        }
        
        public function verificarLogin() {
            include_once 'usuarios.php';
            
            $errores = array();
            
            if (isset($_POST['enviar'])) {
                $usuario = $_POST['usuario'];
                $password = $_POST['password'];
                
                if (empty($usuario)) {
                    $errores['usuario'] = "El usuario no puede estar vacío";
                }
                
                if (empty($password)) {
                    $errores['password'] = "La contraseña no puede estar vacía";
                }
                
                if (empty($errores)) {
                    $usuariosDAO = new Usuarios();
                    $user = $usuariosDAO->verificarUsuario($usuario, $password);
                    
                    if ($user) {
                        if (session_status() == PHP_SESSION_NONE) {
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
        public function logout() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION = array();
            
            session_destroy();
            
            header('Location: index.php');
            exit;
        }
        public function addToCart() {
            if(isset($_GET['id'])) {
                $productId = $_GET['id'];
                
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                $carritoId = isset($_SESSION['id_usuario']) ? 'user_'.$_SESSION['id_usuario'] : session_id();
                
                if(!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = array();
                }
                
                if(!isset($_SESSION['carrito'][$carritoId])) {
                    $_SESSION['carrito'][$carritoId] = array();
                }
                
                if(isset($_SESSION['carrito'][$carritoId][$productId])) {
                    $_SESSION['carrito'][$carritoId][$productId]++;
                } else {
                    $_SESSION['carrito'][$carritoId][$productId] = 1;
                }
                
                header('Location: index.php');
            }
        }
        
        public function verCarrito() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $carritoId = isset($_SESSION['id_usuario']) ? 'user_'.$_SESSION['id_usuario'] : session_id();
            
            if(!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }
            
            if(!isset($_SESSION['carrito'][$carritoId])) {
                $_SESSION['carrito'][$carritoId] = array();
            }
            
            $carrito = array();
            if(!empty($_SESSION['carrito'][$carritoId])) {
                $productos = new ProductosTienda();
                $todosProductos = $productos->getProductos();
                
                $productosPorId = array();
                foreach($todosProductos as $producto) {
                    $productosPorId[$producto->id] = $producto;
                }
                
                // Construir el carrito con detalles del producto
                foreach($_SESSION['carrito'][$carritoId] as $productoId => $cantidad) {
                    if(isset($productosPorId[$productoId])) {
                        $item = $productosPorId[$productoId];
                        $item->cantidad = $cantidad;
                        $item->subtotal = $cantidad * $item->precio;
                        $carrito[] = $item;
                    }
                }
            }
            View::show('carrito', $carrito);
        }
        
        public function eliminarDelCarrito() {
            if(isset($_GET['id'])) {
                $productoId = $_GET['id'];
                
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                $carritoId = isset($_SESSION['id_usuario']) ? 'user_'.$_SESSION['id_usuario'] : session_id();
                
                if(isset($_SESSION['carrito'][$carritoId][$productoId])) {
                    unset($_SESSION['carrito'][$carritoId][$productoId]);
                }
                
                header('Location: index.php?controller=ProductosController&action=verCarrito');
            }
        }
        public function finalizarCompra() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            if (!isset($_SESSION['usuario'])) {
                header('Location: index.php?controller=ProductosController&action=login');
                exit;
            }

            $carritoId = 'user_'.$_SESSION['id_usuario'];
            if (isset($_SESSION['carrito'][$carritoId])) {
                $_SESSION['carrito'][$carritoId] = array();
            }
            
            View::show('fincompra', null);
        }
    }
    

?>
