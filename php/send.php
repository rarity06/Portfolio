<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

// DATOS SMTP (EDITA ESTO)
$SMTP_HOST = "smtp.gmail.com";
$SMTP_USER = "TU-EMAIL";
$SMTP_PASS = "TU-CLAVE"; // no uses tu contraseña normal
$SMTP_PORT = 587;

// DATOS DEL FORMULARIO
$name   = $_POST['name'] ?? '';
$email  = $_POST['email'] ?? '';
$asunto = $_POST['asunto'] ?? '';
$msg    = $_POST['msg'] ?? '';

$contenido = "
<h2>Nuevo mensaje del formulario</h2>
<p><strong>Nombre:</strong> {$name}</p>
<p><strong>Correo:</strong> {$email}</p>
<p><strong>Asunto:</strong> {$asunto}</p>
<p><strong>Mensaje:</strong><br>{$msg}</p>
";

$mail = new PHPMailer(true);

try {
    // CONFIGURAR SMTP
    $mail->isSMTP();
    $mail->Host       = $SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = $SMTP_USER;
    $mail->Password   = $SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $SMTP_PORT;

    // REMITENTES / DESTINOS
    $mail->setFrom($SMTP_USER, 'Portafolio web');
    $mail->addAddress("rarityluna12@gmail.com", "Hector");
    $mail->addReplyTo($email, $name);
    $mail->addCC($email);

    // CONTENIDO
    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail->Body    = $contenido;

    $mail->send();
    if($mail->send()){
        header("Location: ../index.html#contact");
    }
}catch (Exception $e) {
            echo "<span style='color:red;'>Error al enviar el correo: {$mail->ErrorInfo}</span>";
        }
