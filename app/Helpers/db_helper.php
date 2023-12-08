<?php
    function get_identitas($field)
    {
        $db = \Config\Database::connect();

        $query = $db->table('tb_identitas');
        $query->select('*');
        $query->where('id', '1');
        $result = $query->get()->getRow();
        
        return $result->$field;
    }

    function get_user($id)
    {
        $db = \Config\Database::connect();

        $query = $db->table('tb_users');
        $query->select('*');
        $query->where('id', text_dekripsi($id));
        $result = $query->get()->getRow();

        return $result;
    }
?>