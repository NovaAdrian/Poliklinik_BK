
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: loginpasien.php');
    exit();
}

include('koneksi.php'); // Sesuaikan dengan nama file koneksi

// Ambil No RM dari tabel pengguna berdasarkan session username
$query = "SELECT no_rm FROM pasien WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$no_rm = $row['no_rm'];
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>

<style>
    .custom-icon {
        font-size: 30px;
    }
</style>
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
<!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/ic4.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">

     <!-- Left navbar links -->
     <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.php" class="nav-link">Home</a>
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
    <a href="index3.php" class="brand-link">
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
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Pasien
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="daftarpoli.php" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Daftar Poli</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="riwayatpoli.php" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Riwayat Daftar Poli</p>
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
            <h1 class="m-0">Daftar Poli</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Daftar Poli</li>
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
                <h5 class="m-0">Daftar Poli</h5>
              </div>
              <div class="card-body">
  <!-- Kode php untuk menghubungkan form dengan database -->
<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">

<!-- AMBIL DATA UNTUK UBAH -->
<?php
            include ('koneksi.php');
            $id_pasien = '';
            $id_jadwal = '';
            $keluhan = '';
            $no_antrian = '';
            $status_periksa = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, 
                "SELECT * FROM daftar_poli 
                WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $id_pasien = $row[''];
                    $id_jadwal = $row['id_jadwal'];
                    $keluhan = $row['keluhan'];
                    $no_antrian = $row['no_antrian'];
                    $status_periksa = $row['status_periksa'];
                }
            ?>
                <input type=hidden name="id" value="<?php echo
                $_GET['id'] ?>">
            <?php
            }
            ?>
        <!-- No RM -->
        <label class="form-label fw-bold">No RM</label>
        <input type="text" class="form-control my-2" name="id_pasien" value="<?php echo $no_rm; ?>" readonly>


        <!-- SELECT poli -->
       <label class="fw-bold">Pilih Poli</label>
       <select id="inputPoli" class="form-control my-2" name="nama_poli">
    <?php
    include('koneksi.php');
    $selected = '';
    $poli = mysqli_query($mysqli, "SELECT * FROM poli");
    while ($data = mysqli_fetch_array($poli)) {
        if ($data['id'] == $id_jadwal) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
    ?>
        <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama_poli'] ?></option>
    <?php
    }
    ?>
</select>
        <!-- SELECT jadwal -->
       <label class="fw-bold">Pilih Jadwal</label>
       <select id="jadwal" class="form-control my-2" name="id_jadwal">
    <?php
    include('koneksi.php');
    $selected = '';
    $jadwal = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa");
    while ($data = mysqli_fetch_array($jadwal)) {
        if ($data['id'] == $id_jadwal) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
    ?>
        <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['hari'] ?></option>
    <?php
    }
    ?>
</select>       
       <label class="fw-bold">Keluhan</label>
       <input type="text" class="form-control my-2" name="keluhan"  value="<?php echo $keluhan ?>"> 

       <button class="btn btn-primary" type="submit" name="simpan" >daftar</button>
    </form>

    <!-- TABLE -->
    <div class="table-responsive my-4">
        <table class="table"  id="myTable">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Poli</th>
                <th scope="col">Dokter</th>
                <th scope="col">Hari</th>
                <th scope="col">Mulai</th>
                <th scope="col">Selesai</th>
                <th scope="col">Antrian</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
            berdasarkan status dan tanggal awal-->
                <?php
                    $result = mysqli_query($mysqli, "SELECT 
                                                        pol.nama_poli AS nama_poli,
                                                        dok.username AS nama_dokter,
                                                        jp.hari AS hari,
                                                        jp.jam_mulai AS jam_mulai,
                                                        jp.jam_selesai AS jam_selesai,
                                                        dp.no_antrian AS no_antrian
                                                        FROM pasien AS ps
                                                            JOIN daftar_poli AS dp ON ps.id = dp.id_pasien
                                                            JOIN jadwal_periksa AS jp ON dp.id_jadwal = jp.id
                                                            JOIN dokter as dok ON jp.id_dokter = dok.id
                                                            JOIN poli AS pol ON dok.id_poli = pol.id
                                                            WHERE ps.id = '" . $_SESSION['username'] . "'
                                                    ");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['dokter'] ?></td>
                    <td><?php echo $data['hari'] ?></td>
                    <td><?php echo $data['mulai'] ?></td>
                    <td><?php echo $data['selesai'] ?></td>
                    <td><?php echo $data['antrian'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" 
                        href="daftarpoli.php?page=daftarpoli&id=<?php echo $data['id'] ?>">Ubah
                        </a>
                        <a class="btn btn-danger rounded-pill px-3" 
                        href="daftarpoli.php?page=daftarpoli&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        </table>
    </div>
</div>

<!-- FUNGSI CRUD -->
<?php
include('koneksi.php');
if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE daftar_poli SET 
                                        no_rm = '" . $_POST['no_rm'] . "'                                      
                                        poli = '" . $_POST['id_jadwal'] . "',
                                        dokter = '" . $_POST['id_jadwal'] . "',
                                        hari = '" . $_POST['id_jadwal'] . "',
                                        mulai = '" . $_POST['id_jadwal'] . "',
                                        selesai = '" . $_POST['id_jadwal'] . "',
                                        antrian = '" . $_POST['antrian'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) 
                                          VALUES (
                                              '" . $_SESSION['id_pasien'] . "',
                                              '" . $_POST['id_jadwal'] . "',
                                              '" . $_POST['keluhan'] . "' ,
                                              '" . $no_antrian . "' 
                                          )");
    }

    echo "<script> 
            document.location='daftarpoli.php';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM daftar_poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='daftarpoli.php';
            </script>";
}
?>
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
<!-- icons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script>
document.getElementById('inputPoli').addEventListener('change', function() {
    var selectedPoli = this.value;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'jadwal.php?idpoli=' + selectedPoli, true);
    xhr.setRequestHeader('Content-Type', 'text/html');

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('jadwal').innerHTML = xhr.responseText;
        }
    };

    xhr.send();
});

</script>

</body>
</html>

</body>
</html>
