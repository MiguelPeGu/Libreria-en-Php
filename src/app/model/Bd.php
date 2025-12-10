<?php
declare(strict_types=1);
namespace App\model;

use App\model\Libro;
use App\model\User;


use PDO;

const HOSTNAME = "db";
const DBNAME   = "my_application_db";
const USERNAME = "app_user";
const PASSWORD = "app_password";

class Bd
{
    private static ?Bd $instance = null;
    private static ?PDO $pdo = null;

    private function __construct()
    {
        self::conectar();
    }

    public static function getInstance(): Bd
    {
        if (self::$instance === null) {
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    private static function conectar(): void
    {
        $dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . ";charset=utf8";
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                $dsn,
                USERNAME,
                PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_CASE => PDO::CASE_LOWER // <- claves en minúsculas
                ]
            );
        }
    }

    public static function getPDO(): PDO
    {
        return self::$pdo;
    }

    private function __clone()
    {

    }



    public static function listarLibros():array{
        $sql= "SELECT * FROM `LIBROS`";
        $stmt=Bd::getPDO()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public static function topVentas():array{
    $sql= "SELECT idLibro, SUM(cantidad) AS total_vendido
            FROM DETALLES_FACTURA
            GROUP BY idLibro
            ORDER BY total_vendido DESC
            LIMIT 7";
    $stmt=Bd::getPDO()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public static function encontrarLibroId(int $id): Libro|bool
    {
        $sql = "SELECT * FROM LIBROS WHERE id = :id";
        $stmt = Bd::getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() !== 0){
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);
            $libro= new Libro(
                $resultados["id"],
                $resultados["isbn"],
                $resultados["img"],
                $resultados["titulo"],
                $resultados["autor"],
                $resultados["precio"],
                $resultados["iva"],
                $resultados["stock"],
                $resultados["stock_lim"],
                $resultados["descripcion"]
            );
            return $libro;
        }
        else{
            return false;
        }
    }

    public static function encontrarLibroBarra(string $busqueda): array|bool
    {
        $sql = "SELECT * FROM LIBROS 
            WHERE titulo LIKE :texto OR autor LIKE :texto";

        $stmt = Bd::getPDO()->prepare($sql);
        $stmt->bindValue(':texto', "%$busqueda%");
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultados) {
            return false;
        }

        $libros = [];
        foreach ($resultados as $fila) {
            $libros[] = new Libro(
                $fila["id"],
                $fila["isbn"],
                $fila["img"],
                $fila["titulo"],
                $fila["autor"],
                $fila["precio"],
                $fila["iva"],
                $fila["stock"],
                $fila["stock_lim"],
                $fila["descripcion"]
            );
        }

        return $libros;
    }




    public static function validarUser(User $user): User|bool {
    $sql = "SELECT * FROM `USERS` WHERE `USUARIO` = :usuario AND `PASSWD` = :passwd";
    $stmt = Bd::getPDO()->prepare($sql);
    $stmt->bindValue(':usuario', $user->getUsuario());
    $stmt->bindValue(':passwd', md5($user->getPasswd()));
    $stmt->execute();

    $arrayUser = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($arrayUser) {
        $userCompleto = new User($arrayUser['id'], $arrayUser['usuario'], $arrayUser['passwd']);
        return $userCompleto;
    } else {
        return false;
    }
}

public static function registrarUsuario(User $user):bool{
     $sql= "INSERT INTO `USERS` (`ID`, `USUARIO`, `PASSWD`) VALUES (NULL, :usuario,:passwd )";
    $stmt=Bd::getPDO()->prepare($sql);
     $stmt->bindValue(':usuario', $user->getUsuario());
        $stmt->bindValue(':passwd', md5($user->getPasswd()));
        $stmt->execute();
        if($stmt->rowCount()!==0){
            return true;
        }else{
            return false;
        }
}


public static function encontrarLibroAutor (string $autor) : array|bool
{


     $sql = "SELECT * FROM LIBROS WHERE autor LIKE :autor";
    $stmt = Bd::getPDO()->prepare($sql);
    $stmt->bindValue(':autor', "%$autor%"); 
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$resultados) {
        return false;
    }
    foreach ($resultados as $fila) {
        $libros[] = new Libro(
            $fila["id"],
            $fila["isbn"],
            $fila["img"],
            $fila["titulo"],
            $fila["autor"],
            $fila["precio"],
            $fila["iva"],
            $fila["stock"],
            $fila["stock_lim"],
            $fila["descripcion"]
        );
    }

    return $libros;
}




public static function crearFactura(Factura $factura): bool
{
$sql = "INSERT INTO `FACTURAS` 
    (`idFactura`, `idUsuario`, `fecha`, `dni`, `nombre`, `apellidos`, `telefono`, `direccion`, `cp`, `localidad`, `total`, `metodoPago`) 
    VALUES 
    (:idFactura, :idUsuario, :fecha, :dni, :nombre, :apellidos, :telefono, :direccion, :cp, :localidad, :total, :metodoPago);";

    $stmt = Bd::getPDO()->prepare($sql);
    $stmt->bindValue(":idFactura", $factura->getIdFactura());
    $stmt->bindValue(":idUsuario", $factura->getIdUsuario());
    $stmt->bindValue(":fecha", $factura->getFecha());
    $stmt->bindValue(":dni", $factura->getDni());
    $stmt->bindValue(":nombre", $factura->getNombre());
    $stmt->bindValue(":apellidos", $factura->getApellidos());
    $stmt->bindValue(":direccion", $factura->getDireccion());
    $stmt->bindValue(":cp", $factura->getCp());
    $stmt->bindValue(":localidad", $factura->getLocalidad());
    $stmt->bindValue(":telefono", $factura->getTelefono());
    $stmt->bindValue(":metodoPago", $factura->getMetodoPago());
    $stmt->bindValue(":total", $factura->getTotal());
    $stmt->execute();
    if ($stmt->rowCount()!==0) {
        return true; 
    }else{
    return false;
    }

}



public static function crearDetalleFactura(Factura_Detalles $detalle): bool
{
    $sql = "INSERT INTO DETALLES_FACTURA
            (idFactura, idLibro, cantidad, precioUd, subtotal, iva, totalLinea)
            VALUES
            (:idFactura, :idLibro, :cantidad, :precioUd, :subtotal, :iva, :totalLinea)";

    $stmt = Bd::getPDO()->prepare($sql);

    $stmt->bindValue(":idFactura", $detalle->getIdFactura());
    $stmt->bindValue(":idLibro", $detalle->getIdLibro());
    $stmt->bindValue(":cantidad", $detalle->getCantidad());
    $stmt->bindValue(":precioUd", $detalle->getPrecioUd());
    $stmt->bindValue(":subtotal", $detalle->getSubtotal());
    $stmt->bindValue(":iva", $detalle->getIva());
    $stmt->bindValue(":totalLinea", $detalle->getTotalLinea());

    $stmt->execute();

     if ($stmt->rowCount()!==0) {
        return true; 
    }else{
    return false;
    };
}

public static function restarStock(int $idLibro): bool
{
  
    $libro = self::encontrarLibroId($idLibro);

    if ($libro === false) {
 
        return false;
    }

    $nuevoStock = $libro->getStock() - 1;
    if ($nuevoStock < 0) {
        return false; 
    }
    $sql = "UPDATE `LIBROS` SET `stock` = :stock WHERE `id` = :id";
    $stmt = Bd::getPDO()->prepare($sql);
    $stmt->bindValue(":stock", $nuevoStock);
    $stmt->bindValue(":id", $idLibro);
    $stmt->execute();
    return true;
}


}