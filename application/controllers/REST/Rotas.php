<?php

/**
 * Implementação da API rest usando a biblioteca do link abaixo
 * Essa biblioteca possui quatro arquivos distintos:
 * 1 - REST_Controller na pasta libraries, que altera o comportamento padrão das controllers padrões do CI
 * 2 - REST_Controller_Definitions na pasta libraries, que tras algumas definições para o REST_Controller,
 *     trabalha como um arquivo de padrões auxiliando o controller principal
 * 3 - Format na pasta Libraries, que faz o parsing (conversão) dos diferentes tipos de dados (JSON, XML, CSV e etc)
 * 4 - rest.php na pasta config, para as configurações desta biblioteca
 * 
 * @author      Aluno Gabriel Périco
 * @link        https://github.com/chriskacerguis/codeigniter-restserver
 */

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;


require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Rotas extends Rest_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index_post()
    {
        $this->load->model('Rotas_model');
        $rota = $this->post(0);

        $rotaArray = array(
            'lat_inicial' => $rota['lat_inicial'],
            'lat_final' => $rota['lat_final'],
            'lng_inicial' => $rota['lng_inicial'],
            'lng_final' => $rota['lng_final'],
            'id_onibus' => $this->get('id'),
            'horario_ini' => $rota['horario_ini'],
            'horario_fim' => $rota['horario_fim'],
            'v_passagem' => $rota['v_passagem'],
            'v_passagem_estudante' => $rota['v_passagem_estudante']
        );
        $idRota = $this->Rotas_model->insertRota($rotaArray);
        $paradas = $this->post();
        for ($i = 1; $i < sizeof($paradas); $i++) {
            $data['lat']    = $paradas[$i]['lat'];
            $data['lng']     = $paradas[$i]['lat'];
            $data['horario'] = $paradas[$i]['horario'];
            $data['id_rota'] = $idRota;
            $this->Rotas_model->insertParadas($data);
        }
        $this->set_renponse('ta d boassa', REST_Controller_Definitions::HTTP_OK);
    }

    public function rotasPerto_post()
    {
        $lat = $this->post('lat');
        $lng = $this->post('lng');
        $this->load->model('Rotas_model');

        $query = $this->Rotas_model->getRotas($lat, $lng);
        $this->set_response($query, REST_Controller_Definitions::HTTP_OK);
    }

    public function pegarRotas_get()
    {
        $id = $this->get('id');
        $this->load->model('Rotas_model');
        $query = $this->Rotas_model->getCaminhoRota($id);
        $this->set_response($query, REST_Controller_Definitions::HTTP_OK);
    }
}
