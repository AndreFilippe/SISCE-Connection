<?php
namespace Code\Validacao;

class Limpa
{
    public static function limpaDado($data,$filtros)
    {
        $data = array_map('trim',$data);
        return filter_var_array($data,$filtros);
    }
}