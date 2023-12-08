  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= $tot_pegawai ?></h3>
                <p>Data Pegawai</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="<?= base_url('pegawai') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?= $tot_gaji ?></h3>
                <p>Data Gaji</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-wave-alt"></i>
              </div>
              <a href="<?= base_url('gaji') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $tot_jamkerja ?></h3>
                <p>Data Jam Kerja</p>
              </div>
              <div class="icon">
                <i class="fa fa-clock"></i>
              </div>
              <a href="<?= base_url('jamkerja') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $tot_absensi ?></h3>
                <p>Absensi</p>
              </div>
              <div class="icon">
                <i class="fa fa-check"></i>
              </div>
              <a href="<?= base_url('absensi') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
        </div>

      </div>
    </section>