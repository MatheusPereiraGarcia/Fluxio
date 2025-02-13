<?php
// Verifica se a sessão já foi iniciada antes de chamar session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    // Se não estiver logado, redireciona para a página de login
    $mensagem = "Você precisa estar logado para acessar esta página.";
    header("Location: login.php?mensagem={$mensagem}");
    exit();
}

// Verifica se o usuário logado é um administrador (se tipo e igual a 0)
if ($_SESSION['tipo'] == 0) {
    // Se não for administrador, destrói a sessão e redireciona para a página de login
    session_unset(); // Limpa todas as variáveis de sessão
    session_destroy(); // Destroi a sessão
    
    // Redireciona para o login com uma mensagem de erro
    $mensagem = "Acesso restrito. Somente administradores podem acessar esta página.";
    header("Location: login.php?mensagem={$mensagem}");
    exit();
}
?>
