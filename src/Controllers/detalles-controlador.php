<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;

$bd = Bd::getInstance();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);//PUEDE DAR ERROR
if ($id === false) {
    $_SESSION["msg"] = "El id no ha sido bien introducido";
    header("location: ../index.php");
    exit();
}else{
    $libro=Bd::encontrarLibro($id);
    if($libro!==false){
        $_SESSION["msg"] = "Has accedido a detalles correctamente";
        header("Location: ../view/detalles-view.php?id=$id");
        exit();
    }else{
        $_SESSION["msg"] = "El libro no existe";
        header("Location: ../index.php");
        exit();
    }

}