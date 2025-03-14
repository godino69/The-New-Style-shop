<?php
/*
  Controlador de Productos
 
  Este controlador gestiona todas las operaciones relacionadas con los productos,
  incluyendo listar, ver detalles, añadir nuevos productos y eliminar productos existentes.
 */
include_once './models/productos.php';
include_once './vistas/view.php';

class ProductosController {
    /*
      Muestra el formulario para añadir productos
      
      Renderiza la vista con el formulario para añadir un nuevo producto.
     */
    public function showProductos() {
        View::show('addProduct', null);
    }
    
    /*
      Lista todos los productos disponibles
      
      Obtiene todos los productos de la base de datos y los envía
      a la vista de listado de productos.
     */
    public function listarProductos() {
        $productos = new ProductosTienda();
        $data = $productos->getProductos();
        
        View::show('listarproductos', $data);
    }
    
    /*
      Muestra los detalles de un producto específico
      
      Recibe el ID del producto vía GET, busca sus datos en la base de datos
      y muestra la vista de detalle. Si el producto no existe o no se proporciona ID,
      redirige al listado general de productos.
     */
    public function verDetalleProducto() {
        if(isset($_GET['id'])) {
            $productoId = $_GET['id'];
            
            $productos = new ProductosTienda();
            $producto = $productos->getProductoPorId($productoId);
            
            if($producto) {
                View::show('detalleProducto', $producto);
            } else {
                header('Location: index.php?controller=ProductosController&action=listarProductos');
            }
        } else {
            header('Location: index.php?controller=ProductosController&action=listarProductos');
        }
    }
    
    /*
      Procesa la adición de un nuevo producto
      
      Valida los campos del formulario, muestra errores si los hay,
      o inserta el nuevo producto en la base de datos si todo es correcto.
      Incluye validaciones para cada campo del producto.
     */
    public function aniadirProduct() {
        $errores = array();
        if(isset($_POST['insertar'])) {
            if(!isset($_POST['imagen']) || strlen($_POST['imagen']) == 0) {
                $errores['imagen'] = "El campo imagen no puede estar vacio";
            }
            if(!isset($_POST['nombre']) || strlen($_POST['nombre']) == 0) {
                $errores['nombre'] = "El campo nombre no puede estar vacio";
            }
            if(!isset($_POST['descripcion_corta']) || strlen($_POST['descripcion_corta']) < 10) {
                $errores['descripcion_corta'] = "La descripción debe tener al menos 10 caracteres";   
            }
            if(!isset($_POST['descripcion']) || strlen($_POST['descripcion']) < 20) {
                $errores['descripcion'] = "La descripción debe tener al menos 20 caracteres";   
            } 
            if(!isset($_POST['precio']) || strlen($_POST['precio']) == 0) {
                $errores['precio'] = "El precio no puede estar vacío.";
            }
            if(!isset($_POST['cantidad']) || strlen($_POST['cantidad']) == 0) {
                $errores['cantidad'] = "La cantidad no puede estar vacía.";
            }

            if(empty($errores)) {
                $productosDAO = new ProductosTienda();
                
                if($productosDAO->insertarProducto($_POST['imagen'], $_POST['nombre'], $_POST['descripcion_corta'], $_POST['descripcion'], $_POST['precio'], $_POST['cantidad'])) {
                    header('Location: index.php');
                    exit;
                } else {
                    View::show("addProduct", $errores);  
                }
            } else { 
                View::show('addProduct', $errores);
            }
        } else {
            View::show('addProduct', null);
        }
    }
    
    /*
      Muestra la interfaz de administración de productos
      
      Verifica que el usuario tenga rol de administrador, redirige si no.
      Obtiene todos los productos y los muestra en la vista de administración
      donde se pueden eliminar.
     */
    public function mostrarProductosAdmin() {
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
            header('Location: index.php');
            exit;
        }
        
        $productos = new ProductosTienda();
        $data = $productos->getProductos();
        
        View::show('delPorduct', $data);
    }
    
    /*
      Elimina un producto específico
      
      Verifica que el usuario tenga rol de administrador.
     Recibe el ID del producto vía GET y lo elimina de la base de datos,
      redirigiendo después a la vista de administración de productos.
     */
    public function eliminarProducto() {
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
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
}
?>