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

    public function getRotas($lat, $lng)
    {
        $latini = $lat + 0.00267;
        $lngini = $lng + 0.00267;
        $latfin = $lat - 0.00267;
        $lngfin = $lng - 0.00267;

        $query = $this->db->query("SELECT rotas.id FROM rotas LEFT JOIN paradas ON paradas.id_rota = rotas.id WHERE (paradas.lat >= $latfin AND paradas.lat <= $latini AND paradas.lng >= $lngfin AND paradas.lng <= $lngini) OR (rotas.lat_inicial >= $latfin AND rotas.lat_inicial <= $latini AND rotas.lng_inicial >= $lngfin AND rotas.lng_inicial <= $lngini ) OR (rotas.lat_final >= $latfin AND rotas.lat_final <= $latini AND rotas.lng_final >= $lngfin AND rotas.lng_final <= $lngini) GROUP BY rotas.id");
        return $query->result();
    }
    public function getCaminhoRota($id)
    {
        
        $query = $this->db->query("SELECT r.id,r.lat_inicial AS lat, r.lng_inicial AS lng, r.horario_ini AS horario, r.v_passagem AS passagem, r.v_passagem_estudante AS passagemE FROM rotas AS r WHERE r.id = $id UNION ALL SELECT p.id_rota AS id, p.lat, p.lng, p.horario, r.v_passagem AS passagem, r.v_passagem_estudante AS passagemE FROM paradas AS p RIGHT JOIN rotas AS r ON r.id = p.id_rota WHERE p.id_rota = $id UNION ALL SELECT r.id,r.lat_final AS lat, r.lng_final AS lng,r.horario_fim AS horario, r.v_passagem AS passagem, r.v_passagem_estudante AS passagemE FROM rotas AS r WHERE r.id = $id");
        return $query->result();
    }
}
