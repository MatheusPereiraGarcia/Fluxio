<?php
require_once("verificaAdm.php");

// Conexão com o banco de dados
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Verificar se a conexão foi bem-sucedida
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}




// Fechar a conexão com o banco
mysqli_close($conexao);
?>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Fluxio ADM</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="menu">
        <?php require_once("menuAdm.php"); ?>
    </div>

    <div class="container mt-5">
        <!-- Introdução ao Sistema -->
        <h1>Bem-vindo ao Fluxio</h1>
        <p>
            O <strong>Fluxio</strong> é um sistema simples para a gestão de pequenas empresas. 
            Aqui, você pode gerenciar o estoque, registrar vendas e acessar relatórios detalhados para 
            apoiar as tomadas de decisão no seu negócio. Explore as funcionalidades e veja como o sistema 
            pode simplificar suas operações.
        </p>

        <!-- Tutorial Rápido -->
        <h2 class="mt-5">Como Usar o Sistema</h2>
        <p>
            Para facilitar seu uso, preparamos um guia rápido sobre as principais funcionalidades do sistema:
        </p>
        <ul>
            <li>
                <strong>Cadastro de Produtos:</strong> Vá até o menu, clique em "Cadastros", selecione produtos e preencha os dados como nome, preço de compra e venda, descrição e categorias.
            </li>
            <li>
                <strong>Registro de Vendas:</strong> Entre como usuario restrito, insira os produtos comprados, a quantidade e o tipo de pagamento. O sistema calculará o total automaticamente.
            </li>
            <li>
                <strong>Relatórios:</strong> Acesse os relatórios no menu, clicando em relatórios e selecionando o relatório que deseja, seja uma listagem de usuario de clientes ou vendas por periodo.
            </li>
        </ul>


        
        
    </div>

    <?php require_once("footer.php"); ?>
</body>

</html>
