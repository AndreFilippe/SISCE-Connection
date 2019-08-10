<?php require VIEWS_PATH . 'includes/header.php'; ?>
<br>
<h3>Estoque <?= ucfirst(strtolower($this->unidade['nome']))?> </h3>
<hr>
<br>
<?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Quantidade</th>
      <th scope="col">Dt. Cadastro</th>
      <th scope="col">Opcões</th>
    </tr>
  </thead>
  <tbody>
    <?php $conta = 1;
    foreach ($this->itens as $i) : ?>
      <tr>
        <th scope="row"><?= $conta++ ?></th>
        <td><?= ucfirst(strtolower($i['nome'])) ?></td>
        <td><?=($i['qtd_entrada'] - $i['qtd_saida'])?></td>
        <td><?= date('d/m/Y H:i:s', strtotime($i['updated_at'])); ?></td>
        <td>
            <a class="btn btn-danger" href="<?= HOME ?>/item/visualizar/<?= $i['id'] ?>" role="button">Editar</a>
            <a class="btn btn-secondary" href="<?= HOME ?>/estoque/entrada/<?= $i['id'] ?>" role="button">Entrada</a>
            <a class="btn btn-success" href="<?= HOME ?>/estoque/saida/<?= $i['id'] ?>" role="button">Saída</a>
            <a class="btn btn-info" href="<?= HOME ?>/estoque/envio/<?= $i['id'] ?>" role="button">Enviar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>