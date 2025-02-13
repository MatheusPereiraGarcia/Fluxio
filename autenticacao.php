<?php
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

if (isset($_POST['salvar'])) {
    $email = $_POST['email'];  // Agora estamos pegando o email
    $senha = $_POST['senha'];

    // Escapar a variável para evitar SQL Injection
    $email = mysqli_real_escape_string($conexao, $email);

    // Consulta SQL para verificar o usuário pelo e-mail
    $sql = "SELECT id, nome, email, senha, tipo FROM usuario WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Buscar os dados do usuário
        $row = mysqli_fetch_assoc($resultado);
        $id = $row['id'];
        $nome_db = $row['nome']; // Mantemos o nome para exibir após o login
        $email_db = $row['email'];
        $senhaHash = $row['senha'];
        $tipo = $row['tipo'];

        // Verificar a senha usando password_verify()
        if (password_verify($senha, $senhaHash)) {
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['nome'] = $nome_db;
            $_SESSION['email'] = $email_db;
            $_SESSION['tipo'] = $tipo;

            // Redireciona o usuário com base no tipo
            if ($tipo == 1) {
                header("Location: Index.php");
                exit();
            } else {
                header("Location: venda.php");
                exit();
            }
        } else {
            // Senha incorreta - redireciona de volta para a página de login com erro
            $mensagem = "Senha incorreta!";
            header("Location: login.php?erro={$mensagem}");
            exit();
        }
    } else {
        // Usuário não encontrado - redireciona de volta para a página de login com erro
        $mensagem = "Usuário não encontrado!";
        header("Location: login.php?erro={$mensagem}");
        exit();
    }

    mysqli_free_result($resultado);
    mysqli_close($conexao);
}
?>
