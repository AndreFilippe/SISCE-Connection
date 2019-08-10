<?php 
namespace Code\Login;

use Code\Entity\User;
use Code\Session\Session;
use Code\Seguranca\SenhaHash;

class Login 
{
    private $user;

    public function __construct(User $user = null)
    {   
        $this -> user = $user;
    }

    public function login(array $credenciais)
    {
        $user = $this -> user -> where([
            'usuario' => $credenciais['usuario']
        ]);
        if(!$user){
            return false;
        }
        if(!SenhaHash::valida($credenciais['senha'],$user['senha'])){
            return false;
        }
        if($user['status'] == 0){
            return false;
        }
        unset($user['senha']);
        Session::add('usuario',$user);
        return true;
    }

    public function logout()
    {
        if(Session::has('usuario')){
            Session::remove("usuario");
        }
        Session::limpa();
    }
}