<?php



define('FUNCIONES_URL', __DIR__ . "/funciones/funciones.php");
define('TEMPLATES_URL', __DIR__ . "/templates");

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
