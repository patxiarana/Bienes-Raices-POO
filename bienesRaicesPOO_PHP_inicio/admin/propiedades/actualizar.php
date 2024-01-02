<?php

use App\Propiedad;

include '../../includes/app.php';
// Proteger esta ruta.
estaAutenticado() ; 

// Verificar el id
$id =  $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if(!$id) {
    header('Location: /admin');
}


// Obtener la propiedad
  $propiedad = Propiedad::find($id) ; 

 // debuguear($propiedad) ;
// obtener vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// Leer datos del formulario... 

// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";

// Validar 

$errores = [];



// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";


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

        $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', descripcion = '$descripcion', habitaciones = '$habitaciones', wc = '$wc', estacionamiento = '$estacionamiento', vendedorId = '$vendedor', imagen = '$rutaImagen'  WHERE id = '$id' ";
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
       
    <?php include '../../includes/templates/formulario_propiedades.php'; ?>
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

    </form>

</main>


<?php

incluirTemplate('footer');

mysqli_close($db); ?>

</html>