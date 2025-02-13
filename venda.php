<?php


require_once("verificaAutenticacao.php");
require_once("conexao.php");

$sql = "SELECT * FROM cliente";
$resultado = mysqli_query($conn, $sql);
$sql2 = "SELECT * FROM produtos";
$resultado2 = mysqli_query($conn, $sql2);
// Verifica se há um parâmetro 'sucesso' na URL
if (isset($_GET['sucesso'])) {
    $sucesso = $_GET['sucesso'] == 'true';  // Se sucesso for 'true', exibe mensagem de sucesso
    $mensagem = isset($_GET['mensagem']) ? urldecode($_GET['mensagem']) : '';  // Obtém a mensagem da URL

    // Exibe a mensagem
    if ($sucesso) {
        echo "<div class='alert alert-success'>$mensagem</div>";
    } else {
        echo "<div class='alert alert-danger'>$mensagem</div>";
    }
}

?>


<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <?php require_once("menu.php"); ?>
    <div class="container">
        <form name="form" action="cadastrarVenda.php" method="post">

            <div class="row">
                <!-- Resumo da venda -->
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Resumo</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <span>Soma dos Produtos</span>
                            <span class="text-muted">
                                <div id="resumoSoma">0,00</div>
                            </span>
                        </li>
                        <div class="input-group text-right">
                            <div class="input-group-prepend">
                                <div class="input-group-text font-weight-bold text-success">Desconto R$</div>
                            </div>
                            <input type="text" class="form-control text-right" name="desconto" placeholder="0,00" >
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" id="btnAplicarDesconto"><i
                                        class="fas fa-check">-</i></button>
                            </div>
                        </div>
                        <div class="input-group-prepend">
                            <div class="mb-3">
                                <label for="tipoRecebimento" class="form-label">Tipo de Pagamento</label>
                                <select id="tipoRecebimento" name="tipoRecebimento" class="form-select" required>
                                    <option value="" selected disabled>-- Selecione --</option>
                                    <option value="à vista">À vista</option>
                                    <option value="cartao_credito">Cartão de Crédito</option>
                                    <option value="cartao_debito">Cartão de Débito</option>
                                    <option value="boleto">Boleto Bancário</option>
                                    <option value="transferencia">Transferência Bancária</option>
                                    <option value="pix">PIX</option>
                                </select>
                            </div>
                        </div>
                        <li class="list-group-item d-flex justify-content-between">
                            <h6 class="my-0">Total (R$)</h6>
                            <strong>
                                <div id="resumoValorFinal">0,00</div>
                            </strong>
                        </li>
                    </ul>
                    <div class="input-group">
                        <button type="submit" name="finalizar" value="finalizar"
                        href="compra-concluida.html" class="botao-primario btn-lg btn-block">Finalizar
                        </button>
                    </div>
                </div>

                <!-- Dados do cliente e produtos -->
                <div class="col-md-8 order-md-1">
                    <div class="row">
                        <div class="col-md-9">
                        <a href="cadastro-cliente.php"
                        class="botao-primary botao-sm">+</a><label for="cliente_id" class="font-weight-bold">‎ ‎ Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="custom-select" required>
                                <option value="" selected disabled>--selecione--</option>
                                <?php while ($linhaCliente = mysqli_fetch_assoc($resultado)): ?>
                                    <option value="<?= $linhaCliente['id'] ?>">
                                        <?= htmlspecialchars($linhaCliente['nome']) ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <hr>

                    <h4 class="mb-3">Produtos</h4>

                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="produto_id">Produto</label>
                                <select name="produto_id[]" id="produto_id" class="custom-select">
                                    <option value="" selected disabled>--selecione--</option>
                                    <?php while ($linhaProduto = mysqli_fetch_assoc($resultado2)): ?>
                                        <option value="<?= $linhaProduto['id'] ?>"
                                            data-preco="<?= number_format($linhaProduto['vlrVenda'], 2, ',', '.') ?>">
                                            <?= htmlspecialchars($linhaProduto['nome']) ?>
                                        </option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="qtd">Qtd.</label>
                                    <input type="number" id="quantidade" name="quantidade[]" class="form-control"
                                        min="1" max="1000" value="1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="valorUnitario">Valor Un.</label>
                                    <div class="input-group mb-2 text-right">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">R$</div>
                                        </div>
                                        <input type="text" id="valorUnitario" name="valor[]" placeholder="0,00"
                                            class="form-control text-right" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-secondary" id="btnAdicionar">Adicionar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4 class="mb-3">Lista de Produtos</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="tabela" class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col" class="text-right">Qtd.</th>
                                        <th scope="col" class="text-right">Preço Un.</th>
                                        <th scope="col" class="text-right">Preço Total</th>
                                        <th scope="col" class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Conteúdo dinâmico -->
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <hr class="mb-4">
                </div>
            </div>

            <!-- Campo oculto para o total da venda -->
            <input  name="total" type="hidden" id="totalVenda" value="0.00" />

        </form>
    </div>
    <?php require_once("footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/compra-venda.js"></script>


</body>