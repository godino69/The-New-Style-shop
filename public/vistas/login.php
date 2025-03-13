<div class="container mt-3">
    <h2>Iniciar Sesión</h2>
    
    <?php if(isset($data) && isset($data['login'])): ?>
        <div class="alert alert-danger"><?php echo $data['login']; ?></div>
    <?php endif; ?>
    
    <form method="post" action="index.php?controller=ProductosController&action=verificarLogin">
        <div class="mb-3">
            <label for="usuario">Usuario:</label>
            <input type="text" class="form-control" name="usuario">
            <?php
                if (isset($data) && isset($data['usuario']))
                    echo "<div class='alert alert-danger'>"
                        .$data['usuario'].
                        "</div>";
            ?>
        </div>
        
        <div class="mb-3">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" name="password">
            <?php
                if (isset($data) && isset($data['password']))
                    echo "<div class='alert alert-danger'>"
                        .$data['password'].
                        "</div>";
            ?>
        </div>
        
        <button type="submit" name="enviar" class="btn btn-primary">Acceder</button>
    </form>
</div>