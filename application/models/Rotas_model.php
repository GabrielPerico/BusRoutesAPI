<?php

class Rotas_model extends CI_Model
{
    public function insertRota($data = array())
    {
        $this->db->insert('rotas', $data);
        return $this->db->insert_id();
    }

    public function insertParadas($data = array())
    {
        $this->db->insert('paradas', $data);
    }
}
