<?php require_once("verificaAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Cadastro de Usuario</title>
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

        <h1 class="mt-2">Cadastro de Usuário</h1>
        <form method="post" action="cadastrar-usuario.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" placeholder="Digite o nome completo" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Usuário</label>
                <select name="tipo" class="form-select" id="tipo" required>
                    <option value="0">Usuário Restrito</option>
                    <option value="1">Administrador</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Digite o seu email" required>
            </div>

            <div class="mb-3">
                <label for="senha1" class="form-label">Senha</label>
                <input name="senha1" type="password" class="form-control" id="senha1" placeholder="Crie uma senha" required>
            </div>

            <div class="mb-3">
                <label for="senha2" class="form-label">Confirmar Senha</label>
                <input name="senha2" type="password" class="form-control" id="senha2" placeholder="Confirme a senha" required>
            </div>
            <br>
            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
        </form>
    </div>
    <?php require_once("footer.php"); ?>
</body>

</html>
