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
  if (!photoInput.files.length) {
    event.preventDefault();
    alert('Debe seleccionar una imagen.');
    return;
  }

  // Usar fetch para enviar los datos
  fetch('acciones/compra.php', {
    method: 'POST',
    body: formData  // Los datos del formulario se pasan directamente en el cuerpo
  })
  .then(response => response.json())  // Asumiendo que el servidor retorna una respuesta JSON
  .then(data => {
    closeFinalModal();
    successModal.classList.remove('hidden');
  })
  .catch(error => {
    alert('Hubo un error al realizar la compra. Por favor, intenta nuevamente más tarde.');
  });
});
