<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use App\model\Carrito;
use App\model\Bd;

$bd = Bd::getInstance();

if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = new Carrito();
}

$carrito = $_SESSION["carrito"];
$productos = $carrito->verCarrito();

// Generar lista de productos únicos
$productosUnicos = [];
foreach ($productos as $libro) {
    $productosUnicos[$libro->getId()] = $libro;
}

$user = $_SESSION["user"] ?? null;
$msg = $_SESSION["msg-compra"] ?? "";
unset($_SESSION["msg-compra"]);
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

<!-- CHECKOUT GRID V2 -->
<div class="checkout-v2-grid">

    <!-- Formulario -->
    <div class="checkout-v2-form-box">
        <h2>Datos de envío</h2>
        <?php if ($msg !== "") { ?>
            <p class="checkout-v2-success-msg"><i class="fa-solid fa-circle-check"></i> <?= $msg ?></p>
        <?php } ?>

        <form method="post" action="../Controllers/compra-controller.php">
            <label for="dni">DNI</label>
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

            <label for="localidad">Localidad</label>
    <select name="localidad" id="localidad" required>
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

            <label for="mPago">Método de Pago</label>
    <select name="mPago" id="mPago" required>
    <option value="">Seleccione un método de pago</option>
    <option value="Efectivo">Efectivo</option>
    <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
    <option value="Transferencia">Transferencia Bancaria</option>
    <option value="Bizum">Bizum</option>
    </select><br><br>


            <button type="submit" name="finalizar_compra" class="checkout-v2-btn-comprar">Finalizar Compra</button>
        </form>
    </div>

    <!-- Resumen del carrito -->
    <div class="checkout-v2-cart-box">
        <h2>Resumen de tu pedido</h2>

        <?php if (empty($productos)) { ?>
            <p>Tu carrito está vacío.</p>

        <?php } else {
            $precioTotal = 0;

            foreach ($productosUnicos as $libro) {
                $cantidad = $carrito->contarLibro($libro->getId());
                $precioConIva = round($libro->getPrecio() + ($libro->getPrecio() * $libro->getIva()/100), 2);
                ?>

                <div class="checkout-v2-item">
                    <a href="../Controllers/detalles-controlador.php?id=<?= $libro->getId() ?>">
                        <img src="../<?= $libro->getImg() ?>"
                             alt="Portada de <?= htmlspecialchars($libro->getTitulo()) ?>">
                    </a>

                    <div class="checkout-v2-info">
                        <h3><?= $libro->getTitulo() ?></h3>
                        <p class="autor"><?= $libro->getAutor() ?></p>
                        <p class="precio"><?= $precioConIva ?> €</p>
                        <p class="cantidad">Cantidad: <?= $cantidad ?></p>
                    </div>
                </div>

                <?php
                $precioTotal += $precioConIva * $cantidad;
            } ?>

            <p class="checkout-v2-total">Total: <?= number_format($precioTotal, 2) ?> €</p>

        <?php } ?>
    </div>

</div> <!-- FIN checkout-v2-grid -->

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
