<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $column_order = ['buku.id', 'buku.isbn', 'buku.id_kategori', 'buku.id_rak', 'kategori.nama as namakategori', 'rak.nama as namarak', 'buku.judul', 'buku.penerbit', 'buku.tahun', 'buku.penulis', 'buku.no_klasifikasi', 'buku.jumlah'];
    protected $column_search = ['buku.isbn', 'kategori.nama', 'rak.nama', 'buku.judul', 'buku.penerbit', 'buku.tahun', 'buku.penulis', 'buku.no_klasifikasi', 'buku.jumlah'];
    protected $order = ['buku.id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt_table = $this->db->table($this->table);
        $this->dt = $this->db->table($this->table)->join('kategori','kategori.id='.$this->table.'.id_kategori')->join('rak','rak.id='.$this->table.'.id_rak')->select($this->column_order);

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

    public function getlastid()
    {
        $execute = $this->dt_table->orderBy('buku.id','DESC')->limit(1)->get()->getRow();
        return $execute->id;
    }
    
    public function countdata($where)
    {
        $execute = $this->dt->where($where)->countAllResults();
        return $execute;
    }
}