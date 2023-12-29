<?php
include 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1 class="fw-300 centrar-texto">Nuestro Blog</h1>

    <article class="entrada-blog">
        <div class="imagen">
            <img src="/build/img/blog1.jpg" alt="Entrada de blog">
        </div>
        <div class="texto-entrada">
            <a href="entrada.php">
                <h4>Terraza en el techo de tu casa</h4>
            </a>
            <p>Escrito el: <span> 20/10/2019 </span> por: <span> Admin </span> </p>
            <p>Consejos para construir una terraza en el techo de tu casa, con los mejores materiales y ahorrando dinero</p>
        </div>
    </article>

    <article class="entrada-blog">
        <div class="imagen">
            <img src="/build/img/blog2.jpg" alt="Entrada de blog">
        </div>
        <div class="texto-entrada">
            <a href="entrada.php">
                <h4>Construye una alberca en tu hogar</h4>
            </a>
            <p>Escrito el: <span> 20/10/2019 </span> por: <span> Admin </span> </p>
            <p>Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio</p>
        </div>
    </article>

    <article class="entrada-blog">
        <div class="imagen">
            <img src="/build/img/blog3.jpg" alt="Entrada de blog">
        </div>
        <div class="texto-entrada">
            <a href="entrada.php">
                <h4>Guía para la decoración de tu hogar</h4>
            </a>
            <p>Escrito el: <span> 20/10/2019 </span> por: <span> Admin </span> </p>
            <p>Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio</p>
        </div>
    </article>

    <article class="entrada-blog">
        <div class="imagen">
            <img src="/build/img/blog4.jpg" alt="Entrada de blog">
        </div>
        <div class="texto-entrada">
            <a href="entrada.php">
                <h4>Guía para la decoración de tu habitación</h4>
            </a>
            <p>Escrito el: <span> 20/10/2019 </span> por: <span> Admin </span> </p>
            <p>Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio</p>
        </div>
    </article>
</main>

<?php
incluirTemplate('footer');
?>