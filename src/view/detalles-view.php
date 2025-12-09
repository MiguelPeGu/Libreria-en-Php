<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;
$bd=Bd::getInstance();
$id=filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$libro=Bd::encontrarLibro($id);
$libro=$libro[0];


if(!isset($_SESSION["carrito"])){
    $_SESSION["carrito"] = new Carrito();
}
$carrito = $_SESSION["carrito"];
$productos = $carrito->verCarrito();
$librosEncontrados = $_SESSION["resultado_busqueda"] ?? null;
unset($_SESSION["resultado_busqueda"]);
$user=$_SESSION["user"] ?? null;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LISTA DE LIBROS</title>
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


        <article class="book-details">
            <h2>DETALLES</h2>

            <div class="details-container">
                <img src="../<?= $libro->getImg(); ?>" alt="Portada del libro"  width= "250px">

                <div class="info">
                    <p><strong>Titulo:</strong> <?= $libro->getTitulo(); ?></p>
                    <p><strong>ISBN:</strong> <?= $libro->getIsbn(); ?></p>
                    <p><strong>Autor:</strong> <?= $libro->getAutor(); ?></p>
                    <p><strong>Stock:</strong> <?= $libro->getStock(); ?></p>
                    <br><br><br><br><br>
                    <p class="price" style='margin-right: 80%';><strong>Precio:</strong> <?= round($libro->getPrecio()+($libro->getPrecio()*$libro->getIva()/100),2) ?> €</p>

                    <form method='post' action='../Controllers/carrito-controller.php' style='display:inline;'>
                    <input type='hidden' name='id_libro' value='<?= $libro->getId(); ?>'>
                    <button type='submit' name='carrito' style='background-color: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-size: 16px;'>
            <i class='fa-solid fa-basket-shopping'></i> Añadir a la cesta
        </button>
      </form>
                    
                </div>
            </div>
        </article>


        <!-- LIBROS DEL MISMO AUTOR -->
<aside class="related-books">
    <?php
    $librosAutor = Bd::encontrarLibroAutor($libro->getAutor()) ?: [];
    // Filtrar para no mostrar el libro actual
    $librosFiltrados = []; // Creamos un array vacío

foreach ($librosAutor as $l) {
    if ($l->getId() !== $libro->getId()) {
        $librosFiltrados[] = $l; // Solo añadimos los libros que no sean el actual
    }
}

$librosAutor = $librosFiltrados; // Reemplazamos el array original

    if (!empty($librosAutor)) {
        echo "<h3 style='margin-left: 5%;'>Otros libros del mismo autor:</h3>";
    } else {
        $todosLibros = Bd::listarLibros();
        shuffle($todosLibros);
        $librosAutor = array_slice($todosLibros, 0, 7);
        echo "<h3 style='margin-left: 5%;'>También te podría interesar:</h3>";
    }

    echo "<section style='display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px;'>";
    
    foreach ($librosAutor as $l) {
        // Diferenciar si viene de objeto o array
        $id = is_object($l) ? $l->getId() : $l['id'];
        $titulo = is_object($l) ? $l->getTitulo() : $l['titulo'];
        $autor = is_object($l) ? $l->getAutor() : $l['autor'];
        $precio = is_object($l) ? $l->getPrecio() + ($l->getPrecio() * $l->getIva() / 100) : $l['precio'] + ($l['precio'] * $l['iva'] / 100);
        $img = is_object($l) ? $l->getImg() : $l['img'];

        echo "<article class='card'>";
        echo "<a href='../Controllers/detalles-controlador.php?id={$id}'>";
        echo "<h2>{$titulo}</h2>";
        echo "<img src='../{$img}' alt='Portada del libro' width='150'>";
        echo "</a>";
        echo "<p>Autor: {$autor}</p>";
        echo "<p class='price'><strong>Precio:</strong> " . round($precio, 2) . " €</p>";

        echo "<form method='post' action='../Controllers/carrito-controller.php' style='display:inline;'>
                <input type='hidden' name='id_libro' value='{$id}'>
                <button type='submit' name='carrito' 
                        style='background-color: #28a745; color: white; border: none; 
                               padding: 8px 12px; border-radius: 5px; cursor: pointer; 
                               font-size: 16px;'>
                    <i class='fa-solid fa-basket-shopping'></i> Añadir a la cesta
                </button>
              </form>";

        echo "</article>";
    }

    echo "</section>";
    ?>
</aside>



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
