<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class Email extends Model {

    public function sendMail($titulo, $email, $desc, $texto){

        $mail = new PHPMailer(); 

        // Método de envio 
        $mail->IsSMTP(); 
        
        // Enviar por SMTP 
        $mail->Host = "email-ssl.com.br"; 
        
        // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
        $mail->Port = 587; 
        
        
        // Usar autenticação SMTP (obrigatório) 
        $mail->SMTPAuth = true; 
        
        // Usuário do servidor SMTP (endereço de email) 
        // obs: Use a mesma senha da sua conta de email 
        $mail->Username = 'app2park@novandi.com.br'; 
        $mail->Password = '3648$182236Tgr-yjdu'; 
        
        // Configurações de compatibilidade para autenticação em TLS 
        $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
        
        // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
        // $mail->SMTPDebug = 2; 
        
        // Define o remetente 
        // Seu e-mail 
        $mail->From = "app2park@novandi.com.br"; 
        
        // Seu nome 
        $mail->FromName = "App2Park"; 
        
        // Define o(s) destinatário(s) 
        $mail->AddAddress($email); 
        
        // Opcional: mais de um destinatário
        // $mail->AddAddress('fernando@email.com'); 
        
        // Opcionais: CC e BCC
        // $mail->AddCC('joana@provedor.com', 'Joana'); 
        // $mail->AddBCC('roberto@gmail.com', 'Roberto'); 
        
        // Definir se o e-mail é em formato HTML ou texto plano 
        // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
        $mail->IsHTML(true); 
        
        // Charset (opcional) 
        $mail->CharSet = 'UTF-8'; 
        
        // Assunto da mensagem 
        $mail->Subject = $titulo; 
        
        // Corpo do email 
        $mail->Body = $desc.' > '.$texto; 
        
        // Opcional: Anexos 
        // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 
        
        // Envia o e-mail 
        $enviado = $mail->Send(); 

        return true;
    }

    public function sendMailDesc($titulo, $email, $desc){

        $mail = new PHPMailer(); 

        // Método de envio 
        $mail->IsSMTP(); 
        
        // Enviar por SMTP 
        $mail->Host = "email-ssl.com.br"; 
        
        // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
        $mail->Port = 587; 
        
        
        // Usar autenticação SMTP (obrigatório) 
        $mail->SMTPAuth = true; 
        
        // Usuário do servidor SMTP (endereço de email) 
        // obs: Use a mesma senha da sua conta de email 
        $mail->Username = 'app2park@novandi.com.br'; 
        $mail->Password = '3648$182236Tgr-yjdu'; 
        
        // Configurações de compatibilidade para autenticação em TLS 
        $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
        
        // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
        // $mail->SMTPDebug = 2; 
        
        // Define o remetente 
        // Seu e-mail 
        $mail->From = "app2park@novandi.com.br"; 
        
        // Seu nome 
        $mail->FromName = "App2Park"; 
        
        // Define o(s) destinatário(s) 
        $mail->AddAddress($email); 
        
        // Opcional: mais de um destinatário
        // $mail->AddAddress('fernando@email.com'); 
        
        // Opcionais: CC e BCC
        // $mail->AddCC('joana@provedor.com', 'Joana'); 
        // $mail->AddBCC('roberto@gmail.com', 'Roberto'); 
        
        // Definir se o e-mail é em formato HTML ou texto plano 
        // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
        $mail->IsHTML(true); 
        
        // Charset (opcional) 
        $mail->CharSet = 'UTF-8'; 
        
        // Assunto da mensagem 
        $mail->Subject = $titulo; 
        
        // Corpo do email 
        $mail->Body = $desc; 
        
        // Opcional: Anexos 
        // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 
        
        // Envia o e-mail 
        $enviado = $mail->Send(); 

        return true;
    }

    public function sendMailDescCron($titulo, $email, $desc){

        $mail = new PHPMailer(); 

        // Método de envio 
        $mail->IsSMTP(); 
        
        // Enviar por SMTP 
        $mail->Host = "email-ssl.com.br"; 
        
        // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
        $mail->Port = 587; 
        
        
        // Usar autenticação SMTP (obrigatório) 
        $mail->SMTPAuth = true; 
        
        // Usuário do servidor SMTP (endereço de email) 
        // obs: Use a mesma senha da sua conta de email 
        $mail->Username = 'app2park@novandi.com.br'; 
        $mail->Password = '3648$182236Tgr-yjdu'; 
        
        // Configurações de compatibilidade para autenticação em TLS 
        $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
        
        // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
        // $mail->SMTPDebug = 2; 
        
        // Define o remetente 
        // Seu e-mail 
        $mail->From = "app2park@novandi.com.br"; 
        
        // Seu nome 
        $mail->FromName = "App2Park"; 
        
        // Define o(s) destinatário(s) 
        $mail->AddAddress($email); 
        
        // Opcional: mais de um destinatário
        //$mail->AddAddress('app2park@app2park.com.br'); 
        
        // Opcionais: CC e BCC
        // $mail->AddCC('joana@provedor.com', 'Joana'); 
         $mail->AddBCC('app2park@app2park.com.br', 'App2Park'); 
        
        // Definir se o e-mail é em formato HTML ou texto plano 
        // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
        $mail->IsHTML(true); 
        
        // Charset (opcional) 
        $mail->CharSet = 'UTF-8'; 
        
        // Assunto da mensagem 
        $mail->Subject = $titulo; 
        
        // Corpo do email 
        $mail->Body = $desc; 
        
        // Opcional: Anexos 
        // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 
        
        // Envia o e-mail 
        $enviado = $mail->Send(); 

        return true;
    }
}