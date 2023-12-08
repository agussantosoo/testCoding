<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\LogsModel;
use Config\Services;

class Login extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->mUsers = new UsersModel($this->request);
        $this->mLogs = new LogsModel($this->request);
    }

    public function index()
    {
        $data['title'] = 'Login';
        $data = array_merge($data, path_info());
        return render_login($data);
    }

    public function check()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember_me = $this->request->getPost('remember');

        $data_user = $this->mUsers->getUserBy(['username' => $username]);
        if ($data_user) {
            if (password_verify($password, $data_user->password)) {
                session()->set([
                    'id_user' => text_enkripsi($data_user->id),
                    'logged_in' => true
                ]);

                $data = [
                    'aksi' => 'Login',
                    'keterangan' => 'Berhasil login ke aplikasi '.$data_user->id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->mLogs->adddata($data);

                go_to_url('dashboard');
            } else {
                session()->setFlashdata('error', 'Username & Password Salah');
                go_to_url('login');
            }
        } else {
            session()->setFlashdata('error', 'Username & Password Salah');
            go_to_url('login');
        }
    }

    function logout()
    {
        $data = [
            'aksi' => 'Logout',
            'keterangan' => 'Berhasil keluar aplikasi '.text_dekripsi(session()->get('id_user')),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->mLogs->adddata($data);

        session()->destroy();
        go_to_url('login');
    }

}
