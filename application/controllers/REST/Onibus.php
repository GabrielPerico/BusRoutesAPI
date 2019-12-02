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

class Onibus extends Rest_Controller    {
    public function __construct(){
        parent::__construct();
    }

    public function index_post(){
        if (!$this->post('placa') || !$this->post('intermunicipal') || !$this->post('id_empresa')){
            $retorno = '';
            if (!$this->post('placa')) {
                $retorno = 'Placa ';
            } 
            if (!$this->post('intermunicipal')) {
                $retorno = $retorno.'Intermunicipal ';
            }
            if (!$this->post('id_empresa')) {
                $retorno = $retorno.'Id_empresa ';
            }  
            if (!$this->post('img_onibus')) {
                $retorno = $retorno.'[NO]img_onibus ';
            }
            if (!$this->post('modelo')) {
                $retorno = $retorno.'[NO]modelo ';
            }

            $this->set_response([
                'status' => false,
                'message' => 'Campos não preenchidos: '.$retorno
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
            
        }else{
            
            $this->load->model('Onibus_model');
            $data = array(
                "placa" => $this->post('placa'),
                "intermunicipal" => $this->post('intermunicipal'),
                "id_empresa" => $this->post('id_empresa'),
                "ativo" => 1
            );
            if ($this->post('img_onibus')){
                $data["img_onibus"] =$this->post('img_onibus');
            }
            if ($this->post('modelo')){
                $data["modelo"] = $this->post('modelo');   
            }

            $retorno = $this->Onibus_model->registerBus($data);

            $this->set_response([
                'status' => true,
                'message' => 'Onibus registrado com sucesso!'
            ], REST_Controller_Definitions::HTTP_OK);
            return;
        }
    }

    public function selectBus_post(){
        if (!$this->get('id')){
            $this->set_response([
                'status' => false,
                'message' => 'Campo não preenchido: Id'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }else{
            $this->load->model('Onibus_model');

            $id = $this->get('id');
            
            if ($id > 0) {
                $retorno = $this->Onibus_model->getBus($id);
                if (!isset($retorno)){
                    $this->set_response([
                        'status' => false,
                        'message' => 'Nenhum onibus encontrado'
                    ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                    return;    
                }else{
                    $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
                    return;
                }
            }
        }
    }

    public function index_put(){
        if (!$this->get('id')){
            $this->set_response([
                'status' => false,
                'message' => 'Id não informado'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }else{
            $id = $this->get('id');
            if (!$this->put('placa') || !$this->put('modelo') || !$this->put('intermunicipal') || !$this->put('img_onibus') || !$this->put('ativo')){
                $this->set_response([
                    'status' => false,
                    'message' => 'Nenhum campo foi informado'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;   
            }else{
                if($this->put('placa')){
                    $data['placa'] = $this->put('placa');
                }
                if($this->put('modelo')){
                    $data['modelo'] = $this->put('modelo');
                }
                if($this->put('intermunicipal')){
                    $data['intermunicipal'] = $this->put('intermunicipal');
                }
                if($this->put('img_onibus')){
                    $data['img_onibus'] = $this->put('img_onibus');
                }
                if($this->put('ativo')){
                    $data['ativo'] = $this->put('ativo');
                }
                $this->load->model('Onibus_model');

                $retorno = $this->Onibus_model->updateBus($id,$data);

                $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
                return;
            }
        }
    }

    public function localizacaoBus_post(){
        if ($this->get('id')){
            $id = $this->get('id');
            $this->load->model('Onibus_model');

            $onibus = $this->Onibus_model->getBus($id);

            if (isset($onibus)){
                $onibusloc = $this->Onibus_model->getBusLoc($id);
                if (isset($onibusloc)){
                    if (!$this->post('lat_atual') || !$this->post('lng_atual')){
                        $retorno = '';
                        if (!$this->post('lat_atual')){
                            $retorno = 'Latitude_atual ';
                        }
                        if (!$this->post('lng_atual')){
                            $retorno = $retorno.'Longitude_atual ';
                        }
                        $this->set_response([
                            'status' => false,
                            'message' => 'Campos não preenchidos: '.$retorno
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                        return;
                    }else{

                        $data = array(
                            "lat_atual" => $this->post('lat_atual'),
                            "lng_atual" => $this->post('lng_atual')
                        );
                        $retorno = $this->Onibus_model->updateLocalizacao($id,$data);
                    }   

                    if ($retorno > 0){
                        $this->set_response('Localização do onibus atualizada com sucesso', REST_Controller_Definitions::HTTP_OK);
                        return;
                    }else{
                        $this->set_response('Falha ao atualizar localização do onibus', REST_Controller_Definitions::HTTP_OK);
                        return;  
                    }
                }else{
                    $data = array(
                        "lat_atual" => $this->post('lat_atual'),
                        "lng_atual" => $this->post('lng_atual'),
                        "id_onibus" => $id
                    );

                    $retorno = $this->Onibus_model->insertLocalizacao($data);

                    if ($retorno > 0){
                        $this->set_response('Localização do onibus cadastrada com sucesso', REST_Controller_Definitions::HTTP_OK);
                        return;
                    }else{
                        $this->set_response('Falha ao cadastrar localização do onibus', REST_Controller_Definitions::HTTP_OK);
                        return;  
                    }
                }
            }else{
                $this->set_response([
                    'status' => false,
                    'message' => 'Onibus não existente'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return; 
           }
        } else{
            $this->set_response([
                'status' => false,
                'message' => 'Id não informado'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;   
        }
    }

    public function getAllOnibus_get(){
        $this->load->model('Onibus_model');
        $onibus = $this->Onibus_model->getAll();
        $this->set_response($onibus, REST_Controller_Definitions::HTTP_OK);
    }

    public function localizacaoBus_get(){
        if ($this->get('id')){
            $id = $this->get('id');
            $this->load->model('Onibus_model');

            $onibus = $this->Onibus_model->getBus($id);
            if (isset($onibus)){
                $retorno = $this->Onibus_model->getBusLoc($id);
                if (isset($retorno)){
                    $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
                    return;
                }else{
                    $this->set_response('Falha ao localizar onibus', REST_Controller_Definitions::HTTP_OK);
                    return;  
                }
            }else{
                $this->set_response([
                    'status' => false,
                    'message' => 'Onibus não existente'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return; 
            }
        }else{
            $this->set_response([
                'status' => false,
                'message' => 'Id não informado'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;   
        }
    }

    public function onibusEmpresa(){
        if (!$this->get('id')){
            $this->set_response([
                'status' => false,
                'message' => 'Id não informado'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;  
        }else{
            $id = $this->get('id');
            
            $this->load->model('Onibus_model');
            $retorno = $this->Onibus_model->getBusEmpresa($id);

            if (isset($retorno)){
                $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
                return;
            }else{
                $this->set_response('Falha ao localizar onibus', REST_Controller_Definitions::HTTP_OK);
                return;  
            }
            
        }
    }
}