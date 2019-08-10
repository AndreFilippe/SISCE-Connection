<?php
/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);
/* Habilita a exibição de erros */
ini_set("display_errors", 1);

require __DIR__ . '/vendor/autoload.php';

define('HOME', 'http://sisce.com');
define('VIEWS_PATH',  __DIR__ .'/views/');
define("APP_DEBUG",false);

define('DB_NAME','Estoque');
define("DB_HOST",'mysql');
define("DB_USER",'Estoque');
define("DB_PASSWORD",'7fcb8cffdd8445253b6e9ce44cbda47c');
define("DB_CHARSET",'SET NAMES UTF8');

date_default_timezone_set('America/Sao_Paulo');
