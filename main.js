const loginBtn = document.getElementById('loginBtn');
const registerBtn = document.getElementById('registerBtn');
const keluarBtn = document.getElementById('keluar');

if (keluarBtn) {
  document.getElementById("keluar").addEventListener("click", function (event) {
    event.preventDefault();
  
    const yakin = window.confirm("Yakin ingin logout?");
  
    if (yakin) {
      alert ("Selamat Anda sudah Logout");
      window.location.assign("logout.php");
    }
  });
}

if (loginBtn) {
  loginBtn.addEventListener('click', function(){
    console.log('Login submitted');
  })
}

if (registerBtn) {
  registerBtn.addEventListener('click', function(){
    console.log('Register submitted');
  })
}

const purchaseModal = document.getElementById('purchaseModal');
const successModal = document.getElementById('successModal');
const closeModal = document.querySelector('.closeModal');
const closeSuccess = document.getElementById('closeSuccess');
const btnPayment = document.querySelectorAll('.btn-payment');
const purchaseForm = document.getElementById('purchaseForm');
const selectedPlan = document.getElementById('selectedPlan');
const successName = document.getElementById('successName');
const paymentMethod = document.getElementById('paymentMethod');
const paymentDate = document.getElementById('paymentDate');
const productName = document.getElementById('productName');
const invoiceNumber = document.getElementById('invoiceNumber');

if (purchaseModal) {
  btnPayment.forEach(btn => {
    btn.addEventListener('click', function () {
      purchaseModal.style.display = 'flex';

      if (typeof lenis !== 'undefined' && lenis) {
        lenis.stop();
      }
    });
  });
}

if (closeModal && purchaseModal) {
  closeModal.addEventListener('click', function () {
    purchaseModal.style.display = 'none';

    if (typeof lenis !== 'undefined' && lenis) {
      lenis.start();
    }
  });
}