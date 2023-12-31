<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('koneksi.php'); // Sesuaikan dengan file koneksi Anda

    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Lakukan validasi atau manipulasi data jika diperlukan

    // Simpan ke database
    $insert_query = $mysqli->prepare("INSERT INTO dokter (username, password, alamat, no_hp) VALUES (?, ?, ?, ?)");
    $insert_query->bind_param("ssss", $username, $password, $alamat, $no_hp);
    
    if ($insert_query->execute()) {
        // Registrasi sukses, bisa tambahkan informasi lain ke tabel lain jika diperlukan
        // Redirect atau lakukan aksi lainnya setelah registrasi berhasil
        header('location: index2.php'); // Ganti dengan halaman tujuan setelah registrasi berhasil
        exit();
    } else {
        // Registrasi gagal
        $error = "Registrasi gagal. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Dokter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.php"><b>Registrasi</b>Dokter</a>
  </div>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/ic4.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register</p>

      <form action="regisdokter.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Name" name="username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nomor HP" name="no_hp" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="col-14">
          <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
      </form>
      <div class="social-auth-links text-center">
        <p>- OR -</p>
      </div>
      <a href="logindokter.php" class="text-center">I already have an account</a>
    </div>
      <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>



<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
