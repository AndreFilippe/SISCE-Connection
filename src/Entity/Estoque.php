<?php
namespace Code\Entity;

use Code\DB\Entity;

class Estoque extends Entity
{
    protected $tabela = 'item_quantidade';
    static $filtroEntrada = [
        "id_item" => FILTER_SANITIZE_NUMBER_INT,
        "id_unidade" => FILTER_SANITIZE_NUMBER_INT,
        "qtd_entrada" => FILTER_SANITIZE_NUMBER_INT,
        "observacao" => FILTER_SANITIZE_STRING
    ];
    static $filtroSaida = [
        "id_item" => FILTER_SANITIZE_NUMBER_INT,
        "id_unidade" => FILTER_SANITIZE_NUMBER_INT,
        "qtd_saida" => FILTER_SANITIZE_NUMBER_INT,
        "observacao" => FILTER_SANITIZE_STRING
    ];
    static $filtroEnvio = [
        "id_item" => FILTER_SANITIZE_NUMBER_INT,
        "id_unidade_origem" => FILTER_SANITIZE_NUMBER_INT,
        "id_unidade_destino" => FILTER_SANITIZE_NUMBER_INT,
        "qtd_envio" => FILTER_SANITIZE_NUMBER_INT,
        "observacao" => FILTER_SANITIZE_STRING
    ];
}