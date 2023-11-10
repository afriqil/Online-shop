<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

// Pagination settings
$limit = 4;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalRecordsQuery = "SELECT COUNT(*) AS total FROM products";
$totalRecordsResult = $con->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);


// fungsi pencarian
if (isset($_GET['search'])) {
    $search = $con->real_escape_string($_GET['search']);
    $query = "SELECT products.*, product_categories.category_name
              FROM products
              LEFT JOIN product_categories ON products.category_id = product_categories.id
              WHERE
              products.product_name LIKE '%$search%' OR
              product_categories.category_name LIKE '%$search%' OR
              products.description LIKE '%$search%'";
} else {
    $query = "SELECT products.*, product_categories.category_name
              FROM products
              LEFT JOIN product_categories ON products.category_id = product_categories.id";
}

// limit dan offset
$query .= " LIMIT $limit OFFSET $offset";

$result = $con->query($query);
if (!$result) {
    die("Error in query execution: " . $con->error);
}

// ... (sisa kode Anda)
$categoryQuery = "SELECT * FROM product_categories";
$categoryResult = $con->query($categoryQuery);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product User</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!--Navbar-->
        <?php include('navbar.php'); ?>
        <!--Navbar-->

        <!-- Main Sidebar Container -->
        <?php include('sidebar.php'); ?>
        <!--/sidebar-->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- ... (kode HTML lainnya) ... -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="tambahproduct.php" class="btn btn-primary" role="button" title="Tambah Data"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
                                    <div class="float-right">
                                        <form id="search" method="get">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control" placeholder="Cari produk">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Cari</button>
                                                </div>
                                                <a href="data_product.php" class="btn btn-secondary"><i class="fas fa-sync"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama produk</th>
                                                <th>Kategori produk</th>
                                                <th>Kode produk</th>
                                                <th>deskripsi</th>
                                                <th>Harga</th>
                                                <th>Images</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = ($page - 1) * $limit + 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $no . "</td>";
                                                echo "<td>" . $row['product_name'] . "</td>";
                                                echo "<td>" . $row['category_name'] . "</td>";
                                                echo "<td>" . $row['product_code'] . "</td>";
                                                echo "<td>" . $row['description'] . "</td>";
                                                echo "<td>" . $row['price'] . "</td>";

                                                // Menguraikan data JSON yang berisi path gambar
                                                $image_paths = json_decode($row['image']);

                                                // Sekarang, $image_paths adalah array yang berisi path gambar
                                                // Anda dapat mengakses path gambar seperti ini:
                                                foreach ($image_paths as $path) {
                                                    echo "<td><img src='" . $path . "' alt='Gambar Produk' width='100'></td>";
                                                }

                                                echo "<td>";
                                                echo "<a href='edit_product.php?id=" . $row['id'] . "' class='btn btn-success'>Ubah</a>";
                                                echo "<a href='hapus_product.php?id=" . $row['id'] . "' class='btn btn-danger'>Hapus</a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama produk</th>
                                                <th>Kategori produk</th>
                                                <th>Kode produk</th>
                                                <th>deskripsi</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>aksi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <?php
                                            if (isset($_GET['search'])) {
                                                if ($page > 1) {
                                                    echo "<li class='page-item'><a class='page-link' href='data_product.php?search=$search&page=" . ($page - 1) . "'>Previous</a></li>";
                                                }

                                                for ($i = 1; $i <= $totalPages; $i++) {
                                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'>";
                                                    echo "<a class='page-link' href='data_product.php?search=$search&page=$i'>$i</a>";
                                                    echo "</li>";
                                                }

                                                if ($page < $totalPages) {
                                                    echo "<li class='page-item'><a class='page-link' href='data_product.php?search=$search&page=" . ($page + 1) . "'>Next</a></li>";
                                                }
                                            } else {
                                                if ($page > 1) {
                                                    echo "<li class='page-item'><a class='page-link' href=data_product.php?page=" . ($page - 1) . "'>Previous</a></li>";
                                                }

                                                for ($i = 1; $i <= $totalPages; $i++) {
                                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'>";
                                                    echo "<a class='page-link' href='data_product.php?page=$i'>$i</a>";
                                                    echo "</li>";
                                                }

                                                if ($page < $totalPages) {
                                                    echo "<li class='page-item'><a class='page-link' href='data_product.php?page=" . ($page + 1) . "'>Next</a></li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <!--card body-->
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include('footer.php'); ?>
        <!--/Main Footer-->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    var rowText = $(this).text().toLowerCase();
                    $(this).toggle(
                        rowText.indexOf(value) > -1
                    );
                });
            });
        });
    </script>

</body>

</html>