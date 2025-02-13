<?php require_once("verificaAdm.php"); ?>
<?php

// Conexão com o banco de dados
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');
function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }

        $d = ((10 * $d) % 11) % 10;

        if ($cpf[$t] != $d) {
            return false;
        }
    }

    return true;
}
if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $dtNasc = $_POST['dtNasc'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];

    // Valida o CPF
    if (!validarCPF($cpf)) {
        $_SESSION['mensagem'] = "CPF inválido!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        header("Location: alterar-cliente.php?id=$id"); // Inclui o ID no redirecionamento
        exit();
    }

    $sql = "UPDATE cliente SET nome = '$nome', fone = '$fone', email = '$email', cpf = '$cpf', dtNasc = '$dtNasc', cep = '$cep', cidade = '$cidade', uf = '$uf', rua = '$rua', numero = '$numero' WHERE id = '$id'";

    mysqli_query($conexao, $sql);
    header('Location: listar-cliente.php');
    exit;
}

$sql = "SELECT * FROM cliente WHERE id = " . $_GET['id'];
$resultado = mysqli_query($conexao, $sql);
$cliente = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <title>Alterar Cliente</title>
</head>

<script>
    $(document).ready(function () {
        // Máscaras
        $('#cpf').mask('000.000.000-00', { reverse: true });
        $('#fone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');

        // API ViaCEP para preenchimento automático
        $('#cep').on('blur', function () {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                    } else {
                        $('#rua').val(data.logradouro);
                        $('#cidade').val(data.localidade);
                        $('#uf').val(data.uf);
                    }
                });
            } else {
                alert('Por favor, informe um CEP válido.');
            }
        });
    });
</script>

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
        <h1 class="mt-2">Alterar Cliente</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input name="nome" type="text" class="form-control" id="nome" required value="<?= $cliente['nome'] ?>">
            </div>

            <div class="mb-3">
                <label for="fone" class="form-label">Telefone</label>
                <input name="fone" type="text" class="form-control" id="fone" required value="<?= $cliente['fone'] ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input name="email" type="email" class="form-control" id="email" required
                    value="<?= $cliente['email'] ?>">
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input name="cpf" type="text" class="form-control" id="cpf" required value="<?= $cliente['cpf'] ?>">
            </div>

            <div class="mb-3">
                <label for="dtNasc" class="form-label">Data de Nascimento</label>
                <input name="dtNasc" type="date" id="dtNasc" required value="<?= $cliente['dtNasc'] ?>"
                    max="<?php echo date('Y-m-d') ?>">
            </div>

            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input name="cep" type="text" class="form-control" id="cep" required value="<?= $cliente['cep'] ?>">
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input name="cidade" type="text" class="form-control" id="cidade" required
                    value="<?= $cliente['cidade'] ?>">
            </div>

            <div class="mb-3">
                <label for="uf" class="form-label">UF</label>
                <select name="uf" class="form-select" id="uf" required>
                    <option value="" disabled>Selecione o Estado</option>
                    <?php
                    $estados = ["AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"];
                    foreach ($estados as $estado) {
                        $selected = $cliente['uf'] == $estado ? 'selected' : '';
                        echo "<option value='$estado' $selected>$estado</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="rua" class="form-label">Rua</label>
                <input name="rua" type="text" class="form-control" id="rua" required value="<?= $cliente['rua'] ?>">
            </div>

            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input name="numero" type="text" class="form-control" id="numero" required
                    value="<?= $cliente['numero'] ?>">
            </div>

            <button name="salvar" type="submit" class="botao-primario">
                <i class="fa-solid fa-check"></i> Salvar
            </button>
            <a href="listar-cliente.php" class="botao-secundario">Voltar</a>
        </form>
    </div>
    <?php require_once("footer.php"); ?> <!-- O footer agora ocupa toda a largura -->
</body>

</html>