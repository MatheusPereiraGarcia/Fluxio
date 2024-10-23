<!--  http://localhost/TCC3/cadastro-cliente.php  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css"/>
    <title>Cadastro de Clientes</title>
</head>

<body>
<?php require_once ("menu.php"); ?>
    <div class="container">
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $mensagem ?>
            </div>
        <?php } ?>


        <h1 class="mt-2">Cliente Cadastrar</h1>
        <form method="post" action="cadastrar-cliente.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Telefone</label>
                <input name="fone" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Email</label>
                <input name="email" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">CPF</label>
                <input name="cpf" type="text" class="form-control" id="nome" requiredv </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Data de Nascimento</label>
                <input name="dtNasc" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Endereço</label>
                <input name="endereco" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">CEP</label>
                <input name="cep" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Cidade</label>
                <input name="cidade" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">UF</label>
                <input name="uf" type="text" class="form-control" id="nome" required> </div>

                <div class="mb-3">
                <label for="nome" class="form-label">Rua</label>
                <input name="rua" type="text" class="form-control" id="nome" required> </div>


                <div class="mb-3">
                    <label for="nome" class="form-label">Número</label>
                    <input name="numero" type="text" class="form-control" id="nome" required> </div>
                <br>
                        <button name="salvar" type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i> Salvar
                        </button>
        </form>
    </div>
    <?php require_once("footer.php"); ?>
</body>

</html>