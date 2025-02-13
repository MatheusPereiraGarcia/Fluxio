$(function () {
    /////////////////////////////////////////////////////
    // EVENTOS DE FORMULÁRIO/////////////////////////////
    /////////////////////////////////////////////////////

    // Adiciona o preço do produto selecionado no campo "Valor Un."
    $("#produto_id").on("change", function () {
        var precoUnitario = $(this).find("option:selected").data("preco"); // Pega o valor do data-preco
        $("#valorUnitario").val(precoUnitario); // Atualiza o campo "Valor Un."
    });
    var totalGlobal = 0; // Armazena o valor total global dos produtos

    function Adicionar() {
         // Validação dos campos do formulário
         if (!validaCamposFormularioProduto()) {
            return false;
        }

        var quantidade = Number($("#quantidade").val());

        // Verifica se a quantidade está fora do intervalo e ajusta
        if (quantidade < 1) {
            alert("A quantidade mínima é 1. Ajustando para o valor mínimo.");
            $("#quantidade").val(1); // Redefine para o valor mínimo
            quantidade = 1; // Atualiza a variável para o valor mínimo
        } else if (quantidade > 1000) {
            alert("A quantidade máxima é 1000. Ajustando para o valor máximo.");
            $("#quantidade").val(1000); // Redefine para o valor máximo
            quantidade = 1000; // Atualiza a variável para o valor máximo
        }

        var produto_id = $("#produto_id").val(); //form.produto_id.value
        var produto_descricao = $("#produto_id option:selected").text();
        var quantidade = Number($("#quantidade").val());
        var valorUnitario = Number($("#valorUnitario").val().replace(',', '.'));
        var valorTotalDoItem = quantidade * valorUnitario;

        // Troca de ponto para vírgula para exibir os decimais no valor
        var valorUnitarioStr = formataValorStr(valorUnitario);
        var valorTotalItemStr = formataValorStr(valorTotalDoItem);

        totalGlobal += valorTotalDoItem; // Atualiza o total global com o valor do novo item

        // Adiciona linha na tabela dinâmica
        $("#tabela").append(
            "<tr>" +
            "<input type=\"hidden\" name=\"produto_id[]\" value='" + produto_id + "' />" +
            "<input type=\"hidden\" name=\"quantidade[]\" value='" + quantidade + "' />" +
            "<input type=\"hidden\" name=\"valor[]\" value='" + valorUnitario + "' />" +
            "<td>" + produto_descricao + "</td>" +
            "<td class=\"text-right\" id=\"quantidade\">" + quantidade + "</td>" +
            "<td class=\"text-right\" id=\"valorUnitario\">" + valorUnitarioStr + "</td>" +
            "<td class=\"text-right\" id=\"valorTotalItem\">" + valorTotalItemStr + "</td>" +
            "<td class=\"text-center\">" +
            "<button type=\"button\" class=\"btn btn-danger btn-sm btnExcluir\">" + "<img src='img/lixo.png' alt='Minha Figura'>" +
            "<i class=\"far fa-trash-alt\"></i>" +
            "</button>" +
            "</td>" +
            "</tr>"
        );

        $(".btnExcluir").bind("click", Excluir);

        limpaCampos();
        recalculaValores();
    }

    function Excluir() {
        var par = $(this).parent().parent(); // tr
        var valorItem = parseFloat(par.find('#valorTotalItem').text().replace(',', '.'));
        totalGlobal -= valorItem; // Subtrai o valor do item removido
        par.remove();
        recalculaValores();
    }

    function AplicarDesconto() {
        $(document).ready(function () {
            // Remover qualquer evento de clique previamente vinculado
            $("#btnAplicarDesconto").off("click");

            // Vincula o evento de clique apenas uma vez
            $("#btnAplicarDesconto").click(function () {
                var totalVenda = totalGlobal;  // Valor total da venda (totalGlobal sem desconto)
                var desconto = parseFloat($("input[name='desconto']").val().replace(',', '.'));  // Valor do desconto

                // Verifica se o valor do desconto é válido
                if (isNaN(desconto) || desconto < 0) {
                    alert("O valor do desconto deve ser um número válido e não pode ser negativo.");
                    return false;
                }

                // Verifica se o desconto é maior que o total da venda
                if (desconto > totalVenda) {
                    alert("O valor do desconto não pode ser maior que o total da venda.");
                    $("#resumoValorFinal").text(formataValorStr(totalGlobal));
                    return false;
                }

                // Se o desconto for válido, atualiza o valor com o desconto aplicado
                var totalComDesconto = totalVenda - desconto;
                $("#resumoValorTotal").text(totalComDesconto.toFixed(2).replace('.', ','));  // Exibe o total com o desconto
                $("#totalVenda").val(totalComDesconto.toFixed(2)); // Atualiza o campo oculto do total da venda

                // Exibe o valor do desconto no resumo
                $("#resumoSoma").text(desconto.toFixed(2).replace('.', ',')); // Exibe o valor do desconto

                recalculaValores(); // Atualiza os valores finais após o desconto
            });
        });
    }

    /////////////////////////////////////////////////////
    // FUNÇÕES AUXILIARES ///////////////////////////////
    /////////////////////////////////////////////////////

    // Valida os campos do form de Produtos
    function validaCamposFormularioProduto() {
        if (form.produto_id.value == '') {
            alert('O campo produto é obrigatório.')
            form.produto_id.focus()
            return false;
        } else if (form.quantidade.value == '') {
            alert('O campo quantidade é obrigatório.')
            form.quantidade.focus()
            return false;
        } else if (form.valorUnitario.value == '') {
            alert('O campo valor unitário é obrigatório.')
            form.valorUnitario.focus()
            return false;
        }

        return true;
    }

    function limpaCampos() {
        form.produto_id.value = '';
        form.quantidade.value = '1';
        form.valorUnitario.value = '';
    }

    function recalculaValores() {
        var conteudo = document.getElementById("tabela").rows; // Pega todas as 'tr' da tabela

        var somaProdutos = 0;
        for (i = 1; i < conteudo.length; i++) { // Começa a partir de 1, pq a linha 0 é o cabeçalho
            var valorItemStr = conteudo[i].querySelector(`#valorTotalItem`).textContent; // Pega o valor total do item
            somaProdutos += Number(valorItemStr.replace(',', '.')); // Converte pra numérico e soma com somaProdutos
        }

        // Atualiza o resumo da soma dos produtos
        $("#resumoSoma").text(formataValorStr(somaProdutos)); // Exibe o total dos produtos (antes do desconto)

        // Desconto
        var desconto = Number(form.desconto.value.replace(',', '.'));

        // Calcula o valor total (com desconto, se houver)
        var valorFinal = somaProdutos - desconto;

        // Exibe o valor total após o desconto
        $("#resumoValorFinal").text(formataValorStr(valorFinal));

        // Atualiza o campo oculto com o valor total da venda
        $("#totalVenda").val(valorFinal.toFixed(2)); // Atualiza o valor total no campo oculto
    }

    function formataValorStr(valor) {
        return valor.toFixed(2).toString().replace('.', ',');
    }

    $(".btnExcluir").bind("click", Excluir);
    $("#btnAdicionar").bind("click", Adicionar);
    $("#btnAplicarDesconto").bind("click", AplicarDesconto);
});
