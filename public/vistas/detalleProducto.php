<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="../imagenes/<?php echo $data->imagen; ?>" alt="<?php echo $data->nombre_producto; ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h1><?php echo $data->nombre_producto; ?></h1>
            <hr>
            <p class="lead"><?php echo $data->descripcion_completa; ?></p>
            
            <div class="my-4">
                <h3 class="text-primary"><?php echo $data->precio; ?> €</h3>
            </div>
            
            <div class="d-grid gap-2">
                <a href="index.php?controller=ProductosController&action=addToCart&id=<?php echo $data->id; ?>" class="btn btn-primary btn-lg">Añadir al Carrito</a>
                <a href="index.php" class="btn btn-outline-secondary">Volver a Productos</a>
            </div>
        </div>
    </div>
</div>