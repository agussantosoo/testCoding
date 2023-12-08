    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('pegawai') ?>">Pegawai</a></li>
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
                <form id="frm-add" method="post" action="<?= base_url('pegawai/update') ?>">
                    <input type="hidden" name="id" readonly value="<?= $id ?>">
                    <div class="form-group">
                        <label>Nip / Id Pegawai <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <input type="text" name="nip" class="form-control" placeholder="Nip" required value="<?= $nip ?>">
                    </div>
                    <div class="form-group">
                        <label>Nama <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama" required value="<?= $nama ?>">
                    </div>
                    <div class="form-group">
                        <button name="update" type="submit" value="Simpan" class="btn btn-success">Simpan</button>
                        <a href="<?= base_url('pegawai') ?>" class="btn btn-danger">Batal</a>
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