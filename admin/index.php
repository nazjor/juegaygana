<?php
$title = 'Rifa - Juega y Gana';
include_once 'components/header.php';
?>

<main>

    <div class="grid">
        <div class="col-span-1 w-full px-6">

            <!-- Page Title -->
            <div class="flex justify-between items-center my-6">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900">Rifas</h1>
                <hr>
                <!-- Botón de "Nuevo" a la derecha -->
                <button id="agregarRifaBtn" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out shadow-md">
                    Agregar Nueva Rifa
                </button>
            </div>

            <!-- tasks panel -->
            <div id="rifas-container"></div>
        </div>
    </div>


<!-- Main modal -->
<div id="agregar-rifa-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Crear Nueva Rifa
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="agregar-rifa-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="rifaForm">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <!-- Campos del formulario -->
                    <div class="col-span-2">
                        <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título de la Rifa</label>
                        <input type="text" name="titulo" id="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nombre de la rifa" required=""/>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="precio_boleto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio del Boleto</label>
                        <input type="number" name="precio_boleto" id="precio_boleto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$ Precio" required=""/>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="total_boletos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total de Boletos</label>
                        <input type="number" name="total_boletos" id="total_boletos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Cantidad total de boletos" required=""/>
                    </div>
                    <div class="col-span-2">
                        <label for="fecha_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required=""/>
                    </div>
                    <div class="col-span-2">
                        <label for="imagen_rifa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen de la Rifa</label>
                        <input type="file" name="imagen_rifa" id="imagen_rifa" accept="image/*" required=""/>
                    </div>
                </div>
                <button type="submit" class="w-full text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Guardar Rifa
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar -->
<div id="modalEditar" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Rifa
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
                <input type="hidden" id="idRifa" name="id">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <!-- Campos del formulario -->
                    <div class="col-span-2">
                        <label for="tituloE" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título de la Rifa</label>
                        <input type="text" id="tituloE" name="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required/>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="precioBoleto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio por Boleto</label>
                        <input type="number" id="precioBoleto" name="precio_boleto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required/>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="totalBoletos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total de Boletos</label>
                        <input type="number" id="totalBoletos" name="total_boletos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required/>
                    </div>
                    <div class="col-span-2">
                        <label for="fechaInicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                        <input type="date" id="fechaInicio" name="fecha_inicio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required/>
                    </div>
                    <div class="col-span-2">
                        <label for="imagen_rifa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen de la Rifa</label>
                        <input type="file" id="imagen_rifa" name="imagen_rifa" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                    </div>
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
    // Cargar rifas al inicio
    loadRifas();

    // Mostrar el modal al hacer clic en el botón "Agregar Nueva Rifa"
    $('#agregarRifaBtn').click(function() {
        $('#agregar-rifa-modal').removeClass('hidden');
    });

    // Cerrar el modal cuando se hace clic en el botón de cerrar
    $('[data-modal-toggle="agregar-rifa-modal"]').click(function() {
        $('#agregar-rifa-modal').addClass('hidden');
    });

    // Cerrar el modal cuando se hace clic fuera del área del modal
    $('#agregar-rifa-modal').click(function(e) {
        if ($(e.target).is('#agregar-rifa-modal')) {
            $(this).addClass('hidden');
        }
    });

    // Cerrar el modal de edición cuando se hace clic en el botón de cerrar
    $('[data-modal-toggle="modalEditar"]').click(function() {
        $('#modalEditar').addClass('hidden');
    });

    // Cerrar el modal de edición cuando se hace clic fuera del área del modal
    $('#modalEditar').click(function(e) {
        if ($(e.target).is('#modalEditar')) {
            $(this).addClass('hidden');
        }
    });

    // Función para cargar rifas
    function loadRifas() {
        $.ajax({
            url: 'load/getRifas.php',
            method: 'GET',
            success: function(response) {
                $('#rifas-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar las rifas: ", error);
                swal("Error", "Hubo un problema al cargar las rifas", "error");
            }
        });
    }

    // Evento de submit del formulario
    $('#rifaForm').on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'acciones/saveRifa.php',  // URL de tu script PHP que procesa el formulario
            type: 'POST',  // Método de envío
            data: formData,  // Datos del formulario
            processData: false,  // No procesar los datos, ya que estamos enviando archivos
            contentType: false,  // No establecer un tipo de contenido, ya que estamos enviando un formulario con archivos
            success: function(response) {
                loadRifas();
                $('#rifaForm')[0].reset();
                $('#agregar-rifa-modal').addClass('hidden');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'La rifa se ha creado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
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

    // Evento para enviar el formulario de edición
    $('#formEditar').on('submit', function(event) {
        event.preventDefault();  // Crear el FormData con los datos del formulario

        var formData = new FormData(this); 

        $.ajax({
            url: 'acciones/editRifa.php',  // URL donde se procesa el formulario
            type: 'POST',
            data: formData,
            processData: false,  // No procesar los datos, ya que estamos enviando un archivo
            contentType: false,  // No establecer el tipo de contenido
            success: function(response) {
                $('#rifaForm')[0].reset();
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'La rifa se ha editado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
                loadRifas();
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

// Función para editar una rifa
function editarRifa(rifa) {
    document.getElementById('modalEditar').classList.remove('hidden');
    document.getElementById('idRifa').value = rifa.id;
    document.getElementById('tituloE').value = rifa.titulo;
    document.getElementById('fechaInicio').value = rifa.fecha_inicio;
    document.getElementById('totalBoletos').value = rifa.total_boletos;
    document.getElementById('precioBoleto').value = rifa.precio_boleto;
}

</script>

<?php
include_once 'components/footer.php';
?>
