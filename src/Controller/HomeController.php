<?php
namespace Code\Controller;

use Code\View\View;
use Code\Login\ValidaLogin;

class HomeController
{
    use ValidaLogin;

    public function __construct()
    {
        if(!$this -> check()) {
            return header("Location: " . HOME . "/login");
        }
    }

    public function index(){
        $view = new View("site/index.php");
        return $view->render();
    }
}