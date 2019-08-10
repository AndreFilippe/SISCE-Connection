<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Novo item</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/item/salvar" method="post">
      <div class="form-group">
        <label for="Nome">Nome</label>
        <input type="text" class="form-control" required name="nome">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Tipo">Categoria</label>
        <select class="form-control" name="id_categoria" required>
          <option value="">Selecione</option>
          <?php foreach ($this->categorias as $c) : ?>
            <option value="<?= $c['id'] ?>"><?= ucfirst(strtolower($c['nome'])) ?></option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Quantidade mínima">Quantidade mínima</label>
        <input type="number" class="form-control" required name="qtd_minima">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Descrição">Descrição</label>
        <textarea class="form-control" name="descricao" rows="3" required></textarea>
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-dark">Salvar</button>
        <a class="btn btn-dark" href="<?= HOME ?>/item" role="button">Voltar</a>
      </div>
    </form>
  </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>