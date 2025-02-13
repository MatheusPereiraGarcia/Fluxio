<?php require_once("verificaAdm.php"); ?>
<?php

//1. Conectar no BD (IP, usuário, senha, nome do banco)
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');
?>
<?php
//2. Prepara a SQL
$sql = "select * from marca";
$sql2 = "select * from grupo";

//3. Executa a SQL
$resultado = mysqli_query($conexao, $sql);
$resultado2 = mysqli_query($conexao, $sql2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Cadastro de Produto</title>
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


        <h1 class="mt-2">Cadastro de Produtos</h1>
        <form method="post" action="cadastrar-produtos.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" placeholder="Digite o nome do produto" required>
            </div>

            <div class="mb-3">
                <label for="vlrCompra" class="form-label">Valor de Compra</label>
                <input name="vlrCompra" type="number" step="0.01" class="form-control" id="vlrCompra" placeholder="Informe o valor de compra" required>
            </div>

            <div class="mb-3">
                <label for="vlrVenda" class="form-label">Valor de Venda</label>
                <input name="vlrVenda" type="number" step="0.01" class="form-control" id="vlrVenda" placeholder="Informe o valor de venda" required>
            </div>

            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label><a href="cadastro-marca.php" class="botao-primary botao-sm">+</a>
                <br>
                <select id="marca" name="idMarca" class="form-select" required>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <option value="<?= $linha['id'] ?>"><?= htmlspecialchars($linha['nome']) ?></option>
                    <?php endwhile ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="grupo" class="form-label">Grupo</label><a href="cadastro-grupo.php" class="botao-primary botao-sm">+</a>
                <br>
                <select id="grupo" name="idGrupo" class="form-select" required>
                    <?php while ($linhaGrupo = mysqli_fetch_assoc($resultado2)): ?>
                        <option value="<?= $linhaGrupo['id'] ?>"><?= htmlspecialchars($linhaGrupo['nome']) ?></option>
                    <?php endwhile ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" id="descricao" rows="5" placeholder="Descreva o produto aqui" ></textarea>
            </div>
            <br>

            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
        </form>
    </div>

    <!-- Footer -->
    <?php require_once("footer.php"); ?>
</body>

</html>
