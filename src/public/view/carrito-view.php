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

// Generar lista de productos únicos para mostrar
$productosUnicos = [];
foreach ($productos as $libro) {
    $productosUnicos[$libro->getId()] = $libro;
}
$librosEncontrados = $_SESSION["resultado_busqueda"] ?? null;
unset($_SESSION["resultado_busqueda"]);
$user=$_SESSION["user"] ?? null;
$msg= $_SESSION["msg-carrito"] ?? "";
unset($_SESSION["msg-carrito"]);
$msgError= $_SESSION["msg-carritoError"] ?? "";
unset($_SESSION["msg-carritoError"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/carrito.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

</head>
<body>

<header class="header-libmichael">
    <div class="header-container">
        <div class="logo">
            <a href="../index.php">Librería <span>Michael</span></a>
        </div>

        <form class="buscador" method="get" action="./lista-view.php">
            <input type="text" name="buscar" placeholder="Buscar libros o autor..." />
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

 <nav class="nav-header">
            <?php
            if($user!==null){
                  echo "<h3>"."Bienvenid@ ". $user->getUsuario()."</h3>";
                echo "<a href='../index.php' class='btn'>Inicio</a>";
                echo "<a href='./lista-view.php' class='btn'>Catálogo</a>";
                echo "<a href='../Controllers/logout-controller.php' class='btn'>Cerrar sesion</a>";
            }else{
            ?>
                <a href="../index.php" class="btn">Inicio</a>
                <a href="./lista-view.php" class="btn">Catálogo</a>
            <a href="./login.php" class="btn">Login</a>
            <a href="./register.php" class="btn">Crea tu cuenta</a>

            <?php } ?>
            <a href="./carrito-view.php" class="carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="contador">
                    <?= count($productos) ?>
                </span>
            </a>
        </nav>
    </div>
</header>

<h1 class="titulo-carrito">Mi Carrito contiene <?= count($productos) ?> productos</h1>

<div class="carrito-contenedor">
    <?php if (empty($productos)) { ?>
        <p class='carrito-vacio'>Tu carrito está vacío.</p>
         <?php }else { 
        if ($msg !== ""){
        echo "<p class='success-msg'>
        <i class='fa-solid fa-circle-check'></i> " . $msg . "
        </p>";
        unset($_SESSION["msg"]);
        }
        if ($msgError !== ""){
        echo 
        "<p class='error-msg'>
        <i class='fa-solid fa-triangle-exclamation'></i> " . $msgError . "
        </p>";
        unset($_SESSION["msg-carritoError"]);
        }


    $precioTotal = 0;
        foreach ($productosUnicos as $libro){
            $cantidad = $carrito->contarLibro($libro->getId());
            $precioConIva = $libro->getPrecio()+($libro->getPrecio()*$libro->getIva()/100);
            $precioArticulo= number_format($precioConIva, 2, ',',".");
            ?>
            <div class="carrito-item">
                <a href="../Controllers/detalles-controlador.php?id=<?= $libro->getId() ?>">
                <img src="../<?= $libro->getImg() ?>" alt="Portada de <?= $libro->getTitulo() ?>" width= "250px">

                <div class="carrito-info">
                    <h3><?= $libro->getTitulo() ?></h3>
                    </a>
                    <p class="autor"><?= $libro->getAutor() ?></p>
                    <p class="precio"><?= $precioArticulo ?> €</p>
                    <p class="cantidad">Cantidad: <?= $cantidad ?></p>

                    <form method="post" action="../Controllers/carrito-controller.php">
                        <input type="hidden" name="id_libro" value="<?= $libro->getId() ?>">
                        <button name="sumar" class="btn-cantidad">+</button>
                        <button name="restar" class="btn-cantidad">−</button>
                        <button name="eliminar_todos" class="btn-eliminar">Eliminar todos</button>
                    </form>
                </div>
            </div>
        <?php
        $precioTotal = $precioTotal + ($precioConIva * $cantidad);
        ;}

       ?>
<p class="total-carrito"><strong>Total de la cesta: <?= number_format($precioTotal, 2,",",".") ?> €</strong></p>

<div style="display: flex; gap: 10px;">
    <form method="post" action="../Controllers/carrito-controller.php">
        <button name="eliminar_carrito" class="btn-eliminar">Vaciar carrito</button>
    </form>

    <form method="post" action="./terminarCompra-view.php">
        <button name="comprar" class="btn-comprar">Finalizar la compra</button>
    </form>
</div>
   <?php  }?>
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
