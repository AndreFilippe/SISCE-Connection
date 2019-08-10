<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Novo usuário</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/usuario/editar" method="post" class="row">
      <input type="hidden" name="id" value="<?= $this->resultado['id']?>">
      <div class="form-group col-6">
        <label for="Nome">Nome</label>
        <input type="text" class="form-control" required name="nome" value="<?= $this->resultado['nome']?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-6">
        <label for="cpf">CPF</label>
        <input type="number" class="form-control" required name="cpf" value="<?= $this->resultado['cpf']?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-4">
        <label for="usuário">Usuário</label>
        <input type="text" class="form-control" required name="usuario" value="<?= $this->resultado['usuario']?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-4">
        <label for="senha">Senha</label>
        <input type="password" class="form-control" name="senha" placeholder="Deixe em branco para manter a mesma senha">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group col-4">
        <label for="confirma senha">Confirma senha</label>
        <input type="password" class="form-control" name="senha_confirma">
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