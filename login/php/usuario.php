<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include('conn.php');

interface User
{
    public function registrarUsuario($name, $nickname, $correo, $pass);
    public function mostrarUsuario($nickname);
    public function modificarUsuario($nickname, $name, $correo);
    public function eliminarUsuario($nickname);
    public function loginUsuario($nickname, $pass);
}

trait funExtras
{
    abstract function cambiarPass($nickname, $pass, $correo);
}

class Usuario implements User
{
    use funExtras;

    public $name;
    public $nickname;
    public $correo;
    public $pass;

    public $host;
    public $db;
    public $usuario;
    public $passdb;
    public $conexion;

    private $pdo;

    public function __construct(Conexion $dbconection)
    {
        $this->pdo = $dbconection->getPDO();
    }

    public function registrarUsuario($name, $nickname, $correo, $pass)
    {
        if (empty($name) || empty($nickname) || empty($pass) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Campos vacios']);
        }
        try {
            $stmt = $this->pdo->prepare('INSERT INTO usuarios(nombre_usuario, nickname_usuario, correo_usuario, pass_usuario)
                                                VALUES(:nombre, :nickname, :correo, :pass)');

            $stmt->execute([
                ':nombre' => $name,
                ':nickname' => $nickname,
                ':correo' => $correo,
                ':pass' => password_hash($pass, PASSWORD_DEFAULT)
            ]);
            echo json_encode([
                "status" => "success",
                "success" => true,
                "message" => "Registro completo"
            ]);
        } catch (PDOException $e) {
            error_log('error al registrar el usuario' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                'success' => false,
                'message' => 'error al registrar el usuario'
            ]);
        }
        exit;
    }
    public function mostrarUsuario($nickname)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE nickname_usuario = :nickname');

            $stmt->execute([':nickname' => $nickname]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('error al mostrar el usuario' . $e->getMessage());
            throw new Exception("sucedio un error al mostrar los datos del usuario");
        }
        exit;
    }
    public function modificarUsuario($nickname, $nuevoName, $nuevoCorreo)
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE usuarios SET nombre_usuario = :nombre, correo_usuario = :correo WHERE nickname_usuario = :nickname');
            $stmt->execute([
                ':nombre' => $nuevoName,
                ':correo' => $nuevoCorreo,
                ':nickname' => $nickname,
            ]);
            echo json_encode(['success' => true, 'message' => 'datos actualizados con exito']);
        } catch (PDOException $e) {
            error_log("error al modificar al usuario" . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'error al modifican los datos'
            ]);
        }
        exit;
    }
    public function eliminarUsuario($nickname)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE nickname_usuario = :nickname');
            $stmt->execute([
                ':nickname' => $nickname
            ]);
            echo json_encode([
                'status' => 'success',
                'success' => true,
                'message' => 'el usuario se elmino correctamente'
            ]);
        } catch (PDOException $e) {
            error_log('error al eliminar el usuario' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'error al eliminar el usuarios'
            ]);
        }
        exit;
    }
    public function loginUsuario($nickname, $pass)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT nickname_usuario, pass_usuario FROM usuarios WHERE nickname_usuario = :nickname');
            $stmt->execute([':nickname' => $nickname]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                if (password_verify($pass, $usuario['pass_usuario'])) {
                    session_start();
                    $_SESSION['usuario'] = $nickname;
                    echo json_encode([
                        "status" => "success",
                        'success' => true,
                        'message' => 'Has ingresado correctamente'
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        'success' => false,
                        'message' => 'Contraseña incorrecta'
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }
        } catch (PDOException $e) {
            error_log('error al iniciar sesion' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'error al iniciar sesion'
            ]);
            exit;
        }
        exit;
    }
    public function cambiarPass($nickname, $pass, $correo)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT nickname_usuario FROM usuarios WHERE nickname_usuario = :nickname AND correo_usuario = :correo');
            $stmt->execute([
                ':nickname' => $nickname,
                ':correo' => $correo
            ]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $stmt = $this->pdo->prepare('UPDATE usuarios SET pass_usuario = :pass WHERE nickname_usuario = :nickname');
                $stmt->execute([
                    ':nickname' => $nickname,
                    ':pass' => password_hash($pass, PASSWORD_DEFAULT)
                ]);
                echo json_encode([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'la contraseña se cambio correctamente'
                ]);
                exit;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'success' => false,
                    'message' => 'no se pudo cambiar la contraseña'
                ]);
                exit;
            }
        } catch (PDOException $e) {
            error_log('Error al cambiar contraseña: ' . $e->getMessage());
            http_response_code(500);
            json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'error al procesar la solicitud'
            ]);
            exit;
        }
        exit;
    }
}
