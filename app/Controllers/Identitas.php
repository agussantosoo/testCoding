<?php

namespace App\Controllers;

use App\Models\IdentitasModel;
use App\Models\LogsModel;
use Config\Services;

class Identitas extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mIdentitas = new IdentitasModel($this->request);
        $this->mLogs = new LogsModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Identitas';
        $data['content'] = view('admin/identitas/index', path_info());
        $data = array_merge($data, path_info());
        return render_admin($data);
    }

    public function update()
    {
        if ($this->request->getMethod(true) === 'POST') {
            $nm_app = $this->request->getPost('nm_app');
            $potong_alfa = $this->request->getPost('potong_alfa');
            $potong_telat = $this->request->getPost('potong_telat');
            
            $where = ['id' => '1'];

            $data = [
                'nm_app' => $nm_app,
                'potong_alfa' => $potong_alfa,
                'potong_telat' => $potong_telat,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->mIdentitas->updatedata($data,$where);
            if ($result)
            {
                $data = [
                    'aksi' => 'Update identitas',
                    'keterangan' => 'Mengubah data identitas',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->mLogs->adddata($data);

                session()->setFlashdata(['code' => '200', 'msg' => 'Data berhasil diubah']);
            }
            else
            {
                session()->setFlashdata(['code' => '400', 'msg' => 'Data gagal diubah']);
            }   

            go_to_url('identitas');
        }
    }
}
