<?php
$error=false;

function micro_sanear_string($string){
  $string = trim($string);

  $string = str_replace(
    array('á', 'Á'),
    array('&aacute;','&Aacute;'),
    $string
  );

  $string = str_replace(
    array('é', 'É'),
    array('&eacute;','&Eacute;'),
    $string
  );

  $string = str_replace(
    array('í', 'Í'),
    array('&iacute;','&Iacute;'),
    $string
  );

  $string = str_replace(
    array('ó', 'Ó'),
    array('&oacute;','&Oacute;'),
    $string
  );

  $string = str_replace(
    array('ú', 'Ú'),
    array('&uacute;','&Uacute;'),
    $string
  );

  $string = str_replace(
    array('ñ', 'Ñ'),
    array('&ntilde;','&Ntilde;'),
    $string
  );

  return $string;
}
require 'PHPMailer/PHPMailerAutoload.php';
require_once('PHPMailer/class.phpmailer.php');
// Tomar la IP del usuario
if ($_SERVER) {
  if ( $_SERVER[HTTP_X_FORWARDED_FOR] ) {
    $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
  } elseif ( $_SERVER["HTTP_CLIENT_IP"] ) {
    $realip = $_SERVER["HTTP_CLIENT_IP"];
  } else {
    $realip = $_SERVER["REMOTE_ADDR"];
  }
} else {
  if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
    $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
  } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
    $realip = getenv( 'HTTP_CLIENT_IP' );
  } else {
    $realip = getenv( 'REMOTE_ADDR' );
  }
}
//Navegador del usuario
$navegador = $_SERVER['HTTP_USER_AGENT'];

$mensaje=htmlentities($mensaje, ENT_QUOTES, "UTF-8");
$nombre=htmlentities($nombre, ENT_QUOTES, "UTF-8");
$asunto=(strlen($asunto)>=1)?'<strong>Asunto: </strong>'.$asunto:'';

//Cargo el HTML
$message = file_get_contents('contacto.html',FILE_USE_INCLUDE_PATH);
//Aplicamos valores
$ano = date('Y');
$message = str_replace('%mensaje%', '<strong>Mensaje: </strong>'.$mensaje, $message);
$message = str_replace('%nombre%', '<strong>Nombre: </strong>'.$nombre, $message);
$message = str_replace('%email%', '<strong>Email: </strong>'.$email, $message);
$message = str_replace('%asunto%', $asunto, $message);

$message = str_replace('%ip%', $realip, $message);
$message = str_replace('%navegador%', $navegador, $message);
$message = str_replace('%ano%', $ano, $message);

$message=micro_sanear_string($message);

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(true); // telling the class to use SMTP
$mail->SMTPOptions = array(
  'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
  )
);

try {
  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "mail.agenciawebporta.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
  $mail->Username   = "mailer@agenciawebporta.com";  // GMAIL username
  $mail->Password   = "yxeVqPUv";            // GMAIL password
  $mail->AddReplyTo('soporte@fisae.com.py', 'Soporte Fisae');

  $mail->AddAddress($email, $nombre); // RECIPIENTE
  // $mail->AddBCC("info@fisae.com.py","Soporte Fisae"); // RECIPIENTE COPIA OCULTA
  $mail->AddBCC("fiorella@fisae.com.py", "Fiorella Di Pardo"); // RECIPIENTE COPIA OCULTA

  $mail->SetFrom('fisae@fisae.com.py', 'Fisae');
  $mail->Subject = 'Fisae: Nuevo mail para Fisae';
  $mail->AltBody = 'Para visualizar este mensaje, por favor use un correo compatible con contenidos HTML!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML($message);

  if (strlen($destino)>=5) {
    $mail->AddAttachment('/var/www/fisae.agenciawebporta.com/public/'.$destino);      // attachment
  }
  // $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  // echo "Message Sent OK<p></p>\n";
} catch (phpmailerException $e) {
  // echo $e->errorMessage(); //Pretty error messages from PHPMailer
  $error=true;
} catch (Exception $e) {
  // echo $e->getMessage(); //Boring error messages from anything else!
  $error=true;
}

// try {
//   $mail->ClearAllRecipients();
//   $mail->clearAttachments();
//   $mail->AddAddress($email, $nombre); // RECIPIENTE
//   $mail->Send();
// } catch (phpmailerException $e) {
//   // echo $e->errorMessage(); //Pretty error messages from PHPMailer
//   $error=true;
// } catch (Exception $e) {
//   // echo $e->getMessage(); //Boring error messages from anything else!
//   $error=true;
// }

?>
