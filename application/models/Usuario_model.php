<?php

class Usuario_model extends CI_Model{

    public function getUsuario($email,$senha){

        $this->db->where('email',$email);
        $this->db->where('senha',$senha);
        $query = $this->db->get('usuario');
        return $query->row();

    }

    public function registerUsuario($data = array())
    {
        $this->db->insert('usuario',$data);
        $lastid = $this->db->insert_id();
        $this->db->where('id', $lastid);
        $query = $this->db->get('usuario');
        return $query->row();
    }

    public function checkEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuario');
        return $query->row();
    }
}