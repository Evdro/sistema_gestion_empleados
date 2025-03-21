<?php

include 'conn.php';

function contarEmpleados()
{
    $pdo = new Conexion();
    $pdo = $pdo->getPDO();
    $sql = "SELECT COUNT(*) AS total FROM empleados";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function contarEmpleadosActivos(){
    $pdo = new Conexion();
    $pdo = $pdo->getPDO();
    $sql = "SELECT COUNT(*) AS total FROM empleados WHERE status_empleado = 'Activo'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}


function contarEmpleadosInactivos(){
    $pdo = new Conexion();
    $pdo = $pdo->getPDO();
    $sql = "SELECT COUNT(*) AS total FROM empleados WHERE status_empleado = 'Inactivo'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}