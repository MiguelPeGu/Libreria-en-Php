<?php
declare(strict_types=1);

require_once  '../../vendor/autoload.php';
session_start();

use App\model\Bd;
use App\model\Libro;
use App\model\Carrito;
use App\model\User;

$bd = Bd::getInstance();

if(isset($_POST["log"])){
    $username=filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
    $passwd=filter_input(INPUT_POST,"passwd",FILTER_SANITIZE_SPECIAL_CHARS);
    if($username ===false || $passwd === false){
        $_SESSION["msg-error"]="Error en los datos introducidos";
        header("Location: ../index.php");
        exit();
    }else{
        $user= new User(null,$username,$passwd);
        $userCompleto=Bd::validarUser($user);
        if($userCompleto!==false){
            $_SESSION["msg-acierto"]="Te has logueado correctamente";
            $_SESSION["user"]=$userCompleto;
             header("Location: ../index.php");
             exit();
        }else{
            $_SESSION["msg-error"]="Error en el usuario o en la password";
             header("Location: ../view/login.php");
             exit();
        }
    }
}