<?php
namespace Code\Entity;

use Code\DB\Entity;

class Categoria extends Entity
{
    protected $tabela = 'categoria';
    static $filtrosNovo = [
        "nome" => FILTER_SANITIZE_STRING,
        "descricao" => FILTER_SANITIZE_STRING
    ];
    static $filtroseditar = [
        'id' => FILTER_SANITIZE_NUMBER_INT,
        'nome' => FILTER_SANITIZE_STRING,
        'descricao' => FILTER_SANITIZE_STRING
    ];

}