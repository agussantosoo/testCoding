    <form action="<?= base_url('absensi/create') ?>" method="post">
        <div class="form-group">
            <label>Nip/Id Pegawai <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
            <input type="text" class="form-control" placeholder="Masukkan nip atau id pegawai" name="nip" required autofocus>
        </div>
        <div class="form-group">
            <label>Jenis Absensi <span class="text-danger" data-toggle="tooltip" data-original-title="Wajib diisi">*</span></label>
            <select name="absensi" class="form-control">
                <option value="masuk">Absensi Masuk</option>
                <option value="keluar">Absensi Keluar</option>
            </select>
        </div>
        <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary btn-block">Proses</button>
            <a href="<?= base_url('login') ?>" type="button" class="btn btn-dark btn-block">Login</a>
        </div>
    </form>
