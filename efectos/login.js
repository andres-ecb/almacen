$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const username = $('#username').val();
        const password = $('#password').val();

        $.ajax({
            type: 'POST',
            url: 'authenticate.php',
            data: { username: username, password: password },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = 'dashboard.php';
                } else {
                    $('#infoSection').html(`
                        <div class="bg-white p-4 rounded">
                            <p>${response.message}</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#infoSection').html(`
                    <div class="bg-white p-4 rounded">
                        <p>Ocurrió un error. Inténtelo nuevamente.</p>
                    </div>
                `);
            }
        });
    });

    $('#forgotPasswordLink').on('click', function(e) {
        e.preventDefault();
        $('#infoSection').html(`
            <div class="bg-white p-4 rounded">
                <h4>Recuperar Contraseña</h4>
                <form id="resetPasswordForm">
                    <div class="form-outline mb-4">
                        <input type="text" id="resetUsername" name="resetUsername" class="form-control" placeholder="Nombre de usuario" required />
                        <label class="form-label" for="resetUsername">Nombre de usuario</label>
                    </div>
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Enviar</button>
                </form>
            </div>
        `);
    });

    $('#infoSection').on('submit', '#resetPasswordForm', function(e) {
        e.preventDefault();
        const resetUsername = $('#resetUsername').val();

        $.ajax({
            type: 'POST',
            url: 'reset_password.php',
            data: { username: resetUsername },
            dataType: 'json',
            success: function(response) {
                $('#infoSection').html(`
                    <div class="bg-white p-4 rounded">
                        <p>${response.message}</p>
                    </div>
                `);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#infoSection').html(`
                    <div class="bg-white p-4 rounded">
                        <p>Ocurrió un error. Inténtelo nuevamente.</p>
                    </div>
                `);
            }
        });
    });
});
