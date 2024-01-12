<?php



define('FUNCIONES_URL', __DIR__ . "/funciones/funciones.php");
define('TEMPLATES_URL', __DIR__ . "/templates");
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/') ; 

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado()
{
    session_start();

    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    if (!$_SESSION['login']) {
       header('Location: /') ;
    }
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "<pre>";
    exit;
} ; 


//Escapa / sanitizar el HTML 
function s($html) : string {
$s = htmlspecialchars($html) ; 
return $s ; 
}

//Validar tipo de contenido 
function validarTipodeContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'] ; 

return in_array($tipo,  $tipos) ; 
}