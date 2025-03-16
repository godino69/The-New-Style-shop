<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devide-width, initial-scale=1">
    <title> The New Style </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
<!--
  Página de cabecera estática. Contiene el menú de la aplicación con enlaces que apuntan a la página
  index con el controlador y acción apropiado.
-->
<div class="container">
    
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-4">The New Style</span>
        </a>
        <ul class="nav nav-pills">
            <!-- 
            Verificación condicional para mostrar enlace de administración
            Solo se muestra si el usuario tiene sesión iniciada y su rol es 'admin'
            -->
            <?php
               if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') {
                echo '<li class="nav-item"><a href="index.php?controller=ProductosController&action=mostrarProductosAdmin" class="nav-link success">Gestionar</a></li>';
              }
            ?>
            
            <!-- Enlace al carrito de compras con icono -->
            <li class="nav-item"><a href="index.php?controller=CarritoController&action=verCarrito" class="nav-link">🛒</a></li>
            
            <!-- 
            Sección condicional para mostrar opciones de sesión:
            - Si hay una sesión activa, muestra opciones para cerrar sesión y el nombre de usuario
            - Si no hay sesión, muestra la opción para iniciar sesión
            -->
            <?php if(isset($_SESSION['usuario'])): ?>
              <li class="nav-item"><a href="index.php?controller=UsuariosController&action=logout" class="nav-link active">Cerrar sesión</a></li>
              <li class="nav-item"><span class="nav-link"><?php echo $_SESSION['usuario']; ?></span></li>
            <?php else: ?>
              <li class="nav-item"><a href="index.php?controller=UsuariosController&action=login" class="nav-link active">Iniciar sesión</a></li>
            <?php endif; ?>
        </ul>
    </header>
</div>