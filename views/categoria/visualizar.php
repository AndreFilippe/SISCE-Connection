<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Editar Categoria</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/categoria/editar" method="post">
      <div class="form-group">
        <label for="Nome">Nome</label>
        <input type="hidden" name="id" value="<?= $this->categoria['id'] ?>">
        <input type="text" class="form-control" required name="nome" value="<?= $this->categoria['nome'] ?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Tipo">Descrição</label>
        <input type="text" class="form-control" required name="descricao" value="<?= $this->categoria['descricao'] ?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-dark">Salvar</button>
        <a class="btn btn-dark" href="<?= HOME ?>/categoria" role="button">Voltar</a>
      </div>
    </form>
  </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>