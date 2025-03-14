<?php
/*
  Controlador de Carrito
  
  Este controlador gestiona todas las operaciones relacionadas con el carrito de compras,
  incluyendo añadir productos, ver el carrito, eliminar productos y finalizar la compra.
  Funciona tanto para usuarios registrados como para invitados.
 */
include_once './models/productos.php';
include_once './vistas/view.php';

class CarritoController {
    /*
      Añade un producto al carrito de compras
      
      Recibe el ID del producto vía GET, verifica si ya existe en el carrito
      y aumenta su cantidad o lo añade con cantidad 1 si es la primera vez.
      Utiliza diferentes identificadores de carrito para usuarios registrados y anónimos.
     */
    public function addToCart() {
        if(isset($_GET['id'])) {
            $productId = $_GET['id'];
            
            if(session_status() == PHP_SESSION_NONE) {
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
    
    /*
      Muestra el contenido actual del carrito de compras
      
      Recupera los productos en el carrito, obtiene sus detalles desde la base de datos
      y calcula los subtotales por producto. Luego envía estos datos a la vista del carrito.
     */
    public function verCarrito() {
        if(session_status() == PHP_SESSION_NONE) {
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
    
    /*
      Elimina un producto específico del carrito
      
      Recibe el ID del producto vía GET y lo elimina completamente del carrito,
      independientemente de la cantidad que hubiera.
     */
    public function eliminarDelCarrito() {
        if(isset($_GET['id'])) {
            $productoId = $_GET['id'];
            
            if(session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $carritoId = isset($_SESSION['id_usuario']) ? 'user_'.$_SESSION['id_usuario'] : session_id();
            
            if(isset($_SESSION['carrito'][$carritoId][$productoId])) {
                unset($_SESSION['carrito'][$carritoId][$productoId]);
            }
            
            header('Location: index.php?controller=CarritoController&action=verCarrito');
        }
    }
    
    /*
      Finaliza el proceso de compra
      
      Verifica que el usuario esté autenticado (redirige a login si no),
    vacía el carrito del usuario y muestra la vista de compra finalizada.
     */
    public function finalizarCompra() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if(!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=UsuariosController&action=login');
            exit;
        }

        $carritoId = 'user_'.$_SESSION['id_usuario'];
        if(isset($_SESSION['carrito'][$carritoId])) {
            $_SESSION['carrito'][$carritoId] = array();
        }
        
        View::show('fincompra', null);
    }
}
?>