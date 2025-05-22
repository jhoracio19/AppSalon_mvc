<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }
    
    public function enviarConfirmacion(){
        try {
            // Crear el objeto de Email
            $mail = new PHPMailer(true); // true habilita excepciones
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->SMTPSecure = 'tls'; // Importante para MailerSend
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            
            // Configurar el remitente
            $mail->setFrom('noreply@jhoracio19.pro', 'AppSalon');
            
            // Añadir el destinatario (el email del usuario)
            $mail->addAddress($this->email, $this->nombre);
            
            $mail->Subject = 'Confirma tu cuenta';
            
            // Configurar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            // Crear el contenido
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ". $this->nombre. "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presione aquí: <a href='" . $_ENV['APP_URL'] ."/confirmar-cuenta?token=". $this->token. "'>Confirmar Cuenta</a> </p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
            $contenido .= "</html>";
            
            $mail->Body = $contenido;
            $mail->AltBody = "Hola {$this->nombre}, confirma tu cuenta en AppSalon: {$_ENV['APP_URL']}/confirmar-cuenta?token={$this->token}";
            
            // Enviar el email
            return $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar email de confirmación: {$mail->ErrorInfo}");
            return false;
        }
    }   
    
    public function enviarInstrucciones(){
        try {
            // Crear el objeto de Email
            $mail = new PHPMailer(true); // true habilita excepciones
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->SMTPSecure = 'tls'; // Importante para MailerSend
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            
            // Configurar el remitente
            $mail->setFrom('notificaciones@jhoracio19.pro', 'AppSalon');
            
            // Añadir el destinatario (el email del usuario)
            $mail->addAddress($this->email, $this->nombre);
            
            $mail->Subject = 'Reestablece tu password';
            
            // Configurar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            // Crear el contenido
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ". $this->nombre. "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo. </p>";
            $contenido .= "<p>Presione aquí: <a href='" . $_ENV['APP_URL'] ."/recuperar?token=". $this->token. "'>Reestablecer Password</a> </p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
            $contenido .= "</html>";
            
            $mail->Body = $contenido;
            $mail->AltBody = "Hola {$this->nombre}, reestablece tu password en AppSalon: {$_ENV['APP_URL']}/recuperar?token={$this->token}";
            
            // Enviar el email
            return $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar email de instrucciones: {$mail->ErrorInfo}");
            return false;
        }
    }
}