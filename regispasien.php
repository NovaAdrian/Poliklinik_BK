<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require('koneksi.php');

  $username = $_POST['username'];
  $password = $_POST['password'];
  $alamat = $_POST['alamat'];
  $no_ktp = $_POST['no_ktp'];
  $no_hp = $_POST['no_hp'];

  $insert_query = $mysqli->prepare("INSERT INTO pasien (username, password, alamat, no_ktp, no_hp) VALUES (?, ?, ?, ?, ?)");
  $insert_query->bind_param("sssss", $username, $password, $alamat, $no_ktp, $no_hp);

  if ($insert_query->execute()) {
      // Menghitung jumlah total data pasien yang ada di database
      $count_query = "SELECT COUNT(*) as total FROM pasien";
      $result = $mysqli->query($count_query);
      $row = $result->fetch_assoc();
      $total_patients = $row['total'];

      $tahun_bulan = date('Ym');
      $nomor_urut_formatted = sprintf("%03d", $total_patients); // Menggunakan jumlah data pasien sebagai nomor urut
      $nomor_rekam_medis = $tahun_bulan . '-' . $nomor_urut_formatted;

      $update_nomor_rekam_query = $mysqli->prepare("UPDATE pasien SET no_rm = ? WHERE username = ?");
      $update_nomor_rekam_query->bind_param("ss", $nomor_rekam_medis, $username);
      $update_nomor_rekam_query->execute();

      header('location: index3.php');
      exit();
  } else {
      $error = "Registrasi gagal. Silakan coba lagi.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Pasien</title>

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
    <a href="index3.php"><b>Registrasi</b>Pasien</a>
  </div>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/ic4.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register</p>

      <form action="regispasien.php" method="post">
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
          <input type="text" class="form-control" placeholder="Nomor KTP" name="no_ktp" required>
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
      <a href="loginpasien.php" class="text-center">I already have an account</a>
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
