    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan Absensi & Gaji Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Laporan Absensi & Gaji</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <form id="frm-lap">
                  <div class="row mb-2">
                    <div class="col-md-3">
                        <label>Bulan</label>
                        <select class="form-control" name="bulan" id="input-bulan">
                          <?php
                            for($a=1;$a<=12;$a++){
                              $selected = $a == date('m') ? 'selected' : '';
                              echo '<option value="'.$a.'" '.$selected.'>'.get_bulan_indo($a).'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Tahun</label>
                        <select class="form-control" name="tahun" id="input-tahun">
                          <?php
                            for ($a = 10; $a >= 0; $a--) {
                              $tahun = date('Y') - $a;
                              $selected = $tahun == date('Y') ? 'selected' : '';
                              echo '<option value="'.$tahun.'" '.$selected.'>'.$tahun.'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-success" style="margin-top:32px" id="btn-cari"><i class="fa fa-search"></i> Cari</button>
                        <button type="button" class="btn btn-dark" style="margin-top:32px" id="btn-refresh"><i class="ion ion-refresh"></i> Refresh</button>
                        <button type="button" class="btn btn-info" style="margin-top:32px" id="btn-print"><i class="fa fa-print"></i> Cetak Absensi</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
      
          <div class="col-12" id="detail-lap">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-6 text-left"><h3 class="card-title">Data Laporan Peminjaman</h3></div>
                    <div class="col-6 text-right"></div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="content-table">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script type="text/javascript">
        $('#detail-lap').hide();

        $('#btn-cari').on('click', function(){
            var bulan = $('#input-bulan').val();
            var tahun = $('#input-tahun').val();
            loadtabel(bulan, tahun);
            $('#detail-lap').show();
        })

        $('#btn-refresh').on('click', function(){
            $('#input-bulan').val('<?= date('m') ?>');
            $('#input-tahun').val('<?= date('Y') ?>');
            $('#detail-lap').hide();
        })

        $('#btn-print').on('click', function(){
            var bulan = $('#input-bulan').val();
            var tahun = $('#input-tahun').val();
            window.open("<?= base_url('lapabsensi/cetak/') ?>"+bulan+'/'+tahun, "_blank");
        })

        function loadtabel(bulan, tahun){
          $.ajax({
              url: "<?= base_url('lapabsensi/datatables') ?>",
              method: "POST",
              data: {bulan : bulan, tahun : tahun},
              success: function(msg){
                $('#content-table').html(msg);
              },
          });
        }
    </script>