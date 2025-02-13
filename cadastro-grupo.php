<?php require_once("verificaAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Document</title>
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
        <h1 class="mt-2">Cadastro de Grupo</h1>
        <form method="post" action="cadastrar-grupo.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" placeholder="Digite o nome do grupo" required>
            </div>

            <div class="mb-3">
                <label for="obs" class="form-label">Observações</label>
                <textarea name="obs" class="form-control" id="obs" rows="5" cols="100" placeholder="Adicione observações sobre o grupo"></textarea>
            </div>
            <br>

            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
        </form>
    </div>

    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>
