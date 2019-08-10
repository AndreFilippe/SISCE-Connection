<?php if(\Code\Session\Session::has("sucesso")): ?>
    <div class="alert alert-success" role="alert">
        <?= \Code\Session\Mensagem::get("sucesso")?>
    </div>
<?php endif;?>
<?php if(\Code\Session\Session::has("alerta")): ?>
    <div class="alert alert-warning" role="alert">
        <?= \Code\Session\Mensagem::get("alerta")?>
    </div>
<?php endif;?>
<?php if(\Code\Session\Session::has("erro")): ?>
    <div class="alert alert-danger" role="alert">
        <?= \Code\Session\Mensagem::get("erro")?>
    </div>
<?php endif;?>