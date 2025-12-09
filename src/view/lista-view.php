<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
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
$msgBusqueda=$_SESSION["msg-busqueda"] ?? "";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOP VENTAS</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

</head>

<body>
    <header class="header-libmichael">
    <div class="header-container">

        <!-- LOGO -->
        <div class="logo">
            <a href="../index.php">Librería <span>Michael</span></a>
        </div>

        <!-- BUSCADOR -->
        <form class="buscador" method="get" action="../Controllers/lista-controller.php">
            <input type="text" id ="busqueda" name="busqueda" placeholder="Buscar libros..." />
            <button type="submit" name="buscar" ><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <!-- BOTONES Y CARRITO -->
  <nav class="nav-header">
            <?php
            if($user!==null){
                echo "<h3>"."Bienvenid@ ". $user->getUsuario()."</h3>";
                echo "<a href='../index.php' class='btn'>Inicio</a>";
                echo "<a href='../Controllers/logout-controller.php' class='btn'>Cerrar sesion</a>";
            }else{
            ?>
                <a href="../index.php" class="btn">Inicio</a>
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

<?php  
// -----------------------------------
// SI HAY RESULTADOS DE BÚSQUEDA
// -----------------------------------
if ($librosEncontrados !== null) {
    echo "<h1>LIBROS ENCONTRADOS:</h1>";
    echo "<section>";
    // Si es solo un libro, lo metemos en un array para simplificar
    $lista = is_array($librosEncontrados) ? $librosEncontrados : [$librosEncontrados];

    foreach ($lista as $libro) {

        echo "<article class='card'>";
        echo "<a href='../Controllers/detalles-controlador.php?id=" . $libro->getId() . "'>";
        echo "<h2>" . $libro->getTitulo() . "</h2>";
        echo "<img src='../" . $libro->getImg() . "' alt='Portada del libro' width='150'>";
        echo "</a><br><br>";
        echo "Autor: " . $libro->getAutor() . "<br><br>";
        echo "Precio: " . $libro->getPrecio() . " €<br><br>";

          echo "<form method='post' action='../Controllers/carrito-controller.php' style='display:inline;'>
        <input type='hidden' name='id_libro' value='" . $libro->getId() . "'>
        <button type='submit' name='carrito' style='background-color: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-size: 16px;'>
            <i class='fa-solid fa-basket-shopping'></i> Añadir a la cesta
        </button>
      </form>";

        echo "</article>";
    }

} else {

// -----------------------------------
// NO HAY BÚSQUEDA — MOSTRAR TODO
// -----------------------------------

    echo "<h1>TODOS LOS LIBROS DISPONIBLES:</h1>";
     if ($msgBusqueda !== "") {
    echo "<p class='error-msg'>
            <i class='fa-solid fa-triangle-exclamation'></i> "
            . htmlspecialchars($msgBusqueda) .
         "</p>";

    unset($_SESSION["msg-busqueda"]);
}

    echo "<section>";

    $listaLibros = Bd::listarLibros();

    foreach ($listaLibros as $fila) {

        $libro = new Libro(
            $fila["id"],
            $fila["isbn"],
            $fila["img"],
            $fila["titulo"],
            $fila["autor"],
            $fila["precio"],
            $fila["iva"],
            $fila["stock"],
            $fila["stock_lim"]
        );

    echo "<article class='card'>";
    echo "<a href='../Controllers/detalles-controlador.php?id=" . $libro->getId() . "'>";
    echo "<h2>" . $libro->getTitulo() . "</h2>";
    echo "<img src='../" . $libro->getImg() . "' alt='Portada del libro' width='150'>";
    echo "</a><br><br>";



echo "Autor: " . $libro->getAutor() . "<br><br>";
echo "<p class='price'><strong>Precio:</strong> " . 
     round($libro->getPrecio() + ($libro->getPrecio() * $libro->getIva() / 100), 2) . 
     " €</p>";

echo "</a>";
echo "<form method='post' action='../Controllers/carrito-controller.php' style='display:inline;'>
        <input type='hidden' name='id_libro' value='" . $libro->getId() . "'>
        <button type='submit' name='carrito' 
                style='background-color: #28a745; color: white; border: none; 
                       padding: 8px 12px; border-radius: 5px; cursor: pointer; 
                       font-size: 16px;'>
            <i class='fa-solid fa-basket-shopping'></i> Añadir a la cesta
        </button>
      </form>";

echo "</article>";


    }
}
?>

</section>



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
