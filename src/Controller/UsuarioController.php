<?php

namespace Code\Controller;

use Code\DB\Conexao;
use Code\Entity\User;
use Code\Login\ValidaLogin;
use Code\Seguranca\SenhaHash;
use Code\Session\Mensagem;
use Code\Validacao\Limpa;
use Code\Validacao\Valida;
use Code\View\View;
use Code\Session\Session;

class UsuarioController
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
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        try {
            $pesquisa = null;
            $method = $_SERVER["REQUEST_METHOD"];
            $view = new View("usuario/lista.php");
            if ($method == 'POST') {
                $pesquisa = $_POST['pesquisa'];
            }
            $view->pesquisa = $pesquisa;
            $view->lista = (new User(Conexao::getInstance()))->whereLista(["nome" => "%$pesquisa%","cpf" => "%$pesquisa%"], ' OR ', '*', ' LIKE ');
            if (!$view->lista) {
                Mensagem::add("alerta", "Nenhum item encontrado!");
            }
            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/usuario');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/usuario');
        }
    }
    public function novo()
    {
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        $view = new View("usuario/novo.php");
        return $view->render();
    }
    public function salvar()
    {
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, User::$filtrosNovo);
                $dados['cpf'] = preg_replace('/[^0-9]/is', '',$dados['cpf']);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/usuario/novo');
                }
                if (!Valida::validaIgualdade($dados['senha'], $dados['senha_confirma'])) {
                    Mensagem::add("alerta", "Senhas não conferem!");
                    return header('Location: ' . HOME . '/usuario/novo');
                }
                if (!Valida::tamanhoSenha($dados['senha'])) {
                    Mensagem::add("alerta", "Senha deve ter 8 Caractere!");
                    return header('Location: ' . HOME . '/usuario/novo');
                }
                if(!Valida::cpf($dados['cpf'])){
                    Mensagem::add("alerta", "CPF inválido!");
                    return header('Location: ' . HOME . '/usuario/novo');
                }
                $resultado = new User(Conexao::getInstance());
                unset($dados['senha_confirma']);
                $dados['senha'] = (new SenhaHash())->hash($dados['senha']);
                $resultado->insert($dados);
            }
            Mensagem::add("sucesso", "Usuario cadastrada com sucesso!");
            return header('Location: ' . HOME . '/usuario');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/usuario');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/usuario');
        }
    }
    public function visualizar($id)
    {
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        $id = (int) $id;
        $pdo = Conexao::getInstance();
        $view = new View("usuario/visualizar.php");
        $view->resultado = (new User($pdo))->where(['id' => $id]);
        if (!$view->resultado) {
            Mensagem::add("erro", "Usuario não encontrado!");
            return header('Location: ' . HOME . '/usuario');
        }
        return $view->render();
    }
    public function editar()
    {
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, User::$filtrosEditar);
                $dados['cpf'] = preg_replace('/[^0-9]/is', '',$dados['cpf']);
                if(!Valida::cpf($dados['cpf'])){
                    Mensagem::add("alerta", "CPF inválido!");
                    return header('Location: ' . HOME . '/usuario/visualizar/' . $dados['id']);
                }
                if($dados['senha']){
                    if (!Valida::validaIgualdade($dados['senha'], $dados['senha_confirma'])) {
                        Mensagem::add("alerta", "Senhas não conferem!");
                        return header('Location: ' . HOME . '/usuario/visualizar/' . $dados['id']);
                    }
                    if (!Valida::tamanhoSenha($dados['senha'])) {
                        Mensagem::add("alerta", "Senha deve ter 8 Caractere!");
                        return header('Location: ' . HOME . '/usuario/visualizar/' . $dados['id']);
                    }
                    $dados['senha'] = (new SenhaHash())->hash($dados['senha']);
                }else{
                    unset($dados['senha']);
                }
                unset($dados['senha_confirma']);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/usuario/visualizar/' . $dados['id']);
                }
                $resultado = new User(Conexao::getInstance());
                $resultado->update($dados);
            }
            Mensagem::add("sucesso", "Usuario atualizado com sucesso!");
            return header('Location: ' . HOME . '/usuario');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/usuario');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/usuario');
        }
    }
    public function ativar($id)
    {
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        try {
            $id = (int) $id;
            $dados = ['id' => $id, 'status' => 1];
            $resultado = new User(Conexao::getInstance());
            $resultado->update($dados);
            return header('Location: ' . HOME . '/usuario');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/usuario');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/usuario');
        }
    }
    public function desativar($id)
    {
        $usuario = Session::get("usuario");
        if(!$usuario['admin']){return header('Location: ' . HOME);}
        try {
            $id = (int) $id;
            $dados = ['id' => $id, 'status' => 0];
            $resultado = new User(Conexao::getInstance());
            $resultado->update($dados);
            return header('Location: ' . HOME . '/usuario');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/usuario');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/usuario');
        }
    }
    public function alterarSenha()
    {
        $pdo = Conexao::getInstance();
        $view = new View("usuario/alterarsenha.php");
        $usuario = Session::get('usuario');
        $id = $usuario['id'];
        $view->resultado = (new User($pdo))->where(['id' => $id],' AND ','id,usuario');
        if (!$view->resultado) {
            Mensagem::add("erro", "Usuario não encontrado!");
            return header('Location: ' . HOME . '/usuario');
        }
        return $view->render();
    }
    public function novaSenha()
    {
        try {
            $pdo = Conexao::getInstance();
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == 'POST') {
                $dados = Limpa::limpaDado($_POST, User::$filtrosAlteraSenha);
                if (!Valida::validaDado($dados)) {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/usuario/alterarSenha');
                }
                $id = $dados['id'];
                $verifica = (new User($pdo))->where(['id' => $id],' AND ','id,senha');
                if(!SenhaHash::valida($dados['senha_atual'],$verifica['senha'])){
                    Mensagem::add("alerta", "Senhas atual não conferem!");
                    return header('Location: ' . HOME . '/usuario/alterarSenha');
                }
                if (!Valida::validaIgualdade($dados['senha'], $dados['senha_confirma'])) {
                    Mensagem::add("alerta", "Senhas não conferem!");
                    return header('Location: ' . HOME . '/usuario/alterarSenha');
                }
                if (!Valida::tamanhoSenha($dados['senha'])) {
                    Mensagem::add("alerta", "Senha deve ter 8 Caractere!");
                    return header('Location: ' . HOME . '/usuario/alterarSenha');
                }
                $dados['senha'] = (new SenhaHash())->hash($dados['senha']);
                unset($dados['senha_atual']);
                unset($dados['senha_confirma']);
                $resultado = (new User($pdo))->update($dados);
                if($resultado){
                    Mensagem::add("sucesso", "Senha atualizada com sucesso!");
                    return header('Location: ' . HOME);                     
                }else{
                    Mensagem::add("erro", "Erro interno. Não foi possivel alterar a senha!");
                    return header('Location: ' . HOME . '/usuario/alterarSenha');                     
                }
            }  
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME);
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME);
        }
    }
}
