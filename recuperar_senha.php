<?php
$conexao = mysqli_connect('127.0.0.1', 'root', '', 'tcc');

// Verificar a conexão
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Instanciando o PHPMailer
$mail = new PHPMailer(true);
$emailUsuario = $_POST['email'];

// Verificar se o e-mail existe no banco de dados
$sql = "SELECT id FROM usuario WHERE email = ?";
$stmt = $conexao->prepare($sql);

// Verificar se a preparação da consulta falhou
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conexao->error);
}

$stmt->bind_param("s", $emailUsuario); // 's' indica que o parâmetro é uma string
$stmt->execute();
$result = $stmt->get_result();

// Se o e-mail existir
if ($result->num_rows > 0) {
    // Gerar um token único (usando o ID do usuário e um valor aleatório)
    $token = bin2hex(random_bytes(16)); // Gera um token de 32 caracteres
    $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token válido por 1 hora

    // Armazenar o token e a data de expiração no banco de dados
    $sql_update = "UPDATE usuario SET token_recuperacao = ?, token_expiracao = ? WHERE email = ?";
    $stmt_update = $conexao->prepare($sql_update);
    
    // Verificar se a preparação da consulta de atualização falhou
    if ($stmt_update === false) {
        die("Erro na preparação da consulta de atualização: " . $conexao->error);
    }

    $stmt_update->bind_param("sss", $token, $expiracao, $emailUsuario);
    $stmt_update->execute();

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();        // Enviar usando SMTP
        $mail->SMTPAuth = true;                                // Habilitar autenticação SMTP
        $mail->Username = 'fluxiotcc@gmail.com';               // Seu e-mail Gmail
        $mail->Password = 'zlovmipipxwsdpwt';                 // Senha de aplicativo (caso tenha 2FA)
        // Informações especificadas pelo Google
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;

        // Define o remetente
        $mail->setFrom('fluxiotcc@gmail.com', 'Fluxio');

        // Define o destinatário
        $mail->addAddress($emailUsuario);

        $mail->isHTML(true); // Seta o formato do e-mail para aceitar conteúdo HTML
        $mail->Subject = 'Recuperacao de Senha - Fluxio';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
                <h2 style="color: #0056b3;">Recuperação de Senha</h2>
                <p>Olá,</p>
                <p>Recebemos uma solicitação para redefinir sua senha. Para continuar, clique no link abaixo:</p>
                <p style="margin: 20px 0;">
                    <a href="http://localhost/fluxio/resetar_senha.php?token=' . urlencode($token) . '" 
                       style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #0056b3; text-decoration: none; border-radius: 5px;">
                        Redefinir Senha
                    </a>
                </p>
                <p>Se você não fez esta solicitação, por favor ignore este e-mail. Sua senha permanecerá segura.</p>
                <p style="margin-top: 30px;">Atenciosamente,<br>Fluxio</p>
                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                <p style="font-size: 12px; color: #666;">
                    Este e-mail foi enviado automaticamente. Por favor, não responda.
                </p>
            </div>';
        


        // Enviar e-mail
        $mail->send();
        // Redireciona para a página de recuperação com mensagem de sucesso
        header('Location: esqueciSenha.php?sucesso=Mensagem+enviada+com+sucesso');
        exit;

    } catch (Exception $e) {
        // Redireciona para a página de recuperação com erro
        header('Location: esqueciSenha.php?erro=Erro+ao+enviar+o+e-mail');
        exit;
    }
} else {
    // Caso o e-mail não seja encontrado, redireciona com mensagem de erro
    header('Location: esqueciSenha.php?erro=O+e-mail+informado+não+está+registrado');
    exit;
}

$stmt->close();
$conexao->close();
?>
