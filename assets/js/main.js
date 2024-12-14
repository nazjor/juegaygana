let ticketCount = 2;
const ticketCountElement = document.getElementById('ticketCount');
const decreaseBtn = document.getElementById('decreaseBtn');
const increaseBtn = document.getElementById('increaseBtn');
const modal = document.getElementById('static-modal');
const modalTicketCount = document.getElementById('modalTicketCount');
const modalTotalPrice = document.getElementById('modalTotalPrice');
const purchaseBtn = document.getElementById('purchaseBtn');
const finalModal = document.getElementById('final-modal');

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
// Evento de submit del formulario
document.getElementById('purchase-form').addEventListener('submit', function(event) {
  event.preventDefault();  // Evitar que se recargue la página

  const formData = new FormData(this);  // Obtener los datos del formulario

  // Usar fetch para enviar los datos
  fetch('acciones/compra.php', {
    method: 'POST',
    body: formData  // Los datos del formulario se pasan directamente en el cuerpo
  })
  .then(response => response.json())  // Asumiendo que el servidor retorna una respuesta JSON
  .then(data => {
    // Maneja la respuesta del servidor
    console.log(data);  // Puedes mostrar la respuesta en la consola o hacer algo más

    if (data.success) {
      // Mostrar modal de éxito
      alert('Compra realizada con éxito. Tus boletos serán enviados una vez confirmado el pago.');
      // Aquí puedes mostrar un modal o realizar alguna acción adicional
    } else {
      // Mostrar mensaje de error
      alert('Hubo un error al procesar tu compra. Intenta nuevamente.');
    }
  })
  .catch(error => {
    console.error('Error al realizar la compra:', error);
    alert('Hubo un error al realizar la compra. Por favor, intenta nuevamente más tarde.');
  });
});
