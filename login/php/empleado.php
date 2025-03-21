<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include('conn.php');

interface empleados{
    public function registrarEmpleado(
        $nombre,
        $correo,
        $puesto,
        $telefono,
        $direccion,
        $fechaIn,
        $salario,
        $departamento,
        $supervisor,
        $genero,
        $nss,
        $curp,
        $rfc,
        $stat
    );
    public function mostrarEmpleado($nombre);
    public function editarEmpleado($nombre, $correo, $puesto, $telefono, $direccion, $salario, $departamento, $stat);
    public function eliminarEmpleado($nombre);    
}

trait funEmpExt{
    public abstract function cambiarStatusEmpleado($status, $nombre);
    public abstract function mostrarTodosEmpleados();
}

class Empleado implements empleados{

    use funEmpExt;

    private $nombre;
    private $correo;
    private $puesto;
    private $stat;

    private $pdo;

    public function __construct(Conexion $dbconection)
    {
        $this->pdo = $dbconection->getPDO();
    }

    public function registrarEmpleado(
        $nombre,
        $correo,
        $puesto,
        $telefono,
        $direccion,
        $fechaIn,
        $salario,
        $departamento,
        $supervisor,
        $genero,
        $nss,
        $curp,
        $rfc,
        $stat
    ) {
        // Validación de campos vacíos
        foreach (func_get_args() as $arg) {
            if (empty($arg)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Campos vacíos'
                ]);
                exit;
            }
        }
    
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO `empleados`
                (`nombre_empleado`, `correo_empleado`, `puesto_empleado`, `telefono_empleado`, `direccion_empleado`, `fecha_ingreso_empleado`, `fecha_salida_empleado`,
                 `salario`, `departamento_empleado`, `supervisor_id`, `genero_empleado`, `nss_empleado`, `curp_empleado`, `rfc_empleado`, `status_empleado`) 
                VALUES (:nombre, :correo, :puesto, :tel, :dir, :fechaIn, NULL, :salario, :departamento, :supervisor, :genero, :nss, :curp, :rfc, :stat)"
            );
    
            $stmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':puesto' => $puesto,
                ':tel' => $telefono,
                ':dir' => $direccion,
                ':fechaIn' => $fechaIn,
                ':salario' => $salario,
                ':departamento' => $departamento,
                ':supervisor' => $supervisor,
                ':genero' => $genero,
                ':nss' => $nss,
                ':curp' => $curp,
                ':rfc' => $rfc,
                ':stat' => $stat
            ]);
    
            echo json_encode([
                'status' => 'success',
                'success' => true,
                'message' => 'Empleado registrado'
            ]);
            exit;
        } catch (PDOException $e) {
            error_log('Error al registrar al empleado: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Error al registrar al empleado'
            ]);
            exit;
        }
    }
    
    public function mostrarEmpleado($nombre)
{
    if (!empty($nombre)) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM empleados WHERE nombre_empleado = :nombre');
            $stmt->execute([':nombre' => $nombre]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                $datos = array_map(function ($fila) {
                    return [
                        'id' => $fila['id_empleado'],
                        'nombre' => $fila['nombre_empleado'],
                        'correo' => $fila['correo_empleado'],
                        'puesto' => $fila['puesto_empleado'],
                        'status' => $fila['status_empleado']
                    ];
                }, $resultados);
                echo json_encode(['status' => 'success', 'data' => $datos]);
                exit;
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'success' => false,
                    'message' => 'No se encontraron empleados con ese nombre'
                ]);
                exit;
            }
        } catch (PDOException $e) {
            error_log('Error al mostrar al empleado: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'No se pudo mostrar el empleado'
            ]);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'success' => false,
            'message' => 'El campo "nombre" está vacío'
        ]);
        exit;
    }
}

