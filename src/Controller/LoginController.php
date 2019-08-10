<?php
namespace Code\Controller;

use Code\View\View;
use Code\Entity\User;
use Code\DB\Conexao;
use Code\Login\Login;

class LoginController
{
    public function index()
    {
        $view = new View('login/login.php');
        $view -> erro = null;
        return $view -> render();
    }

    public function valida(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user = new User(Conexao::getInstance());
            $valida = new Login($user);
            if(!$valida -> login($_POST)){
                $view = new View('login/login.php');
                $view -> erro = true;
                return $view -> render();
                die();
            }
            header('Location: ' . HOME);
        }
    }
    public function logout(){
        $logout = (new Login())->logout();
        header('Location: ' . HOME . '/login');
    }
}