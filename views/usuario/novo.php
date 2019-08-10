<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Novo usuário</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/usuario/salvar" method="post" class="row">
      <div class="form-group col-6">
        <label for="Nome">Nome</label>
        <input type="text" class="form-control" required name="nome">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-6">
        <label for="cpf">CPF</label>
        <input type="number" class="form-control" required name="cpf">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-4">
        <label for="usuário">Usuário</label>
        <input type="text" class="form-control" required name="usuario">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-4">
        <label for="senha">Senha</label>
        <input type="password" class="form-control" required name="senha">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-4">
        <label for="confirma senha">Confirma senha</label>
        <input type="password" class="form-control" required name="senha_confirma">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col">
        <button type="submit" class="btn btn-dark">Salvar</button>
        <a class="btn btn-dark" href="<?= HOME ?>/usuario" role="button">Voltar</a>
      </div>
    </form>
  </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>