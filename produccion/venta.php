<?php
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
  include('../config.php');
    $table='';
    $sql="SELECT * FROM carrito_detalles WHERE id_carrito='$carrito_id_mail' AND cod_plan<2";
    $result=mysql_query($sql);
    $total=0;
    $totalSinEnvio=0;
    $envio=0;
    while ($row=mysql_fetch_array($result))
    {
      $comentarios=$row['comentarios']; $comentarios=htmlentities($comentarios, ENT_QUOTES, "UTF-8");
      $imagen=$root.'public/'.$row['imagen'];
      // $total=$total+$row['total'];
      $precio=number_format ($row['total'],0,",",".");
      $totalSinEnvio=$totalSinEnvio+$row['total'];
      $titulo=htmlentities($row['titulo'], ENT_QUOTES, "UTF-8");
      $table=$table.'<table class="content" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"> <tbody> <tr> <td class="content_cell product_row" align="center" valign="top" style="padding: 24px 0;text-align: center;background-color: #ffffff;border-top: 1px solid;border-color: #feefe6;font-size: 0 !important;"> <div class="row" style="display: inline-block;width: 100%;vertical-align: top;text-align: center;max-width: 600px;margin: 0 auto;"> <div class="col-1" style="display: inline-block;width: 100%;vertical-align: top;text-align: center;max-width: 200px;"> <table class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;vertical-align: top;"> <tbody> <tr> <td class="column_cell font_default image_thumb" align="center" valign="top" style="padding: 8px 16px;font-family: Helvetica, Arial, sans-serif;font-size: 16px;text-align: center;vertical-align: top;color: #0033b5;"><img src="'.$imagen.'" width="168" height="168" alt="" style="line-height: 1;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;mso-line-height-rule: exactly;-webkit-border-radius: 4px;border-radius: 4px;"></td><!-- /.column_cell:image_thumb --> </tr> </tbody> </table> </div> <div class="col-13" style="display: inline-block;width: 100%;vertical-align: top;text-align: center;max-width: 400px;"> <table class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;vertical-align: top;"> <tbody> <tr> <td class="column_cell font_default" align="center" valign="top" style="padding: 8px 16px;font-family: Helvetica, Arial, sans-serif;font-size: 16px;text-align: left;vertical-align: top;color: #0033b5;"> <h4 style="font-family: Helvetica, Arial, sans-serif;margin-left: 0;margin-right: 0;margin-top: 16px;margin-bottom: 8px;padding: 0;font-size: 19px;line-height: 28px;font-weight: normal;color: #4e5558;"><span style="color: #afb0b1;">'.$row['cantidad'].'<small>x</small></span> <strong>'.$titulo.'</strong></h4> <h6 style="font-family: Helvetica, Arial, sans-serif;margin-left: 0;margin-right: 0;margin-top: 0;margin-bottom: 8px;padding: 0;font-size: 30px;line-height: 34px;font-weight: bold;color: #0033b5;">GS. '.$precio.'</h6></td> </tr> </tbody> </table> </div> </div> </td> </tr> </tbody></table>';
    }

    $sql2="SELECT * FROM carrito WHERE id='$carrito_id_mail'";
    $result2=mysql_query($sql2);
    while ($row2=mysql_fetch_array($result2))
    {
      $direccion=$row2['direccion']; $direccion=htmlentities($direccion, ENT_QUOTES, "UTF-8");
      $barrio=$row2['barrio']; $barrio=htmlentities($barrio, ENT_QUOTES, "UTF-8");
      $ciudad=$row2['ciudad']; $ciudad=htmlentities($ciudad, ENT_QUOTES, "UTF-8");
      $departamento=$row2['departamento']; $departamento=htmlentities($departamento, ENT_QUOTES, "UTF-8");
      $cod_user=$row2['id_usuario'];
      $metodo=$row2['metodo'];
      $uuid=$row2['uuid'];
      $total=$row2['total'];
    }

    $sql3="SELECT * FROM fb_login_users WHERE id='$cod_user'";
    $result3=mysql_query($sql3);
    while ($row3=mysql_fetch_array($result3))
    {
      $nombre_persona=$row3['last_name'].' '.$row3['first_name'];
      $email_user=$row3['email'];
      $telefono_user=$row3['telefono'];
      $celular_user=$row3['celular'];

    }

    $envio=$total-$totalSinEnvio;
  $total=number_format ($total,0,",",".");
  $envio=number_format ($envio,0,",",".");
  $totalSinEnvio=number_format ($totalSinEnvio,0,",",".");
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

  //Cargo el HTML
  $message = file_get_contents('venta.html',FILE_USE_INCLUDE_PATH);
  //Aplicamos valores
  $ano = date('Y');
  $message = str_replace('%aclatatoria%', $aclaratoria, $message);
  $message = str_replace('%comentarios%', $comentarios, $message);
  $message = str_replace('%nombre%', $nombre_persona, $message);
  $message = str_replace('%email%', $email_user, $message);
  $message = str_replace('%telefono%', $telefono_user, $message);
  $message = str_replace('%celular%', $celular_user, $message);
  $message = str_replace('%metodo%', $metodo, $message);
  $message = str_replace('%ip%', $realip, $message);
  $message = str_replace('%navegador%', $navegador, $message);
  $message = str_replace('%ano%', $ano, $message);
  $message = str_replace('%detalles%', $detalles, $message);
  $message = str_replace('%id%', $detalles, $message);
  $message = str_replace('%comentarios%', $comentarios, $message);

  $message = str_replace('%direccion%', $direccion, $message);
  $message = str_replace('%barrio%', $barrio, $message);
  $message = str_replace('%ciudad%', $ciudad, $message);
  $message = str_replace('%departamento%', $departamento, $message);

  $message = str_replace('%uuid%', $uuid, $message);
  $message = str_replace('%id_pedido%', $carrito_id_mail, $message);
  $message = str_replace('%total%', $total, $message);

  ///tabla
  $message = str_replace('%table%', $table, $message);
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
    $mail->CharSet    = "UTF-8";

    $mail->AddReplyTo("soporte@fisae.com.py","Soporte Fisae");
    $mail->AddAddress($email_user, $nombre_persona);
    // $mail->AddBCC("federico@porta.com.py","Desarrollo Porta");
    // $mail->AddBCC("info@fisae.com.py","Soporte Fisae");
    // $mail->AddBCC("fiorella@fisae.com.py","Fiorella Di Pardo");
    $mail->AddBCC("fiorella@fisae.com.py", "Fiorella Di Pardo"); // RECIPIENTE COPIA OCULTA

    $mail->SetFrom("fisae@fisae.com.py","Fisae");
    $mail->Subject = 'Fisae: Hemos recepcionado tu pedido!';
    $mail->AltBody = 'Para visualizar este mensaje, por favor use un correo compatible con contenidos HTML!'; // optional - MsgHTML will create an alternate automatically
    $mail->MsgHTML($message);
    //$mail->AddAttachment('images/phpmailer.gif');      // attachment
    //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
    $mail->Send();
    // echo "Message Sent OK<p></p>\n";
  } catch (phpmailerException $e) {
    // echo $e->errorMessage(); //Pretty error messages from PHPMailer
  } catch (Exception $e) {
    // echo $e->getMessage(); //Boring error messages from anything else!
  }




?>
