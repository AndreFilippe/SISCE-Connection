<?php

namespace Code\DB;

use Code\Session\Mensagem;

class Conexao
{
    private static $instance = null;

    private function __construct()
    { }

    public static function getInstance()
    {
        try {
            if (is_null(self::$instance)) {
                self::$instance = new \PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASSWORD);
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$instance->exec(DB_CHARSET);
            }
            return self::$instance;
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Mensagem::add("erro", $e->getMessage());
                return header('Location: ' . HOME . '/login');
            }
            Mensagem::add("erro", "Erro interno. Contate o administrador!");
            return header('Location: ' . HOME . '/login');
        }
    }
}
