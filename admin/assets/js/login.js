$(document).ready(function () {
    // Al enviar el formulario
    $('#login-form').submit(function (e) {
        e.preventDefault();

        // Obtener los datos del formulario
        var email = $('#emailaddress').val().trim();
        var password = $('#password').val().trim();

        // Validar campos antes de enviar la solicitud
        if (email === '' || password === '') {
            Swal.fire({
                icon: 'warning',
                title: '¡Campos vacíos!',
                text: 'Por favor, complete todos los campos.',
                confirmButtonText: 'Aceptar'
            });
            return; // Detener ejecución si hay campos vacíos
        }

        // Mostrar un indicador de carga mientras se procesa la solicitud
        Swal.fire({
            title: 'Procesando...',
            text: 'Por favor, espere mientras validamos su información.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Enviar la solicitud AJAX
        $.ajax({
            url: '<?php echo HOST_ADMIN;?>acciones/login.php', // Ruta del script que maneja la autenticación
            type: 'POST',
            dataType: 'json', // Especificamos que esperamos JSON del servidor
            data: { email: email, password: password },
            success: function (response) {
                Swal.close(); // Cerrar el indicador de carga
                if (response && response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Redirigir al dashboard o a la página principal
                        window.location.href = '<?php echo HOST_ADMIN;?>';
                    });
                } else {
                    // Manejo de respuestas inesperadas
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error inesperado!',
                        text: 'La respuesta del servidor no es válida.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.close(); // Cerrar el indicador de carga
                let errorMessage = '';
                if (jqXHR.status === 401) {
                    errorMessage = 'Credenciales incorrectas. Por favor, intente nuevamente.';
                } else if (jqXHR.status === 500) {
                    errorMessage = 'Hubo un error interno en el servidor. Inténtelo más tarde.';
                } else if (jqXHR.status === 405) {
                    errorMessage = 'Método no permitido. Verifique la configuración de su solicitud.';
                } else {
                    errorMessage = `Hubo un problema con la solicitud: ${textStatus}.`;
                }

                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: errorMessage,
                    footer: `Detalles del error: ${errorThrown}`,
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});