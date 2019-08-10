<?php
namespace Code\Entity;

use Code\DB\Entity;

class User extends Entity
{
    protected $tabela = "usuario";
    static $filtrosNovo = [
        'nome' => FILTER_SANITIZE_STRING,
        'cpf' => FILTER_SANITIZE_STRING,
        'senha' => FILTER_SANITIZE_STRING,
        'usuario' => FILTER_SANITIZE_STRING,
        'senha_confirma' => FILTER_SANITIZE_STRING
    ];
    static $filtrosEditar = [
        'id' => FILTER_SANITIZE_NUMBER_INT,
        'nome' => FILTER_SANITIZE_STRING,
        'cpf' => FILTER_SANITIZE_STRING,
        'senha' => FILTER_SANITIZE_STRING,
        'usuario' => FILTER_SANITIZE_STRING,
        'senha_confirma' => FILTER_SANITIZE_STRING
    ];
    static $filtrosAlteraSenha = [
        'id' => FILTER_SANITIZE_NUMBER_INT,
        'senha_atual' => FILTER_SANITIZE_STRING,
        'senha' => FILTER_SANITIZE_STRING,
        'senha_confirma' => FILTER_SANITIZE_STRING
    ];

}