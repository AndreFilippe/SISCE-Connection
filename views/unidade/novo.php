<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Nova unidade</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/unidade/salvar" method="post">
      <div class="form-group">
        <label for="Nome">Nome</label>
        <input type="text" class="form-control" required name="nome">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Tipo">Local</label>
        <input type="text" class="form-control" required name="local">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-dark">Salvar</button>
        <a class="btn btn-dark" href="<?= HOME ?>/unidade" role="button">Voltar</a>
      </div>
    </form>
  </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>