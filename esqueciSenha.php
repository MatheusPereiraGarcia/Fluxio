<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" />
    <title>Recuperar Senha - Fluxio</title>
</head>
<script>
    // Função para voltar à página anterior
    function voltarPagina() {
        window.history.back();
    }
</script>

<body>

    <main>
        <div class="container">
            <!-- Container centralizado -->

            <div class="login-box">
                <div class="left">
                    <img src="img/logo.png" alt="">
                    <h2>Esqueceu sua senha?</h2>
                    <p>Não se preocupe! Informe seu e-mail e enviaremos as instruções para redefinir sua senha.</p>
                </div>
                <div class="right">
                    <div class="imagem-usuario">
                        
                    </div>
                    <h2>Recuperação de Senha</h2>
                    <?php if (isset($_GET['erro'])) { ?>
                        <div class="alerta">
                            <div class="alert alert-danger" role="alert">
                                <?= $_GET['erro'] ?> <!-- Exibe a mensagem de erro -->
                            </div>
                        </div>
                    <?php } elseif (isset($_GET['sucesso'])) { ?>
                        <div class="alerta">
                            <div class="alert alert-success" role="alert">
                                <?= $_GET['sucesso'] ?> <!-- Exibe a mensagem de sucesso -->
                            </div>
                        </div>
                    <?php } ?>
                    <form action="recuperar_senha.php" method="POST" class="formulario">

                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required
                            class="input-login">
                        <input type="submit" value="Recuperar Senha" name="enviar" class="input-enviar-login">
                        <a href="login.php" class="voltar-link-resenha" style="margin-top: 10px;">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>