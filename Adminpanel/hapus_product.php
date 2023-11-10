<?php
include('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM products WHERE id = $id";


    if (mysqli_query($con, $query)) {
        echo '<script>alert("Produk berhasil dihapus!");</script>';
        // Redirect ke halaman produk setelah penghapusan
        header("Location: data_product.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "ID produk tidak valid.";
}
?>




