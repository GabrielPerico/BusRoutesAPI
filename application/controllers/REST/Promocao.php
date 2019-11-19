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

class Promocao extends Rest_Controller    {
    public function __construct(){
        parent::__construct();
    }
    public function index_post(){
        if (!$this->get('id')){
            $this->set_response([
                'status' => false,
                'message' => 'Campo não preenchido: Id'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }else{
            $id = $this->get('id');
            if (!$this->post('descricao') || (!$this->post('prcnt_desconto') && !$this->post('desconto_fixo')) || !$this->post('data_ini') || !$this->post('data_fim')){
                $retorno = '';
                if (!$this->post('descricao')){
                    $retorno = 'Descrição ';
                }
                if (!$this->post('prcnt_desconto')){
                    $retorno = $retorno . 'Porcentagem_Desconto ';
                }
                if (!$this->post('desconto_fixo')){
                    $retorno = $retorno . 'Desconto_Fixo ';
                }
                if (!$this->post('data_ini')){
                    $retorno = $retorno . 'Data_inicial ';
                }
                if (!$this->post('data_fim')){
                    $retorno = $retorno . 'Data_final ';
                }
                $this->set_response([
                    'status' => false,
                    'message' => 'Campos não preenchidos: '.$retorno
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }else{
                $this->load->model('Promocao_model');
                if($this->Promocao_model->getEmpresa($id)){

                    $data = array(
                        "descricao"=>$this->post('descricao'),
                        "prcnt_desconto"=>$this->post('prcnt_desconto'),
                        "desconto_fixo"=>$this->post('desconto_fixo'),
                        "data_ini"=>$this->post('data_ini'),
                        "data_fim"=>$this->post('data_fim')
                    );
                    $retorno = $this->Promocao_model->insertPromocao($id,$data);
                    if ($retorno > 0){
                        $this->set_response('Promoção inserida com sucesso', REST_Controller_Definitions::HTTP_OK);
                        return;
                    }else{
                        $this->set_response('Falha ao cadastrar promoção', REST_Controller_Definitions::HTTP_OK);
                        return;
                    }
                }
                $this->set_response('Empresa não encontrada', REST_Controller_Definitions::HTTP_OK);
                return;
            }
        }
    }
}
