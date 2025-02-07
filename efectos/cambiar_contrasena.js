document.addEventListener('DOMContentLoaded', function() {
    const changePasswordButton = document.getElementById('changePasswordButton');
    const changePasswordForm = document.getElementById('changePasswordForm');
    const discardChangePasswordButton = document.getElementById('discardChangePasswordButton');

    changePasswordButton.addEventListener('click', function(event) {
        event.preventDefault();
        $(changePasswordForm).fadeIn('slow');
        changePasswordButton.disabled = true;
    });

    discardChangePasswordButton.addEventListener('click', function() {
        $(changePasswordForm).fadeOut('slow', function() {
            changePasswordButton.disabled = false;
        });
    });
});

function showAlert(message, type) {
    const alertBox = document.createElement('div');
    alertBox.className = `alert alert-${type} alert-dismissible fade show`;
    alertBox.role = 'alert';
    alertBox.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertBox);

    setTimeout(() => {
        $(alertBox).alert('close');
    }, 5000);
}

function togglePasswordVisibility(id) {
    const passwordField = document.getElementById(id);
    const eyeIcon = document.getElementById('eye-icon-' + id);
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

function validatePasswords() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const message = document.getElementById('passwordMismatchMessage');
    if (newPassword.value !== confirmPassword.value) {
        message.style.display = 'block';
    } else {
        message.style.display = 'none';
    }
}