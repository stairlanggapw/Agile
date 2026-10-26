var loginBtn = document.getElementById('loginBtn');
var registerBtn = document.getElementById('registerBtn');

document.getElementById("keluar").addEventListener("click", function (event) {
  event.preventDefault();

  const yakin = window.confirm("Yakin ingin logout?");

  if (yakin) {
    alert ("Selamat Anda sudah Logout");
    window.location.assign("logout.php");
  }
});

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
