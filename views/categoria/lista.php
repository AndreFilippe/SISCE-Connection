<?php require VIEWS_PATH . 'includes/header.php'; ?>
<br>
<h3>Categorias</h3>
<hr>
<br>
<?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
<form action="<?=HOME?>/categoria" method="post">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Buscar" aria-describedby="button-addon4" name="pesquisa" value="<?=$this->pesquisa?>" autofocus>       
        <div class="input-group-append" id="button-addon4">
            <button type="submit" class="btn btn-outline-secondary" role="button">Buscar</button>
            <a class="btn btn-outline-secondary" href="<?= HOME ?>/categoria/novo" role="button">Novo</a>
        </div>
    </div>
</form>
<br>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
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
                <td title="<?= ucfirst(strtolower($l['descricao'])) ?>"><?= ucfirst(strtolower(substr($l['descricao'], 0, 15))) ?></td>
                <td><?= date('d/m/Y H:i:s', strtotime($l['created_at'])); ?></td>
                <td>
                    <a class="btn btn-danger" href="<?= HOME ?>/categoria/visualizar/<?= $l['id'] ?>" role="button">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>