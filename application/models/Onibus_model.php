<?php

class Onibus_model extends CI_Model{

    public function registerBus($data = array())
    {
        $this->db->insert('onibus',$data);
        return $this->db->affected_rows();
    }

    public function getBus($id)
    {
        if ($id > 0){
            $this->db->where('id',$id);
            $query = $this->db->get('onibus');
            return $query->row();
        }
    }

    public function updateBus($id,$data = array())
    {
        if ($id > 0){
            $this->db->where('id',$id);
            $this->db->update('onibus',$data);
            return $this->db->affected_rows();
        }
    }

    public function getBusLoc($id)
    {
        if ($id > 0){
            $this->db->where('id_onibus',$id);
            $query = $this->db->get('localizacao_onibus');
            return $query->row();
        }
    }

    public function insertLocalizacao($data = array())
    {
        $this->db->insert('localizacao_onibus',$data);
        return $this->db->affected_rows();
    }

    public function updateLocalizacao($id,$data = array())
    {
        $this->db->where('id_onibus',$id);
        $this->db->update('localizacao_onibus',$data);
        return $this->db->affected_rows();
    }

    public function getBusEmpresa($id)
    {
        $this->db->where('id_empresa', $id);
        $query = $this->db->get('onibus');
        return $query->result();
    }
}