<?php
namespace Code\Controller;

use Code\View\View;
use Code\DB\Conexao;
use Code\Entity\Unidade;
use Code\Validacao\Limpa;
use Code\Session\Mensagem;
use Code\Validacao\Valida;
use Code\Login\ValidaLogin;

class UnidadeController
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
            $view = new View("unidade/lista.php");
            if ($method == 'POST') {
                $pesquisa = $_POST['pesquisa'];
            }
            $view->pesquisa = $pesquisa;
            $view->lista = (new Unidade(Conexao::getInstance()))->whereLista(["nome" => "%$pesquisa%"], ' AND ', '*', ' LIKE ');
            if (!$view->lista) {
                Mensagem::add("alerta", "Nenhum item encontrado!");
            }
            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/unidade'); 
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/unidade');
        }
    }
    public function novo()
    {
        $pdo = Conexao::getInstance();
        $view = new View("unidade/novo.php");
        return $view->render();

    }
    public function salvar()
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, Unidade::$filtrosNovo);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/unidade/novo');
                }
                $resultado = new Unidade(Conexao::getInstance());
                $resultado->insert($dados);
            }
            return header('Location: ' . HOME . '/unidade');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/unidade');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/unidade');
        }
    }
    public function visualizar($id)
    {
        $id = (int) $id;
        $pdo = Conexao::getInstance();
        $view = new View("unidade/visualizar.php");
        $view->unidade = (new Unidade($pdo))->where(['id' => $id]);
        return $view->render();
    }
    public function editar()
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, Unidade::$filtrosEditar);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/unidade/editar/' . $dados['id']);
                }
                $resultado = new Unidade(Conexao::getInstance());
                $resultado->update($dados);
            }
            return header('Location: ' . HOME . '/unidade');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/unidade');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/unidade');
        }
    }

    public function estoque($id){
        $id = (int) $id;
        $pdo = Conexao::getInstance();
        $view = new View("unidade/listaEstoque.php");
        $view->unidade = (new Unidade($pdo))->where(['id' => $id]," AND ",'nome');
        $view->itens = (new Unidade($pdo))->whereJoin('item_quantidade','item',' A.id_item = B.id ',['id_unidade' => $id],' B.id,B.nome,A.id_item,A.id_unidade,A.qtd_entrada,A.qtd_saida,A.updated_at ',' AND ',' B.nome ');
        return $view->render();
    }

    public function ativar($id)
    {
        try {
            $id = (int) $id;
            $dados = ['id' => $id, 'status' => 1];
            $resultado = new Unidade(Conexao::getInstance());
            $resultado->update($dados);
            return header('Location: ' . HOME . '/unidade');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/unidade');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/unidade');
        }
    }
    public function desativar($id)
    {
        try {
            $id = (int) $id;
            $dados = ['id' => $id, 'status' => 0];
            $resultado = new Unidade(Conexao::getInstance());
            $resultado->update($dados);
            return header('Location: ' . HOME . '/unidade');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/unidade');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/unidade');
        }
    }
}
