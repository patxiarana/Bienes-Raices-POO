<?php
include '../includes/app.php';
// Proteger esta ruta.
estaAutenticado();

use App\Propiedad;
use App\Vendedor;
//Implementar un metodo para obtener todas las propiedades con Active Record
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();
//debuguear($propiedades) ; 
// Validar la URL 
$mensaje = $_GET['mensaje'] ?? null;


// Importar el Template

incluirTemplate('header');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*echo "<pre>";
    var_dump($_POST);
    echo "</pre>";*/

    // Sanitizar número entero
    $id = $_POST['id_eliminar'];
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    // Eliminar... 
    if ($id) {
 

       $tipo = $_POST['tipo'] ; 

       // debuguear($tipo) ; 
    
       if(validarTipodeContenido($tipo)) {
     
          //Compara lo que vamos a eliminar 
          if($tipo == 'vendedor') {
            $vendedor = Vendedor::find($id);
           //  debuguear($vendedor) ; 
            $vendedor->eliminar();

          } else if($tipo == "propiedad") {
            $propiedad = Propiedad::find($id);
            // debuguear($propiedad) ; 
            $propiedad->eliminar();
        }
          }

       } 
          
    
}
?>

<h1 class="fw-300 centrar-texto">Administración</h1>

<main class="contenedor seccion contenido-centrado">


    <?php
    if ($mensaje == 1) {
        echo '<p class="alerta exito">Anuncio Creado Correctamente</p>';
    } else if ($mensaje == 2) {
        echo '<p class="alerta exito">Anuncio Actualizado Correctamente</p>';
    }
    ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <h2>Propiedades</h2>


    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td>
                        <img loading="lazy" src="/../imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">
                    </td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_eliminar" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" href="/admin/propiedades/borrar.php" class="boton boton-rojo" value="Borrar">
                        </form>

                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton boton-verde">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>


    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido ?></td>
                    <td>
                    </td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_eliminar" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" href="/admin/vendedores/borrar.php" class="boton boton-rojo" value="Borrar">
                        </form>

                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $venededor->id; ?>" class="boton boton-verde">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
incluirTemplate('footer');
?>