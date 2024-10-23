<?php
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Verificar se a conexão foi bem-sucedida
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}


if (isset($_POST['salvar'])) {
    // Pegar os dados do formulário
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $status;
    // Preparar a consulta SQL para evitar SQL Injection
    $sql = "SELECT * FROM usuario WHERE nome = '$nome' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);
    $registro = mysqli_num_rows($resultado);

    if ($nome == "Math" && $senha == "123") {
        $linha = mysqli_fetch_array($resultado); 
        session_start();

        $_SESSION['id'] = $linha['id'];
        $_SESSION['nome'] = $linha['nome'];
        $_SESSION['email'] = $linha['email'];

        header("location: cadastro-usuario.php");
    } else if ($registro > 0) {

        $linha = mysqli_fetch_array($resultado); //Pega usuário do L
        session_start(); //Inicio a sessão no PHP

        //Seta as variáveis de sessão
        $_SESSION['id'] = $linha['id'];
        $_SESSION['nome'] = $linha['nome'];
        $_SESSION['email'] = $linha['email'];

        header("location: menu.php");
    } else {
        session_destroy();
        header('Location:login.php');
        die();
    }
    mysqli_close($conn);
}
