<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\GajiModel;
use App\Models\LogsModel;
use Config\Services;

class Gaji extends BaseController
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
        $data['title'] = 'Data Gaji Pegawai';
        $data['content'] = view('admin/gaji/index');
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function tambah()
    {   
        $data['title'] = 'Tambah Gaji Pegawai';
        $dt_pegawai = $this->mPegawai->getalldata();
        
        $dt_content = [
            'dt_pegawai' => json_encode($dt_pegawai), 
        ];

        $content = array_merge($dt_content, path_info());
        $data['content'] = view('admin/gaji/add',$content);
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function edit($id)
    {   
        $data['title'] = 'Edit Gaji Pegawai';
        $idNew = text_dekripsi($id);
        $dt_pegawai = $this->mPegawai->getalldata();
        $dt_gaji = $this->mGaji->getdata(['tb_gaji.id' => $idNew]);
        $data['content'] = view('admin/gaji/edit', ['id' => $id, 'id_pegawai' => $dt_gaji->id_pegawai, 'nominal' => $dt_gaji->nominal, 'dt_pegawai' => json_encode($dt_pegawai)]);
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function datatables()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->mGaji->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $idEnk = text_enkripsi($list->id);
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nip_pegawai.' - '.$list->nama_pegawai;
                $row[] = rupiah($list->nominal);
                $row[] = '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="" data-original-title="Edit" href="'.base_url('gaji/edit/').$idEnk.'"><span class="fa fa-edit"></span></a> <button class="btn btn-danger btn-xs btn-hapus" data-id="'.$idEnk.'" data-toggle="tooltip" title="" data-original-title="Hapus"><span class="fa fa-trash"></span></button>';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->mGaji->countAll(),
                'recordsFiltered' => $this->mGaji->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function create()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $pegawai = $this->request->getPost('pegawai');
            $nominal = $this->request->getPost('nominal');
            
            $check = $this->mGaji->countdata(['id_pegawai' => $pegawai]);
            if ($check == 0){
                $data = [
                    'id_pegawai' => $pegawai,
                    'nominal' => $nominal,
                    'created_at' => date('Y-m-d H:i:s')
                ];
    
                $result = $this->mGaji->adddata($data);
    
                if ($result)
                {
                    $data = [
                        'aksi' => 'Tambah gaji pegawai',
                        'keterangan' => 'Menambah data gaji pegawai '.$pegawai,
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
                session()->setFlashdata(['code' => '400', 'msg' => 'Data Gaji pegawai tersebut telah ada']);
            }

            go_to_url('gaji');
        }
    }

    public function update()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $id = text_dekripsi($this->request->getPost('id'));
            $nominal = $this->request->getPost('nominal');
            
            $data = [
                'nominal' => $nominal,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->mGaji->updatedata($data, ['id' => $id]);

            if ($result)
            {
                $data = [
                    'aksi' => 'Update gaji pegawai',
                    'keterangan' => 'Mengubah data gaji pegawai '.$id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->mLogs->adddata($data);

                session()->setFlashdata(['code' => '200', 'msg' => 'Data berhasil diubah']);
            }
            else
            {
                session()->setFlashdata(['code' => '400', 'msg' => 'Data gagal diubah']);
            }    

            go_to_url('gaji');   
        }
    }

    public function delete()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $id = text_dekripsi($this->request->getPost('id'));
            
            $result = $this->mGaji->deletedata(['id' => $id]);
            if ($result)
            {
                $data = [
                    'aksi' => 'Hapus gaji pegawai',
                    'keterangan' => 'Menghapus data gaji pegawai '.$id,
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
