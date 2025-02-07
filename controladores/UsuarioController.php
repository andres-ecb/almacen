<?php
require_once '../modelos/Usuario.php';

class UsuarioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Usuario();
    }

    public function cambiarContraseña() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../login.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                $_SESSION['message'] = 'Las nuevas contraseñas no coinciden.';
                $_SESSION['message_type'] = 'danger';
                header('Location: ../index.php');
                exit();
            }

            $user = $this->modelo->getUserById($_SESSION['user_id']);

            if ($user && password_verify($current_password, $user['password'])) {
                $this->modelo->updatePassword($_SESSION['user_id'], $new_password);
                $_SESSION['message'] = 'Contraseña cambiada exitosamente.';
                $_SESSION['message_type'] = 'success';
                header('Location: ../index.php');
                exit();
            } else {
                $_SESSION['message'] = 'Contraseña actual incorrecta.';
                $_SESSION['message_type'] = 'danger';
                header('Location: ../index.php');
                exit();
            }
        }
    }

    public function index() {
        $usuarios = $this->modelo->obtenerUsuariosConRoles();
        $roles = $this->modelo->obtenerRoles();
        require_once dirname(__DIR__) . '/vistas/gestion_usuarios.php';
    }

    public function crear() {
        $nombre_usuario = $_POST['nombre_usuario'];
        $nombre_real = $_POST['nombre_real'];
        $password = $_POST['password'];
        $rol_id = $_POST['rol_id'];

        $this->modelo->crearUsuario($nombre_usuario, $nombre_real, $password, $rol_id);
        header('Location: ../controladores/UsuarioController.php');
    }

    public function actualizar() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../login.php');
            exit;
        }
    
        $id = $_POST['id'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $nombre_real = $_POST['nombre_real'];
        $rol_id = $_POST['rol_id'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
    
        if (!empty($password)) {
            if ($password !== $confirm_password) {
                $_SESSION['message'] = 'Las nuevas contraseñas no coinciden.';
                $_SESSION['message_type'] = 'danger';
                header('Location: ../controladores/UsuarioController.php');
                exit();
            }
            $this->modelo->actualizarUsuario($id, $nombre_usuario, $nombre_real, $rol_id, $password);
        } else {
            $this->modelo->actualizarUsuario($id, $nombre_usuario, $nombre_real, $rol_id);
        }
    
        $_SESSION['message'] = 'Usuario actualizado exitosamente.';
        $_SESSION['message_type'] = 'success';
        header('Location: ../controladores/UsuarioController.php');
    }

    public function eliminar() {
        $id = $_POST['id'];
        $this->modelo->eliminarUsuario($id);
        header('Location: ../vistas/gestion_usuarios.php');
    }
}


if (isset($_GET['action'])) {
    $controller = new UsuarioController();

    switch ($_GET['action']) {
        case 'cambiarContraseña':
            $controller->cambiarContraseña();
            break;
        case 'crear':
            $controller->crear();
            break;
        case 'actualizar':
            $controller->actualizar();
            break;
        case 'eliminar':
            $controller->eliminar();
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller = new UsuarioController();
    $controller->index();
}
?>