    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Identitas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Identitas</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <form id="frm-add" method="post" action="<?= base_url('identitas/update') ?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-9">
              <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama App <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <input type="text" name="nm_app" class="form-control" placeholder="Nama App" required value="<?= get_identitas('nm_app') ?>">
                    </div>
                    <div class="form-group">
                        <label>Potongan Gaji Jika Alfa <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <input type="text" name="potong_alfa" class="form-control" placeholder="Potong Gaji Jika Alfa" required value="<?= get_identitas('potong_alfa') ?>">
                    </div>
                    <div class="form-group">
                        <label>Potongan Gaji Jika Telat <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
                        <input type="text" name="potong_telat" class="form-control" placeholder="Potong Gaji Jika Telat" required value="<?= get_identitas('potong_telat') ?>">
                    </div>
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
              <div class="card">
                <div class="card-body">
                  <button name="update" type="submit" value="Simpan" class="btn btn-success btn-block" id="btn-simpan">Simpan</button>
                </div>
              </div>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>