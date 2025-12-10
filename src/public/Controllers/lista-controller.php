<?php
declare(strict_types=1);

require_once  '../../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;

$bd = Bd::getInstance();


if (isset($_GET["buscar"])) {

    $busqueda = filter_input(INPUT_GET, "busqueda", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($busqueda === false) {
        $_SESSION["msg-busqueda"] = "Datos de la búsqueda erróneos.";
        $_SESSION["resultado_busqueda"] = [];
        header("Location: ../view/lista-view.php");
        exit();
    }

    $resultado = Bd::encontrarLibroBarra($busqueda);


    if (empty($resultado)) {
        $_SESSION["msg-busqueda"] = "No se ha encontrado ningún libro.";
        header("Location: ../view/lista-view.php");
        exit();
    } else{
        $_SESSION["resultado_busqueda"] = $resultado;
        header("Location: ../view/lista-view.php");
        exit();

    }


}
