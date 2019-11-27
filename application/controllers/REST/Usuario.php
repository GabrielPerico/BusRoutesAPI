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

class Usuario extends CI_Controller    {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $post = json_decode(file_get_contents('php://input'));

        if (isset($post->email) && isset($post->senha)){

            $this->load->model('Usuario_model');

            $email = $post->email;
            $senha = sha1(md5($post->senha.'P0U2U4R1o3D1f3r3NT'));
            
            $retorno = $this->Usuario_model->getUsuario($email,$senha);

            
            if ($retorno != null){
                header('Content-Type: application/json; charset=utf-8', true,200);
                echo json_encode($retorno, JSON_PRETTY_PRINT);  
            }else{
                header('Content-Type: application/json; charset=utf-8', false,400);
                echo json_encode('Email ou senha inválidos!', JSON_PRETTY_PRINT);
            }

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

    public function register(){
        $post = json_decode(file_get_contents('php://input'));  
        
        if (isset($post->email) && isset($post->senha) && isset($post->nome)){
            $this->load->model('Usuario_model');

            $query = $this->Usuario_model->checkEmail($post->email);

            if(isset($query)){
                header('Content-Type: application/json; charset=utf-8', false,400);
                echo json_encode("Email já registrado!", JSON_PRETTY_PRINT);    
                exit;
            }

            $data = array(
                "nome" => $post->nome,
                "email" => $post->email,
                "senha" => sha1(md5($post->senha.'P0U2U4R1o3D1f3r3NT')),
                "admin" => 0
            );

            $retorno = $this->Usuario_model->registerUsuario($data);
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

            header('Content-Type: application/json; charset=utf-8', false,400);
            echo json_encode('Campos não preenchidos: '.$retorno, JSON_PRETTY_PRINT);  
            
        }
    }
}