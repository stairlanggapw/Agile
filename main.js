var loginBtn = document.getElementById('loginbtn');
var registerBtn = document.getElementById('registerBtn');

if (loginBtn) {
  loginBtn.addEventListener('click', function(e){
    e.preventDefault();
    alert('Login Successful');
  })
}
