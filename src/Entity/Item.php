<?php
namespace Code\Entity;

use Code\DB\Entity;

class Item extends Entity
{
    protected $tabela = 'item';
    static $filtrosNovo = [
        'id_categoria' => FILTER_SANITIZE_NUMBER_INT,
        'nome' => FILTER_SANITIZE_STRING,
        'descricao' => FILTER_SANITIZE_STRING,
        'qtd_minima' => FILTER_SANITIZE_NUMBER_INT
    ];
    static $filtroseditar = [
        'id' => FILTER_SANITIZE_NUMBER_INT,
        'id_categoria' => FILTER_SANITIZE_NUMBER_INT,
        'nome' => FILTER_SANITIZE_STRING,
        'descricao' => FILTER_SANITIZE_STRING,
        'qtd_minima' => FILTER_SANITIZE_NUMBER_INT
    ];
}