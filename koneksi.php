<?php
$hostname = "localhost";
$username = "root";
$passowrd = "";
$database_name = "web_agile";

$db = mysqli_connect($hostname, $username, $passowrd, $database_name);

if($db -> connect_error){
    die("koneksi database gagal:" . mysqli_connect_error());
}
?>