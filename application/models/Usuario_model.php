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
        return $this->db->affected_rows();
    }

    public function checkEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('usuario');
        return $query->row();
    }
}