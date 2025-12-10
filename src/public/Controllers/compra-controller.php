<?php
declare(strict_types=1);
require_once  '../../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Carrito;
use App\model\Factura;
use App\model\Factura_Detalles;

if (!isset($_POST["finalizar_compra"])) {
    header("Location: ../view/carrito-view.php");
    exit();
}

if (!isset($_SESSION["user"])) {
    $_SESSION["msg-compra-error"] = "Debes estar logueado para finalizar la compra.";
    header("Location: ../view/carrito-view.php");
    exit();
}


if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"]->verCarrito())) {
    $_SESSION["msg-compra"] = "No tienes productos en el carrito.";
    header("Location: ../view/carrito-view.php");
    exit();
}

$carrito = $_SESSION["carrito"];
$productos = $carrito->verCarrito();


$dni       = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_SPECIAL_CHARS);
$nombre    = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_SPECIAL_CHARS);
$apellidos = filter_input(INPUT_POST, "apellidos", FILTER_SANITIZE_SPECIAL_CHARS);
$telefono  = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_SPECIAL_CHARS);
$direccion = filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_SPECIAL_CHARS);
$cp        = filter_input(INPUT_POST, "cp", FILTER_VALIDATE_INT);
$localidad = filter_input(INPUT_POST, "localidad", FILTER_SANITIZE_SPECIAL_CHARS);
$mPago     = filter_input(INPUT_POST, "mPago", FILTER_SANITIZE_SPECIAL_CHARS);

if (!$dni || !$nombre || !$apellidos || !$telefono || !$direccion || !$cp || !$localidad || !$mPago) {
    $_SESSION["msg-compra"] = "Faltan datos obligatorios.";
    header("Location: ../views/terminarCompra-view.php");
    exit();
}


$bd = Bd::getInstance();
$user = $_SESSION["user"];
$idUsuario = $user->getId();




$subtotal = 0;
$ivaTotal = 0;


foreach ($productos as $producto) {
    $cantidad = $carrito->contarLibro($producto->getId());
    $libro = Bd::encontrarLibroId($producto->getId());
    if ($libro->getStock() < $cantidad) {
        $_SESSION["msg-compra"] = "No hay suficiente stock del libro: " . $producto->getTitulo();
        header("Location: ../view/terminarCompra-view.php");
        exit();
    }

    $precio = $producto->getPrecio();
    $iva = $producto->getIva();
    $subtotal += $precio * $cantidad;
    $ivaTotal += ($precio * $iva / 100) * $cantidad;
}

$totalFactura = $subtotal + $ivaTotal;
$fechaActual = new DateTime();
$fechaFormateada = $fechaActual->format('Y-m-d H:i:s');
$idFactura = Factura::crearIdFactura($idUsuario);
$factura = new Factura(
    $idFactura,
    $idUsuario,
    $fechaFormateada,
    $dni,
    $nombre,
    $apellidos,
    $telefono,
    $direccion,
    $cp,
    $localidad,
    $totalFactura,
    $mPago
);



    if (Bd::crearFactura($factura)===false) {
        $_SESSION["msg-compra"] = "Error al crear la factura";
        header("Location: ../view/terminarCompra-view.php");
        exit();
    }


    foreach ($productos as $producto) {
        $cantidad = $carrito->contarLibro($producto->getId());
        $precio = $producto->getPrecio();
        $iva = $producto->getIva();

        $subtotalLinea = $precio * $cantidad;
        $ivaLinea = ($precio * $iva / 100) * $cantidad;
        $TotalLinea = $subtotalLinea + $ivaLinea;

        $detalles = new Factura_Detalles(
            null,
            $idFactura,
            $producto->getId(),
            $cantidad,
            $precio,
            $subtotalLinea,
            $ivaLinea,
            $TotalLinea
        );

        if (Bd::crearDetalleFactura($detalles)===false) {
            $_SESSION["msg-compra"] = "Error al crear los detalles de la factura";
            header("Location: ../view/terminarCompra-view.php");
            exit();
        }

        if (Bd::restarStock($producto->getId())===false) {
            $_SESSION["msg-compra"] = "Ha ocurrido un error al obtener los stocks";
            header("Location: ../view/terminarCompra-view.php");
            exit();
        }
    }

    $_SESSION['factura'] = $factura;
    $_SESSION["msg-compra"] = "¡Compra realizada con éxito! Gracias por confiar en nosotros.";
    header("Location: ../view/pantalla-de-carga-view.php");
    exit();


