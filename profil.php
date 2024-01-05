
<?php
session_start();

// Pastikan pengguna sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    header('Location: logindokter.php');
    exit();
}

// Di sini, Anda dapat melakukan pengambilan data dari database untuk menampilkan info dokter
// Sesuaikan dengan struktur tabel dan koneksi yang Anda miliki

// Informasi profil dokter (contoh sederhana)
$username = $_SESSION['username']; // Menggunakan data sesi yang sudah disimpan saat login

// Lakukan koneksi ke database Anda
require('koneksi.php'); // Sesuaikan dengan file koneksi Anda

// Query untuk mengambil data dokter berdasarkan username
$query = "SELECT * FROM dokter WHERE username = ?";

// Siapkan statement
$stmt = $mysqli->prepare($query);

// Bind parameter
$stmt->bind_param("s", $username);

// Execute statement
$stmt->execute();

// Ambil hasil query
$result = $stmt->get_result();

// Ambil baris data
if ($row = $result->fetch_assoc()) {
    $nama_dokter = $row['username'];
    $no_hp = $row['no_hp'];
    $alamat = $row['alamat'];
    // Informasi lainnya jika ada, sesuaikan dengan kolom di database Anda
}

// Jika tombol simpan ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    // Di sini, Anda dapat menangani proses pembaruan profil dokter
    // Sesuaikan dengan kebutuhan Anda, misalnya: update ke database

    // Contoh: Mengambil data yang diinput pengguna
    $nama_dokter = $_POST['nama_dokter'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Query untuk update data ke database
    $update_query = $mysqli->prepare("UPDATE dokter SET no_hp = ?, alamat = ? WHERE username = ?");

    // Bind parameter
    $update_query->bind_param("sss", $no_hp, $alamat, $username);

    // Eksekusi query
    if ($update_query->execute()) {
        // Redirect kembali ke halaman profil setelah update
        header('Location: profil.php');
        exit();
    } else {
        // Jika ada kesalahan saat update
        $error = "Gagal menyimpan perubahan. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Informasi Poliklinik</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">


<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/ic4.png" alt="AdminLTELogo" height="60" width="60">
  </div>
  
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">

     <!-- Left navbar links -->
     <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index2.php" class="nav-link">Home</a>
      </li>
    </ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="logout.php" role="button">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </li>
</ul>
</nav>
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index2.php" class="brand-link">
      <img src="img/ic2.png" alt="icon" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">POLIKLINIK</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <?php if (isset($_SESSION['username'])) : ?>
        <div class="info">
            <a class="d-block"><?php echo $_SESSION['username']; ?></a>
        </div>
    <?php endif; ?>
</div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dokter
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="jadwal.php" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>jadwal Periksa</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="periksa.php?page=periksa" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Memeriksa Pasien</p>
                </a>
            </li>
              <li class="nav-item">
                <a href="riwayat.php?page=riwayat" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Riwayat Pasien</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="profil.php?page=profil" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Profil Dokter</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index2.php">Home</a></li>
              <li class="breadcrumb-item active">Profil</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
     <!-- Konten Profil Dokter -->
     <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10">
                            <!-- Form untuk menampilkan informasi profil dan mengubahnya -->
                            <div class="card">
                                <div class="card-body">
                                    <!-- Form untuk menampilkan informasi profil dan mengubahnya -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
          <label for="nama_dokter">Nama Dokter</label>
          <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="<?php echo $nama_dokter; ?>" required>
      </div>
      <div class="form-group">
          <label for="alamat">Alamat</label>
          <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required>
      </div>
      <div class="form-group">
          <label for="no_hp">Nomor HP</label>
          <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp; ?>" required>
      </div>
      <!-- Tambahkan input untuk informasi lainnya jika perlu -->
      <div class="form-group d-flex justify-content-center">
    <button type="submit" class="btn btn-primary" name="simpan">Simpan Perubahan</button>
      </div>
  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
    </div>
    <div>
    <li class="sidebar-item">
          <a href="logout.php">
            <i><b>Logout</b></i> 
          </a>
      </li>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
