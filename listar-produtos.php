<?php require_once("verificaAdm.php"); ?>
<?php
// Conexão com o banco de dados
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Mensagem de retorno
$mensagem = "";

// Se foi clicado no botão 'excluir'
if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];
    $sql = "DELETE FROM produtos WHERE id = " . $idProduto;
    if (mysqli_query($conexao, $sql)) {
        $mensagem = "Produto excluído com sucesso.";
    } else {
        $mensagem = "Erro ao excluir produto.";
    }
}

// Verifica se o campo de pesquisa foi preenchido
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Substitui vírgula por ponto caso o usuário tenha digitado um valor com vírgula
if (!empty($search)) {
    // Substituir vírgulas por pontos (para valores numéricos de preços)
    $search = str_replace(',', '.', $search);
}

// Consulta para listar todos os produtos (com ou sem filtro de pesquisa)
$sql = "SELECT * FROM produtos WHERE nome LIKE '%$search%' OR vlrCompra LIKE '%$search%' OR vlrVenda LIKE '%$search%' OR descricao LIKE '%$search%'";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css"/>
</head>

<body>

    <?php require_once("menuAdm.php"); ?>

    <div class="container">

        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h2 class="card-title">Relatório do Estoque
                    <a href="cadastro-produtos.php" class="botao-primary botao-sm">
                        <i class="bi bi-person-add"></i> Cadastrar Novo
                    </a>
                </h2>
            </div>
        </div>

        <!-- Formulário de pesquisa -->
        <form method="POST" action="listar-produtos.php">
            <div class="mb-3">
                <label for="search" class="form-label">Buscar por Nome, Valor de Compra, Valor de Venda ou Descrição</label>
                <input type="text" name="search" class="form-control" id="search" placeholder="Buscar..." value="<?= htmlspecialchars($search) ?>">
                <small class="form-text text-muted">Digite o nome, valor de compra, valor de venda ou descrição do produto para buscar.</small>
            </div>
            <button type="submit" class="botao-primario">Buscar</button>
        </form>

        <br>

        <!-- Exibe mensagem de sucesso ou erro -->
        <?php if ($mensagem): ?>
            <div class="alert <?= strpos($mensagem, 'Erro') === false ? 'alert-success' : 'alert-danger' ?>" role="alert">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <!-- Tabela de Produtos -->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor de Compra</th>
                    <th scope="col">Valor de Venda</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($linha = mysqli_fetch_array($resultado)): ?>
                    <tr>
                        <td><?= $linha['id'] ?></td>
                        <td><?= $linha['nome'] ?></td>
                        <td><?= $linha['vlrCompra'] ?></td>
                        <td><?= $linha['vlrVenda'] ?></td>
                        <td>
                            <?php
                            $sql1 = "SELECT * FROM marca WHERE id= " . $linha['idMarca'];
                            $resultado1 = mysqli_query($conexao, $sql1);
                            $marca = mysqli_fetch_assoc($resultado1);
                            echo $marca['nome'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $sql2 = "SELECT * FROM grupo WHERE id= " . $linha['idGrupo'];
                            $resultado2 = mysqli_query($conexao, $sql2);
                            $grupo = mysqli_fetch_assoc($resultado2);
                            echo $grupo['nome'];
                            ?>
                        </td>
                        <td><?= $linha['descricao'] ?></td>
                        <td>
                            <a class="botao-alterar btn-sm" href="alterar-produtos.php?id=<?= $linha['id'] ?>">
                                <i class="bi bi-pencil"></i> Alterar
                            </a>
                            <a href="listar-produtos.php?id=<?= $linha['id'] ?>" class="botao-excluir btn-sm" onclick="return confirm('Confirma exclusão?')">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php require_once("footer.php"); ?>
</body>

</html>

<?php
mysqli_close($conexao); // Fecha a conexão com o banco de dados
?>
