<?php
namespace Code\Controller;

use Code\View\View;
use Code\DB\Conexao;
use Code\Entity\Item;
use Code\Entity\Envio;
use Code\Entity\Saida;
use Code\Entity\Entrada;
use Code\Entity\Estoque;
use Code\Entity\Unidade;
use Code\Session\Session;
use Code\Validacao\Limpa;
use Code\Session\Mensagem;
use Code\Validacao\Valida;
use Code\Login\ValidaLogin;

class EstoqueController
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
        return header("Location: " . HOME . "/item");
    }
    public function entrada($id)
    {
        $pdo = Conexao::getInstance();
        
        $view = new View("estoque/entrada.php");
        $view->preset = $id;
        $view->unidades = (new Unidade($pdo))->whereLista(null, ' AND ', ' * ', ' = ', ' nome');
        $view->itens = (new Item($pdo))->whereLista(null, ' AND ', ' * ', ' = ', ' nome');
        return $view->render();
    }

    public function salvarEntrada()
    {
        try {
            
            $method = $_SERVER["REQUEST_METHOD"];
            
            if ($method == 'POST') 
            {
                $dados = Limpa::limpaDado($_POST, Estoque::$filtroEntrada);

                if (!Valida::validaDado($dados)) 
                {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/estoque/entrada');
                }
                unset($dados['observacao']);
                $resultado = new Estoque(Conexao::getInstance());

                $existe = $resultado->where(['id_item' => $dados['id_item'], 'id_unidade' => $dados['id_unidade']], ' AND ', 'id,qtd_entrada');
                
                
                if ($existe) 
                {
                    $dados['qtd_entrada'] = $dados['qtd_entrada'] + $existe['qtd_entrada'];
                    $resultado->update(['id' => $existe['id']] + $dados);
                } else {
                    $resultado->insert($dados);
                }

                $resultado = new Entrada(Conexao::getInstance());
                $usuario = Session::get('usuario');
                $dados['qtd_entrada'] = (int) $_POST['qtd_entrada'];
                $dados['id_funcionario'] = (int) $usuario['id'];
                $dados['observacao'] = (string) $_POST['observacao'];
                $resultado->insert($dados);
            }

            Mensagem::add("sucesso", "Entrada registraca com sucesso!");
            return header('Location: ' . HOME . '/estoque/entrada');

        } catch (\Exception $e) {
            
            if (APP_DEBUG) 
            {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/item');
            }

            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/item');

        }
    }

    public function saida($id)
    {
        $pdo = Conexao::getInstance();
        $view = new View("estoque/saida.php");
        $view->preset = $id;
        $view->unidades = (new Unidade($pdo))->whereLista(null, ' AND ', ' * ', ' = ', ' nome');
        $view->itens = (new Item($pdo))->whereLista(null, ' AND ', ' * ', ' = ', ' nome');
        return $view->render();
    }

    public function salvarSaida()
    {
        try {

            $method = $_SERVER["REQUEST_METHOD"];
            
            if ($method == 'POST') {

                $dados = Limpa::limpaDado($_POST, Estoque::$filtroSaida);
                
                if (!Valida::validaDado($dados)) 
                {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/estoque/saida');
                }
                
                $resultado = new Estoque(Conexao::getInstance());
                unset($dados['observacao']);

                $existe = $resultado->where(['id_item' => $dados['id_item'], 'id_unidade' => $dados['id_unidade']], ' AND ', 'id,qtd_saida,qtd_entrada');

                if ($existe && ($existe['qtd_entrada'] - $existe['qtd_saida']) > $dados['qtd_saida']) 
                {
                    $usuario = Session::get('usuario');

                    $dados['qtd_saida'] = $existe['qtd_saida'] + $dados['qtd_saida'];
                    $resultado->update(['id' => $existe['id']] + $dados);
                    
                    $resultado = new Saida(Conexao::getInstance());
                    $dados['qtd_saida'] = (int) $_POST['qtd_saida'];
                    $dados['id_funcionario'] = (int) $usuario['id'];
                    $dados['observacao'] = (string) $_POST['observacao'];
                    $resultado->insert($dados);
                } else {
                    Mensagem::add("alerta", "Quantidade indisponível!");
                    return header('Location: ' . HOME . '/estoque/saida');
                }
            }

            Mensagem::add("sucesso", "Saída registrada com sucesso!");
            return header('Location: ' . HOME . '/estoque/saida');

        } catch (\Exception $e) {
            if (APP_DEBUG) 
            {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/item');
            }

            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/item');
        }
    }

    public function envio($id)
    {
        $pdo = Conexao::getInstance();
        $view = new View("estoque/enviar.php");
        $view->preset = $id;
        $view->unidades = (new Unidade($pdo))->whereLista(null, ' AND ', ' * ', ' = ', ' nome');
        $view->itens = (new Item($pdo))->whereLista(null, ' AND ', ' * ', ' = ', ' nome');
        return $view->render();
    }

    public function salvarEnvio()
    {
        try {

            $method = $_SERVER["REQUEST_METHOD"];

            if ($method == 'POST') 
            {
                $dados = Limpa::limpaDado($_POST, Estoque::$filtroEnvio);
                if (!Valida::validaDado($dados)) 
                {
                    Mensagem::add("alerta", "Preencha todos os campos!");
                    return header('Location: ' . HOME . '/estoque/envio/' . $dados['id_item']);
                }
                if (Valida::validaIgualdade($dados['id_unidade_origem'], $dados['id_unidade_destino'])) 
                {
                    Mensagem::add("alerta", "Origem e destino nao pode ser igual!");
                    return header('Location: ' . HOME . '/estoque/envio/' . $dados['id_item']);
                }
                if ($dados['qtd_envio'] < 1) 
                {
                    Mensagem::add("alerta", "Quantidade deve ser maior que 0!");
                    return header('Location: ' . HOME . '/estoque/envio/' . $dados['id_item']);
                }

                $resultado = new Estoque(Conexao::getInstance());
                $existe = $resultado->where(['id_item' => $dados['id_item'], 'id_unidade' => $dados['id_unidade_origem']], ' AND ', 'id,qtd_saida,qtd_entrada');
                if ($existe && ($existe['qtd_entrada'] - $existe['qtd_saida']) > $dados['qtd_envio']) 
                {
                    $dados['qtd_entrada'] = $existe['qtd_entrada'] - $dados['qtd_envio'];
                    $resultado->update(['id' => $existe['id'], 'qtd_entrada' => $dados['qtd_entrada']]);
                    $resultado->update(['id' => $existe['id_unidade_destino'], 'qtd_entrada' => $dados['qtd_entrada']]);

                    $resultado = new Estoque(Conexao::getInstance());
                    $existe = $resultado->where(['id_item' => $dados['id_item'], 'id_unidade' => $dados['id_unidade_destino']], ' AND ', 'id,qtd_entrada');
                    if ($existe) 
                    {
                        $dados['qtd_entrada'] = $dados['qtd_envio'] + $existe['qtd_entrada'];
                        $resultado->update(['id' => $existe['id'], 'qtd_entrada' => $dados['qtd_entrada']]);
                    } else {
                        $resultado->insert(['id_item' => $dados['id_item'], 'id_unidade' => $dados['id_unidade_destino'], 'qtd_entrada' => $dados['qtd_envio']]);
                    }
                    
                    $resultado = new Envio(Conexao::getInstance());
                    $usuario = Session::get('usuario');
                    unset($dados['qtd_entrada']);
                    $dados['id_funcionario'] = (int) $usuario['id'];
                    $resultado->insert($dados);

                } else {

                    Mensagem::add("alerta", "Quantidade indisponível!");
                    return header('Location: ' . HOME . '/estoque/envio');
                    
                }
            }

            Mensagem::add("sucesso", "Envio registrada com sucesso!");
            return header('Location: ' . HOME . '/estoque/envio');

        } catch (\Exception $e) {
            if (APP_DEBUG) 
            {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/item');
            }

            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/item');
        }
    }

}
