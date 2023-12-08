<?php
 
namespace App\Models;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
 
class IdentitasModel extends Model
{
    protected $table = 'tb_identitas';
    protected $column_order = ['id', 'nm_app', 'denda_gaji'];
    protected $column_search = ['nm_app', 'denda_gaji'];
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

    public function getdata($where)
    {
        $execute = $this->dt->where($where)->get()->getRow();
        return $execute;
    }

    public function updatedata($data,$where)
    {
        $execute = $this->dt->where($where)->update($data);
        return $execute;
    }

}

