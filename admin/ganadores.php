<?php
$title = 'Ganadores - Juega y Gana';
include_once 'components/header.php';
// Obtener el parámetro 'pagina' con un valor predeterminado
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
?>
<title><?php echo $title?></title>
<main>
    <div class="grid">
        <div class="col-span-1 w-full px-6">

            <!-- Page Title -->
            <div class="flex justify-between items-center my-6">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900">Ganadores</h1>
            </div>

            <!-- tasks panel -->
            <div id="ganadores-container"></div>
        </div>
    </div>

<!-- Modal para editar pago -->
<div id="modalEditar" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Ganador
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modalEditar">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="formEditar">
                <input type="hidden" id="idPago" name="id">
                <div class="grid gap-4 mb-4 grid-cols-2">
          
                </div>
                <button type="submit" class="w-full text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</div>

</main>

<script>
$(document).ready(function() {

    // Cerrar el modal cuando se hace clic en el botón de cerrar
    $('[data-modal-toggle="modalEditar"]').click(function() {
        $('#modalEditar').addClass('hidden');
    });

    // Cerrar el modal cuando se hace clic fuera del área del modal
    $('#modalEditar').click(function(e) {
        if ($(e.target).is('#modalEditar')) {
            $(this).addClass('hidden');
        }
    });

    // Obtener la página inicial desde PHP
    const initialPage = <?php echo $pagina; ?>;

    // Cargar pagos al inicio
    loadPagos(initialPage);

    // Función para cargar pagos
    function loadPagos(page = 1) {
        $.ajax({
            url: `load/getPagos.php?pagina=${page}`, // Pasar la página como parámetro
            method: 'GET',
            success: function(response) {
                $('#ganadores-container').html(response); // Reemplazar el contenido del contenedor
                updatePagination(page); // Actualizar la paginación activa
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar los pagos: ", error);
                swal("Error", "Hubo un problema al cargar los pagos", "error");
            }
        });
    }

    // Evento para enviar el formulario de edición
    $('#formEditar').on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this); 

        $.ajax({
            url: 'acciones/editPago.php',  // URL donde se procesa el formulario
            type: 'POST',
            data: formData,
            processData: false,  
            contentType: false,  
            success: function(response) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'El pago se ha editado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
                loadPagos(initialPage);
                $('#modalEditar').addClass('hidden');
            },
            error: function(xhr, status, error) {
                const errorResponse = JSON.parse(xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: errorResponse.error,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});

// Función para editar un pago
function editarPago(pago) {
    document.getElementById('modalEditar').classList.remove('hidden');
    document.getElementById('idPago').value = pago.id;
    document.getElementById('estadoPago').value = pago.estado;
}
</script>

<?php
include_once 'components/footer.php';
?>
