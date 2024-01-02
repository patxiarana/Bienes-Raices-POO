<?php

include '../../includes/app.php';
// Proteger esta ruta.
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;




estaAutenticado();


$db = conectarDb();

$propiedad = new Propiedad() ; 

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crea una nueva instancia
    $propiedad = new Propiedad($_POST);
     //debuguear($propiedad) ; 
   // Subida de archivoS
    //Nombre unico 


    // Setea la imagen 
    //Realiza un resize a la imagen con intervention 
   // debuguear($_FILES['imagen']['name']) ;  
   $nombreImagen =$_FILES['imagen']['name'];
   if($_FILES['imagen']['name']) {
    $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
     $propiedad->setImagen($nombreImagen);
}
 //debuguear($propiedad) ; 
//debuguear($_FILES['imagen']) ; 
    //validar
    $errores = $propiedad->validar();
    
    $medida = 2 * 1000 * 1000;

   /* if ($imagen['size'] > $medida) {
        $errores[] = 'La Imagen es muy grande';
    } */

    // El array de errores esta vacio
    if (empty($errores)) {
        //Subir la imagen
        //Crear la carpeta para subir imagenes 

        if(!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }


        $imagen = $_FILES['imagen'] ?? null;

        //Guarda la imagen en el servidor 
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        // Guardar en la base de datos
    $resultado = $propiedad->guardar();

    if($resultado) {
        header('Location: /') ; 
    }
}

}



?>

<?php
$nombrePagina = 'Crear Propiedad';

incluirTemplate('header');
?>

<h1 class="fw-300 centrar-texto">Administración - Nueva Propiedad</h1>

<main class="contenedor seccion contenido-centrado">
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">

    </form>

</main>


<?php

incluirTemplate('footer');

mysqli_close($db); ?>

</html>