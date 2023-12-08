<?php
    function go_to_url($controller)
    {
        echo "<script>document.location='".base_url($controller)."';</script>";
    }
    
    function path_info()
    {
        $data = array(
            'base_url' => base_url('public/adminlte/'),
            'site_url' => base_url(),
            'img_path' => base_url('public/img/'),
            'foto_user_default' => 'default.png',
            'login' => (session()->get('logged_in') == true) ? true : false,
        );
    
        return $data;
    }

    function render_login($data)
    {
        $template = 'login/index';
        return view($template, $data);
    }

    function render_admin($data)
    {
        $template = 'admin/layout/index';
        return view($template, $data);
    }

    function render_form($data)
    {
        $template = 'form/index';
        return view($template, $data);
    }


    function text_enkripsi($text)
    {
        $enkripsi = service('encrypter');
        $encoded = base64_encode($enkripsi->encrypt($text));
        $encoded = strtr($encoded, array('+' => '.', '=' => '-', '/' => '~'));
        return $encoded;
    }

    function text_dekripsi($text)
    {
        $enkripsi = service('encrypter');
        $text = strtr($text, array('.' => '+', '-' => '=', '~' => '/'));
        $decoded = $enkripsi->decrypt(base64_decode($text));
        return $decoded;
    }

    function rupiah($rp){
        if($rp!=0){
            $hasil = number_format($rp, 0, ',', '.');
        }else{
            $hasil=0;
        }
        return $hasil;
    }

    function get_uri()
    {
        $request = service('request');
        $uri = $request->uri; 
        return $uri->getSegment(1);
    }

    function day_now($tanggal)
    {
		$day = date('D', strtotime($tanggal));
		$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		);
		return $dayList[$day];
	}

    function get_bulan_indo($bln)
    {
        switch ($bln){
            case 1: 
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    
    // function waktu_indo($tgl)
    // {
    //     $tanggal = date('d', strtotime($tgl));
    //     $bulan = get_bulan_indo(date('m', strtotime($tgl)));
    //     $tahun = date('Y', strtotime($tgl));
    //     return $tanggal.' '.$bulan.' '.$tahun.' '.date('H:i', strtotime($tgl));		 
    // }
    
    // function tgl_indo($tgl)
    // {
    //     $tanggal = date('d', strtotime($tgl));
    //     $bulan = get_bulan_indo(date('m', strtotime($tgl)));
    //     $tahun = date('Y', strtotime($tgl));
    //     return $tanggal.' '.$bulan.' '.$tahun;		 
    // }

?>