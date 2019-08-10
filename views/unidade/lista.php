<?php require VIEWS_PATH . 'includes/header.php'; ?>
<br>
<h3>Unidades</h3>
<hr>
<br>
<?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
<form action="<?=HOME?>/unidade" method="post">
  <div class="input-group">
    <input type="text" class="form-control" placeholder="Buscar" aria-describedby="button-addon4" name="pesquisa" value="<?=$this->pesquisa?>" autofocus>
    <div class="input-group-append" id="button-addon4">
      <button type="submit" class="btn btn-outline-secondary" role="button">Buscar</button>
      <a class="btn btn-outline-secondary" href="<?= HOME ?>/unidade/novo" role="button">Novo</a>
    </div>
  </div>
</form>
<br>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Local</th>
      <th scope="col">Dt. Cadastro</th>
      <th scope="col">Opcões</th>
    </tr>
  </thead>
  <tbody>
    <?php $conta = 1;
    foreach ($this->lista as $l) : ?>
      <tr>
        <th scope="row"><?= $conta++ ?></th>
        <td><?= ucfirst(strtolower($l['nome'])) ?></td>
        <td><?= ucfirst(strtolower($l['local'])) ?></td>
        <td><?= date('d/m/Y H:i:s', strtotime($l['created_at'])); ?></td>
        <td>
          <a class="btn btn-danger" href="<?= HOME ?>/unidade/visualizar/<?= $l['id'] ?>" role="button">Editar</a>
          <a class="btn btn-info" href="<?= HOME ?>/unidade/estoque/<?= $l['id'] ?>" role="button">Estoque</a>
          <?php if ($l['status'] == 1) { ?>
            <a class="btn btn-secondary" href="<?= HOME ?>/unidade/desativar/<?= $l['id'] ?>/0" role="button">Desativar</a>
          <?php } else { ?>
            <a class="btn btn-success" href="<?= HOME ?>/unidade/ativar/<?= $l['id'] ?>/1" role="button">Ativar</a>
          <?php } ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>