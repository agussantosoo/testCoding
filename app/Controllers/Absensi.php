<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\HariModel;
use App\Models\AbsensiModel;
use App\Models\JamKerjaModel;
use App\Models\LogsModel;
use Config\Services;

class Absensi extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mPegawai = new PegawaiModel($this->request);
        $this->mHari = new HariModel($this->request);
        $this->mAbsensi = new AbsensiModel($this->request);
        $this->mJamKerja = new JamKerjaModel($this->request);
        $this->mLogs = new LogsModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Absensi Pegawai';
        $data['content'] = view('form/absensi/index');
        $data = array_merge($data, path_info());
        return render_form($data);
    }

    public function create()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $nip = $this->request->getPost('nip');
            $jenis_absensi = $this->request->getPost('absensi');
            $waktu_absensi =  date('Y-m-d H:i:s');

            $hari_ini = day_now(date('Y-m-d'));
            $dt_hari = $this->mHari->getdata(['nama' => $hari_ini]);
            $id_hari = $dt_hari->id;

            
            $dt_jamkerja = $this->mJamKerja->getdata(['id_hari' => $id_hari]);
            
            if (empty($dt_jamkerja)){
                session()->setFlashdata(['code' => '400', 'msg' => 'Tidak ada jadwal absensi hari ini']);
            }else{
                $check = $this->mPegawai->countdata(['nip' => $nip]);
                if ($check == 0){
                    session()->setFlashdata(['code' => '400', 'msg' => 'Nip atau id pegawai salah']);
                }else{
                    $dt_pegawai = $this->mPegawai->getdata(['nip' => $nip]);
                    $id_pegawai = $dt_pegawai->id;
    
                    $dt_absensi = $this->mAbsensi->getdata(['id_pegawai' => $id_pegawai, 'id_hari' => $id_hari]);
                    if ($jenis_absensi == 'masuk'){
                        if (!empty($dt_absensi->waktu_masuk)){
                            session()->setFlashdata(['code' => '400', 'msg' => 'Anda telah melakukan absensi masuk hari ini']);
                        }else{
                            $data = [
                                'id_pegawai' => $id_pegawai,
                                'id_hari' => $id_hari,
                                'waktu_masuk' => $waktu_absensi
                            ];
                
                            $result = $this->mAbsensi->adddata($data);
                            if ($result)
                            {
                                $data = [
                                    'aksi' => 'Tambah absensi pegawai masuk',
                                    'keterangan' => 'Menambah absensi pegawai masuk '.$nip,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];
                                $this->mLogs->adddata($data);
                            }
    
                            $jam_masuk = $dt_jamkerja->jam_masuk;
                            if (strtotime($waktu_absensi) > strtotime($jam_masuk)){
                                session()->setFlashdata(['code' => '200', 'msg' => 'Anda telat dalam melakukan absensi']);
                            }else{
                                session()->setFlashdata(['code' => '200', 'msg' => 'Absensi masuk berhasil disimpan']);
                            }
                        }
                    }elseif ($jenis_absensi == 'keluar'){
                        if (!empty($dt_absensi->waktu_keluar)){
                            session()->setFlashdata(['code' => '400', 'msg' => 'Anda telah melakukan absensi keluar hari ini']);
                        }else{
                            if (empty($dt_absensi)){
                                session()->setFlashdata(['code' => '400', 'msg' => 'Anda belum melakukan absensi masuk hari ini']);
                            }else{
                                $id_absensi = $dt_absensi->id;
    
                                $data = [
                                    'waktu_keluar' => $waktu_absensi,
                                ];
                    
                                $result = $this->mAbsensi->updatedata($data, ['id' => $id_absensi]);
                                
                                if ($result)
                                {
                                    $data = [
                                        'aksi' => 'Tambah absensi pegawai keluar',
                                        'keterangan' => 'Menambah absensi pegawai keluar '.$nip,
                                        'created_at' => date('Y-m-d H:i:s')
                                    ];
                                    $this->mLogs->adddata($data);
                                }
                                session()->setFlashdata(['code' => '200', 'msg' => 'Absensi keluar berhasil disimpan']);
                            }
                        }
                    }
                }
            }

            go_to_url('absensi');
        }
    }
}
