<?php require_once("verificaAdm.php"); ?>
<?php
// Conexão com o banco de dados
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Mensagem de retorno
$mensagem = "";

// Verifica se foi clicado no botão 'excluir'
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Verifica se existem vendas associadas ao cliente
    $sqlCheck = "SELECT COUNT(*) as total FROM venda WHERE idCliente = $idCliente";
    $resultadoCheck = mysqli_query($conexao, $sqlCheck);
    $rowCheck = mysqli_fetch_assoc($resultadoCheck);

    if ($rowCheck['total'] > 0) {
        $mensagem = "Erro: Não é possível excluir o cliente, pois ele está associado a vendas.";
    } else {
        // Excluir cliente
        $sqlDelete = "DELETE FROM cliente WHERE id = $idCliente";
        if (mysqli_query($conexao, $sqlDelete)) {
            $mensagem = "Cliente excluído com sucesso.";
        } else {
            $mensagem = "Erro ao excluir cliente.";
        }
    }
}

// Verifica se o campo de pesquisa foi preenchido
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Consulta para listar todos os clientes (com ou sem filtro de pesquisa)
$sql = "SELECT * FROM cliente WHERE nome LIKE '%$search%' OR email LIKE '%$search%' OR cpf LIKE '%$search%'";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Clientes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

    <?php require_once("menuAdm.php"); ?>

    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h2 class="card-title">Listagem de Clientes
                    <a href="cadastro-produtos.php" class="botao-primary botao-sm">
                        <i class="bi bi-person-add"></i> Cadastrar Novo
                    </a>
                </h2>
            </div>
        </div>

        <!-- Formulário de pesquisa -->
        <form method="POST" action="listar-cliente.php">
            <div class="mb-3">
                <label for="search" class="form-label">Buscar por Nome, Email ou CPF</label>
                <input type="text" name="search" class="form-control" id="search" placeholder="Buscar..." value="<?= $search ?>">
                <small class="form-text text-muted">Digite o nome, email ou CPF do cliente para buscar.</small>
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
                    <th scope="col">Email</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data de Nascimento</th>
                    <th scope="col">CEP</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">UF</th>
                    <th scope="col">Rua</th>
                    <th scope="col">Número</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($linha = mysqli_fetch_array($resultado)): ?>
                    <tr>
                        <td><?= $linha['id'] ?></td>
                        <td><?= $linha['nome'] ?></td>
                        <td><?= $linha['email'] ?></td>
                        <td><?= $linha['cpf'] ?></td>
                        <td><?= $linha['dtNasc'] ?></td>
                        <td><?= $linha['cep'] ?></td>
                        <td><?= $linha['cidade'] ?></td>
                        <td><?= $linha['uf'] ?></td>
                        <td><?= $linha['rua'] ?></td>
                        <td><?= $linha['numero'] ?></td>
                        <td>
                            <a class="botao-alterar btn-sm" href="alterar-cliente.php?id=<?= $linha['id'] ?>">
                                <i class="bi bi-pencil"></i> Alterar
                            </a>
                            <a href="listar-cliente.php?id=<?= $linha['id'] ?>" class="botao-excluir btn-sm"
                                onclick="return confirm('Confirma exclusão?')">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>

<?php
mysqli_close($conexao); // Fecha a conexão com o banco de dados
?>

