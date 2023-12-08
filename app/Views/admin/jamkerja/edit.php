    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Jam Kerja</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('jamkerja') ?>">Jam Kerja</a></li>
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
                <form id="frm-add" method="post" action="<?= base_url('jamkerja/update') ?>">
                    <input type="hidden" name="id" readonly value="<?= $id ?>">
                    <div class="form-group">
                      <label>Hari <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                      <select class="form-control" name="hari" required disabled>
                        <option value="" disabled selected>- Pilih Hari -</option>
                        <?php
                          foreach (json_decode($dt_hari) as $hr) {
                            $selected = $id_hari == $hr->id ? 'selected' : '';
                            echo '<option value="'.$hr->id.'" '.$selected.'>'.$hr->nama.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                        <label>Jam Masuk <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <div class="input-group date" id="inputtimemasuk" data-target-input="nearest">
                          <input type="text" name="jam_masuk" required class="form-control datetimepicker-input" data-target="#inputtimemasuk" data-toggle="datetimepicker" value="<?= $jam_masuk ?>"/>
                          <div class="input-group-append" data-target="#inputtimemasuk" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jam Keluar <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <div class="input-group date" id="inputtimekeluar" data-target-input="nearest">
                          <input type="text" name="jam_keluar" required class="form-control datetimepicker-input" data-target="#inputtimekeluar" data-toggle="datetimepicker" value="<?= $jam_keluar ?>"/>
                          <div class="input-group-append" data-target="#inputtimekeluar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button name="update" type="submit" value="Simpan" class="btn btn-success">Simpan</button>
                        <a href="<?= base_url('jamkerja') ?>" class="btn btn-danger">Batal</a>
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