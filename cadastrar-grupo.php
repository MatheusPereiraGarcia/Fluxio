<?php require_once("verificaAdm.php"); ?>
<?php

session_start();
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os dados para inserir no BD
    $nome = $_POST['nome'];
    $obs = $_POST['obs'];

    // Verificar se já existe um grupo com o mesmo nome
    $sql_verificar = "SELECT id FROM grupo WHERE LOWER(nome) = LOWER('$nome')";
    $resultado = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado) > 0) {
        // Caso já exista um grupo com o mesmo nome
        $_SESSION['mensagem'] = "Já existe um grupo com esse nome!";
        $_SESSION['mensagem_tipo'] = "alert alert-warning"; // Tipo de alerta para aviso
    } else {
        // Prepara a SQL para inserir o novo grupo
        $sql = "INSERT INTO grupo (nome, obs) VALUES ('$nome', '$obs')";
        
        if (mysqli_query($conn, $sql)) {
            // Armazenar mensagem de sucesso
            $_SESSION['mensagem'] = "Grupo cadastrado com sucesso!";
            $_SESSION['mensagem_tipo'] = "alert alert-success"; // Tipo de alerta para sucesso
        } else {
            // Armazenar mensagem de erro
            $_SESSION['mensagem'] = "Erro ao cadastrar grupo: " . mysqli_error($conn);
            $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        }
    }

    // Redirecionar para a página de cadastro de grupo
    header('Location: cadastro-grupo.php');
    exit(); // Importante para evitar a execução do restante do script
}

mysqli_close($conn); // Fecha a conexão com o banco de dados
?>
