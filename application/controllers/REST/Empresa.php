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

class Empresa extends CI_Controller    {
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $post = json_decode(file_get_contents('php://input'));

        if (isset($post->email) && isset($post->senha)){

            $this->load->model('Empresa_model');

            $email = $post->email;
            $senha = sha1(md5($post->senha.'Qu3rOV3rP4Ss4RD1ss0'));
    
            $retorno = $this->Empresa_model->getEmpresa($email,$senha);
            header('Content-Type: application/json; charset=utf-8', true,200);
            echo json_encode($retorno, JSON_PRETTY_PRINT);  

        }else{
            $retorno = '';
            if (!isset($post->email)){
                $retorno = 'Email ';
            }
            if (!isset($post->senha)){
                $retorno = $retorno.'Senha ';
            }
            header('Content-Type: application/json; charset=utf-8', false,400);
            echo json_encode('Campos não preenchidos: '.$retorno, JSON_PRETTY_PRINT);   
        }
    }

    public function cadastrar(){
        $post = json_decode(file_get_contents('php://input'));

        if (isset($post->email) && isset($post->senha) && isset($post->nome) && isset($post->telefone)){

            $this->load->model('Empresa_model');

            $data = array(
                "nome" => $post->nome,
                "email" => $post->email,
                "senha" => sha1(md5($post->senha.'Qu3rOV3rP4Ss4RD1ss0')),
                "telefone" => $post->telefone,
                "token" => sha1($post->nome.$post->email.sha1(md5($post->senha.'Qu3r0V3rP4Ss4RD1ss0')))
            );

            $retorno = $this->Empresa_model->registerEmpresa($data);
            header('Content-Type: application/json; charset=utf-8', true,200);
            echo json_encode($retorno, JSON_PRETTY_PRINT);

        }else{
            $retorno = '';
            if (!isset($post->email)){
                $retorno = 'Email ';
            }
            if (!isset($post->senha)){
                $retorno = $retorno.'Senha ';
            }
            if (!isset($post->nome)){
                $retorno = $retorno.'Nome ';
            }
            if (!isset($post->telefone)){
                $retorno = $retorno.'Telefone ';
            }
            header('Content-Type: application/json; charset=utf-8', false,400);
            echo json_encode('Campos não preenchidos: '.$retorno, JSON_PRETTY_PRINT);  

        }   
    }
}