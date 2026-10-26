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
