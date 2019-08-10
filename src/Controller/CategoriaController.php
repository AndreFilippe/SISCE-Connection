<?php

namespace Code\Controller;

use Code\View\View;
use Code\DB\Conexao;
use Code\Validacao\Limpa;
use Code\Entity\Categoria;
use Code\Session\Mensagem;
use Code\Validacao\Valida;
use Code\Login\ValidaLogin;

class CategoriaController
{
    use ValidaLogin;

    public function __construct()
    {
        if (!$this->check()) {
            return header("Location: " . HOME . "/login");
        }
    }
    public function index()
    {
        try {

            $pesquisa = null;
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') 
            {
                $pesquisa = $_POST['pesquisa'];
            }
            
            $view = new View("categoria/lista.php");
            $view->pesquisa = $pesquisa;
            $view->lista = (new Categoria(Conexao::getInstance()))->whereLista(["nome" => "%$pesquisa%"], ' AND ', '*', ' LIKE ');
            
            if (!$view->lista) 
            { 
                Mensagem::add("alerta", "Nenhum item encontrado!"); 
            }

            return $view->render();
        
        } catch (\Exception $e) {

            if (APP_DEBUG) 
            {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/categoria');
            }
            
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/categoria');

        }
    }

    public function novo()
    {
        $view = new View("categoria/novo.php");
        return $view->render();
    }
    
    public function salvar()
    {
        try {

            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, Categoria::$filtrosNovo);
            
                if (!Valida::validaDado($dados)) 
                {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/categoria/novo');
                }
            
                $insert = new Categoria(Conexao::getInstance());
                $insert->insert($dados);
            
            }
            
            Mensagem::add("sucesso", "Categoria cadastrada com sucesso!");
            return header('Location: ' . HOME . '/categoria');

        } catch (\Exception $e) {
            if (APP_DEBUG) 
            {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/categoria');
            }
            
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/categoria');
        }
    }
    public function visualizar($id)
    {
        $id = (int) $id;

        $view = new View("categoria/visualizar.php");
        $view->categoria = (new Categoria(Conexao::getInstance()))->where(['id' => $id]);
        
        if (!$view->categoria) 
        {
            Mensagem::add("erro", "Categoria não encontrado!");
            return header('Location: ' . HOME . '/categoria');
        }

        return $view->render();
    }

    public function editar()
    {
        try {

            $method = $_SERVER["REQUEST_METHOD"];
            
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, Categoria::$filtroseditar);
                if (!Valida::validaDado($dados)) 
                {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/categoria/visualizar/' . $dados['id']);
                }
                $resultado = new Categoria(Conexao::getInstance());
                $resultado->update($dados);
            }
            Mensagem::add("sucesso", "Categoria atualizado com sucesso!");
            return header('Location: ' . HOME . '/categoria');

        } catch (\Exception $e) {
            
            if (APP_DEBUG) 
            {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/categoria');
            }
            
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/categoria');
        }
    }
}
