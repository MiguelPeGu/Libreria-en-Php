<?php
declare(strict_types=1);

require_once  '../../vendor/autoload.php';
session_start();

use App\model\Carrito;
use App\model\Bd;

$bd = Bd::getInstance();

if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = new Carrito();
}

$carrito = $_SESSION["carrito"];
$productos = $carrito->verCarrito();


$productosUnicos = [];
foreach ($productos as $libro) {
    $productosUnicos[$libro->getId()] = $libro;
}

$user = $_SESSION["user"] ?? null;
$msgError = $_SESSION["msg-compra-error"] ?? "";
unset($_SESSION["msg-compra-error"]);
if(!isset($_SESSION["user"])){
     $_SESSION["msg-carritoError"] = "Debes estar logueado para finalizar la compra.";
    header("Location: ./carrito-view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
</head>
<body>

<header class="header-libmichael">
    <div class="header-container">
        <div class="logo">
            <a href="../index.php">Librería <span>Michael</span></a>
        </div>
        <nav class="nav-header">
            <?php
            if($user!==null){
                echo "<h3>Bienvenid@ ". $user->getUsuario()."</h3>";
                echo "<a href='../index.php' class='btn'>Inicio</a>";
                echo "<a href='../Controllers/logout-controller.php' class='btn'>Cerrar sesión</a>";
            } else {
                ?>
                <a href="../index.php" class="btn">Inicio</a>
                <a href="./lista-view.php" class="btn">Catálogo</a>
                <a href="./login.php" class="btn">Login</a>
                <a href="./register.php" class="btn">Registro</a>
            <?php } ?>
            <a href="./carrito-view.php" class="carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="contador"><?= count($productos) ?></span>
            </a>
        </nav>
    </div>
</header>


<div class="checkout-v2-grid">


    <div class="checkout-v2-form-box">
        <h2>Datos de envío</h2>
        <?php if ($msgError !== "") { ?>
            <p class='error-msg'><i class='fa-solid fa-triangle-exclamation'></i> <?= $msgError ?></p>
        <?php } ?>

        <form method="post" action="../Controllers/compra-controller.php">
            <label for="dni">DNI o NIE</label>
            <input type="text" name="dni" id="dni" required>

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" name="telefono" id="telefono" required>

            <label for="direccion">Dirección de Facturación</label>
            <input type="text" name="direccion" id="direccion" required>

            <label for="cp">Código Postal o zip</label>
            <input type="text" name="cp" id="cp" required>

            <div class="select-container">
                <label for="localidad" class="select-label">Localidad</label>
                <select name="localidad" id="localidad" class="select-box" required>
                    <option value="">Seleccione una localidad</option>
                    <option value="Madrid">Madrid</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Valencia">Valencia</option>
                    <option value="Sevilla">Sevilla</option>
                    <option value="Zaragoza">Zaragoza</option>
                    <option value="Málaga">Málaga</option>
                    <option value="Murcia">Murcia</option>
                    <option value="Bilbao">Bilbao</option>
                </select>
            </div>

            <div class="select-container">
                <label for="mPago" class="select-label">Método de Pago</label>
                <select name="mPago" id="mPago" class="select-box" required>
                    <option value="">Seleccione un método de pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="Transferencia">Transferencia Bancaria</option>
                    <option value="Bizum">Bizum</option>
                </select>
            </div>



            <button type="submit" name="finalizar_compra" class="checkout-v2-btn-comprar">Finalizar Compra</button>
        </form>
    </div>


    <div class="checkout-v2-cart-box">
        <h2>Resumen de tu pedido</h2>

        <?php if (empty($productos)) { ?>
            <p>Tu carrito está vacío.</p>

        <?php } else {
            $precioTotal = 0;

            foreach ($productosUnicos as $libro) {
                $cantidad = $carrito->contarLibro($libro->getId());
                $precioConIva = $libro->getPrecio()+($libro->getPrecio()*$libro->getIva()/100);
                $precioArticulo= number_format($precioConIva, 2, ',',".");
                ?>

                <div class="checkout-v2-item">
                    <a href="../Controllers/detalles-controlador.php?id=<?= $libro->getId() ?>">
                        <img src="../<?= $libro->getImg() ?>"
                             alt="Portada de <?= $libro->getTitulo() ?>">
                    </a>

                    <div class="checkout-v2-info">
                        <h3><?= $libro->getTitulo() ?></h3>
                        <p class="autor"><?= $libro->getAutor() ?></p>
                        <p class="precio"><?= $precioArticulo ?> €</p>
                        <p class="cantidad">Cantidad: <?= $cantidad ?></p>
                    </div>
                </div>

                <?php
                $precioTotal += $precioConIva * $cantidad;
            } ?>

            <p class="checkout-v2-total">Total: <?= number_format($precioTotal, 2) ?> €</p>

        <?php } ?>
    </div>

</div> 

<footer class="footer-libmichael">
    <div class="footer-container">
        <div class="footer-col">
            <h3>Librería Michael</h3>
            <p>Tu lugar de confianza para descubrir nuevas historias.</p>
        </div>
        <div class="footer-col">
            <h4>Enlaces</h4>
            <a href="../index.php">Inicio</a>
            <a href="./lista-view.php">Catálogo</a>
            <a href="./login.php">Login</a>
            <a href="./register.php">Registro</a>
        </div>
        <div class="footer-col">
            <h4>Contacto</h4>
            <p>Email: contacto@libreriamichael.com</p>
            <p>Tel: +34 600 123 456</p>
        </div>
    </div>
    <p class="footer-copy">© 2025 Librería Michael — Todos los derechos reservados.</p>
</footer>

</body>
</html>
