<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" />
    <title>Login - Fluxio</title>
</head>

<body>

    <main>
        <div class="container">
            <!-- Exibe a mensagem de erro se houver -->

            <div class="login-box">
                <div class="left">
                    <img src="img/logo_aumentada.png" alt="">
                    <h2>Bem-vindo de volta!</h2>
                    <p>Acesse sua conta agora mesmo.</p>
                    <a href="esqueciSenha.php">Esqueci minha senha</a>
                </div>
                <div class="right">
                    <div class="imagem-usuario">
                        <img src="img/logo_simp_nobg.png" alt="">
                    </div>
                    <h2>Login</h2>
                    <?php if (isset($_GET['erro'])) { ?>
                        <div class="alerta">
                            <div class="alert alert-danger" role="alert">
                                <?= $_GET['erro'] ?> <!-- Aqui você exibe a mensagem de erro -->
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_GET['sucesso'])) {
                        $mensagemSucesso = $_GET['sucesso'];
                        ?>
                        <div class="alert alert-success"><?= htmlspecialchars($mensagemSucesso) ?></div>
                        <?php
                    }
                    ?>
                    <form action="autenticacao.php" method="POST" class="formulario">
                        <input type="email" id="username" name="email" placeholder="E-mail" required
                            class="input-login"> <!-- Alterado para "email" -->
                        <input type="password" id="password" name="senha" placeholder="Senha" required
                            class="input-login">
                        <input type="submit" value="login" name="salvar" class="input-enviar-login">
                    </form>

                    <!-- Link para a página de cadastro -->
                    <p>Não tem uma conta? <a href="novo-usuario.php">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>