<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Temu Janji Pasien Dokter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #007bff;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .container {
      margin: 50px auto;
      text-align: center;
      display: inline-block;
      width: 30%; /* Sesuaikan lebar container */
      margin-right: 20px; /* Jarak antar konten */
      vertical-align: top; /* Menjaga konten tetap sejajar di bagian atas */
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      margin: 10px;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    
  </style>
</head>
<body>

<div class="wrapper">



  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/ic4.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <div class="header">
    <h1>Sistem Temu Janji Pasien Dokter</h1>
    <p>Selamat datang di platform temu janji pasien-dokter!</p>
  </div>

  <div class="container">
    <h2>Login Sebagai Pasien</h2>
    <p>Daftarkan diri Anda dan buatlah janji dengan dokter Anda.</p>
    <a href="regispasien.php" class="btn btn-primary">Daftar Sekarang</a>
  </div>

  <div class="container">
    <h2>Login Sebagai Dokter</h2>
    <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani Pasien!</p>
    <a href="logindokter.php" class="btn btn-primary">Login</a>
  </div>

  <div class="container">
    <h2>Login Sebagai Admin</h2>
    <p>Apabila Anda adalah seorang Admin, silahkan Login untuk mengakses Dashboard </p>
    <a href="login.php" class="btn btn-primary">Login</a>
  </div>

<!-- REQUIRED SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- icons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
