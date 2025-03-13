<div class="container mt-4">
    <h2 class="mb-3">Listado de Productos</h2>
    
    <div class="row row-cols-2 row-cols-md-4 g-3">
        <?php foreach ($data as $producto): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <a href="index.php?controller=ProductosController&action=verDetalleProducto&id=<?php echo $producto->id; ?>">
                        <img src="../imagenes/<?php echo $producto->imagen; ?>" class="card-img-top" alt="Imagen del producto" style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body p-2">
                        <h6 class="card-title"><?php echo $producto->nombre_producto; ?></h6>
                        <p class="card-text small"><?php echo $producto->descripcion_producto; ?></p>
                    </div>
                    <div class="card-footer p-2 d-flex justify-content-between align-items-center">
                        <span class="fw-bold"><?php echo $producto->precio; ?> €</span>
                        <a href="index.php?controller=ProductosController&action=addToCart&id=<?php echo $producto->id; ?>" class="btn btn-sm btn-primary">Añadir al carrito</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>