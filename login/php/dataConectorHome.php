<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require('empleado.php');
$conexion = new Conexion();
$empleado = new Empleado($conexion);

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $empleado->mostrarTodosEmpleados();
    exit;
}
