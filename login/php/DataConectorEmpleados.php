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

//controlador para registrarEmpleados
if(isset($_POST['btnRegistrarEmpleado'])){
    if(!empty($_POST['nombreEmpleadoRegistro'])&&!empty($_POST['correoEmpleadoRegistro'])&&!empty($_POST['empleadoPuestoRegistro'])&&!empty($_POST['empleadoStatusRegistro'])){
        $nombre = $_POST['nombreEmpleadoRegistro'];
        $correo = $_POST['correoEmpleadoRegistro'];
        $puesto = $_POST['empleadoPuestoRegistro'];
        $telefono = $_POST['telefonoEmpleadoRegistro'];
        $direccion = $_POST['direccionEmpleadoRegistro'];
        $fechaIn = $_POST['fechaIngresoRegistro'];
        $salario = $_POST['salarioEmpleadoRegistro'];
        $departamento = $_POST['departamentoEmpleadoRegistro'];
        $supervisor = $_POST['supervisorEmpleadoRegistro'];
        $genero = $_POST['generoEmpleadoRegistro'];
        $nss = $_POST['nssEmpleadoRegistro'];
        $curp = $_POST['curpEmpleadoRegistro'];
        $rfc = $_POST['rfcEmpleadoRegistro'];
        $status = $_POST['empleadoStatusRegistro'];

        $resultado = $empleado->registrarEmpleado($nombre, $correo, $puesto, $telefono, $direccion, $fechaIn, $salario, $departamento, $supervisor, $genero, $nss, $curp, $rfc, $status);

        if($resultado){
            echo json_encode([
                'status'=>'success',
                'message'=>'Empleado registrado correctamente'
            ]);
            exit;
        }else{
            echo json_encode([
                'status'=>'error',
                'message'=>'Error al registrar al empleado'
            ]);
            exit;
        }
       
    }else{
        echo json_encode([
            'status'=>'error',
            'message'=>'campos vacios'
        ]);
        exit;
    }
}

//controlador para mostrar tabla de empleados
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $empleado->mostrarTodosEmpleados();
    exit;
}

//controlador para eliminar empleados
if(isset($_POST['btnEliminarEmpleado'])){
    if($_POST['idEmpleado']){
        $idEmpleado = $_POST['idEmpleado'];
        $resultado = $empleado->eliminarEmpleado($idEmpleado);

        if($resultado){
            echo json_encode([
                'status'=>'success',
                'success'=>true,
                'message'=>'Empleado eliminado'
            ]);
        }else{
            echo json_encode([
                'status'=>'success',
                'success'=>false,
                'message'=>'Error al eliminar usuario'
            ]);
        }
    }
}

//controlador para modificar a los empleados
if (isset($_POST['btnCambiarDatos'])) {
    $nombreEmpleado = $_POST['cambiarNombreEmpleado'];
    $correoEmpleado = $_POST['cambiarCorreoEmpleado'];
    $puestoEmpleado = $_POST['cambiarPuestoEmpleado'];
    $statusEmpleado = $_POST['cambiarStatusEmpleado'];
    $telefonoEmpleado = $_POST['cambiarTelefonoEmpleado'];
    $direccionEmpleado = $_POST['cambiarDireccionEmpleado'];
    $salarioEmpleado = $_POST['cambiarSalarioEmpleado'];
    $departamentoEmpleado = $_POST['cambiarDepartamentoEmpleado'];

    if (!empty($nombreEmpleado) && !empty($correoEmpleado) && !empty($puestoEmpleado) && !empty($statusEmpleado)) {
        $resultado = $empleado->editarEmpleado($nombreEmpleado, $correoEmpleado, $puestoEmpleado, $telefonoEmpleado, $direccionEmpleado, $salarioEmpleado, $departamentoEmpleado, $statusEmpleado);

        if ($resultado) {
            echo json_encode([
                'status' => 'success',
                'success' => true,
                'message' => 'Los datos se modificaron correctamente'
            ]);
            exit;
        } else {
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Error al modificar los datos'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'success' => false,
            'message' => 'Campos vacíos o incompletos'
        ]);
        exit;
    }
}