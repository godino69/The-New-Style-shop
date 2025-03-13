<?php
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once ("vistas/header.php");
include ("proController.php");


if (isset($_REQUEST['action']) && isset($_REQUEST['controller']) ){
    $act=$_REQUEST['action'];
    $cont=$_REQUEST['controller'];

    //Instanciación del controlador e invocación del método
    $controller=new $cont();
    $controller->$act();

}else{
    $productos = new ProductosTienda();
    $data = $productos->getProductos();
     
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-3">Listado de Productos</h2>';
    
    echo '<div class="row row-cols-2 row-cols-md-4 g-3">';
    
    foreach ($data as $producto){
        $rutaimage = "../imagenes/" . $producto->imagen;
        echo '<div class="col">';
        echo '<div class="card h-100 shadow-sm">';
        echo '<a href="index.php?controller=ProductosController&action=verDetalleProducto&id='. $producto->id .'"><img src="'. $rutaimage .'" class="card-img-top" alt="Imagen del producto" style="height: 200px; object-fit: cover;"></a>';
        echo '<div class="card-body p-2">';
        echo '<h6 class="card-title">'. $producto->nombre_producto .'</h6>';
        echo '<p class="card-text small">'. $producto->descripcion_producto .'</p>';
        echo '</div>';
        echo '<div class="card-footer p-2 d-flex justify-content-between align-items-center">';
        echo '<span class="fw-bold">'. $producto->precio .' €</span>';
        echo '<a href="index.php?controller=ProductosController&action=addToCart&id='. $producto->id .'" class="btn btn-sm btn-primary">Añadir al carritos</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
 }

  

  require_once ("vistas/footer.php");
ob_end_flush();

?>

