<?php
// Verifica se a sessão já foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Inicia a sessão apenas se ainda não foi iniciada
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    // Se não estiver, exibe uma mensagem e redireciona para o login
    $mensagem = "Sessão expirada. Faça o login novamente.";
    header("location:login.php?mensagem={$mensagem}");
    exit;  // Garante que o script pare de executar após o redirecionamento
}
?>
