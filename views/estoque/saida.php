<?php require VIEWS_PATH . 'includes/header.php'; ?>
<div class="row">
    <div class="col-12">
        <br>
        <h3>Saída</h3>
        <hr>
        <br>
        <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
        <form action="<?= HOME ?>/estoque/salvarSaida" class="row" method="post">
            <div class="form-group col">
                <label for="Item">Item</label>
                <select class="form-control" name="id_item" required>
                    <option value="">Selecione</option>
                    <?php foreach ($this->itens as $i) : ?>
                        <option <?php if($this->preset == $i['id']){echo ' selected ';}?>  value="<?= $i['id'] ?>"><?= ucfirst(strtolower($i['nome'])) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col">
                <label for="Estoque">Estoque</label>
                <select class="form-control" name="id_unidade" required>
                    <option value="">Selecione</option>
                    <?php foreach ($this->unidades as $u) : ?>
                        <option value="<?= $u['id'] ?>"><?= ucfirst(strtolower($u['nome'])) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col">
                <label for="Quantidade">Quantidade</label>
                <input type="number" class="form-control" required name="qtd_saida">
            </div>
            <div class="form-group col-12">
                <label for="Observação">Observação</label>
                <textarea name="observacao" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group col-12">
                <button type="submit" class="btn btn-dark">Salvar</button>
                <a class="btn btn-dark" href="<?= HOME ?>/estoque" role="button">Voltar</a>
            </div>
        </form>
    </div>
</div>
<?php require VIEWS_PATH . 'includes/footer.php'; ?>