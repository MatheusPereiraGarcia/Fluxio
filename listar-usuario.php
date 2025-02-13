<?php
require_once("verificaAdm.php");
// 1. Conectar no BD (IP, usuário, senha, nome do banco)
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Se foi clicado no botão 'excluir'
if (isset($_GET['id'])) {
    $sql = "DELETE FROM usuario WHERE id = " . $_GET['id'];
    mysqli_query($conexao, $sql);
}
?>

<?php
// 2. Verifica se existe o termo de busca
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Definindo a variável para a cláusula SQL
$sql = "SELECT * FROM usuario WHERE nome LIKE '%$search%' OR email LIKE '%$search%'";

// 3. Verifica se a pesquisa inclui 'Administrador' ou 'Usuário' e ajusta a consulta
if (strtolower($search) === 'administrador') {
    $sql .= " OR tipo = 1"; // 1 é o tipo para "Administrador"
} elseif (strtolower($search) === 'usuário' || strtolower($search) === 'usuario') {
    $sql .= " OR tipo = 0"; // 0 é o tipo para "Usuário"
}

// 4. Executa a SQL
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Usuários</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <?php require_once("menuAdm.php"); ?>
    <div class="container">

        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h2 class="card-title">Listagem de Usuários
                    <a href="cadastro-usuario.php" class="botao-primary botao-sm">
                        <i class="bi bi-person-add"></i> Cadastrar Novo
                    </a>
                </h2>
            </div>
        </div>

        <!-- Formulário de busca -->
        <form method="POST" action="listar-usuario.php">
            <div class="mb-3">
                <label for="search" class="form-label">Buscar por Nome, E-mail ou Tipo</label>
                <input type="text" name="search" class="form-control" id="search" placeholder="Buscar..."
                    value="<?= $search ?>">
                <small class="form-text text-muted">Para buscar por tipo de usuário, digite "Administrador" ou
                    "Usuário".</small>
            </div>
            <button type="submit" class="botao-primario">Buscar</button>
        </form>

        <br>

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tipo</th> <!-- Coluna para exibir tipo -->
                    <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($linha = mysqli_fetch_array($resultado)): ?>
                    <tr>
                        <td><?= $linha['id'] ?></td>
                        <td><?= $linha['nome'] ?></td>
                        <td><?= $linha['email'] ?></td>

                        <!-- Exibe o tipo do usuário -->
                        <td>
                            <?php
                            // Exibe "Administrador" para tipo 1, e "Usuário" para tipo 0
                            $tipoUsuario = $linha['tipo'] == 1 ? 'Administrador' : 'Usuário';
                            echo $tipoUsuario;
                            ?>
                        </td>

                        <td>
                            <a class="botao-alterar" href="alterar-usuario.php?id=<?= $linha['id'] ?>"> <i
                                    class="bi bi-pencil"></i> Alterar</a>

                            <a href="listar-usuario.php?id=<?= $linha['id'] ?>" class="botao-excluir"
                                onclick="return confirm('Confirma exclusão?')">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>

        </table>
    </div>
    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>

<?php
mysqli_close($conexao); // Fecha a conexão com o banco de dados
?>