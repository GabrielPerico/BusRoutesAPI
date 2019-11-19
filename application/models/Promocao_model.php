<?php

class Promocao_model extends CI_Model{
    public function insertPromocao($id,$data){
        if ($id > 0){
            $this->db->insert('promocao', $data);
            $ids['id_promocao'] = $this->db->insert_id();
            $ids['id_empresa'] = $id;
            
            $this->db->insert('promocoes_empresa',$ids);
            return $this->db->affected_rows();
        }
    }
    public function getEmpresa($id){
       
        $this->db->where('id', $id);      
        $query = $this->db->get('empresa');
        if (isset($query)){
            return true;
        }else{
            return false;
        }        
    }
}