<?php

use App\Propiedad;
use APP\Vendedor ; 
use Intervention\Image\ImageManagerStatic as Image;



include '../../includes/app.php';
// Proteger esta ruta.
estaAutenticado();

// Verificar el id
$id =  $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin');
}


// Obtener la propiedad
$propiedad = Propiedad::find($id);

// debuguear($propiedad) ;
$vendedores = Vendedor::all() ; 
//debuguear($propiedad); 

$errores = Propiedad::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los atributos 
    $args = $_POST['propiedad'];
    $propiedad->sincronizar($args);

    //validazion 
    $errores = $propiedad->validar();



    //Subida de archivos 

    //Nombre Imagen 
    $nombreImagen = md5(uniqid(rand(), true)) . "jpg";

    if ($_FILES['propiedad']['name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }



    if(empty($errores)) {
        // Almacenar la imagen
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }

        $propiedad->guardar();
    }
    
    }


// Insertar en la BD.








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