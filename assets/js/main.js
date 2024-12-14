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

// Close success modal
function closeSuccessModal() {
  successModal.classList.add('hidden');
}
// Evento de submit del formulario
document.getElementById('purchase-form').addEventListener('submit', function(event) {
  event.preventDefault();  // Evitar que se recargue la página

  const formData = new FormData(this);  // Obtener los datos del formulario
  const photoInput = document.getElementById('photo');
  const allowedFormats = ['image/jpeg', 'image/png'];  // Formatos permitidos

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

  // Usar fetch para enviar los datos
  fetch('acciones/compra.php', {
    method: 'POST',
    body: formData  // Los datos del formulario se pasan directamente en el cuerpo
  })
  .then(response => response.json())  // Asumiendo que el servidor retorna una respuesta JSON
  .then(data => {
    if (data.success) {
      closeFinalModal();
      successModal.classList.remove('hidden');
    } else {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: data.message || 'Hubo un error al realizar la compra. Por favor, intenta nuevamente más tarde.',
        footer: `Detalles del error: ${data.message}`,
        confirmButtonText: 'Aceptar',
      });
    }
  })
  .catch(error => {
    console.log(error);
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'Hubo un error al realizar la compra. Por favor, intenta nuevamente más tarde.',
      footer: `Detalles del error: `,
      confirmButtonText: 'Aceptar',
    });
  });
});
