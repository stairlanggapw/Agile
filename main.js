var loginBtn = document.getElementById('loginBtn');
var registerBtn = document.getElementById('registerBtn');

document.getElementById('keluar').addEventListener('click', function(){
  const konfirmasi = confirm("Apakah anda yakin ingin keluar?");

  if(konfirmasi){
    localStorage.removeItem('userToken');

    window.location.href = 'home.php';
  }
})

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

(function () {
  var toast = document.getElementById('toast');

  if (!toast) {
    return;
  }

  var toastTimer = null;

  document.addEventListener('click', function (event) {
    var bookBtn = event.target.closest('.btn-book');

    if (!bookBtn) {
      return;
    }

    var title = bookBtn.getAttribute('data-title') || 'film ini';

    toast.textContent = 'Pemesanan tiket "' + title + '" segera hadir.';
    toast.classList.add('show');

    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () {
      toast.classList.remove('show');
    }, 2800);
  });
})();
