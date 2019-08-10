<?php
namespace Code\Validacao;

class Valida
{
    public static function validaDado(array $data): bool
    {
        foreach($data as $key => $value){
            if(is_null($data[$key]))
            {
                return false;
                break;
            }
        }
        return true;
    }
    public static function validaIgualdade($string,$confirmaString):bool
    {
        return $string == $confirmaString;
    }
    public static function tamanhoSenha($senha):bool
    {
        return strlen($senha) >= 8;
    }
    public static function cpf($cpf):bool
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        if (strlen($cpf) != 11) {
            return false;
        }
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }
}