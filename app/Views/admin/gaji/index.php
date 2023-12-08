    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Gaji Pegawai</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Data Gaji Pegawai</li>
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
              <div class="card-header">
                <a href="<?= base_url('gaji/tambah') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="table-data" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Pegawai</th>
                        <th>Gaji Per Bulan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
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
  
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#table-data').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= base_url('gaji/datatables') ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [0,3],
                    "orderable": false,
                }, ],
            });
            
            $(document).on("click",".btn-hapus",function(){
              var id = $(this).data('id');
              Swal.fire({
                title: 'Anda yakin?',
                text: "Data akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak'
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                      url: "<?= base_url('gaji/delete') ?>",
                      method: "POST",
                      data: {id : id},
                      success: function(msg){
                        const obj = JSON.parse(msg);
                        if (obj.code == '200'){
                          Toast.fire({
                            icon: 'success',
                            title: '<center>Sukses! <br>'+obj.msg+'</center>'
                          }) 
                        }else{
                          Toast.fire({
                            icon: 'error',
                            title: '<center>Gagal! <br>'+obj.msg+'</center>'
                          }) 
                        }
                        table.ajax.reload();
                      },
                  });
                }
              })
            });
        });
    </script>