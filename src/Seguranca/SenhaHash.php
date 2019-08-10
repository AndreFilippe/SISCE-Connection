<?php 
namespace Code\Seguranca;

class SenhaHash
{
    public static function hash($string)
    {
        return password_hash($string,PASSWORD_ARGON2I);
    }
    public static function valida($string,$senhaHash)
    {
        return password_verify($string,$senhaHash);
    }
}