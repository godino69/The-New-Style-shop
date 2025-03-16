<div class="container mt-3">
    <h1>Gestión de Productos</h1>
    
    <?php if(empty($data)): ?>
        <!-- Mensaje que se muestra cuando no hay productos disponibles -->
        <div class="alert alert-info">
            No hay productos disponibles.
        </div>
        <div class="mt-3">
            <a href="index.php?controller=ProductosController&action=showProductos" class="btn btn-primary">Añadir Nuevo Producto</a>
            <a href="index.php" class="btn btn-secondary">Volver a Tienda</a>
        </div>
    <?php else: ?>
        <!-- Tabla que muestra los productos disponibles para gestión -->
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
                        <!-- Muestra la imagen del producto -->
                        <img src="../imagenes/<?php echo $producto->imagen; ?>" alt="Imagen del producto" width="50">
                    </td>
                    <td><?php echo $producto->nombre_producto; ?></td>
                    <td><?php echo $producto->descripcion_producto; ?></td>
                    <td><?php echo $producto->precio; ?> €</td>
                    <td><?php echo $producto->cantidad; ?></td>
                    <td>
                    <!-- Botón para eliminar un producto -->
                    <a href="index.php?controller=ProductosController&action=eliminarProducto&id=<?php echo $producto->id; ?>" 
                        class="btn btn-danger btn-sm">
                        Eliminar
                    </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Botones para añadir un nuevo producto o volver a la tienda -->
        <div class="mt-3">
            <a href="index.php?controller=ProductosController&action=showProductos" class="btn btn-primary">Añadir Nuevo Producto</a>
            <a href="index.php" class="btn btn-secondary">Volver a Tienda</a>
        </div>
    <?php endif; ?>
</div>