public function editarEmpleado($nombre, $correo, $puesto, $telefono, $direccion, $salario, $departamento, $stat)
{
    if (empty($nombre) || empty($correo) || empty($puesto) || empty($telefono) || empty($direccion) || empty($salario) || empty($departamento) || empty($stat)) {
        echo json_encode([
            'status' => 'error',
            'success' => false,
            'message' => 'Todos los campos son obligatorios'
        ]);
        exit;
    }

    try {
        // Verificar si el empleado existe
        $stmt = $this->pdo->prepare('SELECT * FROM empleados WHERE nombre_empleado = :nombre');
        $stmt->execute([':nombre' => $nombre]);
        $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$empleado) {
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Empleado no encontrado'
            ]);
            exit;
        }

        // Actualizar datos del empleado
        $stmt = $this->pdo->prepare(
            'UPDATE empleados 
             SET correo_empleado = :correo, 
                 puesto_empleado = :puesto, 
                 telefono_empleado = :tel,
                 direccion_empleado = :dir,
                 salario = :salario,
                 departamento_empleado = :departamento,
                 status_empleado = :stat
             WHERE nombre_empleado = :nombre'
        );

        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':puesto' => $puesto,
            ':tel' => $telefono,
            ':dir' => $direccion,
            ':salario' => $salario,
            ':departamento' => $departamento,
            ':stat' => $stat
        ]);

        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => 'success',
                'success' => true,
                'message' => 'Datos modificados correctamente'
            ]);
        } else {
            echo json_encode([
                'status' => 'warning',
                'success' => false,
                'message' => 'No se realizaron cambios en los datos'
            ]);
        }
        exit;
    } catch (PDOException $e) {
        error_log('Error al editar el empleado: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'success' => false,
            'message' => 'No se pudo modificar el empleado'
        ]);
        exit;
    }
}


    public function eliminarEmpleado($idEmpleado)
    {
        if($idEmpleado){
            try{
                $stmt = $this->pdo->prepare('DELETE FROM empleados WHERE id_empleado = :idE');
                $stmt->execute([':idE'=>$idEmpleado]);
                echo json_encode([
                    'status'=>'success',
                    'success'=>true,
                    'message'=>'Empleado eliminado correctamente'
                ]);
                exit;
            }catch(PDOException $e){
                http_response_code(400);
                echo json_encode([
                    'status'=>'error',
                    'success'=>false,
                    'message'=>'error al elminar el empleado'
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status'=>'error',
                'success'=>false,
                'message'=>'campos vacios'
            ]);
        }
       
    }
    public function cambiarStatusEmpleado($status, $nombre)
    {
        if($status){
            try{
                $stmt = $this->pdo->prepare('UPDATE empleados SET status_empleado = :stat WHERE nombre_empleado = :nombre');
                $stmt->execute([
                    ':stat' => $status,
                    ':nombre' => $nombre
                ]);
            }catch(PDOException $e){
                echo json_encode([
                    'status'=>'error',
                    'success'=>false,
                    'message'=>'no se pudo cambiar el status '.$e
                ]);
                exit;
            }
        }if (empty($status) || empty($nombre)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Campos vacíos'
            ]);
            exit;
        }
        
    }

    public function mostrarTodosEmpleados()
{
    try {
        $stmt = $this->pdo->prepare('SELECT * FROM empleados');
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($resultados) {
            $datos = array_map(function ($fila) {
                return [
                    'id' => $fila['id_empleado'],
                    'nombre' => $fila['nombre_empleado'],
                    'correo' => $fila['correo_empleado'],
                    'puesto' => $fila['puesto_empleado'],
                    'status' => $fila['status_empleado'],
                    'telefono' => $fila['telefono_empleado'],
                    'direccion' => $fila['direccion_empleado'],
                    'fecha_ingreso' => $fila['fecha_ingreso_empleado'],
                    'salario' => $fila['salario'],
                    'departamento' => $fila['departamento_empleado']
                ];
            }, $resultados);
            echo json_encode(['status' => 'success', 'data' => $datos]);
            exit;
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'No se encontraron empleados'
            ]);
            exit;
        }
    } catch (PDOException $e) {
        error_log('Error al mostrar empleados: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'success' => false,
            'message' => 'No se pudieron mostrar los empleados'
        ]);
        exit;
    }
}
}