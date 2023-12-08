<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title ?> | <?= get_identitas('singkatan_app') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= $img_path.get_identitas('logo') ?>">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">

    <style>
        * {
            -webkit-box-sizing: border-box;
                box-sizing: border-box;
        }

        body {
            padding: 0;
            margin: 0;
        }

        #notfound {
            position: relative;
            height: 100vh;
        }

        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);
        }

        .notfound {
            max-width: 520px;
            width: 100%;
            line-height: 1.4;
            text-align: center;
        }

        .notfound .notfound-404 {
            position: relative;
            height: 240px;
        }

        .notfound .notfound-404 h1 {
            font-family: 'Montserrat', sans-serif;
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);
            font-size: 252px;
            font-weight: 900;
            margin: 0px;
            color: #262626;
            text-transform: uppercase;
            letter-spacing: -40px;
            margin-left: -20px;
        }

        .notfound .notfound-404 h1>span {
            text-shadow: -8px 0px 0px #fff;
        }

        .notfound .notfound-404 h3 {
            font-family: 'Cabin', sans-serif;
            position: relative;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            color: #262626;
            margin: 0px;
            letter-spacing: 3px;
            padding-left: 6px;
        }

        .notfound h2 {
            font-family: 'Cabin', sans-serif;
            font-size: 20px;
            font-weight: 400;
            text-transform: uppercase;
            color: #000;
            margin-top: 0px;
            margin-bottom: 25px;
        }

        @media only screen and (max-width: 767px) {
            .notfound .notfound-404 {
                height: 200px;
            }
            .notfound .notfound-404 h1 {
                font-size: 200px;
            }
        }

        @media only screen and (max-width: 480px) {
            .notfound .notfound-404 {
                height: 162px;
            }
            .notfound .notfound-404 h1 {
                font-size: 162px;
                height: 150px;
                line-height: 162px;
            }
            .notfound h2 {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h3>Oops! Halaman tidak ditemukan</h3>
				<h1><span>4</span><span>0</span><span>4</span></h1>
			</div>
			<h2>Kami minta maaf, halaman yang Anda minta tidak ditemukan</h2>
            <a href="javascript:history.go(-1)" class="btn btn-primary btn-sm">Kembali</a>
		</div>
	</div>

    <!-- jQuery -->
    <script src="<?= $base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= $base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= $base_url ?>dist/js/adminlte.js"></script>
</body>

</html>
