<?php
namespace Code\Session;

class Mensagem
{
    public static function add($titulo,$mesagem)
    {
        Session::add($titulo,$mesagem);
    }
    public static function get($titulo)
    {
       $mesagem = Session::get($titulo);
       Session::remove($titulo);
       return $mesagem;
    }
}