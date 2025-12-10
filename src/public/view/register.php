<?php
declare(strict_types=1);

require_once  '../../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\User;
use App\model\Libro;
use App\model\Carrito;

$bd = Bd::getInstance();
if(!isset($_SESSION["carrito"])){
    $_SESSION["carrito"] = new Carrito();
}
$carrito = $_SESSION["carrito"];
$productos = $carrito->verCarrito();
$msgError = $_SESSION["msg-error"] ?? "";
$msgAcierto = $_SESSION["msg-acierto"] ?? "";


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

</head>

<body>

<header class="header-libmichael">
    <div class="header-container">

        <div class="logo">
            <a href="../index.php">Librería <span>Michael</span></a>
        </div>

       
        <nav class="nav-header">
            <a href="../index.php" class="btn">Inicio</a>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Crea tu cuenta</a>

            <a href="./carrito-view.php" class="carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="contador"><?= count($productos) ?></span>
            </a>
        </nav>

    </div>
</header>

<main>
    <div class="form-login-container">
        <form action="../Controllers/register-controller.php" method="POST" class="form-login">

            <i class="fa-solid fa-user-plus" style="font-size: 30px; color: #4e342e; margin-bottom: 15px;"></i>
            <h2>Crear cuenta</h2>

            <?php if ($msgError) { ?>
                <p class="error-msg">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?= $msgError ?>
                </p>
            <?php 
                unset($_SESSION["msg-error"]);
                    }
                     ?>

            <?php if ($msgAcierto) { ?>
                <p class="success-msg">
                    <i class='fa-solid fa-circle-check'></i>
                    <?= $msgAcierto ?>
                </p>
            <?php 
                unset($_SESSION["msg-acierto"]);
                    }
                      ?>

            <label>Usuario:</label>
            <input type="text" name="username" required>

            <label>Contraseña:</label>
            <input type="password" name="passwd" required>

            <label>Repite la contraseña:</label>
            <input type="password" name="passwd2" required>

            <button type="submit" name="register" class="btn-register-brown">
                <i class="fa-solid fa-user-check"></i> Registrarme
            </button>

            <p class="registro-texto-small">¿Ya tienes cuenta?</p>

            <a href="./login.php" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión
            </a>

        </form>
    </div>
</main>

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
