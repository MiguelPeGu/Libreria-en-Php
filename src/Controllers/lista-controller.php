<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;

$bd = Bd::getInstance();

// -------------------------
//   PROCESO DE BÚSQUEDA
// -------------------------
if (isset($_GET["buscar"])) {

    $busqueda = filter_input(INPUT_GET, "busqueda", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($busqueda === false || $busqueda === "") {
        $_SESSION["msg-busqueda"] = "Datos de la búsqueda erróneos.";
        header("Location: ../view/lista-view.php");
        exit();
    }

    // Buscar libros
    $resultado = Bd::encontrarLibro($busqueda);

    if ($resultado === false) {
        $_SESSION["msg-busqueda"] = "No se ha encontrado ningún libro con esa búsqueda.";
        header("Location: ../view/lista-view.php");
        exit();
    }

    // Si solo hay 1 libro, lo dejamos como objeto
    // Si hay varios, lo dejamos como array
    $libros = $resultado;

    // Guardamos los resultados para la vista
    $_SESSION["resultado_busqueda"] = $libros;
    $listaLibros = Bd::listarLibros();
    $_SESSION["lista_libros"] = $listaLibros;
    header("Location: ../view/lista-view.php");
    exit();
}
