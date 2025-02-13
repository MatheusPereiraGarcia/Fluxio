<?php require_once("verificaAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Cadastro de Marca</title>
</head>

<body>
    <?php require_once("menuAdm.php"); ?>

    <div class="container">
        <?php if (isset($_SESSION['mensagem'])) { ?>
            <div class="alert <?= $_SESSION['mensagem_tipo'] ?>" role="alert">
                <?= $_SESSION['mensagem'] ?>
            </div>
            <?php
            unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); // Limpa a mensagem da sessão 
            ?>
        <?php } ?>

        <h1 class="mt-2">Cadastro de Marca</h1>
        <form method="post" action="cadastrar-marca.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" placeholder="Digite o nome da marca" required>
            </div>

            <div class="mb-3">
                <label for="obs" class="form-label">Observações</label>
                <textarea id="obs" class="form-control" name="obs" rows="5" placeholder="Adicione observações sobre a marca"></textarea>
            </div>

            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
        </form>
    </div>

    <?php require_once("footer.php"); ?>
</body>

</html>
