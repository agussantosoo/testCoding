<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\GajiModel;
use App\Models\LogsModel;
use Config\Services;

class Pegawai extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mPegawai = new PegawaiModel($this->request);
        $this->mGaji = new GajiModel($this->request);
        $this->mLogs = new LogsModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Data Pegawai';
        $data['content'] = view('admin/pegawai/index');
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function tambah()
    {   
        $data['title'] = 'Tambah Pegawai';
        $data['content'] = view('admin/pegawai/add');
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function edit($id)
    {   
        $data['title'] = 'Edit Pegawai';
        $idNew = text_dekripsi($id);
        $dtPegawai = $this->mPegawai->getdata(['id' => $idNew]);
        $data['content'] = view('admin/pegawai/edit', ['id' => $id, 'nip' => $dtPegawai->nip, 'nama' => $dtPegawai->nama]);
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function datatables()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->mPegawai->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $idEnk = text_enkripsi($list->id);
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nip;
                $row[] = $list->nama;
                $row[] = '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="" data-original-title="Edit" href="'.base_url('pegawai/edit/').$idEnk.'"><span class="fa fa-edit"></span></a> <button class="btn btn-danger btn-xs btn-hapus" data-id="'.$idEnk.'" data-toggle="tooltip" title="" data-original-title="Hapus"><span class="fa fa-trash"></span></button>';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->mPegawai->countAll(),
                'recordsFiltered' => $this->mPegawai->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function create()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            
            $check = $this->mPegawai->countdata(['nip' => $nip]);
            if ($check == 0){
                $data = [
                    'nip' => $nip,
                    'nama' => $nama,
                    'created_at' => date('Y-m-d H:i:s')
                ];
    
                $result = $this->mPegawai->adddata($data);
    
                if ($result)
                {
                    $data = [
                        'aksi' => 'Tambah pegawai',
                        'keterangan' => 'Menambah data pegawai '.$nama,
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
                session()->setFlashdata(['code' => '400', 'msg' => 'Nip telah terdaftar']);
            }

            go_to_url('pegawai');
        }
    }

    public function update()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $id = text_dekripsi($this->request->getPost('id'));
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            
            $data = [
                'nip' => $nip,
                'nama' => $nama,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->mPegawai->updatedata($data, ['id' => $id]);

            if ($result)
            {
                $data = [
                    'aksi' => 'Update pegawai',
                    'keterangan' => 'Mengubah data pegawai '.$nama,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->mLogs->adddata($data);

                session()->setFlashdata(['code' => '200', 'msg' => 'Data berhasil diubah']);
            }
            else
            {
                session()->setFlashdata(['code' => '400', 'msg' => 'Data gagal diubah']);
            }    

            go_to_url('pegawai');   
        }
    }

    public function delete()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $id = text_dekripsi($this->request->getPost('id'));
            
            $result = $this->mPegawai->deletedata(['id' => $id]);
            if ($result)
            {
                $data = [
                    'aksi' => 'Hapus pegawai',
                    'keterangan' => 'Menghapus data pegawai '.$id,
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
