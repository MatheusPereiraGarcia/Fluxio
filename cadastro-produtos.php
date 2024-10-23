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
    <link rel="stylesheet" href="css/style.css"/>
    <title>Cadastro de Produto</title>
</head>

<body>
    <?php require_once("menu.php"); ?>
    <div class="container">

        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $mensagem ?>
            </div>
        <?php } ?>


        <h1 class="mt-2">Cadastro de Produtos</h1>
        <form method="post" action="cadastrar-produtos.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" required>
            </div>

            <div class="mb-3">
                <label for="nome" class="form-label">Quantidade</label>
                <input name="quantidade" type="number" class="form-control" id="nome" required>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Valor de Compra</label>
                <input name="vlrCompra" type="number" step="0.01" class="form-control" id="nome" required>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Valor de Venda</label>
                <input name="vlrVenda" type="number" step="0.01" class="form-control" id="nome" required>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Descrição</label>
                <textarea name="descricao" type="text" class="form-control" id="nome" rows="5" cols="100"></textarea>
            </div>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Marca</label><a href="cadastro-marca.php"
                    class="btn btn-primary btn-sm">+</a>
                <br>

                <select id="marca" name="idMarca" required>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <option value="<?= $linha['id'] ?>"><?= htmlspecialchars($linha['nome']) ?></option>
                    <?php endwhile ?>

                </select><br><br>


                <div class="mb-3">
                    <label for="nome" class="form-label">Grupo</label><a href="cadastro-grupo.php"
                        class="btn btn-primary btn-sm">+</a>
                    <br>
                    <select id="marca" name="idGrupo" required>
                        <?php while ($linhaGrupo = mysqli_fetch_assoc($resultado2)): ?>
                            <option value="<?= $linhaGrupo['id'] ?>"><?= htmlspecialchars($linhaGrupo['nome']) ?></option>
                        <?php endwhile ?>
                    </select>
                    <br><br>
                    <br>
                    <button name="salvar" type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check"></i> Salvar
                    </button>
        </form>
    </div>
    <?php require_once("footer.php"); ?>
</body>

</html>