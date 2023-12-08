<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\GajiModel;
use App\Models\JamKerjaModel;
use App\Models\AbsensiModel;
use Config\Services;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mPegawai = new PegawaiModel($this->request);
        $this->mGaji = new GajiModel($this->request);
        $this->mJamKerja = new JamKerjaModel($this->request);
        $this->mAbsensi = new AbsensiModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $content = [
            'tot_pegawai' => $this->mPegawai->countAll(),
            'tot_gaji' => $this->mGaji->countAll(),
            'tot_jamkerja' => $this->mJamKerja->countAll(),
            'tot_absensi' => $this->mAbsensi->countAll(),
        ];
        $data['content'] = view('admin/dashboard/index', $content);
        $data = array_merge($data, path_info());
        return render_admin($data);
    }
}
