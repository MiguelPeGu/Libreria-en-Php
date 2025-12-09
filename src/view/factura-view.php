<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use App\model\Carrito;

$user = $_SESSION["user"] ?? null;
$factura = $_SESSION['factura'] ?? null;
$carrito = $_SESSION["carrito"] ?? new Carrito();
$detallesFactura = $carrito;

// Generar array de productos únicos
$productosUnicos = [];
foreach ($detallesFactura as $detalle) {
    $productosUnicos[$detalle->getId()] = $detalle;
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura <?= htmlspecialchars($factura->getIdFactura() ?? '') ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
</head>
<body>
<style>
main {
    flex: 1;
    background-color: #fffaf0;
    padding: 40px 0;
    text-align: center;
    display: block;
}
.factura-tabla {
    margin: 0 auto 30px auto;
    width: 90%;
}
</style>

<header class="header-libmichael">
    <div class="header-container">
        <div class="logo">
            <a href="../index.php">Librería <span>Michael</span></a>
        </div>
        <nav class="nav-header">
            <?php
            if ($user !== null) {
                echo "<h3>Bienvenid@ " . $user->getUsuario() . "</h3>";
                echo "<a href='../index.php' class='btn'>Inicio</a>";
                echo "<a href='../Controllers/logout-controller.php' class='btn'>Cerrar sesión</a>";
            } else {
                echo "<a href='../index.php' class='btn'>Inicio</a>";
                echo "<a href='./lista-view.php' class='btn'>Catálogo</a>";
                echo "<a href='./login.php' class='btn'>Login</a>";
                echo "<a href='./register.php' class='btn'>Crea tu cuenta</a>";
            }
            ?>
        </nav>
    </div>
</header>

<main>
    <?php
    if ($factura) {
        echo "<h1 style='text-align:center; font-weight:bold; margin-top:20px;'>".$_SESSION["msg-compra"]."</h1>";
        echo "<h1>Factura Nº " . $factura->getIdFactura() . "</h1>";
        echo "<p><strong>Usuario:</strong> " . $user->getUsuario() . "</p>";
        echo "<p><strong>Fecha:</strong> " . $factura->getFecha() . "</p>";
        echo "<h2>Detalles de la compra</h2>";
        echo "<table class='factura-tabla'>
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Cantidad</th>
                        <th>Precio Unidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>";

        $totalGeneral = 0;
        foreach ($productosUnicos as $detalle) {
            $titulo = $detalle->getTitulo() ?? $detalle->getNombre() ?? 'Libro';
            $cantidad = $carrito->contarLibro($detalle->getId());
            $precio = $detalle->getPrecio() + ($detalle->getPrecio() * $detalle->getIva() / 100);
            $subtotal = $precio * $cantidad;
            $totalGeneral += $subtotal;

            echo "<tr>
                    <td>$titulo</td>
                    <td>$cantidad</td>
                    <td>" . number_format($precio, 2, ',', '') . " €</td>
                    <td>" . number_format($subtotal, 2, ',', '') . " €</td>
                  </tr>";
        }

        // Fila final del total
        echo "<tr style='font-weight:bold;'>
                <td colspan='3' style='text-align:right;'>Total:</td>
                <td>" . number_format($totalGeneral, 2, ',', '') . " €</td>
              </tr>";

        echo "</tbody></table>";
        echo '<div style="text-align:center; margin-top:20px;">
        <a class="btn-volver-brown" href="../index.php">Volver al inicio</a>
      </div>';

        
    } else {
        echo "<p>No hay factura disponible.</p>";
    }
    ?>
</main>

<?php
//unset($_SESSION["msg-compra"]);
// unset($_SESSION["carrito"]);
// unset($_SESSION['factura']);
// unset($_SESSION['detallesFactura']);
?>

</body>
</html>
