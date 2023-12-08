<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\PegawaiModel;
use App\Models\JamKerjaModel;
use App\Models\HariModel;
use App\Models\GajiModel;
use Config\Services;

use App\Libraries\Pdfgenerator;

class LapAbsensi extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mAbsensi = new AbsensiModel($this->request);
        $this->mPegawai = new PegawaiModel($this->request);
        $this->mJamKerja = new JamKerjaModel($this->request);
        $this->mHari = new HariModel($this->request);
        $this->mGaji = new GajiModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Laporan Absensi';
        $data['content'] = view('admin/laporan/absensi/index');
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function datatables()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $bulan_ini = $this->request->getPost('bulan');
            $tahun_ini = $this->request->getPost('tahun');
            
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_ini, $tahun_ini);

            echo '  <table class="table table-bordered table-hover" width="100%" style="white-space: nowrap;">
                        <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Pegawai</th>
                            <th colspan="'.$jumlah_hari.'" class="text-center">Bulan '.get_bulan_indo($bulan_ini).'</th>
                            <th rowspan="2">Jumlah Hadir</th>
                            <th rowspan="2">Jumlah Telat</th>
                            <th rowspan="2">Total Gaji</th>
                        </tr>
                        <tr>';
                            for ($i=1; $i <= $jumlah_hari ; $i++) {
                                $tgl_ini = $i < 10 ? '0'.$i : $i;
                                $waktu = $tahun_ini.'-'.$bulan_ini.'-'.$tgl_ini;
                                $merah = (date('N', strtotime($waktu)) == 7) ? 'bg-danger' : '';
                                echo '<th class="'.$merah.'">'.$i.'</th>';
                            }
            echo '      </tr>
                        </thead>
                        <tbody>';
                            $dt_pegawai = $this->mPegawai->getalldata();
                            $no = 1;
                            foreach ($dt_pegawai as $pgw) {
                                echo '<tr>';
                                    echo '<td>'.$no++.'</td>';
                                    echo '<td>'.$pgw->nip.' - '.$pgw->nama.'</td>';
                                    $total_hadir = 0;
                                    $total_telat = 0;
                                    $total_alfa = 0;
                                    for ($i=1; $i <= $jumlah_hari ; $i++) {
                                        $tgl_ini = $i < 10 ? '0'.$i : $i;
                                        $waktu = $tahun_ini.'-'.$bulan_ini.'-'.$tgl_ini;
                                        $bg_libur = (date('N', strtotime($waktu)) == 7) ? 'bg-danger' : '';
                                        $text_telat = '';

                                        $dt_absensi = $this->mAbsensi->getdata(['DATE(tb_absensi.waktu_masuk)' => $waktu, 'tb_absensi.id_pegawai' => $pgw->id]);
                                        if (!empty($dt_absensi->waktu_masuk)){
                                            $ket_absensi = '✓';
                                            $hari_ini = day_now($waktu);
                                            $dt_hari = $this->mHari->getdata(['nama' => $hari_ini]);
                                            $dt_jamkerja = $this->mJamKerja->getdata(['id_hari' => $dt_hari->id]);
                                            $jam_masuk = $dt_jamkerja->jam_masuk;
                                            if (strtotime($dt_absensi->waktu_masuk) > strtotime($jam_masuk)){
                                                $text_telat = 'text-danger';
                                                $total_telat++;
                                            }
                                            $total_hadir++;
                                        }else{
                                            $ket_absensi = ($waktu <= date('Y-m-d')) ? 'A' : '';
                                            if ( $waktu <= date('Y-m-d')){
                                                $total_alfa++;
                                            }
                                        }

                                        if ($bg_libur <> ''){
                                            echo '<td class="'.$bg_libur.'"></td>';
                                        }else{
                                            echo '<td class="'.$text_telat.'">'.$ket_absensi.'</td>';
                                        }
                                    }
                                    echo '<th>'.$total_hadir.'</th>';
                                    echo '<th>'.$total_telat.'</th>';

                                    //hitung gaji
                                    $dt_gaji = $this->mGaji->getdata(['id_pegawai' => $pgw->id]);
                                    $total_gaji = $dt_gaji->nominal - (get_identitas('potong_alfa') * $total_alfa) - (get_identitas('potong_telat') * $total_telat);
                                    echo '<th>'.rupiah($total_gaji).'</th>';
                                echo '</tr>';
                            }

            echo '      </tbody>
                    </table>';
            

            echo '<table>
                    <tr>
                        <th colspan="3">Ketarangan</th>
                    </tr>
                    <tr>
                        <td class="bg-danger" width="20px"></td>
                        <td width="20px" class="text-center">:</td>
                        <td>Hari Minggu (Libur)</td>
                    </tr>
                    <tr>
                        <td class="text-danger">✓</td>
                        <td width="20px" class="text-center">:</td>
                        <td>Telat</td>
                    </tr>
                    <tr>
                        <td>✓</td>
                        <td width="20px" class="text-center">:</td>
                        <td>Hadir</td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td width="20px" class="text-center">:</td>
                        <td>Alfa</td>
                    </tr>
                  </table><br><br>';           
        }
    }

    public function cetak($bulan_ini=NULL, $tahun_ini=NULL)
    {
        $Pdfgenerator = new Pdfgenerator();
        $data['title_pdf'] = 'Cetak';
        $file_pdf = 'Laporan Absensi Pegawai';
        $paper = 'A4';
        $orientation = "landscape";
        
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_ini, $tahun_ini);

        $html = '   <h3 align="center" style="font-weight:bold">LAPORAN ABSENSI & GAJI PEGAWAI</h3>
                    <table width="100%" style="white-space: nowrap;" border="1">
                        <tr style="padding:10px">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Pegawai</th>
                            <th colspan="'.$jumlah_hari.'" class="text-center">Bulan '.get_bulan_indo($bulan_ini).'</th>
                            <th rowspan="2">Jumlah Hadir</th>
                            <th rowspan="2">Jumlah Telat</th>
                            <th rowspan="2">Total Gaji</th>
                        </tr>
                        <tr>';
                            for ($i=1; $i <= $jumlah_hari ; $i++) {
                                $tgl_ini = $i < 10 ? '0'.$i : $i;
                                $waktu = $tahun_ini.'-'.$bulan_ini.'-'.$tgl_ini;
                                $merah = (date('N', strtotime($waktu)) == 7) ? 'style="background-color:red"' : '';
                                $html.= '<th '.$merah.'>'.$i.'</th>';
                            }
        $html.= '       </tr>
                        <tbody>';
                            $dt_pegawai = $this->mPegawai->getalldata();
                            $no = 1;
                            foreach ($dt_pegawai as $pgw) {
                                $html.= '<tr>';
                                $html.= '<td>'.$no++.'</td>';
                                $html.= '<td>'.$pgw->nip.' - '.$pgw->nama.'</td>';
                                    $total_hadir = 0;
                                    $total_telat = 0;
                                    $total_alfa = 0;
                                    for ($i=1; $i <= $jumlah_hari ; $i++) {
                                        $tgl_ini = $i < 10 ? '0'.$i : $i;
                                        $waktu = $tahun_ini.'-'.$bulan_ini.'-'.$tgl_ini;
                                        $bg_libur = (date('N', strtotime($waktu)) == 7) ? 'style="background-color:red"' : '';
                                        $text_telat = '';

                                        $dt_absensi = $this->mAbsensi->getdata(['DATE(tb_absensi.waktu_masuk)' => $waktu, 'tb_absensi.id_pegawai' => $pgw->id]);
                                        if (!empty($dt_absensi->waktu_masuk)){
                                            $hari_ini = day_now($waktu);
                                            $dt_hari = $this->mHari->getdata(['nama' => $hari_ini]);
                                            $dt_jamkerja = $this->mJamKerja->getdata(['id_hari' => $dt_hari->id]);
                                            $jam_masuk = $dt_jamkerja->jam_masuk;
                                            if (strtotime($dt_absensi->waktu_masuk) > strtotime($jam_masuk)){
                                                $ket_absensi = '<img src="'.base_url('public/img/').'check-red.png'.'" width="12px">';
                                                $text_telat = 'style="color:red"';
                                                $total_telat++;
                                            }else{
                                                $ket_absensi = '<img src="'.base_url('public/img/').'check.png'.'" width="15px">';
                                            }
                                            $total_hadir++;
                                        }else{
                                            $ket_absensi = ($waktu <= date('Y-m-d')) ? 'A' : '';
                                            if ( $waktu <= date('Y-m-d')){
                                                $total_alfa++;
                                            }
                                        }

                                        if ($bg_libur <> ''){
                                            $html.= '<td '.$bg_libur.'></td>';
                                        }else{
                                            $html.= '<td '.$text_telat.'>'.$ket_absensi.'</td>';
                                        }
                                    }
                                    $html.= '<th>'.$total_hadir.'</th>';
                                    $html.= '<th>'.$total_telat.'</th>';

                                    //hitung gaji
                                    $dt_gaji = $this->mGaji->getdata(['id_pegawai' => $pgw->id]);
                                    $total_gaji = $dt_gaji->nominal - (get_identitas('potong_alfa') * $total_alfa) - (get_identitas('potong_telat') * $total_telat);
                                    $html.= '<th>'.rupiah($total_gaji).'</th>';
                                    $html.= '</tr>';
                            }
        $html.= '      </tbody>
                    </table>';
        

        $html.= '<br><br>
                <table>
                    <tr>
                        <th colspan="3">Ketarangan</th>
                    </tr>
                    <tr>
                        <td style="background-color:red" width="20px"></td>
                        <td width="20px" class="text-center">:</td>
                        <td>Hari Minggu (Libur)</td>
                    </tr>
                    <tr>
                        <td style="color:red"><img src="'.base_url('public/img/').'check-red.png'.'" width="12px"></td>
                        <td width="20px" class="text-center">:</td>
                        <td>Telat</td>
                    </tr>
                    <tr>
                        <td><img src="'.base_url('public/img/').'check.png'.'" width="15px"></td>
                        <td width="20px" class="text-center">:</td>
                        <td>Hadir</td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td width="20px" class="text-center">:</td>
                        <td>Alfa</td>
                    </tr>
                  </table>
                  <br><br>'; 

        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

}
