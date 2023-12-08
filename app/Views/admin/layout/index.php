<?php
  if ($login == false){
    go_to_url('login');
  }

  $dt_user = session()->get('id_user') <> '' ? get_user(session()->get('id_user')) : '';
  $nama_user = !empty($dt_user->username) ? $dt_user->username : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?> | <?= get_identitas('nm_app') ?></title>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> 
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/daterangepicker/daterangepicker.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">


  <!-- jQuery -->
  <script src="<?= $base_url ?>plugins/jquery/jquery.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= $base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= $base_url ?>plugins/jszip/jszip.min.js"></script>
  <script src="<?= $base_url ?>plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= $base_url ?>plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- date-range-picker -->
  <script src="<?= $base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="<?= $base_url ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <p class="animation__shake" style="font-size:20px"><?= get_identitas('nm_app') ?></p>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link text-center">
      <span class="brand-text font-weight-light"><?= get_identitas('nm_app') ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= $img_path.$foto_user_default; ?>" class="img-circle elevation-2">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $nama_user; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= get_uri() == 'dashboard' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item <?= get_uri() == 'pegawai' || get_uri() == 'gaji' ||  get_uri() == 'jamkerja' ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('pegawai') ?>" class="nav-link <?= get_uri() == 'pegawai' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Pegawai
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('gaji') ?>" class="nav-link <?= get_uri() == 'gaji' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Gaji Pegawai
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('jamkerja') ?>" class="nav-link <?= get_uri() == 'jamkerja' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Hari Dan Jam Kerja
                  </p>
                </a>
              </li>
            </ul>
          <li>

          <li class="nav-item">
            <a href="<?= base_url('lapabsensi') ?>" class="nav-link <?= get_uri() == 'lapabsensi' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Laporan
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('identitas') ?>" class="nav-link <?= get_uri() == 'identitas' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?= base_url('login/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-arrow-left"></i>
              <p>
                Logout
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?= $content ?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <?= get_identitas('nm_app') ?>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="<?= $base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= $base_url ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= $base_url ?>plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= $base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= $base_url ?>plugins/moment/moment.min.js"></script>
<script src="<?= $base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= $base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= $base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= $base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $base_url ?>dist/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="<?= $base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>


<script>
  $('body').tooltip({ selector: '[data-toggle="tooltip"]'});

  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  //Date and time
  $("#inputtimemasuk").datetimepicker({ format: 'HH:mm' });
  $("#inputtimekeluar").datetimepicker({ format: 'HH:mm' });

  // $('#inputdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
  
  // $(".input-date").datetimepicker({ format: 'DD/MM/YYYY' });
</script>

<?php 
  if (!empty(session()->getFlashdata('code'))){
    if (session()->getFlashdata('code') == '200'){
      $code = 'success';
      $text = 'Sukses';
    }else{
      $code = 'error';
      $text = 'Gagal';
    }
    echo "<script>
            Toast.fire({
              icon: '".$code."',
              title: '<center>".$text."! <br>".session()->getFlashdata('msg')."</center>'
            })
          </script>";
  }
?>

</body>
</html>

