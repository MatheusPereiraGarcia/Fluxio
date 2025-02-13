<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Fluxio</title>
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <?php
    // Conectar ao banco de dados
    $conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');
    if (!$conexao) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    // Variáveis de mensagens
    $mensagemErro = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recuperar dados do formulário
        $token = $_POST['token'] ?? null;
        $novaSenha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmar_senha'];

        if ($token && $novaSenha === $confirmarSenha) {
            // Verificar se o token ainda é válido
            $sql = "SELECT id FROM usuario WHERE token_recuperacao = ? AND token_expiracao > NOW()";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado && $resultado->num_rows > 0) {
                // Atualizar a senha no banco de dados
                $usuario = $resultado->fetch_assoc();
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT); // Usar hash para armazenar a senha
                $sql_update = "UPDATE usuario SET senha = ?, token_recuperacao = NULL, token_expiracao = NULL WHERE id = ?";
                $stmt_update = $conexao->prepare($sql_update);
                $stmt_update->bind_param("si", $novaSenhaHash, $usuario['id']);
                $stmt_update->execute();

                // Redirecionar para a página de login
                header('Location: login.php?sucesso=Senha redefinida com sucesso. Faça login!');
                exit;
            } else {
                // Token inválido ou expirado, redirecionar com a mensagem de erro
                $mensagemErro = 'Token inválido ou expirado.';
                header("Location: resetar_senha.php?token=$token&erro=" . urlencode($mensagemErro));
                exit;
            }
        } else {
            // Senhas não coincidem ou o token está ausente, redirecionar com a mensagem de erro
            $mensagemErro = 'As senhas não coincidem ou o token está ausente.';
            header("Location: resetar_senha.php?token=$token&erro=" . urlencode($mensagemErro));
            exit;
        }
    } elseif (isset($_GET['token'])) {
        $token = $_GET['token'];
        $erro = $_GET['erro'] ?? '';

        // Verificar o token no banco de dados
        $sql = "SELECT id, token_expiracao FROM usuario WHERE token_recuperacao = ? AND token_expiracao > NOW()";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            // Token válido, exibir formulário para redefinir senha
    ?>
            <main>
                <div class="container">
                    <div class="login-box">
                        <div class="left">
                            <!-- Se tiver logo, você pode incluir aqui -->
                        </div>
                        <div class="right">
                            <h2>Redefinir Senha</h2>
                            <p>Insira uma nova senha para sua conta.</p>

                            <!-- Exibir mensagem de erro, se houver -->
                            <?php if ($erro): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                            <?php endif; ?>

                            <form action="resetar_senha.php" method="POST" class="formulario">
                                <input type="password" name="senha" placeholder="Nova Senha" required class="input-login">
                                <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required class="input-login">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
                                <input type="submit" value="Redefinir Senha" class="input-enviar-login">
                            </form>
                        </div>
                    </div>
                </div>
            </main>
    <?php
        } else {
            echo '<div class="alert alert-danger">Token inválido ou expirado.</div>';
        }
    } else {
        echo "Token inválido ou ausente.";
    }

    $stmt->close();
    mysqli_close($conexao);
    ?>
</body>

</html>