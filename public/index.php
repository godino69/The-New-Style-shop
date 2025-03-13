<?php
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once ("vistas/header.php");
include ("./controladores/proController.php");


if (isset($_REQUEST['action']) && isset($_REQUEST['controller']) ){
    $act=$_REQUEST['action'];
    $cont=$_REQUEST['controller'];

    //Instanciación del controlador e invocación del método
    $controller=new $cont();
    $controller->$act();

}else{
    $controller = new ProductosController();
    $controller->listarProductos();
} 

  require_once ("vistas/footer.php");
ob_end_flush();

?>

