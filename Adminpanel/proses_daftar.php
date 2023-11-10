<?php
include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $password = password_hash(mysqli_real_escape_string($con, $_POST['password']), PASSWORD_DEFAULT);

    // Set 'group_id' ke 3 (admin products)
    $group_id = 3;

    $query = "INSERT INTO users (name, username, email, phone_number, password, group_id) VALUES ('$name', '$username', '$email', '$phone_number', '$password', '$group_id')";

    if ($con->query($query)) {
        // Pendaftaran berhasil, alihkan ke halaman login
        header('Location: login.php');
        exit();
    } else {
        echo "Terjadi kesalahan saat mendaftar: " . $con->error;
        // Tambahan: Pesan kesalahan yang mungkin diperlukan
    }

    $con->close();
}
?>
