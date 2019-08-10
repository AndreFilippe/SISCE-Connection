<?php
namespace Code\Login;

use Code\Session\Session;

trait ValidaLogin
{
    public function check()
    {
        if(Session::has("usuario")){
            return true;
        }
        return false;
    }
}