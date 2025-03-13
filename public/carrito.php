<div class="container mt-3">
    <h1>Tu Carrito de Compra</h1>
    
    <?php if(empty($data)): ?>
        <div class="alert alert-info">
            Tu carrito está vacío.
        </div>
        <a href="index.php" class="btn btn-primary">Ver Productos</a>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach($data as $producto) { 
                    $rutaimage = "../imagenes/" . $producto->imagen;
                    $total += $producto->subtotal;
                ?>
                <tr>
                    <td><img src="<?php echo $rutaimage; ?>" alt="Imagen del producto" width="50"></td>
                    <td><?php echo $producto->nombre_producto; ?></td>
                    <td><?php echo $producto->precio; ?> €</td>
                    <td><?php echo $producto->cantidad; ?></td>
                    <td><?php echo $producto->subtotal; ?> €</td>
                    <td>
                        <a href="index.php?controller=ProductosController&action=eliminarDelCarrito&id=<?php echo $producto->id; ?>" 
                           class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                    <td><strong><?php echo $total; ?> €</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        
        <div class="d-flex justify-content-between">
            <a href="index.php" class="btn btn-primary">Seguir Comprando</a>
            <a href="index.php?controller=ProductosController&action=finalizarCompra" class="btn btn-success">Finalizar Compra</a>
        </div>
    <?php endif; ?>
</div>