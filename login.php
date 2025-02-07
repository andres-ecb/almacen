<?php
require 'vistas/peq_ic.php';

$error_message = '';
$username = '';
if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error']);
    if (isset($_GET['username'])) {
        $username = htmlspecialchars($_GET['username']);
    }
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SININA - Inicio de Sesión</title>
    <link rel="stylesheet" href="estilos/iniciosesion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arsenal+SC:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="todo">
        <div id="placa">
            <h2> Sistema de Información Institucional<br>de Almacén - <span id="marcasin">SININA</span></h2>
        </div>
        <div id="divform">
            <form id="login-form" class="form" action="authenticate.php" method="post">
                <div class="text-center">
                    <img src="recursos/logo.png" style="width: 46px;" alt="logo">                             
                </div>
                <br>
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" value="<?= $username ?>" required>
                <br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <button type="submit">Ingresar</button>
                <br>
                <?php if ($error_message): ?>
                    <div id="placa-error">
                    <p class="error-message"><?= $error_message ?><br>👉 Intente nuevamente 👈</p>
                    </div>
                <?php endif; ?>
                <a href="recuperar_contraseña.html">¿Olvidaste tu contraseña?</a>
            </form>
        </div>
        <div id="placa" class="logo">
            <h2>ALMAC<span id="marcae">é</span>N</h2>
        </div>
    </div>
</body>
</html>