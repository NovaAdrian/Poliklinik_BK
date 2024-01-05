<?php
include('koneksi.php');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: logindokter.php');
    exit();
}

// Ambil data jadwal dari database berdasarkan poli yang dipilih
$id_poli = $_GET['idpoli']; // Pastikan untuk melakukan sanitasi input ini untuk mencegah serangan SQL Injection
$query_jadwal = "SELECT * FROM jadwal_periksa WHERE id_poli = $id_poli"; // Sesuaikan dengan struktur tabel Anda
$result_jadwal = mysqli_query($koneksi, $query_jadwal);

// Output opsi jadwal berdasarkan data yang diambil dari database
while ($row = mysqli_fetch_assoc($result_jadwal)) {
    echo '<option value="' . $row['id'] . '">' . $row['username'] . ' - ' . $row['hari'] . ' ' . $row['jam_mulai'] . '-' . $row['jam_selesai'] . '</option>';
}

$username = $_SESSION['username'];
$query_dokter = "SELECT id FROM dokter WHERE username = '$username'";
$result_dokter = mysqli_query($mysqli, $query_dokter);

if ($result_dokter && mysqli_num_rows($result_dokter) > 0) {
    $row_dokter = mysqli_fetch_assoc($result_dokter);
    $id_dokter = $row_dokter['id'];

    if (isset($_POST['tambah'])) {
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        $query_check_availability = "SELECT * FROM jadwal_periksa 
                                    WHERE id_dokter = '$id_dokter' 
                                    AND hari = '$hari' 
                                    AND ((jam_mulai BETWEEN '$jam_mulai' AND '$jam_selesai') 
                                    OR (jam_selesai BETWEEN '$jam_mulai' AND '$jam_selesai'))";
        $result_check_availability = mysqli_query($mysqli, $query_check_availability);

        if ($result_check_availability && mysqli_num_rows($result_check_availability) > 0) {
            $error_message = "Jadwal sudah terisi atau tumpang tindih dengan jadwal yang ada.";
            header("Location: jadwal.php?error=" . urlencode($error_message));
            exit();
        } else {
            $query_insert = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) 
                             VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";
            $result_insert = mysqli_query($mysqli, $query_insert);

            if ($result_insert) {
                header("Location: jadwal.php?success=1");
                exit();
            } else {
                $error_message = "Terjadi kesalahan saat menambah jadwal.";
                header("Location: jadwal.php?error=" . urlencode($error_message));
                exit();
            }
        }
    }
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
      $id_jadwal = $_GET['id'];
  
      // Lakukan query untuk menghapus jadwal sesuai dengan ID yang diberikan
      $query_delete = "DELETE FROM jadwal_periksa WHERE id = '$id_jadwal'";
      $result_delete = mysqli_query($mysqli, $query_delete);
  
      if ($result_delete) {
          header("Location: jadwal.php?success_delete=1");
          exit();
      } else {
          $error_message = "Terjadi kesalahan saat menghapus jadwal.";
          header("Location: jadwal.php?error=" . urlencode($error_message));
          exit();
      }
  }
  

    // Eksekusi query untuk mendapatkan data jadwal
    $query = "SELECT jadwal_periksa.*, dokter.username AS nama_dokter, dokter.id_poli AS poli_id, poli.nama_poli AS poli 
    FROM jadwal_periksa 
    INNER JOIN dokter ON jadwal_periksa.id_dokter = dokter.id
    INNER JOIN poli ON dokter.id_poli = poli.id"; // Sesuaikan dengan nama kolom yang sesuai di tabel Anda
$result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Tampilkan data jadwal di tabel
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
              <?php
    if(isset($_GET['error']) && !empty($_GET['error'])) {
        $error_message = $_GET['error'];
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>
  <!-- Kode php untuk menghubungkan form dengan database -->
  <form class="form row" method="POST" action="">
                  <div>
                  <input type="hidden" name="nama_dokter" value="<?php echo $id_dokter; ?>">
                    <label class="form-label fw-bold">Hari</label>
                    <select class="form-control my-2" name="hari">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                    <label class="form-label fw-bold">Jam Mulai</label>
                    <input type="time" class="form-control my-2" name="jam_mulai" value="<?php echo $jam_mulai ?>">
                    <label class="form-label fw-bold">Jam Selesai</label>
                    <input type="time" class="form-control my-2" name="jam_selesai" value="<?php echo $jam_selesai ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-3" name="tambah">Tambah</button>
                </div>
</form>
            <!-- Table-->
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Dokter</th>
                <th scope="col">poli</th>
                <th scope="col">Hari</th>
                <th scope="col">Jam Mulai</th>
                <th scope="col">Jam Selesai</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>     
        <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $row['nama_dokter']; ?></td>
            <td><?php echo $row['poli']; ?></td>
            <td><?php echo $row['hari']; ?></td>
            <td><?php echo $row['jam_mulai']; ?></td>
            <td><?php echo $row['jam_selesai']; ?></td>
            <td>
                <a class="btn btn-success rounded-pill px-3" href="jadwal_edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="btn btn-danger rounded-pill px-3" href="jadwal.php?aksi=hapus&id=<?php echo $row['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php
                        $no++;
                    }
                    ?>
</tbody>                    
    </table>
</div>

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
<?php
    } else {
        echo "Tidak ada data jadwal yang ditemukan.";
    }
} else {
    // Handle jika username dokter tidak ditemukan di tabel dokter
    // ...
}
?>