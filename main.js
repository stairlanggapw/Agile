var loginBtn = document.getElementById('loginBtn');
var registerBtn = document.getElementById('registerBtn');

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
