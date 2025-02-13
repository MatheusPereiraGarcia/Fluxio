<?php require_once("verificaAdm.php"); ?>
<?php

session_start();
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $idMarca = $_POST['idMarca'];
    $idGrupo = $_POST['idGrupo'];
    $vlrCompra = $_POST['vlrCompra'];
    $vlrVenda = $_POST['vlrVenda'];
    $descricao = $_POST['descricao'];

    // Normaliza os valores monetários: substitui vírgula por ponto
    $vlrCompra = str_replace(',', '.', $vlrCompra); 
    $vlrVenda = str_replace(',', '.', $vlrVenda);

    // Valida se os valores são numéricos
    if (is_numeric($vlrCompra) && is_numeric($vlrVenda) && $vlrCompra >= 0 && $vlrVenda >= 0) {
        // Formata os valores para 2 casas decimais
        $vlrCompra = number_format((float)$vlrCompra, 5, '.', '');
        $vlrVenda = number_format((float)$vlrVenda, 2, '.', '');

        // Prepara a consulta SQL para inserir os dados
        $sql = "INSERT INTO produtos (nome, idMarca, idGrupo, vlrCompra, vlrVenda, descricao) 
                VALUES ('$nome', '$idMarca', '$idGrupo', '$vlrCompra', '$vlrVenda', '$descricao')";

        // Executa a consulta SQL
        if (mysqli_query($conn, $sql)) {
            // Armazenar a mensagem de sucesso na sessão
            $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
            $_SESSION['mensagem_tipo'] = "alert alert-success"; // Tipo de alerta para sucesso
        } else {
            // Armazenar a mensagem de erro na sessão
            $_SESSION['mensagem'] = "Erro ao cadastrar produto: " . mysqli_error($conn);
            $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        }
    } else {
        // Se os valores de compra ou venda não forem numéricos, exibe uma mensagem de erro
        $_SESSION['mensagem'] = "Por favor, insira valores válidos para os campos de preço (compra e venda).";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
    }

    // Redireciona de volta para a página de cadastro de produtos
    header('Location: cadastro-produtos.php');
    exit(); // Evita que o script continue
}

mysqli_close($conn);
?>