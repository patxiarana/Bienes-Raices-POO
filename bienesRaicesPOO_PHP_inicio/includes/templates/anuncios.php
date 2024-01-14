<?php 
  //importar la conexion 
    $db = conectarDb();
    //consultar limite 
    $consulta = "SELECT * FROM propiedades LIMIT $limite";
 //   echo $consulta;

    //obtener resultado 
    $resultado = mysqli_query($db, $consulta);

?>

<div class="contenedor-anuncios">
<?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">
        <img loading="lazy" src="/../imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio">$ <?php echo $propiedad['precio']; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img src="/build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad['wc']; ?></p>
                    </li>
                    <li>
                        <img src="/build/img/icono_estacionamiento.svg" alt="icono autos">
                        <p><?php echo $propiedad['estacionamiento']; ?></p>
                    </li>
                    <li>
                        <img src="/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $propiedad['habitaciones']; ?></p>
                    </li>
                </ul>


                <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton boton-amarillo d-block">Ver Propiedad</a>
            </div>
        </div>

<?php endwhile;  ?>
    </div>

    <?php 
mysqli_close($db);
?>
