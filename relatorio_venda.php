<?php require_once("verificaAdm.php"); ?>
<?php

require_once("conexao.php");

// Função para formatar a data no formato brasileiro (DD/MM/YYYY)
function formatarData($data)
{
    $date = new DateTime($data);
    return $date->format('d/m/Y');
}

// Verificar se o formulário foi enviado com o método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegar as datas do formulário ou usar a data atual como padrão
    $dataInicio = $_POST['dataInicio'] ?? date('Y-m-01'); // Primeiro dia do mês atual
    $dataFim = $_POST['dataFim'] ?? date('Y-m-d');        // Data atual
} else {
    // Se o formulário não foi enviado, definir datas padrão
    $dataInicio = date('Y-m-01'); // Primeiro dia do mês
    $dataFim = date('Y-m-d');     // Data atual
}

// Consulta SQL para obter os dados de vendas no período
$sql = "SELECT 
            DATE(dtVenda) AS Data_Venda, 
            SUM(vlrTotal) AS Total_Vendas, 
            SUM(desconto) AS Total_Descontos, 
            SUM(vlrFinal) AS Total_Final
        FROM venda
        WHERE DATE(dtVenda) BETWEEN DATE(?) AND DATE(?)
        GROUP BY DATE(dtVenda)
        ORDER BY Data_Venda";

// Preparar e executar a consulta
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $dataInicio, $dataFim);

if (mysqli_stmt_execute($stmt)) {
    // Buscar os resultados da consulta
    $result = mysqli_stmt_get_result($stmt);
    $vendas = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $_SESSION['mensagem'] = "Erro ao buscar dados de vendas.";
    $_SESSION['mensagem_tipo'] = "alert alert-danger";
    header('Location: relatorio_venda.php');
    exit();
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <?php require_once("menuAdm.php"); ?>
    <div class="container mt-5">
        <h1>Relatório de Vendas</h1>



        <!-- Exibir Mensagens de Erro ou Sucesso -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert <?php echo $_SESSION['mensagem_tipo']; ?>" role="alert">
                <?php echo $_SESSION['mensagem']; ?>
                <?php unset($_SESSION['mensagem']);
                unset($_SESSION['mensagem_tipo']); ?>
            </div>
        <?php endif; ?>

        <!-- Filtro de Período -->
        <form method="POST" action="relatorio_venda.php" class="mb-4">
            <div class="form-row">
                <div class="col">
                    <label for="dataInicio">Data de Início</label>
                    <input type="date" name="dataInicio" max="<?php echo date('Y-m-d') ?>" value="<?php echo date('Y-m-d', strtotime($dataInicio)); ?>"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="dataFim">Data de Fim</label>
                    <input type="date" name="dataFim" max="<?php echo date('Y-m-d') ?>" value="<?php echo date('Y-m-d', strtotime($dataFim)); ?>"
                        class="form-control">
                </div>
                <div class="col">
                    <button type="submit" class="botao-primario">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de Vendas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Data da Venda</th>
                    <th>Total de Vendas</th>
                    <th>Total de Descontos</th>
                    <th>Total Final</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($vendas) > 0): ?>
                    <?php foreach ($vendas as $venda): ?>
                        <tr>
                            <td><?php echo formatarData($venda['Data_Venda']); ?></td>
                            <td>R$ <?php echo number_format($venda['Total_Vendas'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($venda['Total_Descontos'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($venda['Total_Final'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma venda encontrada para o período selecionado.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>