<?php
class Usuario {
    private $pdo;

    public function __construct() {
        require_once dirname(__DIR__) . '/db.php';
        $this->pdo = $pdo;
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare('UPDATE usuarios SET password = ? WHERE id = ?');
        $stmt->execute([$hashed_password, $id]);
    }

    /*public function obtenerUsuarios() {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll();
    }*/

    public function obtenerUsuariosConRoles() {
        $query = "SELECT usuarios.id, usuarios.nombre_usuario, usuarios.nombre_real, usuarios.rol_id, roles.nombre_rol 
                  FROM usuarios 
                  INNER JOIN roles ON usuarios.rol_id = roles.id ORDER BY usuarios.nombre_usuario";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerRoles() {
        $query = "SELECT id, nombre_rol FROM roles";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($nombre_usuario, $nombre_real, $password, $rol_id) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre_usuario, nombre_real, password, rol_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre_usuario, $nombre_real, $hash, $rol_id]);
    }

    public function obtenerUsuarioPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function actualizarUsuario($id, $nombre_usuario, $nombre_real, $rol_id) {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre_usuario = ?, nombre_real = ?, rol_id = ? WHERE id = ?");
        return $stmt->execute([$nombre_usuario, $nombre_real, $rol_id, $id]);
    }

    public function eliminarUsuario($id) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}