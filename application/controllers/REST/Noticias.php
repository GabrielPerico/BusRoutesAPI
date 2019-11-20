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

class Noticias extends Rest_Controller    {
    public function __construct(){
        parent::__construct();
    }

    public function index_post(){
        if (!$this->get('id')){
            $this->set_response([
                'status' => false,
                'message' => 'Id não informado'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }else{
            if(!$this->post('titulo') || !$this->post('descricao')){
                $retorno = '';
                if (!$this->post('titulo')) {
                    $retorno = 'Titulo ';
                } 
                if (!$this->post('descricao')) {
                    $retorno = $retorno.'Descricao ';
                }
                if (!$this->post('minidescricao')){
                    $retorno = $retorno.'[NO]Minidescricao ';
                }
                $this->set_response([
                    'status' => false,
                    'message' => 'Campos não preenchidos: '.$retorno
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }else{
                $id = $this->get('id');
                $this->load->model('Noticias_model');
                $userAdm = $this->Noticias_model->getUser($id);
                if (isset($userAdm)){   
                    $data = array(
                        "titulo" => $this->post('titulo'),
                        "descricao" => $this->post('descricao'),
                        "id_usuario" => $id
                    );
                    
                    if ($this->post('minidescricao')){
                        $data['minidescricao'] = $this->post('minidescricao');
                    }

                    $retorno = $this->Noticias_model->insertNoticia($data);
                    if ($retorno > 0){
                        $this->set_response('Noticias registrada com sucesso', REST_Controller_Definitions::HTTP_OK);
                        return;
                    }else{
                        $this->set_response('Falha ao registrar noticia', REST_Controller_Definitions::HTTP_OK);
                        return;
                    }
                }else{
                    $this->set_response([
                        'status' => false,
                        'message' => 'Usuário não pode enviar noticias'
                    ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                    return; 
                }
            }
        }
    }

    public function index_get(){
        if ($this->get('id')) {
            $limit = $this->get('id');
        }else{
            $limit = 0;
        }
        $this->load->model('Noticias_model');   

        $retorno = $this->Noticias_model->getAllNoticias($limit);
        
        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
        return;
    }

    public function index_put()
    {
        if (!$this->get('id')){
            $this->set_response([
                'status' => false,
                'message' => 'Campo não preenchido: Id'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }else{
            if (!$this->put('titulo') || !$this->put('descricao') || !$this->put('minidescricao')){
                $this->set_response([
                    'status' => false,
                    'message' => 'Nenhum campo foi preenchido'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;   
            }else{
                $id = $this->get('id');
                $this->load->model('Noticias_model');  
                
                if ($this->put('titulo')){
                    $data['titulo'] = $this->put('titulo');
                }
                if ($this->put('descricao')){
                    $data['descricao'] = $this->put('descricao');
                }
                if ($this->put('minidescricao')){
                    $data['minidescricao'] = $this->put('minidescricao');
                }
                $retorno = $this->Noticias_model->updateNoticia($id,$data);
                $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
                return;
            }
        }
    }
}