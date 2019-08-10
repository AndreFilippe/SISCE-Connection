<?php

namespace Code\Controller;

use Code\View\View;
use Code\Entity\Item;
use Code\DB\Conexao;
use Code\Login\ValidaLogin;
use Code\Entity\Categoria;
use Code\Session\Mensagem;
use Code\Validacao\Limpa;
use Code\Validacao\Valida;
use Code\Entity\Estoque;

class ItemController
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
        try{
            $pesquisa = null; 
            $method = $_SERVER["REQUEST_METHOD"];
            $view = new View("item/lista.php");
            if($method == 'POST'){
                $pesquisa = $_POST['pesquisa'];
            }
            $view -> pesquisa = $pesquisa;
            $view->lista = (new Item(Conexao::getInstance()))->whereLista(["nome"=> "%$pesquisa%"],' AND ','*',' LIKE ');
            if (!$view->lista) {
                Mensagem::add("alerta", "Nenhum item encontrado!");
            }
            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e -> getMessage());
                return header('Location: ' . HOME . '/item');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/item');
        }
    }

    public function novo()
    {
        $view = new View("item/novo.php");
        $view->categorias = (new Categoria(Conexao::getInstance()))->whereLista();
        return $view->render();
    }

    public function salvar()
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, Item::$filtrosNovo);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/item/novo');
                }
                $insert = new Item(Conexao::getInstance());
                $insert->insert($dados);
                Mensagem::add("sucesso", "Item cadastrado com sucesso!");
            }
            return header('Location: ' . HOME . '/item');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e -> getMessage());
                return header('Location: ' . HOME . '/item');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/item');
        }
    }

    public function visualizar($id)
    {
        $id = (int) $id;
        $pdo = Conexao::getInstance();
        $view = new View("item/visualizar.php");
        $view->item = (new Item($pdo))->where(['id' => $id]);
        if ($view->item) {
            $view->categorias = (new Categoria($pdo))->whereLista();
            $view->qtd_item = (new Estoque($pdo))->whereJoin('unidade','item_quantidade','A.id = B.id_unidade', ['id_item' => $id], 'A.nome,B.qtd_entrada,B.qtd_saida,B.updated_at', ' = ' ,' A.nome ');
            return $view->render();
        } else {
            Mensagem::add("erro", "Item não encontrado!");
            return header('Location: ' . HOME . '/item');
        }
    }

    public function editar()
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, Item::$filtroseditar);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/item/visualizar/' . $dados['id']);
                }
                $insert = new Item(Conexao::getInstance());
                $insert->update($dados);
                Mensagem::add("sucesso", "Item atualizado com sucesso!");
            }
            return header('Location: ' . HOME . '/item');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e -> getMessage());
                return header('Location: ' . HOME . '/item');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/item');
        }
    }
}
