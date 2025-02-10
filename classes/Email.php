<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this -> nombre = $nombre;
        $this -> email = $email;
        $this -> token = $token;
    }

    public function enviarConfirmacion(){
        
        // Crear el objeto de Email
        $mail = new PHPMailer();
        $mail -> isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username =  'c990eeb225c38e';
        $mail->Password = '9fccb6b55d4aac';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';


        //Set HTML
        $mail -> isHTML(TRUE);
        $mail -> CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre. "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presione aquí: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token. "'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje";
        $contenido .= "</html>";
        $mail -> Body = $contenido;

        //Enviar el email
        $mail -> send();
    }   

    public function enviarInstrucciones(){
    
        // Crear el objeto de Email
        $mail = new PHPMailer();
        $mail -> isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username =  'c990eeb225c38e';
        $mail->Password = '9fccb6b55d4aac';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu password';


        //Set HTML
        $mail -> isHTML(TRUE);
        $mail -> CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre. "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo. </p>";
        $contenido .= "<p>Presione aquí: <a href='http://localhost:3000/recuperar?token=". $this->token. "'>Reestablecer Password</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje";
        $contenido .= "</html>";
        $mail -> Body = $contenido;

        //Enviar el email
        $mail -> send();
    }
}