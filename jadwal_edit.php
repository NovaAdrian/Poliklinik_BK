<?php
include('koneksi.php');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: logindokter.php');
    exit();
}

// Cek jika ada ID yang diteruskan melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: jadwal.php');
    exit();
}

$id_jadwal = $_GET['id'];

// Mendapatkan id_dokter dari tabel dokter berdasarkan username yang login
$username = $_SESSION['username'];
$query_dokter = "SELECT id FROM dokter WHERE username = '$username'";
$result_dokter = mysqli_query($mysqli, $query_dokter);

if ($result_dokter && mysqli_num_rows($result_dokter) > 0) {
    $row_dokter = mysqli_fetch_assoc($result_dokter);
    $id_dokter = $row_dokter['id'];

    // Proses Update Data
    if (isset($_POST['update'])) {
        // Ambil data dari form
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        // Query untuk mengupdate jadwal
        $query_update = "UPDATE jadwal_periksa SET hari = '$hari', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai' WHERE id = $id_jadwal";
        $result_update = mysqli_query($mysqli, $query_update);
        if ($result_update) {
            // Redirect ke halaman jadwal.php jika proses update berhasil
            header('Location: jadwal.php');
            exit();

        // Handle kesalahan atau beri respon berhasil
        // ...
    }else {
    }
}

    // Ambil data jadwal yang akan diedit
    $query_edit = "SELECT * FROM jadwal_periksa WHERE id = $id_jadwal AND id_dokter = $id_dokter";
    $result_edit = mysqli_query($mysqli, $query_edit);

    if ($result_edit && mysqli_num_rows($result_edit) > 0) {
        $row_edit = mysqli_fetch_assoc($result_edit);
        // Data jadwal yang akan diedit ditemukan
        // Disimpan dalam variabel untuk ditampilkan di form
        $hari = $row_edit['hari'];
        $jam_mulai = $row_edit['jam_mulai'];
        $jam_selesai = $row_edit['jam_selesai'];
    } else {
        // Tidak ada data jadwal yang cocok dengan ID yang diteruskan
        // Redirect atau berikan pesan kesalahan
        // ...
    }
} else {
    // Handle jika username dokter tidak ditemukan di tabel dokter
    // ...
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
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index2.php">Home</a></li>
              <li class="breadcrumb-item active">jadwal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">jadwal</h5>
              </div>
              <div class="card-body">
  <!-- Kode php untuk menghubungkan form dengan database -->
  <form class="form row" method="POST" action="">
  <div>
        <input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal; ?>">
        <label class="form-label fw-bold">Hari</label>
        <select class="form-control my-2" name="hari">
            <option value="Senin" <?php if ($hari === 'Senin') echo 'selected'; ?>>Senin</option>
            <option value="Selasa" <?php if ($hari === 'Selasa') echo 'selected'; ?>>Selasa</option>
            <option value="Rabu" <?php if ($hari === 'Rabu') echo 'selected'; ?>>Rabu</option>
            <option value="kamis" <?php if ($hari === 'kamis') echo 'selected'; ?>>kamis</option>
            <option value="Jumat" <?php if ($hari === 'Jumat') echo 'selected'; ?>>Jumat</option>
            <option value="Sabtu" <?php if ($hari === 'Sabtu') echo 'selected'; ?>>Sabtu</option>

        </select>
        <label class="form-label fw-bold">Jam Mulai</label>
        <input type="time" class="form-control my-2" name="jam_mulai" value="<?php echo $jam_mulai ?>">
        <label class="form-label fw-bold">Jam Selesai</label>
        <input type="time" class="form-control my-2" name="jam_selesai" value="<?php echo $jam_selesai ?>">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="update">Update</button>
    </div>
</form>

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
<!-- icons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>