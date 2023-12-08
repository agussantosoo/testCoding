<?php

namespace App\Controllers;


class Error extends BaseController
{
    public function e404()
    {
        $data['title'] = '404';
        $data = array_merge($data, path_info());
        return view('error/404', $data);
    }
}
