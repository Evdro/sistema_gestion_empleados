<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require('usuario.php');
$conexion = new Conexion();
$usuario = new Usuario($conexion);

// Controlador para registro
if(isset($_POST['btnRegistro'])){
    if(!empty($_POST['nombre']) && !empty($_POST['nickname']) && !empty($_POST['correo']) && !empty($_POST['password2'])){
        $nombre = $_POST['nombre'];
        $nickname = $_POST['nickname'];
        $correo = $_POST['correo'];
        $pass = $_POST['password2'];

        $resultado = $usuario->registrarUsuario($nombre, $nickname, $correo, $pass);

        if($resultado){
            echo json_encode(['status' => 'success', 'message' => 'Usuario registrado con éxito']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar el usuario']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Faltan campos por llenar']);
    }
exit;
}

// Controlador para login
if(isset($_POST['btnLogin'])){
    if(!empty($_POST['nickname']) && !empty($_POST['password'])){
        $nickname = $_POST['nickname'];
        $pass = $_POST['password'];

        $resultado = $usuario->loginUsuario($nickname, $pass);

        if($resultado == true){
            session_start();
            $_SESSION['usuario'] = $nickname;
            session_write_close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Datos incorrectos']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Campos vacíos']);
    }
    exit;
}

// Controlador para cambiar contraseña
if(isset($_POST['btnCambiarDatos'])){
    if(!empty($_POST['correo']) && !empty($_POST['nickname']) && !empty($_POST['password2'])){
        $correo = $_POST['correo'];
        $nickname = $_POST['nickname'];
        $pass = $_POST['password2'];

        $usuario->cambiarPass($nickname, $pass, $correo);

        echo json_encode(['status' => 'success', 'message' => 'Contraseña cambiada con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos incorrectos']);
    }
    exit;
}



