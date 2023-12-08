<?php

namespace App\Controllers;

use App\Models\HariModel;
use App\Models\JamKerjaModel;
use App\Models\LogsModel;
use Config\Services;

class JamKerja extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mHari = new HariModel($this->request);
        $this->mJamKerja = new JamKerjaModel($this->request);
        $this->mLogs = new LogsModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Data Jam Kerja';
        $data['content'] = view('admin/jamkerja/index');
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function tambah()
    {   
        $data['title'] = 'Tambah Jam Kerja';
        $dt_hari = $this->mHari->getalldata();
        
        $dt_content = [
            'dt_hari' => json_encode($dt_hari), 
        ];

        $content = array_merge($dt_content, path_info());
        $data['content'] = view('admin/jamkerja/add',$content);
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function edit($id)
    {   
        $data['title'] = 'Edit Jam Kerja';
        $idNew = text_dekripsi($id);
        $dt_hari = $this->mHari->getalldata();
        $dt_jamkerja = $this->mJamKerja->getdata(['tb_jamkerja.id' => $idNew]);
        $data['content'] = view('admin/jamkerja/edit', ['id' => $id, 'id_hari' => $dt_jamkerja->id_hari, 'jam_masuk' => $dt_jamkerja->jam_masuk, 'jam_keluar' => $dt_jamkerja->jam_keluar, 'dt_hari' => json_encode($dt_hari)]);
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function datatables()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->mJamKerja->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $idEnk = text_enkripsi($list->id);
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_hari;
                $row[] = date('H:i', strtotime($list->jam_masuk));
                $row[] = date('H:i', strtotime($list->jam_keluar));
                $row[] = '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="" data-original-title="Edit" href="'.base_url('jamkerja/edit/').$idEnk.'"><span class="fa fa-edit"></span></a> <button class="btn btn-danger btn-xs btn-hapus" data-id="'.$idEnk.'" data-toggle="tooltip" title="" data-original-title="Hapus"><span class="fa fa-trash"></span></button>';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->mJamKerja->countAll(),
                'recordsFiltered' => $this->mJamKerja->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function create()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $hari = $this->request->getPost('hari');
            $jam_masuk = $this->request->getPost('jam_masuk');
            $jam_keluar = $this->request->getPost('jam_keluar');
            
            $check = $this->mJamKerja->countdata(['id_hari' => $hari]);
            if ($check == 0){
                $data = [
                    'id_hari' => $hari,
                    'jam_masuk' => $jam_masuk,
                    'jam_keluar' => $jam_keluar,
                    'created_at' => date('Y-m-d H:i:s')
                ];
    
                $result = $this->mJamKerja->adddata($data);
    
                if ($result)
                {
                    $data = [
                        'aksi' => 'Tambah jam kerja',
                        'keterangan' => 'Menambah data jam kerja '.$hari,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->mLogs->adddata($data);
    
                    session()->setFlashdata(['code' => '200', 'msg' => 'Data berhasil disimpan']);
                }
                else
                {
                    session()->setFlashdata(['code' => '400', 'msg' => 'Data gagal disimpan']);
                }   
            }else{
                session()->setFlashdata(['code' => '400', 'msg' => 'Hari jam kerja tersebut telah ada']);
            }

            go_to_url('jamkerja');
        }
    }

    public function update()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $id = text_dekripsi($this->request->getPost('id'));
            $jam_masuk = $this->request->getPost('jam_masuk');
            $jam_keluar = $this->request->getPost('jam_keluar');
            
            $data = [
                'jam_masuk' => $jam_masuk,
                'jam_keluar' => $jam_keluar,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->mJamKerja->updatedata($data, ['id' => $id]);

            if ($result)
            {
                $data = [
                    'aksi' => 'Update jam kerja',
                    'keterangan' => 'Mengubah data jam kerja '.$id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->mLogs->adddata($data);

                session()->setFlashdata(['code' => '200', 'msg' => 'Data berhasil diubah']);
            }
            else
            {
                session()->setFlashdata(['code' => '400', 'msg' => 'Data gagal diubah']);
            }    

            go_to_url('jamkerja');   
        }
    }

    public function delete()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $id = text_dekripsi($this->request->getPost('id'));
            
            $result = $this->mJamKerja->deletedata(['id' => $id]);
            if ($result)
            {
                $data = [
                    'aksi' => 'Hapus jam kerja',
                    'keterangan' => 'Menghapus data jam kerja '.$id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->mLogs->adddata($data);

                $code = '200';
                $msg = 'Data berhasil dihapus';
            }
            else
            {
                $code = '400';
                $msg = 'Data gagal dihapus';
            }

            $notif = array('code' => $code, 'msg' => $msg);
        
            echo json_encode($notif);    
        }
    }

}
