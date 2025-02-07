<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'menu.php';

require_once 'db.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$stmt = $pdo->prepare('SELECT nombre_rol FROM roles WHERE id = ?');
$stmt->execute([$_SESSION['rol_id']]);
$role = $stmt->fetchColumn();

$stmt2 = $pdo->prepare('SELECT nombre_real FROM usuarios WHERE id = ?');
$stmt2->execute([$_SESSION['user_id']]);
$nom = $stmt2->fetchColumn();

$stmt3 = $pdo->prepare('SELECT nombre_usuario FROM usuarios WHERE id = ?');
$stmt3->execute([$_SESSION['user_id']]);
$nus = $stmt3->fetchColumn();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message'], $_SESSION['message_type']);
} else {
    $message = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SININA - Portada</title>
    <link rel="stylesheet" href="estilos/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="efectos/cambiar_contrasena.js" defer></script>
    <style>
        body, html {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <main style="display: flex; justify-content: center; padding-top: 90px">
        <div class="card text-center" style="width: 60%;">
            <div class="card-header">
                <p><?= htmlspecialchars($nom) ?></p>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($nus) ?></h5>
                <p class="card-text">Ha iniciado sesión en SININA</p>
                <a href="#" id="changePasswordButton" class="btn btn-primary">Cambiar Contraseña</a>
                    <div id="changePasswordForm" style="display: none; margin-top: 20px;">
                        <form id="passwordChangeForm" action="controladores/UsuarioController.php?action=cambiarContraseña" method="POST">
                            <div class="form-group fila">
                                <label for="current_password">Contraseña Actual:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('current_password')">
                                            <i id="eye-icon-current_password" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group fila">
                                <label for="new_password">Nueva Contraseña:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password" required oninput="validatePasswords()">
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('new_password')">
                                            <i id="eye-icon-new_password" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group fila">
                                <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required oninput="validatePasswords()">
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password')">
                                            <i id="eye-icon-confirm_password" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="passwordMismatchMessage" style="color: red; display: none;">
                                Las contraseñas no coinciden
                            </div>
                            <div id="botones">
                                <button type="submit" class="btn btn-success">Confirmar Cambio</button>
                                <button type="button" id="discardChangePasswordButton" class="btn btn-secondary">Descartar Cambio</button>
                            </div>
                        </form>
                    </div>
            </div>
            <div class="card-footer text-body-secondary">
                <p><?= htmlspecialchars($role) ?></p>
            </div>
        </div>
        </main>
    </div>
    <?php if ($message): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert("<?= htmlspecialchars($message) ?>", "<?= htmlspecialchars($message_type) ?>");
            });
        </script>
    <?php endif; ?>
    <?php include 'piedepagina.php'; ?>
</body>
</html>
