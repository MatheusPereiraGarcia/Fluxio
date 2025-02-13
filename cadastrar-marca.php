<?php require_once("verificaAdm.php"); ?>
<?php

session_start();
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os dados para inserir no BD
    $nome = $_POST['nome'];
    $obs = $_POST['obs'];

    // Verificar se já existe uma marca com o mesmo nome (case-insensitive)
    $sql_verificar = "SELECT id FROM marca WHERE LOWER(nome) = LOWER('$nome')";
    $resultado = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado) > 0) {
        // Caso já exista uma marca com o mesmo nome
        $_SESSION['mensagem'] = "Já existe uma marca com esse nome!";
        $_SESSION['mensagem_tipo'] = "alert alert-warning"; // Tipo de alerta para aviso
    } else {
        // Prepara a SQL para inserir a nova marca
        $sql = "INSERT INTO marca (nome, obs) VALUES ('$nome', '$obs')";
        
        if (mysqli_query($conn, $sql)) {
            // Mostrar mensagem de sucesso
            $_SESSION['mensagem'] = "Marca cadastrada com sucesso!";
            $_SESSION['mensagem_tipo'] = "alert alert-success"; // Tipo de alerta para sucesso
        } else {
            // Mostrar mensagem de erro
            $_SESSION['mensagem'] = "Erro ao cadastrar marca: " . mysqli_error($conn);
            $_SESSION['mensagem_tipo'] = "alert alert-danger"; // Tipo de alerta para erro
        }
    }

    // Redirecionar para a página de cadastro
    header('Location: cadastro-marca.php');
    exit(); // Importante para garantir que o script não continue executando
}

mysqli_close($conn); // Fecha a conexão com o banco de dados
?>
