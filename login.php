
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" />
    <title>Document</title>
</head>
<body>
        <div class="container">
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $mensagem ?>
            </div>
        <?php } ?>

        <div class="login-box">
            <div class="left">
                <img src="img/logo-teste.webp" alt="">
                <h2>Bem-vindo de volta!</h2>
                <p>Acesse sua conta agora mesmo.</p>
                <button>Entrar</button>
                <a href="#">Esqueci minha senha</a>
            </div>
            <div class="right">
                <div class="imagem-usuario">
                    <img src="img/usuario.png" alt="">
                </div>
                <h2>Login</h2>
                <form action="autenticacao.php" method="POST" class="formulario"  ">

                        <input type="text" id="username" name="nome" placeholder="Usuário" required class="input-login">
                        <input type="password" id="password" name="senha" placeholder="Senha"  required class="input-login">
                        <input type="submit" value="login" name="salvar" class="input-enviar-login">

                    </form>

            </div>
        </div>
    </div>
</body>
</html>


