let ticketCount = 2;
const ticketCountElement = document.getElementById('ticketCount');
const decreaseBtn = document.getElementById('decreaseBtn');
const increaseBtn = document.getElementById('increaseBtn');
const modal = document.getElementById('static-modal');
const modalTicketCount = document.getElementById('modalTicketCount');
const modalTotalPrice = document.getElementById('modalTotalPrice');
const purchaseBtn = document.getElementById('purchaseBtn');
const finalModal = document.getElementById('final-modal');
const successModal = document.getElementById('success-modal');

// Decrease ticket count
decreaseBtn.addEventListener('click', () => {
  if (ticketCount > 2) {
    ticketCount--;
    ticketCountElement.textContent = ticketCount;
    modalTicketCount.textContent = ticketCount;
    modalTotalPrice.textContent = (ticketCount * pricePerTicket).toFixed(2);
    increaseBtn.disabled = false;
  }
  if (ticketCount === 2) {
    decreaseBtn.disabled = true;
  }
});

// Increase ticket count
increaseBtn.addEventListener('click', () => {
  ticketCount++;
  ticketCountElement.textContent = ticketCount;
  modalTicketCount.textContent = ticketCount;
  modalTotalPrice.textContent = (ticketCount * pricePerTicket).toFixed(2);
  decreaseBtn.disabled = false;
});

// Update ticket count when selecting a button
function updateTicketCount(count) {
  ticketCount = count;
  ticketCountElement.textContent = ticketCount;
  modalTicketCount.textContent = ticketCount;
  modalTotalPrice.textContent = (ticketCount * pricePerTicket).toFixed(2);
}

// Show modal when clicking "¡Compra tu boleto ahora!"
purchaseBtn.addEventListener('click', () => {
  modal.classList.remove('hidden');
});

// Close modal
function closeModal() {
  modal.classList.add('hidden');
}

// Proceed with purchase
function proceedWithPurchase() {
  closeModal();
  finalModal.classList.remove('hidden');
}

// Close final purchase modal
function closeFinalModal() {
  finalModal.classList.add('hidden');
}

function showSuccessModal() {
  const successModal = document.getElementById('success-modal');
  if (successModal) {
    successModal.classList.remove('hidden'); // Muestra el modal
  }
}

function closeSuccessModal() {
  const successModal = document.getElementById('success-modal');
  if (successModal) {
    successModal.classList.add('hidden'); // Oculta el modal
  }
}

// Evento de submit del formulario
document.getElementById('purchase-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Evitar que se recargue la página

  const formData = new FormData(this); // Obtener los datos del formulario
  formData.append("tiques", ticketCount);
  formData.append("monto", (ticketCount * pricePerTicket).toFixed(2));
  const photoInput = document.getElementById('photo');
  const allowedFormats = ['image/jpeg', 'image/png']; // Formatos permitidos
  const submitButton = document.getElementById("botonComprarTique");

  // Verificar si se ha seleccionado una imagen
  if (!photoInput.files.length) {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'Debe seleccionar una imagen.',
      confirmButtonText: 'Aceptar',
    });
    return;
  }

  // Verificar el formato de la imagen
  const file = photoInput.files[0];
  if (!allowedFormats.includes(file.type)) {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'Formato de archivo no permitido. Solo se aceptan JPG, JPEG y PNG.',
      confirmButtonText: 'Aceptar',
    });
    return;
  }

  // Deshabilitar el botón y mostrar el estado de cargando
  submitButton.disabled = true;

  closeFinalModal();

  Swal.fire({
    title: 'Procesando...',
    text: 'Por favor, espere mientras procesamos su compra.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  // Realizar la solicitud
  fetch('acciones/compra.php', {
    method: 'POST',
    body: formData,
  })
    .then(response => {
      if (!response.ok) {
        return response.json().then(errorData => {
          throw new Error(errorData.message || 'Hubo un error al procesar la solicitud.');
        });
      }
      return response.json(); // Si la respuesta es correcta, se parsea como JSON
    })
    .then(data => {
      Swal.close(); // Cerrar el modal de cargando
      if (data.success) {
        // Mostrar el modal de éxito personalizado
        showSuccessModal();
      } else {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: data.message || 'Hubo un error al realizar la compra. Por favor, intenta nuevamente más tarde.',
          confirmButtonText: 'Aceptar',
        });
      }
    })
    .catch(error => {
      Swal.close(); // Asegurarse de cerrar el modal de cargando en caso de error
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: error.message || 'Hubo un error al realizar la compra. Por favor, intenta nuevamente más tarde.',
        confirmButtonText: 'Aceptar',
      });
    })
    .finally(() => {
      // Asegurarse de habilitar el botón en todos los casos (éxito o error)
      submitButton.disabled = false;
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const termsModal = document.getElementById('terms-modal');
  const acceptTermsButton = document.getElementById('accept-terms-btn');

  // Verificar si ya se aceptaron los términos en el localStorage
  const termsAccepted = localStorage.getItem('termsAccepted');

  if (!termsAccepted) {
    // Mostrar el modal
    termsModal.classList.remove('hidden');
  }

  // Agregar evento al botón de aceptar
  acceptTermsButton.addEventListener('click', function () {
    // Guardar en localStorage
    localStorage.setItem('termsAccepted', 'true');

    // Ocultar el modal
    termsModal.classList.add('hidden');
  });
});
