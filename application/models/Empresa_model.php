<?php

class Empresa_model extends CI_Model{

    public function getEmpresa($email,$senha){

        $this->db->where('email',$email);
        $this->db->where('senha',$senha);
        $query = $this->db->get('empresa');
        return $query->row();

    }

    public function registerEmpresa($data = array())
    {
        $this->db->insert('empresa',$data);
        return $this->db->affected_rows();
    }
}