<?php
session_start();
require '../vistas/peq_ic.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
include '../menu.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SININA - Gestión de Usuarios</title>
    <link rel="stylesheet" href="../estilos/menus.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arsenal+SC:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<style>
        body, html {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        h1{
            font-family: "Arsenal SC", sans-serif;
            text-align: center;
        }


    </style>
<body>
    <div class="container mt-4">
        <h1>Gestión de Usuarios</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= $_SESSION['message'] ?>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>
        <div class="text-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
            Crear Usuario
        </button></div>

        <table class="table table-secondary table-hover mt-4">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Persona</th>
                    <th>Rol Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nombre_usuario']) ?></td>
                        <td><?= htmlspecialchars($usuario['nombre_real']) ?></td>
                        <td><?= htmlspecialchars($usuario['nombre_rol']) ?></td> <!-- Mostrar el nombre del rol -->
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" 
                                    data-id="<?= $usuario['id'] ?>" 
                                    data-nombre_usuario="<?= $usuario['nombre_usuario'] ?>" 
                                    data-nombre_real="<?= $usuario['nombre_real'] ?>" 
                                    data-rol_id="<?= $usuario['rol_id'] ?>">
                                Editar
                            </button>
                            <form action="../controladores/UsuarioController.php?action=eliminar" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- creacion de usuario -->
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUsuarioModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../controladores/UsuarioController.php?action=crear" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Ejemplo: sucursal000" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre_real" class="form-label">Nombre Persona</label>
                            <input type="text" class="form-control" id="nombre_real" name="nombre_real" placeholder="Ejemplo: María Álvarez" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol_id" class="form-label">Rol</label>
                            <select class="form-select" id="rol_id" name="rol_id" required>
                                <option selected disabled value="">Elija un rol de usuario</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= htmlspecialchars($rol['nombre_rol']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- actualizacion de usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../controladores/UsuarioController.php?action=actualizar" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editar_id" name="id">
                        <div class="mb-3">
                            <label for="editar_nombre_usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="editar_nombre_usuario" name="nombre_usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar_nombre_real" class="form-label">Nombre Real</label>
                            <input type="text" class="form-control" id="editar_nombre_real" name="nombre_real" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar_rol_id" class="form-label">Rol</label>
                            <select class="form-select" id="editar_rol_id" name="rol_id" required>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= htmlspecialchars($rol['nombre_rol']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editar_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="editar_password" name="password">
                            <small class="text-muted">Deja este campo en blanco si no deseas cambiar la contraseña.</small>
                        </div>
                        <div class="mb-3">
                            <label for="editar_confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="editar_confirm_password" name="confirm_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var editarUsuarioModal = document.getElementById('editarUsuarioModal');
        editarUsuarioModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nombre_usuario = button.getAttribute('data-nombre_usuario');
            var nombre_real = button.getAttribute('data-nombre_real');
            var rol_id = button.getAttribute('data-rol_id');

            var modalTitle = editarUsuarioModal.querySelector('.modal-title');
            var editar_id = editarUsuarioModal.querySelector('#editar_id');
            var editar_nombre_usuario = editarUsuarioModal.querySelector('#editar_nombre_usuario');
            var editar_nombre_real = editarUsuarioModal.querySelector('#editar_nombre_real');
            var editar_rol_id = editarUsuarioModal.querySelector('#editar_rol_id');

            modalTitle.textContent = 'Editar Usuario ' + nombre_usuario;
            editar_id.value = id;
            editar_nombre_usuario.value = nombre_usuario;
            editar_nombre_real.value = nombre_real;
            editar_rol_id.value = rol_id;
        });
    </script>
</body>
<?php include '../piedepagina.php'; ?>
</html>