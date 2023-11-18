<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "pos_shop";

$con = mysqli_connect($localhost, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Setelah koneksi berhasil dibuat, Anda dapat menggunakan mysqli_query
$result = mysqli_query($con, "SELECT * FROM products");

// Lakukan operasi lainnya dengan hasil kueri jika perlu
?>
