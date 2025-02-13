<?php require_once("verificaAdm.php"); ?>
<?php

//1. Conectar no BD (IP, usuario, senha, nome do banco)
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Se o formulário for enviado para salvar as alterações
if (isset($_POST['salvar'])) {
    //2. Pegar os dados para inserir no BD
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];  // Captura o tipo (Administrador ou Normal)

    //3. Prepara a SQL para atualizar os dados no banco
    $sql = "UPDATE usuario
            SET nome = '$nome', email = '$email', senha = '$senha', tipo = '$tipo'
            WHERE id = '$id'";

    //4. Executar a SQL
    mysqli_query($conexao, $sql);

    //5. Mostrar mensagem ao usuario
    $mensagem = "Usuário Alterado com sucesso!";

    // Redireciona para a página de listagem de usuários
    header('Location: listar-usuario.php');
    exit;
}

//2. Pega os dados do usuário para preencher o formulário
$sql = "SELECT * FROM usuario WHERE id = " . $_GET['id'];
$resultado = mysqli_query($conexao, $sql);
$usuario = mysqli_fetch_array($resultado);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Alterar Usuário</title>
</head>

<body>
    <?php require_once("menuAdm.php"); ?>

    <div class="container">
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $mensagem ?>
            </div>
        <?php } ?>

        <h1 class="mt-2">Alterar Usuário</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" required value="<?= $usuario['nome'] ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email" required
                    value="<?= $usuario['email'] ?>">
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Usuário</label>
                <select name="tipo" class="form-select" id="tipo" required>
                    <!-- Condição para selecionar o tipo correto -->
                    <option value="1" <?= $usuario['tipo'] == 1 ? 'selected' : '' ?>>Administrador</option>
                    <option value="0" <?= $usuario['tipo'] == 0 ? 'selected' : '' ?>>Usuário Restrito</option>
                </select>
            </div>

            <br>
            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
            <a href="listar-usuario.php" class="botao-secundario">Voltar</a>
        </form>
    </div>
    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>