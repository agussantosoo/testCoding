    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Gaji Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('gaji') ?>">Gaji Pegawai</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <form id="frm-add" method="post" action="<?= base_url('gaji/update') ?>">
                    <input type="hidden" name="id" readonly value="<?= $id ?>">
                    <div class="form-group">
                      <label>Pegawai <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                      <select class="form-control" name="pegawai" required disabled>
                        <option value="" disabled selected>- Pilih Pegawai -</option>
                        <?php
                          foreach (json_decode($dt_pegawai) as $pgw) {
                            $selected = $id_pegawai == $pgw->id ? 'selected' : '';
                            echo '<option value="'.$pgw->id.'" '.$selected.'>'.$pgw->nip.' - '.$pgw->nama.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Gaji Per Bulan <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <input type="number" name="nominal" class="form-control" placeholder="Nominal" required min="0" value="<?= $nominal ?>">
                    </div>
                    <div class="form-group">
                        <button name="update" type="submit" value="Simpan" class="btn btn-success">Simpan</button>
                        <a href="<?= base_url('gaji') ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->