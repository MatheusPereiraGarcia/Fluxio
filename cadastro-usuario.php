<?php require_once("verificaAutenticacao.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css"/>
    <title>Cadastro de Usuario</title>
</head>
<body>
<?php require_once ("menu.php"); ?>
<div class="container">

        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $mensagem ?>
            </div>
        <?php } ?>


        <h1 class="mt-2">Usuario Cadastrar</h1>
        <form method="post" action="cadastrar-usuario.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Email</label>
                <input name="email" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Senha</label>
                <input name="senha1" type="password" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Confirmar Senha</label>
                <input name="senha2" type="password" class="form-control" id="nome" required> </div>
                <br>
                        <button name="salvar" type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i> Salvar
                        </button>
        </form>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>