<?php require_once("verificaAutenticacao.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Cadastro de Clientes</title>

    <!-- Incluindo o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluindo o jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function () {
            // Máscara para o campo de CPF
            $('#cpf').mask('000.000.000-00', { reverse: true });

            // Máscara para o campo de Telefone
            $('#fone').mask('00 (00) 00000-0000');

            // Máscara para o campo de CEP
            $('#cep').mask('00000-000');

            // Preenchendo o select de UF com os estados do Brasil
            var ufs = [
                "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA",
                "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN",
                "RS", "RO", "RR", "SC", "SP", "SE", "TO"
            ];

            var ufSelect = $('#uf');
            ufs.forEach(function (uf) {
                ufSelect.append('<option value="' + uf + '">' + uf + '</option>');
            });
        });

        $(document).ready(function () {
            // Quando o campo CEP for preenchido
            $('#cep').on('blur', function () {
                var cep = $(this).val().replace(/\D/g, ''); // Remove tudo que não for número
                if (cep.length === 8) {
                    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                        if (data.erro) {
                            alert('CEP não encontrado.');
                        } else {
                            // Preenche os campos com os dados retornados pela API
                            $('#rua').val(data.logradouro); // Rua
                            $('#bairro').val(data.bairro); // Bairro
                            $('#cidade').val(data.localidade); // Cidade
                            $('#uf').val(data.uf); // UF
                        }
                    });
                } else {
                    alert('Por favor, informe um CEP válido.');
                }
            });
        });

    </script>

</head>

<body>
    <?php require_once("menu.php"); ?>
    <div class="container">
        <?php if (isset($_SESSION['mensagem'])) { ?>
            <div class="alert <?= $_SESSION['mensagem_tipo'] ?>" role="alert">
                <?= $_SESSION['mensagem'] ?>
            </div>
            <?php
            unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); // Limpa a mensagem da sessão 
            ?>
        <?php } ?>

        <h1 class="mt-2">Cadastro de Cliente</h1>
        <form method="post" action="cadastrar-cliente.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input name="nome" type="text" class="form-control" id="nome" placeholder="Ex: João Carlos Ferreira"
                    required>
            </div>
            <div class="mb-3">
                <label for="fone" class="form-label">Telefone</label>
                <input name="fone" type="text" class="form-control" id="fone" placeholder="Ex: 55 (44) 99999-9999"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Ex: email@gmail.com"
                    required>
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input name="cpf" type="text" class="form-control" id="cpf" placeholder="Ex: 000.000.000-00" required>
            </div>
            <div class="mb-3">
                <label for="dtNasc" class="form-label">Data de Nascimento</label>
                <!--<input name="dtNasc" type="date" class="form-control" id="dtNasc" placeholder="Ex: 01/01/2000"
                    max="<?php/* echo date('Y-m-d') */?>" required>-->
                    <input id="date" type="date"  max="<?php echo date('Y-m-d') ?>" required />
            </div>
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input name="cep" type="text" class="form-control" id="cep" placeholder="Ex: 87506-000" required>
            </div>

            <div class="mb-3">
                <label for="rua" class="form-label">Rua</label>
                <input name="rua" type="text" class="form-control" id="rua" placeholder="Ex: Rua São João" required>
            </div>
            <div class="mb-3">
                <label for="rua" class="form-label">Número</label>
                <input name="numero" type="text" class="form-control" id="rua" placeholder="Ex: 838" required>
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input name="bairro" type="text" class="form-control" id="bairro" placeholder="Ex: Centro" required>
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input name="cidade" type="text" class="form-control" id="cidade" placeholder="Ex: Umuarama" required>
            </div>
            <div class="mb-3">
                <label for="uf" class="form-label">UF</label>
                <select name="uf" class="form-control" id="uf" required>
                    <!-- As opções de estados serão preenchidas automaticamente -->
                </select>
            </div>
            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
        </form>
    </div>

    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>