<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;
use App\model\User;
$bd = Bd::getInstance();

if(isset($_POST["register"])){
    $username=filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
    $passwd=filter_input(INPUT_POST,"passwd",FILTER_SANITIZE_SPECIAL_CHARS);
    $passwd2=filter_input(INPUT_POST,"passwd2",FILTER_SANITIZE_SPECIAL_CHARS);
    if($username===false||$passwd===false||$passwd2===false){
        $_SESSION["msg-error"]="datos erroneos";
        header("Location: ../view/register.php");
        exit();
    }else{
        $user=new User(null,$username,$passwd);
        if($passwd!==$passwd2){
        $_SESSION["msg-error"]="Las contraseñas no coinciden";
        header("Location: ../view/register.php");
        exit();
        }else if(Bd::validarUser($user)){
        $_SESSION["msg-error"]="El usuario ya existe";
        header("Location: ../view/register.php");
        exit();
        }else{
        Bd::registrarUsuario($user);
        $_SESSION["msg-acierto"]="Te has registrado con éxito";
        header("Location: ../view/login.php");
        exit();
        }
    }



}