<?php require_once("verificaAdm.php"); ?>
<?php
// 1. Conectar no BD (IP, usuário, senha, nome do banco)
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Mensagem de retorno
$mensagem = "";

// 2. Verifica se foi clicado no botão 'excluir'
if (isset($_GET['id'])) {
    $idGrupo = $_GET['id'];

    // Excluir grupo
    $sqlDelete = "DELETE FROM grupo WHERE id = $idGrupo";
    if (mysqli_query($conexao, $sqlDelete)) {
        $mensagem = "Grupo excluído com sucesso.";
    } else {
        $mensagem = "Grupo vinculado a algum produto, não é possivel excluir.";
    }
}

// 3. Verifica se o campo de pesquisa foi preenchido
$search = isset($_POST['search']) ? $_POST['search'] : '';

// 4. Consulta para listar os grupos (com ou sem filtro de pesquisa)
$sql = "SELECT * FROM grupo WHERE nome LIKE '%$search%'";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Grupo</title>
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

<?php require_once("menuAdm.php"); ?>

<div class="container">
    <div class="card mt-3 mb-3">
        <div class="card-body">
            <h2 class="card-title">Listagem de Grupo
                <a href="cadastro-grupo.php" class="botao-primary botao-sm">
                    <i class="bi bi-person-add"></i> Cadastrar Novo Grupo
                </a>
            </h2>
        </div>
    </div>

    <!-- Formulário de pesquisa -->
    <form method="POST" action="listar-grupo.php">
        <div class="mb-3">
            <label for="search" class="form-label">Buscar por Nome de Grupo</label>
            <input type="text" name="search" class="form-control" id="search" placeholder="Buscar..." value="<?= $search ?>">
            <small class="form-text text-muted">Digite o nome do grupo para buscar.</small>
        </div>
        <button type="submit" class="botao-primario">Buscar</button>
    </form>

    <br>

    <?php if ($mensagem): ?>
        <div class="alert <?= strpos($mensagem, 'Erro') === false ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Observações</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($linha = mysqli_fetch_array($resultado)): ?>
                <tr>
                    <td><?= $linha['id'] ?></td>
                    <td><?= $linha['nome'] ?></td>
                    <td><?= $linha['obs'] ?></td>
                    <td>
                        <a class="botao-alterar btn-sm" href="alterar-grupo.php?id=<?= $linha['id'] ?>">
                            <i class="bi bi-pencil"></i> Alterar
                        </a>
                        <a href="listar-grupo.php?id=<?= $linha['id'] ?>" class="botao-excluir btn-sm"
                            onclick="return confirm('Confirma exclusão?')">
                            <i class="bi bi-trash"></i> Excluir
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conexao); // Fecha a conexão com o banco de dados
?>
 <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>
</html>
