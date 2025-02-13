<?php require_once("verificaAdm.php"); ?>
<?php 

session_start();
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];
    $tipo = $_POST['tipo'];  // Captura o tipo de usuário (0 para normal, 1 para admin)

    // Verificar se o e-mail já está cadastrado (considerando letras maiúsculas e minúsculas)
    $sql_check_email = "SELECT * FROM usuario WHERE email = BINARY '$email'"; // A cláusula BINARY garante que a comparação será sensível a maiúsculas e minúsculas
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // E-mail já existe no banco
        $_SESSION['mensagem'] = "Este e-mail já está cadastrado!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        header('Location: cadastro-usuario.php');
        exit();
    }

    // Verificar se o nome já está cadastrado (considerando letras maiúsculas e minúsculas)
    $sql_check_nome = "SELECT * FROM usuario WHERE nome = BINARY '$nome'"; // A cláusula BINARY garante que a comparação será sensível a maiúsculas e minúsculas
    $result_check_nome = mysqli_query($conn, $sql_check_nome);

    if (mysqli_num_rows($result_check_nome) > 0) {
        // Nome já existe no banco
        $_SESSION['mensagem'] = "Este nome já está cadastrado!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        header('Location: cadastro-usuario.php');
        exit();
    }

    // Verifica se as senhas coincidem
    if ($senha1 === $senha2) {
        // Criptografa a senha
        $senhaHash = password_hash($senha1, PASSWORD_DEFAULT);

        // Insere o usuário no banco de dados, incluindo o tipo de usuário
        $sql = "INSERT INTO usuario (tipo, nome, email, senha ) VALUES ('$tipo', '$nome', '$email', '$senhaHash')";

        if (mysqli_query($conn, $sql)) {
            // Armazena a mensagem de sucesso na sessão
            $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
            $_SESSION['mensagem_tipo'] = "alert alert-success"; // Tipo da mensagem (sucesso)
        } else {
            // Armazena mensagem de erro na sessão
            $_SESSION['mensagem'] = "Erro ao cadastrar usuário: " . mysqli_error($conn);
            $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo da mensagem (erro)
        }
    } else {
        // Armazena mensagem de erro caso as senhas não coincidam
        $_SESSION['mensagem'] = "Senhas não coincidem.";
        $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo da mensagem (erro)
    }

    // Redireciona de volta para o formulário de cadastro
    header('Location: cadastro-usuario.php');
    exit();
}

mysqli_close($conn);
?>
