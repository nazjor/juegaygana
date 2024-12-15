document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');
    const url = form.getAttribute('data-url'); // Leer el atributo data-url

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();


        if (email === '' || password === '') {
            Swal.fire({
                icon: 'warning',
                title: '¡Campos vacíos!',
                text: 'Por favor, complete todos los campos.',
                confirmButtonText: 'Aceptar',
            });
            return;
        }

        Swal.fire({
            title: 'Procesando...',
            text: 'Por favor, espere mientras validamos su información.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw response;
                }
                return response.json();
            })
            .then((data) => {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    confirmButtonText: 'Aceptar',
                }).then(() => {
                    window.location.href = url.replace('/acciones/login.php', '/'); // Redirigir al dashboard
                });
            })
            .catch((error) => {
                Swal.close();
                error.json().then((err) => {
                    const errorMessage =
                        error.status === 401
                            ? 'Credenciales incorrectas. Por favor, intente nuevamente.'
                            : error.status === 500
                            ? 'Error interno del servidor. Inténtelo más tarde.'
                            : 'Hubo un problema con la solicitud.';
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: errorMessage,
                        footer: `Detalles del error: ${err.message}`,
                        confirmButtonText: 'Aceptar',
                    });
                });
            });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const eyeIcon = document.getElementById('eye-icon');
    const passwordField = document.getElementById('password');

    eyeIcon.addEventListener('click', function() {
        // Alternar tipo de contraseña
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.innerHTML = '<i class="ri-eye-off-line text-lg"></i>'; // Ícono de ojo cerrado
        } else {
            passwordField.type = "password";
            eyeIcon.innerHTML = '<i class="ri-eye-line text-lg"></i>'; // Ícono de ojo abierto
        }
    });
});