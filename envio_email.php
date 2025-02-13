<?php
// Incluir o autoload do Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Certifique-se de ter o Composer instalado

// Função para enviar o e-mail
function enviar_email($destinatario, $assunto, $mensagem) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Configuração do servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'seu_email@gmail.com';  // Seu e-mail Gmail
        $mail->Password = 'sua_senha';  // Sua senha ou senha de aplicativo se tiver 2FA
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Definir remetente e destinatário
        $mail->setFrom('seu_email@gmail.com', 'Seu Nome');
        $mail->addAddress($destinatario);

        // Definir conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;

        // Enviar o e-mail
        $mail->send();
        return true;  // E-mail enviado com sucesso
    } catch (Exception $e) {
        // Exibir o erro caso o envio falhe
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        return false;  // Falha no envio
    }
}
