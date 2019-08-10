<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
  <div class="col-12">
    <br>
    <h3>Editar item</h3>
    <hr>
    <br>
    <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    <form action="<?= HOME ?>/item/editar" method="post">
      <input type="hidden" name="id" value="<?= $this->item["id"] ?>">
      <div class="form-group">
        <label for="Nome">Nome</label>
        <input type="text" class="form-control" required name="nome" value="<?= $this->item["nome"] ?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Tipo">Categoria</label>
        <select class="form-control" name="id_categoria" required>
          <option value="">Selecione</option>
          <?php foreach ($this->categorias as $c) : ?>
            <option <?php if ($c['id'] == $this->item['id_categoria']) {
                      echo " selected ";
                    } ?> value="<?= $c['id'] ?>"><?= ucfirst(strtolower($c['nome'])) ?></option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Quantidade mínima">Quantidade mínima</label>
        <input type="number" class="form-control" required name="qtd_minima" value="<?= $this->item["qtd_minima"] ?>">
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <label for="Descrição">Descrição</label>
        <textarea class="form-control" name="descricao" rows="3" required><?= $this->item['descricao'] ?></textarea>
        <small class="form-text text-muted">Obrigatorio</small>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-dark">Salvar</button>
        <a class="btn btn-dark" href="<?= HOME ?>/item" role="button">Voltar</a>
      </div>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Unidade</th>
          <th scope="col">Quantidade</th>
          <th scope="col">Ultima Alteração</th>
        </tr>
      </thead>
      <tbody>
        <?php $conta = 1;
        foreach ($this->qtd_item as $qi) : ?>
          <tr>
            <th scope="row"><?= $conta++ ?></th>
            <td><?= ucfirst(strtolower($qi['nome'])) ?></td>
            <td><?= intval($qi["qtd_entrada"]) - intval($qi["qtd_saida"]); ?></td>
            <td><?= date('d/m/Y H:i:s', strtotime($qi["updated_at"])); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>