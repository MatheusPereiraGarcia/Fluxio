<?php require_once("verificaAutenticacao.php"); ?>
<?php
//1. Conectar no BD (IP, usuário, senha, nome do banco)
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

//Se foi clicado no botão 'excluir'
if (isset($_GET['id'])) {
    $sql = "DELETE FROM produtos WHERE id = " . $_GET['id'];
    mysqli_query($conexao, $sql);
?>
<?php
}

//2. Prepara a SQL
$sql = "SELECT * FROM produtos";

//3. Executa a SQL
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

    <?php require_once("menu.php"); ?>

    <div class="container">

        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h2 class="card-title">Listagem de Produtos
                    <a href="cadastro-produtos.php" class="btn btn-primary btn-sm">
                        <i class="bi bi-person-add"></i>

                    </a>
                </h2>
            </div>
        </div>

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Valor de Compra</th>
                    <th scope="col">Valor de Venda</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Descrição</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($linha = mysqli_fetch_array($resultado)): ?>
                    <tr>
                        <td><?= $linha['id'] ?></td>
                        <td><?= $linha['nome'] ?></td>
                        <td><?= $linha['quantidade'] ?></td>
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
                            <a class="btn btn-warning" href="alterar-produtos.php?id=<?= $linha['id'] ?>"> <i
                                    class="bi bi-pencil"></i>Alterar</a>


                            <a href="listar-produtos.php?id=<?= $linha['id'] ?> " class="btn btn-danger"
                                onclick="return confirm('confirma exclusão?')">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>

        </table>
    </div>
    <?php require_once("footer.php"); ?>
</body>

</html>