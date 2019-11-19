<?php

class Noticias_model extends CI_Model{

    public function insertNoticia($data = array())
    {
        $this->db->insert('noticias', $data);
        return $this->db->affected_rows();
    }

    public function getUser($id)
    {
        $this->db->where('id', $id);
        $this->db->where('admin', 1);
        $query = $this->db->get('usuario');
        return $query->row(); 
    }
    
    public function getAllNoticias()
    {   
        
        $this->db->select('noticias.*,usuario.nome');
        $this->db->join('usuario', 'usuario.id = id_usuario', 'inner');
        $query = $this->db->get('noticias');
        return $query->result();
    }

    public function updateNoticia($id,$data = array())
    {
        $this->db->where('id', $id);
        $this->db->update('noticias',$data);
        return $this->db->affected_rows();
    }
}