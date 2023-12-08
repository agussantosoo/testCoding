<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class HariModel extends Model
{
    protected $table = 'tb_hari';
    protected $column_order = ['id', 'nama'];
    protected $column_search = ['nama'];
    protected $order = ['id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);

    }

    public function getalldata()
    {
        $execute = $this->dt->get()->getResult();
        return $execute;
    }

    public function getdata($where)
    {
        $execute = $this->dt->where($where)->get()->getRow();
        return $execute;
    }
}