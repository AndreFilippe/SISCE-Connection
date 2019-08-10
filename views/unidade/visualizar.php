<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
    <div class="col-12">
        <br>
        <h3>Editar unidade</h3>
        <hr>
        <br>
        <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
        <form action="<?= HOME ?>/unidade/editar" method="post">
            <div class="form-group">
                <label for="Nome">Nome</label>
                <input type="hidden" name="id" value="<?= $this->unidade['id'] ?>">
                <input type="text" class="form-control" required name="nome" value="<?= $this->unidade['nome'] ?>">
                <small class="form-text text-muted">Obrigatorio</small>
            </div>
            <div class="form-group">
                <label for="Tipo">Local</label>
                <input type="text" class="form-control" required name="local" value="<?= $this->unidade['local'] ?>">
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