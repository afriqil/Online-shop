<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION["login"])) {
  header("location: login.php");

  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Ambil data dari formulir
  $product_name = $_POST['product_name'];
  $category_id = $_POST['category_id'];
  $product_code = $_POST['product_code'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  // Proses unggah gambar
  $image = array();

  if (!empty($_FILES['product_image']['name'][0])) {
    $target_dir = "../images/uplod/"; // Direktori penyimpanan gambar
    $total_images = count($_FILES['product_image']['name']);

    for ($i = 0; $i < $total_images; $i++) {
      $target_file = $target_dir . basename($_FILES['product_image']['name'][$i]);
      if (move_uploaded_file($_FILES['product_image']['tmp_name'][$i], $target_file)) {
        $image[] = $target_file;
      } else {
        echo "Error uploading image " . $_FILES['product_image']['name'][$i];
      }
    }
  }

  // Simpan path gambar dalam format JSON
  $image = json_encode($image);

  $query = "INSERT INTO products (product_name, description, price, category_id, product_code, image) VALUES ('$product_name', '$description', '$price', '$category_id', '$product_code', '$image')";

  if (mysqli_query($con, $query)) {
    echo '<script>alert("Produk berhasil ditambahkan!");</script>';
    header("location: data_product.php");
    exit;
  } else {
    echo "Error: " . mysqli_error($con);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah-Produk</title>

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
    <?php
    include('navbar.php');
    ?>
    <!--/Navbar-->

    <!-- Main Sidebar Container -->
    <?php
    include('sidebar.php');
    ?>
    <!--/sidebar-->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> TAMBAH PRODUK</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Produk</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambahkan Produk</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="product_name">Nama Produk</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Nama Produk" required>
                  </div>
                  <div class="form-group">
                    <?php
                    $query = "SELECT * FROM product_categories";
                    $result = mysqli_query($con, $query);
                    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    ?>
                    <label for="category_id">Kategori Produk:</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                      <option disabled selected value>Pilih Kategori</option>
                      <?php
                      foreach ($categories as $category) {
                        echo "<option value='" . $category['id'] . "'>" . $category['category_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="product_code">kode Produk:</label>
                    <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Kode produk" required>
                  </div>
                  <div class="form-group">
                    <label for="description">Deskripsi:</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Deskripsi Produk" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="price">Harga:</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Harga" required>
                  </div>
                  <div class="form-group">
                    <label for="product_image">Gambar Produk</label>
                    <input type="file" name="product_image[]" id="product_image" class="form-control" multiple accept="image/*">
                  </div>
                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- /.content -->
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
    <?php
    include('footer.php');
    ?>
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
</body>

</html>