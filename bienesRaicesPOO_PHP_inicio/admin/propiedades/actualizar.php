<?php

include '../../includes/funciones.php';
// Proteger esta ruta.
$auth = estaAutenticado();
if(!$auth) {
    header('Location: /');
}

// Verificar el id
$id =  $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if(!$id) {
    header('Location: /admin');
}

require '../../includes/config/database.php';
$db = conectarDb();

// Obtener la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);


// obtener vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// Leer datos del formulario... 

// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";

// Validar 

$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedor = $propiedad['vendedorId'];


// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedor = $_POST['vendedorId'];


    $imagen = $_FILES['imagen'] ?? null;


    if (!$titulo) {
        $errores[] = 'Debes añadir un Titulo';
    }
    if (!$precio) {
        $errores[] = 'El Precio es Obligatorio';
    }
    if (strlen($descripcion) < 50) {
        $errores[] = 'La Descripción es obligatoria y debe tener al menos 50 caracteres';
    }
    if (!$habitaciones) {
        $errores[] = 'La Cantidad de Habitaciones es obligatoria';
    }
    if (!$wc) {
        $errores[] = 'La cantidad de WC es obligatoria';
    }
    if (!$estacionamiento) {
        $errores[] = 'La cantidad de lugares de estacionamiento es obligatoria';
    }
    if (!$vendedor) {
        $errores[] = 'Elige un vendedor';
    }

    $medida = 2 * 1000 * 1000;
    // var_dump($imagen['size']);
    // var_dump($imagen);

    if ($imagen['size'] > $medida) {
        $errores[] = 'La Imagen es muy grande';
    }




    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    // El array de errores esta vacio
    if (empty($errores)) {
        // Si hay una imagen NUEVA, entonces borrar la anterior.

  

        //Subir la imagen
        $carpetaImagenes = '../../imagenes/';
        $rutaImagen = '';
        
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }



        if ($imagen) {

            $carpetaEliminar = explode('/',  $propiedad['imagen']);

            // Borrar la imagen anterior...
            unlink($carpetaImagenes . $propiedad['imagen'] );

            // Borra la carpeta
            rmdir($carpetaImagenes . $carpetaEliminar[0] );

            $imagePath = $carpetaImagenes . md5(uniqid(rand(), true)) . '/' . $imagen['name'];

            // var_dump($imagePath);

            mkdir(dirname($imagePath));

            // var_dump($imagen);

            move_uploaded_file($imagen['tmp_name'], $imagePath);

            $rutaImagen = str_replace($carpetaImagenes, '', $imagePath);

            // var_dump($rutaImagen);
        }

        // Insertar en la BD.
        // echo "No hay errores";

        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', descripcion = '${descripcion}', habitaciones = '${habitaciones}', wc = '${wc}', estacionamiento = '${estacionamiento}', vendedorId = '${vendedor}', imagen = '${rutaImagen}'  WHERE id = '${id}' ";
        // echo $query;


        $resultado = mysqli_query($db, $query) or die(mysqli_error($db));
        // var_dump($resultado);
        // printf("Nuevo registro con el id %d.\n", mysqli_insert_id($db));

        if ($resultado) {
            header('location: /admin/index.php?mensaje=2');
        }
    }

    // Insertar en la BD.


}





?>

<?php
$nombrePagina = 'Crear Propiedad';
incluirTemplate('header');
?>

<h1 class="fw-300 centrar-texto">Administración - Editar Propiedad</h1>

<main class="contenedor seccion contenido-centrado">
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Titulo:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio: </label>
            <input name="precio" type="number" id="precio" placeholder="Precio" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen: </label>
            <input name="imagen" type="file" id="imagen">


            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>


        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" min="1" max="10" step="1" id="habitaciones" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input name="wc" type="number" min="1" max="10" step="1" id="wc" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input name="estacionamiento" type="number" min="1" max="10" step="1" id="estacionamiento" value="<?php echo $estacionamiento; ?>">

            <legend>Información Vendedor:</legend>
            <label for="nombre_vendedor">Nombre:</label>

            <select name="vendedorId" id="nombre_vendedor">
                <option selected value="">-- Seleccione --</option>
                <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedor === $row['id'] ? 'selected' : '' ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?>
                    <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

    </form>

</main>


<?php

incluirTemplate('footer');

mysqli_close($db); ?>

</html>