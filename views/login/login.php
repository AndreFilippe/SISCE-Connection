<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body>
    <div class="text-center fixed-top" style="margin-top: 5%;">
        <?php require VIEWS_PATH . 'includes/mensagem.php'; ?>
    </div>
    <form class="form-signin" action="<?= HOME ?>/login/valida" method="post">
        <h1 class="h3 mb-3 font-weight-normal text-center">Controle de Estoque</h1>
        <label for="inputEmail" class="sr-only">Usuario</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Usuario" name="usuario" required autofocus>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
        <small class="form-text text-muted" style="color:red !important"><?php if ($this->erro) {echo "Usuario ou Senha invalido!";}?></small>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Conectar</button>
    </form>
    <div class="fixed-bottom">
        <hr>
        <p class="text-center">André Filippe dos santos &copy; Todos os Direitos reservados - <?= date('Y') ?></p>
    </div>
</body>

</html>