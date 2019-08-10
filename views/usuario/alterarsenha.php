<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Alterar senha</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/usuario/novaSenha" method="post" >
        <input type="hidden" class="form-control" name="id" value="<?= $this->resultado['id'];?>">
      <div class="form-group">
        <label for="usuário">Usuário</label>
        <input type="text" class="form-control" value="<?= $this -> resultado['usuario'];?>" required disabled>
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="senha">Senha atual</label>
        <input type="password" class="form-control" required name="senha_atual">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="senha">Senha nova</label>
        <input type="password" class="form-control" required name="senha">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="confirma senha">Confirma senha</label>
        <input type="password" class="form-control" required name="senha_confirma">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-dark">Salvar</button>
        <a class="btn btn-dark" href="<?= HOME ?>/usuario" role="button">Voltar</a>
      </div>
    </form>
  </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>