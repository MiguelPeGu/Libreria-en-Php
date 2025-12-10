<?php
declare(strict_types=1);
require_once  '../../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;

$bd = Bd::getInstance();

if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = new Carrito();
}

$carrito = $_SESSION["carrito"];

$id = filter_input(INPUT_POST, "id_libro", FILTER_VALIDATE_INT);
if ($id === false) {
    $_SESSION["msg-carrito"] = "Id mal introducido";
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["carrito"])) {
    $libro = Bd::encontrarLibroId($id);
    if ($libro !== false) {
        if($libro->getStock()===0){
            $_SESSION["msgError"] = 'Lo sentimos, no hay stock de "'.$libro->getTitulo().'"';
            header("Location: ../index.php");
            exit();
        }
        $carrito->alCarrito($libro);
        $_SESSION["msg-carrito"] = "Libro agregado al carrito";

    } else {
        $_SESSION["msg-carrito"] = "Libro no encontrado";
    }
}


if (isset($_POST["sumar"])) {
    $libro = Bd::encontrarLibroId($id);
    if ($libro !== false) {
        $carrito->sumarLibro($libro);
    }
}

if (isset($_POST["restar"])) {
    $carrito->restarLibro($id);
}

if (isset($_POST["eliminar_todos"])) {
    $carrito->eliminarTodos($id);
}

if (isset($_POST["eliminar_carrito"])) {
    $carrito = new Carrito();
    $_SESSION["carrito"]= $carrito;

}

$_SESSION["carrito"] = $carrito;
header("Location: ../view/carrito-view.php");
exit();
