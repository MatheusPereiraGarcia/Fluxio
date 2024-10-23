<?php require_once("verificaAutenticacao.php"); ?>
<?php

//1.Conectar no BD(IP, usuario, senha, nome do banco)
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');


if (isset($_POST['salvar'])) {
    //2. Pegar os dados para inserir no BD
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $idMarca = $_POST['idMarca'];
    $idGrupo = $_POST['idGrupo'];
    $vlrCompra = $_POST['vlrCompra'];
    $vlrVenda = $_POST['vlrVenda'];
    $descricao = $_POST['descricao'];


    //3. Prepara a SQL
    $sql = "UPDATE produtos
    SET nome = '$nome', quantidade = '$quantidade', idMarca ='$idMarca', idGrupo ='$idGrupo'  ,vlrCompra = '$vlrCompra'  , vlrVenda ='$vlrVenda', descricao = '$descricao'
    WHERE id = '$id'";

    //4. Executar a SQL
    mysqli_query($conexao, $sql);


    //5. Mostrar mensagem ao usuario
    $mensagem = "Produto Alterado";

    header('Location: listar-produtos.php');
    exit;
}
$sql = "SELECT * FROM produtos WHERE id = " . $_GET['id'];
$resultado = mysqli_query($conexao, $sql);
$produtos = mysqli_fetch_array($resultado);



$sqlMarca = "select * from marca";
$sqlGrupo = "select * from grupo";

//3. Executa a SQL
$resultadoMarca = mysqli_query($conexao, $sqlMarca);
$resultadoGrupo = mysqli_query($conexao, $sqlGrupo);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css"/>
    <title>Alterar Produto</title>
</head>

<body>

    <?php require_once("menu.php"); ?>


    <div class="container">
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $mensagem ?>
            </div>
        <?php } ?>


        <h1 class="mt-2">Produto Alterar</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?= $produtos['id'] ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome" required
                    value="<?php echo $produtos['nome'] ?>">
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Quantidade</label>
                <input name="quantidade" type="text" class="form-control" id="nome" required
                    value="<?php echo $produtos['quantidade'] ?>">
            </div>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Valor de Compra</label>
                <input name="vlrCompra" type="text" class="form-control" id="nome" required
                    value="<?php echo $produtos['vlrCompra'] ?>">
            </div>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Valor de Venda</label>
                <input name="vlrVenda" type="text" class="form-control" id="nome" required
                    value="<?php echo $produtos['vlrVenda'] ?>">
            </div>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Marca</label>
                <select id="marca" name="idMarca" required>
                    <?php while ($linhaMarca = mysqli_fetch_assoc($resultadoMarca)): ?>
                        <option value="<?= $linhaMarca['id'] ?>" <?= $linhaMarca['id'] == $produtos['idMarca'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($linhaMarca['nome']) ?>
                        </option>
                    <?php endwhile ?>

                </select>
            </div>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Grupo</label>
                <select id="grupo" name="idGrupo" required>
                    <?php while ($linhaGrupo = mysqli_fetch_assoc($resultadoGrupo)): ?>
                        <option value="<?= $linhaGrupo['id'] ?>" <?= $linhaGrupo['id'] == $produtos['idGrupo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($linhaGrupo['nome']) ?>
                        </option>
                    <?php endwhile ?>
                </select>
            </div>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Descrição</label>
                <input name="descricao" type="text" class="form-control" id="nome"
                    value="<?php echo $produtos['descricao'] ?>">
            </div>
            <br>

            <br>
            <button name="salvar" type="submit" class="btn btn-primary">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
            <a type="button" href="listar-produtos.php" class="btn btn-warning">Voltar</a>
        </form>
    </div>
    <?php require_once("footer.php"); ?>
</body>

</html>