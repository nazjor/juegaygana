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
    modalTotalPrice.textContent = (ticketCount * 280).toFixed(2);
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
  modalTotalPrice.textContent = (ticketCount * 280).toFixed(2);
  decreaseBtn.disabled = false;
});

// Update ticket count when selecting a button
function updateTicketCount(count) {
  ticketCount = count;
  ticketCountElement.textContent = ticketCount;
  modalTicketCount.textContent = ticketCount;
  modalTotalPrice.textContent = (ticketCount * 280).toFixed(2);
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