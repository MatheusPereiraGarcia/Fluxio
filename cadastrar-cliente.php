
<?php 
session_start();

require_once("conexao.php");

function validarCPF($cpf) {
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os dados do formulário
    $nome = $_POST['nome'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $dtNasc = $_POST['dtNasc'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $uf = $_POST['uf']; 

    // Valida o CPF
    if (!validarCPF($cpf)) {
        $_SESSION['mensagem'] = "CPF inválido!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        header('Location: cadastro-cliente.php');
        exit();
    }

    // Verificar se o CPF já existe no banco de dados
    $sql_check_cpf = "SELECT * FROM cliente WHERE cpf = '$cpf'";
    $result_check_cpf = mysqli_query($conn, $sql_check_cpf);

    if (mysqli_num_rows($result_check_cpf) > 0) {
        // CPF já existe no banco
        $_SESSION['mensagem'] = "Este CPF já está cadastrado!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        header('Location: cadastro-cliente.php');
        exit();
    }

    // Verificar se o email já existe no banco de dados
    $sql_check_email = "SELECT * FROM cliente WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // E-mail já existe no banco
        $_SESSION['mensagem'] = "Este e-mail já está cadastrado!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        header('Location: cadastro-cliente.php');
        exit();
    }

    // Prepara a SQL para inserir no BD
    $sql = "INSERT INTO cliente(nome, fone, email, cpf, dtNasc, cep, cidade, rua, numero, bairro, uf) 
            VALUES('$nome','$fone','$email','$cpf', '$dtNasc', '$cep', '$cidade', '$rua', '$numero', '$bairro', '$uf')";
    
    if (mysqli_query($conn, $sql)) {
        // Armazena mensagem de sucesso na sessão
        $_SESSION['mensagem'] = "Cliente cadastrado com sucesso!";
        $_SESSION['mensagem_tipo'] = "alert alert-success"; // Tipo de alerta para sucesso
    } else {
        // Armazena mensagem de erro na sessão
        $_SESSION['mensagem'] = "Erro ao cadastrar cliente: " . mysqli_error($conn);
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
    }

    // Redireciona para a página de cadastro
    header('Location: cadastro-cliente.php');
    exit();
}

mysqli_close($conn); // Fecha a conexão com o banco de dados
?>
