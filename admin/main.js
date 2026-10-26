document.getElementById("keluar").addEventListener("click", function (event) {
  event.preventDefault();

  const yakin = window.confirm("Yakin ingin logout?");

  if (yakin) {
    alert ("Selamat Anda sudah Logout");
    window.location.assign("../logout.php");
  }
});
