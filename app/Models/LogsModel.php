<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $table = 'logs';
    protected $column_order = ['id', 'aksi', 'keterangan', 'created_at'];
    protected $column_search = ['aksi', 'keterangan', 'created_at'];
    protected $order = ['id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt_table = $this->db->table($this->table);
        $this->dt = $this->db->table($this->table);
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