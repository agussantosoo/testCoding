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
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> 
  <!-- jQuery -->
  <script src="<?= $base_url ?>plugins/jquery/jquery.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?= $base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
  </script>
</head>
<body class="hold-transition login-page">
  <div class="login-box" style="opacity:0.9">

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

    <div class="card card-outline card-primary" >
      <div class="card-header text-center">
        <span class="h4 mt-2"><?= $title.'<br>'.get_identitas('nm_app') ?></span>
      </div>
      <div class="card-body">
        <?= $content ?>
      </div>
    </div>
  </div>
    
  <!-- Bootstrap 4 -->
  <script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= $base_url ?>dist/js/adminlte.min.js"></script>
  <script>
    $('body').tooltip({ selector: '[data-toggle="tooltip"]'});
  </script>
</body>
</html>
