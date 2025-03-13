<div class="container mt-3">
    <h1>Gestión de Productos</h1>
    
    <?php if(empty($data)): ?>
        <div class="alert alert-info">
            No hay productos disponibles.
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $producto): ?>
                <tr>
                    <td>
                        <img src="../imagenes/<?php echo $producto->imagen; ?>" alt="Imagen del producto" width="50">
                    </td>
                    <td><?php echo $producto->nombre_producto; ?></td>
                    <td><?php echo $producto->descripcion_producto; ?></td>
                    <td><?php echo $producto->precio; ?> €</td>
                    <td><?php echo $producto->cantidad; ?></td>
                    <td>
                    <a href="index.php?controller=ProductosController&action=eliminarProducto&id=<?php echo $producto->id; ?>" 
                        class="btn btn-danger btn-sm">
                        Eliminar
                    </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="mt-3">
            <a href="index.php?controller=ProductosController&action=showProductos" class="btn btn-primary">Añadir Nuevo Producto</a>
            <a href="index.php" class="btn btn-secondary">Volver a Tienda</a>
        </div>
    <?php endif; ?>
</div>