<?php

require 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT id, password, rol_id FROM usuarios WHERE nombre_usuario = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['rol_id'] = $user['rol_id'];
            header('Location: index.php');
            exit;
        } else {
            $error_message = 'Contraseña Incorrecta';
        }
    } else {
        $error_message = 'Nombre de Usuario Incorrecto o no Registrado';
    }
   
    header('Location: login.php?error=' . urlencode($error_message) . '&username=' . urlencode($username));
    exit();

} else {
    header('Location: login.php');
    exit();
}
?>