<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISCE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" href="<?=HOME?>/_imagem/icon.png" />
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="<?=HOME?>">Estoque</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?=HOME?>">Home</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=HOME?>/item">Itens</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=HOME?>/unidade">Unidades</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=HOME?>/categoria">Categorias</span></a>
      </li>
      <?php $usuario = \Code\Session\Session::get('usuario'); if($usuario['usuario'] == 'admin'):?>
      <li class="nav-item">
        <a class="nav-link" href="<?=HOME?>/usuario">Usuários</span></a>
      </li>
      <?php endif; ?>
    </ul>
    <ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?= ucwords(strtolower($usuario['nome']))?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?=HOME?>/usuario/alterarSenha">Alterar senha</a>
          <a class="dropdown-item" href="<?=HOME?>/login/logout">Sair</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<div class="container">

