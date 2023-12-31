      <?php
      include('../koneksi.php');

      class Registrasi
      {
        private $con;

        public function __construct($connection)
        {
          $this->con = $connection;
        }

        public function prosesRegistrasi($name, $username, $email, $phone_number, $password)
        {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $query = "INSERT INTO users (name, username, email, phone_number, password) VALUES ('$name', '$username', '$email', '$phone_number', '$hashed_password')";
          $result = mysqli_query($this->con, $query);

          if (!$result) {
            die("Registrasi gagal: " . mysqli_error($this->con));
          }

          return true;
        }
      }

      $registrasi = new Registrasi($con);

      if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['phone_number'], $_POST['password'])) {
        $name = htmlspecialchars($_POST['name']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $phone_number = htmlspecialchars($_POST['phone_number']);
        $password = htmlspecialchars($_POST['password']);

        $registrasi_sukses = $registrasi->prosesRegistrasi($name, $username, $email, $phone_number, $password);

        if ($registrasi_sukses) {
          // Registrasi berhasil, lakukan sesuatu seperti redirect atau tampilkan pesan sukses
          header('Location: login.php');
          exit;
        }
      }
      ?>

      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | Registration Page (v2)</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/adminlte.min.css">
      </head>

      <body class="hold-transition register-page">
        <div class="register-box">
          <div class="card card-outline card-primary">
            <div class="card-header text-center">
              <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
              <p class="login-box-msg">Register a new membership</p>

              <form action="proses_daftar.php" method="post">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Full name" name="name" id="name">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" placeholder="Phone Number" name="phone_number" id="phone_number">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" placeholder="Retype password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                      <label for="agreeTerms">
                        I agree to the <a href="#">terms</a>
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>

              <div class="social-auth-links text-center">
                <a href="#" class="btn btn-block btn-primary">
                  <i class="fab fa-facebook mr-2"></i>
                  Sign up using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                  <i class="fab fa-google-plus mr-2"></i>
                  Sign up using Google+
                </a>
              </div>

              <a href="login.php" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
          </div><!-- /.card -->
        </div>
        <!-- /.register-box -->

        <!-- jQuery -->
        <script src="../plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
      </body>

      </html>