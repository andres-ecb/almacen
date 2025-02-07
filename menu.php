<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

$stmt = $pdo->prepare('SELECT nombre_rol FROM roles WHERE id = ?');
$stmt->execute([$_SESSION['rol_id']]);
$role = $stmt->fetchColumn();
$stmt2 = $pdo->prepare('SELECT nombre_real FROM usuarios WHERE id = ?');
$stmt2->execute([$_SESSION['user_id']]);
$nom = $stmt2->fetchColumn();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<head>
<link rel="stylesheet" href="estilos/menus.css">
</head>
<div class="contmenu">
    <div class="container">
        <nav class="navbar">
            <div class="navbar-left">
                <h1><a href="/almacen/index.php" id="prna">Bienvenido(a) a SININA</a></h1>
            </div>
            <div class="navbar-right">
                <ul class="nav-list">
                    <?php if ($_SESSION['rol_id'] == 1): // para rol administrador ?>
                        <li class="nav-item"><a>Productos</a>
                            <ul class="submenu">
                                <li><a href="#">Gestión de Productos</a></li>
                                <li><a href="#">Evolución de precios</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a>Informes</a>
                            <ul class="submenu">
                                <li><a href="#">Análisis Individual</a></li>
                                <li><a href="#">Análisis General</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#">Sucursales</a></li>
                        <li class="nav-item"><a href="#">Gestión de Usuarios</a>
                            <ul class="submenu">
                                <li><a href="/almacen/controladores/UsuarioController.php?action=index">Crear y Editar Usuarios</a></li>
                                <li><a href="#">Actividad de Usuario</a></li>
                            </ul>
                        </li>
                        
                    <?php endif; ?>
                    <?php if ($_SESSION['rol_id'] == 2): // para rol jefe desucursal ?>
                        <li class="nav-item"><a href="#">Informes</a>
                            <ul class="submenu">
                                <li><a href="#">Ingresar Informe</a></li>
                                <li><a href="#">Informes Ingresados</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item"><a><?= htmlspecialchars($nom) ?></a></li>
                    <?php endif; ?>
                </ul>
                <a href="/almacen/logout.php" class="logout-button">Salir</a>
            </div>
        </nav>
    </div>
</div>    