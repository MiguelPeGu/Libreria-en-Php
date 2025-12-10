<?php
declare(strict_types=1);

require_once  '../vendor/autoload.php';
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
$librosEncontrados = $_SESSION["resultado_busqueda"] ?? null;
unset($_SESSION["resultado_busqueda"]);
$productos = $carrito->verCarrito();
$user=$_SESSION["user"] ?? null;
$msgAcierto = $_SESSION["msg-acierto"] ?? "";
$msg=$_SESSION["msgError"] ?? "";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOP VENTAS</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">

</head>
<header class="header-libmichael">
    <div class="header-container">

   
        <div class="logo">
            <a href="index.php">Librería <span>Michael</span></a>
        </div>

     
         <form class="buscador" method="get" action="./Controllers/lista-controller.php">
            <input type="text" id ="busqueda" name="busqueda" placeholder="Buscar libros o autor..." />
            <button type="submit" name="buscar" ><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

       
        <nav class="nav-header">
            <?php
            if($user!==null){
                echo "<h3>"."Bienvenid@ ". $user->getUsuario()."</h3>";
                echo "<a href='./view/lista-view.php' class='btn'>Listar libros</a>";
                echo "<a href='./Controllers/logout-controller.php' class='btn'>Cerrar sesion</a>";
            }else{
            ?>
                <a href="./view/lista-view.php" class="btn">Catálogo</a>
            <a href="view/login.php" class="btn">Login</a>
            <a href="view/register.php" class="btn">Crea tu cuenta</a>

            <?php } ?>
            <a href="./view/carrito-view.php" class="carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="contador">
                    <?= count($productos) ?>
                </span>
            </a>
        </nav>
    </div>
</header>
<div class="header-spacer"></div>
<body>
     <?php if ($msgAcierto) { ?>
                <p class="success-msg">
                    <i class='fa-solid fa-circle-check'></i>
                    <?= $msgAcierto ?>
                </p>
            <?php 
                unset($_SESSION["msg-acierto"]);
                    }
                      ?>
     <?php if ($msg) { ?>
         <p class="error-msg">
             <i class="fa-solid fa-triangle-exclamation"></i>
             <?= $msg ?>
         </p>
         <?php
         unset($_SESSION["msgError"]);
     }
     ?>
    <h1>LIBROS TOP VENTAS</h1>

    <section>

    <?php
    $listaTopVentas=Bd::topVentas();
    foreach($listaTopVentas as $libro) {

        $libro = Bd::encontrarLibroId($libro["idlibro"]);
        echo "<article class='card'>";

        echo "<a href='../Controllers/detalles-controlador.php?id=" . $libro->getId() . "'>";
        echo "<h2>" . $libro->getTitulo() . "</h2>";


        echo "<img src='./" . $libro->getImg() . "' alt='Portada del libro' width='150'><br><br>";
        echo "</a>";
        echo "Autor: " . $libro->getAutor() . "<br><br>";
        $precioIva=$libro->getPrecio() + ($libro->getPrecio() * $libro->getIva() / 100);
        echo "<p class='price'><strong>Precio:</strong> " .
                number_format($precioIva, 2, ',') . " €</p>";


        echo "<form method='post' action='./Controllers/carrito-controller.php' style='display:inline;'>
        <input type='hidden' name='id_libro' value='" . $libro->getId() . "'>
        <button type='submit' name='carrito' 
            style='background-color: #28a745; color: white; border: none; padding: 8px 12px; 
                   border-radius: 5px; cursor: pointer; font-size: 16px;'>
            <i class='fa-solid fa-basket-shopping'></i> Añadir a la cesta
        </button>
      </form>";

        echo "</article>";
    }
       echo "</section>";


    echo '<div style="text-align:center; margin-top:20px;">
        <a class="btn-volver-brown" href="./view/lista-view.php">¡Descubre todo nuestro Catálogo!</a>
      </div>';

    ?>


        <br><br>
    <footer class="footer-libmichael">
        <div class="footer-container">
            <div class="footer-col">
                <h3>Librería Michael</h3>
                <p>Tu lugar de confianza para descubrir nuevas historias.</p>
            </div>

            <div class="footer-col">
                <h4>Enlaces</h4>
                <a href="index.php">Inicio</a>
                <a href="./view/lista-view.php">Catálogo</a>
                <a href="./view/login.php">Login</a>
                <a href="./view/register.php">Registro</a>
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
