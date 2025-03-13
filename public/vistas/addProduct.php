<!--
    Vista para añadir nuevos productos. Contiene el código HTML con el formulario así como el código PHP para
    mostrar errores de validación, en caso de existir.
-->

<div class="container"> 
   <h5>Introduce los datos de los productos:</h2>

    <form class="form" action="index.php?controller=ProductosController&action=aniadirProduct" method="post">
    <div class="form-group">
            <label class="form-label" for="imagen">Imagen:</label>
            <input class="form-control" type="text" name="imagen"  maxlength="50" ><br>
            <?php
                if (isset($data) && isset($data['imagen']))
                    echo "<div class='alert alert-danger'>"
                        .$data['imagen'].
                        "</div>";
            ?>
            
        </div>
        <div class="form-group">
            <label class="form-label" for="nombre">Nombre:</label>
            <input class="form-control" type="text" name="nombre"  maxlength="50" value="" ><br>
            <?php
                if (isset($data) && isset($data['nombre']))
                    echo "<div class='alert alert-danger'>"
                        .$data['nombre'].
                        "</div>";
            ?>
            
        </div>
        <div class="form-group">
            <label class="form-label" for="descripcion_corta">Descripcion corta:</label>
            <input class="form-control" type="text" name="descripcion_corta" ><br>
            <?php
                if (isset($data) && isset($data['descripcion_corta']))
                    echo "<div class='alert alert-danger'>"
                        .$data['descripcion_corta'].
                        "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="descripcion">Descripcion:</label>
            <input class="form-control" type="text" name="descripcion" ><br>
            <?php
                if (isset($data) && isset($data['descripcion']))
                    echo "<div class='alert alert-danger'>"
                        .$data['descripcion'].
                        "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="precio">Precio:</label>
            <input class="form-control" type="text" name="precio" ><br>
            <?php
                if (isset($data) && isset($data['precio']))
                    echo "<div class='alert alert-danger'>"
                        .$data['precio'].
                        "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" for="cantidad">Cantidad:</label>
            <input class="form-control" type="text" name="cantidad" ><br>
            <?php
                if (isset($data) && isset($data['cantidad']))
                    echo "<div class='alert alert-danger'>"
                        .$data['cantidad'].
                        "</div>";
            ?>
        </div>
        

        <div class="form-group">
            <input class="form-control" type="submit" name="insertar" value="Enviar">
        </div>
        
    </form>
    </div>
    