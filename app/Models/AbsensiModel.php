<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'tb_absensi';
    protected $column_order = ['tb_absensi.id', 'tb_absensi.waktu_masuk', 'tb_absensi.waktu_keluar'];
    protected $column_search = ['tb_absensi.id', 'tb_absensi.waktu_masuk', 'tb_absensi.waktu_keluar'];
    protected $order = ['tb_absensi.id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)->join('tb_hari','tb_hari.id='.$this->table.'.id_hari')->join('tb_pegawai','tb_pegawai.id='.$this->table.'.id_pegawai')->select('tb_absensi.*, tb_hari.nama as nama_hari, tb_pegawai.nip as nip_pegawai, tb_pegawai.nama as nama_pegawai');
    }
    
    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->dt;
        return $tbl_storage->countAllResults();
    }

    public function getdata($where)
    {
        $execute = $this->dt->where($where)->get()->getRow();
        return $execute;
    }

    public function getdataresult($where)
    {
        $execute = $this->dt->where($where)->get()->getResult();
        return $execute;
    }

    public function getalldata()
    {
        $execute = $this->dt->get()->getResult();
        return $execute;
    }

    public function countdata($where)
    {
        $execute = $this->dt->where($where)->countAllResults();
        return $execute;
    }

    public function adddata($data)
    {
        $execute = $this->dt->insert($data);
        return $execute;
    }

    public function updatedata($data,$where)
    {
        $execute = $this->dt->where($where)->update($data);
        return $execute;
    }

    public function deletedata($where)
    {
        $execute = $this->dt->where($where)->delete();
        return $execute;
    }
}