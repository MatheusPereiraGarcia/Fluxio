<?php
session_start();
require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];

    // Definir o tipo de usuário fixo como "Usuário Normal" (0)
    $tipo = 0;

    // Verificar se o e-mail já está cadastrado
    $sql_check_email = "SELECT * FROM usuario WHERE email = BINARY '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // E-mail já existe no banco
        $_SESSION['mensagem'] = "Este e-mail já está cadastrado!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger";
        header('Location: novo-usuario.php');
        exit();
    }

    // Verificar se o nome já está cadastrado
    $sql_check_nome = "SELECT * FROM usuario WHERE nome = BINARY '$nome'";
    $result_check_nome = mysqli_query($conn, $sql_check_nome);

    if (mysqli_num_rows($result_check_nome) > 0) {
        // Nome já existe no banco
        $_SESSION['mensagem'] = "Este nome já está cadastrado!";
        $_SESSION['mensagem_tipo'] = "alert alert-danger";
        header('Location: novo-usuario.php');
        exit();
    }

    // Verifica se as senhas coincidem
    if ($senha1 === $senha2) {
        // Criptografa a senha
        $senhaHash = password_hash($senha1, PASSWORD_DEFAULT);

        // Insere o usuário no banco de dados
        $sql = "INSERT INTO usuario (tipo, nome, email, senha ) VALUES ('$tipo', '$nome', '$email', '$senhaHash')";

        if (mysqli_query($conn, $sql)) {
            // Armazena mensagem de sucesso
            $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
            $_SESSION['mensagem_tipo'] = "alert alert-success";
        } else {
            // Armazena mensagem de erro
            $_SESSION['mensagem'] = "Erro ao cadastrar usuário: " . mysqli_error($conn);
            $_SESSION['mensagem_tipo'] = "alert alert-danger";
        }
    } else {
        // Senhas não coincidem
        $_SESSION['mensagem'] = "Senhas não coincidem.";
        $_SESSION['mensagem_tipo'] = "alert alert-danger";
    }

    // Redireciona para o formulário de cadastro
    header('Location: novo-usuario.php');
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Fluxio</title>

    <!-- Inclusão do Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        /* Paleta de cores */
        :root {
            --roxo-forte: #8c96ee;
            --roxo-medio: #a6aff2;
            --roxo-medio-claro: #c0c8f7;
            --roxo-fraco: #dae0fb;
            --roxo-claro: #f4f9ff;
        }

        /* Estilo do fundo da página */
        body {
            background-color: var(--roxo-fraco);
            /* Cor de fundo roxa fraca */
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Container centralizado com sombra */
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            /* Sombra suave */
            padding: 30px;
            width: 30%;
            position: relative;
        }


        /* Estilização de alertas de mensagens *//*
        .alert {
            font-size: 1.1em;
        }

        .alert-danger {
            background-color: var(--roxo-claro);
            color: #721c24;
        }

        .alert-success {
            background-color: var(--roxo-medio-claro);
            color: #155724;
        }*/

        /* Estilo do formulário */
        .form-group label {
            color: var(--roxo-forte);
        }

        /* Botão de salvar */
        .btn-primary {
            background-color: var(--roxo-forte);
            border: none;
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--roxo-medio);
        }

        /* Botão de voltar */
        .btn-secondary {
            background-color: gray;
            border: none;
            color: white;
        }

        .btn-secondary:hover {
            background-color: lightgrey;
        }

        /* Personalização dos inputs */
        .form-control {
            background-color: white;
            /* Fundo branco para os inputs */
            border: 2px solid var(--roxo-medio);
            margin-bottom: 20px;
            /* Aumenta o espaçamento entre os inputs */
        }

        .form-control:focus {
            background-color: white;
            border-color: var(--roxo-forte);
        }

        /* Estilização do nome Fluxio dentro do bloco */
        .topo {
            color: var(--roxo-medio);
            padding: 10px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Estilo dos botões (pequenos no canto inferior esquerdo) */
        .btn-container {
            display: flex;
            /* Usar flexbox para os botões ficarem lado a lado */
            justify-content: space-between;
            /* Distribui os botões com espaçamento entre eles */
            gap: 10px;
            margin-top: 20px;
            /* Aumenta o espaço entre o formulário e os botões */
        }

        .btn-container .btn {
            width: auto;
            /* Ajusta o tamanho dos botões */
            padding: 8px 16px;
            /* Botões menores */
        }
    </style>
</head>

<body>
    <div class="form-container">
        <!-- Nome do site dentro do bloco -->
        <div class="topo">
            Fluxio
        </div>

        <!-- Mensagem de erro ou sucesso -->
        <?php if (isset($_SESSION['mensagem'])) { ?>
            <div class="alert <?= $_SESSION['mensagem_tipo'] ?>" role="alert">
                <?= $_SESSION['mensagem'] ?>
            </div>
            <?php
            unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']);
            ?>
        <?php } ?>


        <!-- Formulário de Cadastro -->
        <form method="post" action="novo-usuario.php">
            <div class="form-group">
                <input name="nome" type="text" class="form-control" id="nome" required placeholder="Nome">
            </div>

            <div class="form-group">
                <input name="email" type="email" class="form-control" id="email" required placeholder="Email">
            </div>

            <div class="form-group">
                <input name="senha1" type="password" class="form-control" id="senha1" required placeholder="Senha">
            </div>

            <div class="form-group">
                <input name="senha2" type="password" class="form-control" id="senha2" required
                    placeholder="Confirmar Senha">
            </div>

            <!-- Botões de Salvar e Voltar -->
            <div class="btn-container">
                <button name="salvar" type="submit" class="btn btn-primary btn-sm">Salvar</button>
                <a href="login.php" class="btn btn-secondary btn-sm">Voltar</a>
            </div>
        </form>
    </div>

    <!-- Inclusão do Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>