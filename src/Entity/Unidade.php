<?php
namespace Code\Entity;

use Code\DB\Entity;

class Unidade extends Entity
{
    protected $tabela = 'unidade';
    static $filtrosNovo = [
        "nome" => FILTER_SANITIZE_STRING,
        "local" => FILTER_SANITIZE_STRING,
    ];
    static $filtrosEditar = [
        "id" => FILTER_SANITIZE_NUMBER_INT,
        "nome" => FILTER_SANITIZE_STRING,
        "local" => FILTER_SANITIZE_STRING,
    ];
}