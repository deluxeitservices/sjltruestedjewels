const manualFields = document.getElementById('manualAddressFields');
const manualToggle = document.getElementById('enterManualAddress');
const loginCard = document.querySelector('.login-card');

function updateLoginCardHeight() {
  if (window.innerWidth > 767) {
    // Desktop behavior
    if (manualFields.classList.contains('d-none')) {
      loginCard.style.minHeight = "536px";
    } else {
      loginCard.style.minHeight = "740px";
    }
  } else {
    // Mobile behavior (let CSS handle it, clear inline style)
    loginCard.style.minHeight = "";
  }
}

// Toggle manual fields
manualToggle.addEventListener('click', function(e) {
  e.preventDefault();
  manualFields.classList.toggle('d-none');
  this.textContent = manualFields.classList.contains('d-none')
    ? "Enter address manually"
    : "Hide manual address";
  updateLoginCardHeight();
});

// Also update on resize
window.addEventListener('resize', updateLoginCardHeight);

// Initial load
updateLoginCardHeight();