<?php
include 'includes/app.php';
incluirTemplate('header');
?>

<h1 class="fw-300 centrar-texto">Contacto</h1>
<img src="/build/img/destacada3.jpg" alt="Imagen Principal">

<main class="contenedor seccion contenido-centrado">
    <h2 class="fw-300 centrar-texto">Llena el formulario de Contacto</h2>

    <form class="formulario" action="">
        <fieldset>
            <legend>Información Personal</legend>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" placeholder="Tu Nombre">

            <label for="email">E-mail: </label>
            <input type="email" id="email" placeholder="Tu Correo electrónico" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" placeholder="Tu Teléfono" required>

            <label for="mensaje">Mensaje: </label>
            <textarea id="mensaje"></textarea>

        </fieldset>


        <fieldset>
            <legend>Información sobre Propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select id="opciones">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" min="0" max="100" step="5">
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>Como desea ser Contactado:</p>

            <div class="forma-contacto">
                <label for="telefono">Teléfono</label>
                <input type="radio" name="contacto" value="telefono" id="telefono">

                <label for="correo">E-mail</label>
                <input type="radio" name="contacto" value="correo" id="correo">
            </div>

            <p>Si eligió Teléfono, elija la fecha y la hora</p>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha">

            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00" max="18:00">


        </fieldset>

        <input type="submit" value="Enviar" class="boton boton-verde">

    </form>
</main>

<?php
incluirTemplate('footer');
?>