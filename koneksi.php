<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "web_agile";

$koneksi = mysqli_connect($hostname, $username, $password, $database_name);

$db = $koneksi;

if (!$koneksi) {
    die("koneksi database gagal:" . mysqli_connect_error());
}