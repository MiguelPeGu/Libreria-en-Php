<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Carrito;
use App\model\Factura;
use App\model\Factura_Detalles;

if (!isset($_POST["finalizar_compra"])) {
    header("Location: ../views/carrito-view.php");
    exit();
}

if (!isset($_SESSION["user"])) {
    $_SESSION["msg-compra"] = "Debes estar logueado para finalizar la compra.";
    header("Location: ../view/terminarCompra-view.php");
    exit();
}

// -------------------------------------------------------
// 1. Validar sesión y carrito
// -------------------------------------------------------
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"]->verCarrito())) {
    $_SESSION["msg-compra"] = "No tienes productos en el carrito.";
    header("Location: ../view/carrito-view.php");
    exit();
}

$carrito = $_SESSION["carrito"];
$productos = $carrito->verCarrito();

// -------------------------------------------------------
// 2. Recoger y validar datos del formulario
// -------------------------------------------------------
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

// -------------------------------------------------------
// 3. Preparar base de datos y calcular totales
// -------------------------------------------------------
$bd = Bd::getInstance();
$user = $_SESSION["user"];
$idUsuario = $user->getId();

// Calcular totales de la factura
$subtotal = 0;
$ivaTotal = 0;

// Validar stock antes de procesar
foreach ($productos as $producto) {
    $cantidad = $carrito->contarLibro($producto->getId());
    $libros = Bd::encontrarLibro($producto->getId());
    /** @var \App\model\Libro $libro */
    $libro = $libros[0];
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

// -------------------------------------------------------
// 4. Procesar factura dentro de una transacción
// -------------------------------------------------------
try {
    $pdo = Bd::getPDO();
    $pdo->beginTransaction();

    // Crear factura
    if (!Bd::crearFactura($factura)) {
        throw new Exception("Error al crear la factura.");
    }

    // Crear detalles y restar stock
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

        if (!Bd::crearDetalleFactura($detalles)) {
            throw new Exception("Error al crear detalle de factura para el libro: " . $producto->getTitulo());
        }

        if (!Bd::restarStock($producto->getId())) {
            throw new Exception("No hay suficiente stock del libro: " . $producto->getTitulo());
        }
    }

    // Commit de la transacción
    $pdo->commit();

    $_SESSION['factura'] = $factura;
    $_SESSION["msg-compra"] = "¡Compra realizada con éxito! Gracias por confiar en nosotros.";
    header("Location: ../view/factura-view.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION["msg-compra"] = $e->getMessage();
    header("Location: ../view/terminarCompra-view.php");
    exit();
}
