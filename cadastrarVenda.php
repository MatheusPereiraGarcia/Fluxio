<?php require_once("verificaAutenticacao.php"); ?>
<?php
session_start();
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os dados para inserir no BD
    if (!isset($_POST['cliente_id']) || empty($_POST['cliente_id'])) {
        header('Location: venda.php?sucesso=false&mensagem=Cliente%20não%20selecionado');
        exit();
    }

    $tipoRecebimento = $_POST['tipoRecebimento'];
    $desconto = floatval($_POST['desconto']); // Garantir que é numérico
    $vlrFinal = floatval($_POST['total']); // Garantir que é numérico
    $idCliente = $_POST['cliente_id'];

    // Recuperar o ID do usuário logado da sessão
    $idUsuario = $_SESSION['id'];

    // Calcular o vlrTotal com o desconto
    $vlrTotal = $vlrFinal + $desconto;

    // Verificar se os dados necessários foram recebidos
    if (empty($tipoRecebimento) || empty($vlrFinal) || empty($idCliente)) {
        header('Location: venda.php?sucesso=false&mensagem=Todos%20os%20campos%20devem%20ser%20preenchidos');
        exit();
    }

    // Prepara a SQL para inserir a venda (incluindo o idUsuario)
    $sql = "INSERT INTO venda (tipoRecebimento, vlrTotal, desconto, vlrFinal, idCliente, idUsuario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Verificar se a preparação foi bem-sucedida
    if (!$stmt) {
        header('Location: venda.php?sucesso=false&mensagem=Erro%20ao%20preparar%20a%20consulta');
        exit();
    }

    // Vincular os parâmetros e executar
    mysqli_stmt_bind_param($stmt, 'sdddii', $tipoRecebimento, $vlrTotal, $desconto, $vlrFinal, $idCliente, $idUsuario);

    if (mysqli_stmt_execute($stmt)) {
        // Pega o ID da venda inserida
        $idVenda = mysqli_insert_id($conn);

        // Agora, insira os produtos na tabela venda_produto
        if (!empty($_POST['produto_id']) && !empty($_POST['quantidade']) && !empty($_POST['valor'])) {
            $produto_ids = $_POST['produto_id'];
            $quantidades = $_POST['quantidade'];
            $valores = $_POST['valor'];

            // Loop para inserir cada produto relacionado à venda
            foreach ($produto_ids as $index => $produto_id) {
                $quantidade = $quantidades[$index];
                $valorUnitario = $valores[$index];

                // Inserir o produto na tabela venda_produto
                $sqlProduto = "INSERT INTO venda_produto (idVenda, idProduto, quantidade, vlrUnit) VALUES (?, ?, ?, ?)";
                $stmtProduto = mysqli_prepare($conn, $sqlProduto);

                if (!$stmtProduto) {
                    header('Location: venda.php?sucesso=false&mensagem=Erro%20ao%20preparar%20consulta%20para%20inserir%20produto');
                    exit();
                }

                // Vincular os parâmetros e executar
                mysqli_stmt_bind_param($stmtProduto, 'iiid', $idVenda, $produto_id, $quantidade, $valorUnitario);

                if (!mysqli_stmt_execute($stmtProduto)) {
                    header('Location: venda.php?sucesso=false&mensagem=Erro%20ao%20inserir%20produto%20na%20venda');
                    exit();
                }
            }
            
            // Mensagem de sucesso
            header('Location: venda.php?sucesso=true&mensagem=Venda%20conclu%C3%ADda%20com%20sucesso!');
            exit();
        } else {
            header('Location: venda.php?sucesso=false&mensagem=Nenhum%20produto%20selecionado');
            exit();
        }
    } else {
        header('Location: venda.php?sucesso=false&mensagem=Erro%20ao%20registrar%20a%20venda');
        exit();
    }
}

mysqli_close($conn); // Fecha a conexão com o banco de dados
?>
