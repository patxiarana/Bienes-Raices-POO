<fieldset>
            <legend>Información General</legend>
            <label for="titulo">Titulo:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

            <label for="precio">Precio: </label>
            <input name="precio" type="number" id="precio" placeholder="Precio" value="<?php echo s($propiedad->precio) ; ?>">

            <label for="imagen">Imagen: </label>
            <input name="imagen" type="file" id="imagen">


            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>

        </fieldset>


        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" min="1" max="10" step="1" id="habitaciones" value="<?php echo s($propiedad->habitaciones); ?>">

            <label for="wc">Baños:</label>
            <input name="wc" type="number" min="1" max="10" step="1" id="wc" value="<?php echo s($propiedad->wc); ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input name="estacionamiento" type="number" min="1" max="10" step="1" id="estacionamiento" value="<?php echo s($propiedad->estacionamiento); ?>">

            <legend>Información Vendedor:</legend>
            <label for="nombre_vendedor">Nombre:</label>

            </select>
        </fieldset>