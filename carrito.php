<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <?php
	 $map_perfil=false;
    $the_maps=true;
	$p = "Carrito";
        include 'head-new.php';

        // traer el numero de giros tigo que se carga en el panel
        $sql_numero_tigo = mysql_query("SELECT * FROM metodos_pago WHERE metodo = 'comprar7' ORDER BY id DESC LIMIT 1");
        while ($row_numero_tigo = mysql_fetch_assoc($sql_numero_tigo)) {
          $numero_tigo = $row_numero_tigo['descripcion'];
        }

        //VINO CIUDAD?

        if (isset($_POST['alias_token'])) {
          //para pago con tarjetas catastradas
          $alias_token=$_POST['alias_token'];
          $amount=$_POST['amount'];
          $fb_id=$_POST['fb_id'];
          $the_id_carrito=$_POST['the_id_carrito'];
          define("ROOT_DIR","http://".$_SERVER['SERVER_NAME']."/");
          require_once("/var/www/fisae.agenciawebporta.com/pagar/bancard-js.php");
          $bancard = new Bancard();
          $charge = $bancard -> charge($fb_id,$amount,$the_id_carrito, $alias_token);
          if($charge->status == "success")
          {
            $VpStatus = "aprobado";
          }
          else
          {
            $VpStatus = "rechazado";
          }
          $sql_confirmacion = "UPDATE vpos SET
                VpStatus 						= '$VpStatus',
                token 							= '{$charge->confirmation->token}',
                response 						= '{$charge->confirmation->response}',
                response_details 				= '{$charge->confirmation->response_details}',
                response_code 					= '{$charge->confirmation->response_code}',
                response_description 			= '{$charge->confirmation->response_description}',
                extended_response_description 	= '{$charge->confirmation->extended_response_description}',
                amount 							= '{$charge->confirmation->amount}',
                currency 						= '{$charge->confirmation->currency}',
                authorization_number 			= '{$charge->confirmation->authorization_number}',
                ticket_number 					= '{$charge->confirmation->ticket_number}',
                card_source 					= '{$charge->confirmation->security_information->card_source}',
                customer_ip 					= '{$charge->confirmation->security_information->customer_ip}',
                card_country 					= '{$charge->confirmation->security_information->card_country}',
                version 						= '{$charge->confirmation->security_information->version}',
                risk_index 						= '{$charge->confirmation->security_information->risk_index}'
              WHERE process_id = '{$charge->confirmation->shop_process_id}'";
          mysql_query($sql_confirmacion);

          $aux_hash=md5($charge->confirmation->shop_process_id);
          echo '<script>window.location = "'.$raiz.'carrito?pago='.$aux_hash.'";</script>';

          exit();
        }

		if (isset($_GET['c']))
		{
			$clave=$_GET['c'];
			if ($clave>=1)
			{
				$sqlDireccion="SELECT * FROM direcciones WHERE id='$clave'";
				$resultDireccion=mysql_query($sqlDireccion);
				while ($rowDireccion=mysql_fetch_array($resultDireccion))
				{
					$direccion_user_2=$rowDireccion['direccion'];
					$barrio_user_2=$rowDireccion['barrio'];
					$cod_departamento_user_2=$rowDireccion['cod_departamento'];
					$departamento_user_2=$rowDireccion['departamento'];
					$cod_ciudad_user_2=$rowDireccion['cod_ciudad'];
					$ciudad_user_2=$rowDireccion['ciudad'];
				}
			}
			else
			{
				$direccion_user_2=$direccion_user;
				$barrio_user_2=$barrio_user;
				$cod_departamento_user_2=$cod_departamento_user;
				$departamento_user_2=$departamento_user;
				$cod_ciudad_user_2=$cod_ciudad_user;
				$ciudad_user_2=$ciudad_user;
			}
		}
		else
		{
			$direccion_user_2=$direccion_user;
			$barrio_user_2=$barrio_user;
			$cod_departamento_user_2=$cod_departamento_user;
			$departamento_user_2=$departamento_user;
			$cod_ciudad_user_2=$cod_ciudad_user;
			$ciudad_user_2=$ciudad_user;
		}

		$espacios = array('"', ' ');
    ?>
    <body class="blog-list wpb-js-composer js-comp-ver-5.0.1 vc_responsive  pace-done">
        <div id="page" class="hfeed site">
    <?php

        include 'menu-compra.php';

    ?>

    <?php
      if (isset($_POST['cantidad'])) {
          $sql_carrito=mysql_query("SELECT id from carrito WHERE id_usuario='$carrito_user_id' and estado='0' order by id desc limit 1");
          while ($row_carrito=mysql_fetch_array($sql_carrito)) {
            $cod_carrito=$row_carrito['id'];
          }

          $id_carrito_detalle=$_POST['id_carrito_detalle'];
          $cantidad=$_POST['cantidad'];

          mysql_query("UPDATE carrito_detalles set cantidad='$cantidad', total=cantidad*precio WHERE id='$id_carrito_detalle' and estado='0' and id_carrito='$cod_carrito'");


          $sql_sum=mysql_query("SELECT SUM(total) as total FROM carrito_detalles WHERE id_carrito='$cod_carrito'");
      		while ($row_sum=mysql_fetch_array($sql_sum)) {
      			$total=$row_sum['total'];

      			mysql_query("UPDATE carrito SET total='$total' WHERE id='$cod_carrito'");
      		}
        }
        // confirmar compra
        if (isset($_POST['confirmar'])) {
      $comprar = true;
			$amount=$_POST['amount'];
			$comentarios=$_POST['comentarios'];
      $TheTotal=$_POST['amount'];
			$metodo=$_POST['metodo'];
      $the_id_carrito=$_POST['the_id_carrito'];
      $carrito_id_mail=$the_id_carrito;

      if ($metodo=='comprar3') {

        $_POST['fb_id']=$fb_id;
        // include_once('pagar/index.php');

        if (isset($_POST['cod_direccion'])) {
				$cod_direccion=$_POST['cod_direccion'];
        if ($cod_direccion=='propio') {
					$direccion_user_2=$direccion_user;
					$barrio_user_2=$barrio_user;
					$ciudad_user_2=$ciudad_user;
					$cod_ciudad_user_2=$cod_ciudad_user;
					$cod_departamento_user_2=$cod_departamento_user;
					$departamento_user_2=$departamento_user;
          $latitud_2=$latitud_user;
          $longitud_2=$longitud_user;
          $nombre_2=$nombre_persona;
          $telefono_2=$telefono_user;
          $celular_2=$celular_user;
          $referencias_2=$referencias_user;
          $horario_2=$horario_user;
				}else {
					$sqlDir="SELECT * FROM direcciones WHERE id='$cod_direccion'";
					$resultDir=mysql_query($sqlDir);
					while ($rowDir=mysql_fetch_array($resultDir))
					{
						$direccion_user_2=$rowDir['direccion'];
						$barrio_user_2=$rowDir['barrio'];
						$cod_ciudad_user_2=$rowDir['cod_ciudad'];
						$ciudad_user_2=$rowDir['ciudad'];
						$cod_departamento_user_2=$rowDir['cod_departamento'];
						$departamento_user_2=$rowDir['departamento'];
            $latitud_2=$rowDir['latitud'];
            $longitud_2=$rowDir['longitud'];
            $nombre_2=$rowDir['nombre'];
            $telefono_2=$rowDir['telefono'];
            $celular_2=$rowDir['celular'];
            $referencias_2=$rowDir['referencias'];
            $horario_2=$rowDir['horario'];
					}
				}
				$sqlUpdate="SELECT * FROM carrito_detalles WHERE id_usuario = $fb_id and estado = 0";
				$resultUpdate=mysql_query($sqlUpdate);
				while ($rowUpdate=mysql_fetch_array($resultUpdate))
				{
					$thCarritoId=$rowUpdate['id_carrito'];
				}
				$aux_con_descuento=$TheTotal-$descuento;
				if ($aux_con_descuento<=0) {
					$aux_con_descuento=0;
				}
        $fecha_compra=date('Y-m-d H:i:s');
				$updateSQL="UPDATE carrito SET direccion='$direccion_user_2', barrio='$barrio_user_2', ciudad='$ciudad_user_2', departamento='$departamento_user_2', total='$aux_con_descuento', fecha_compra='$fecha_compra', latitud='$latitud_2', longitud='$longitud_2', nombre='$nombre_2', telefono='$telefono_2', celular='$celular_2', referencias='$referencias_2', horario='$horario_2', cod_direccion='$cod_direccion' WHERE id='$thCarritoId'";
				mysql_query($updateSQL);
        mysql_query("UPDATE carrito_detalles SET comentarios='$comentarios' WHERE id_carrito='$thCarritoId'");
        include_once('pago_online_template.php');
        exit();
			}
      }

			$gift_card=$_POST['gift-card'];
      $nombre_firmante=$_POST['nombre_firmante'];
      $ci_firmante=$_POST['ci_firmante'];
      $telefono_firmante=$_POST['telefono_firmante'];
      $banco_firmante=$_POST['banco_firmante'];
      $numero_cuenta_firmante=$_POST['numero_cuenta_firmante'];
      $gift_card=strtoupper($_POST['gift-card']);
			$descuento=0;
			$query_sgc = mysql_query("SELECT valor FROM gift_cards WHERE UCASE(hash)='$gift_card' and estado='1'");
			while ($row_sgc = mysql_fetch_array($query_sgc))
			{
		    $descuento=$row_sgc['valor'];
			}
      $dia=date('d');
				$mes=date('m');
				$ano=date('Y');
				$fecha_actual=date('Y-m-d');
				$query_cupones = mysql_query("SELECT valor FROM cupones WHERE UCASE(codigo)='$gift_card' and date(vencimiento)>='$fecha_actual' ");
				while ($row_cupones = mysql_fetch_array($query_cupones))
				{
			    $descuento=round(($row_cupones['valor']*$TheTotal)/100);
				}
        if (isset($_POST['cod_direccion'])) {
				$cod_direccion=$_POST['cod_direccion'];
        if ($cod_direccion=='propio') {
					$direccion_user_2=$direccion_user;
					$barrio_user_2=$barrio_user;
					$ciudad_user_2=$ciudad_user;
					$cod_ciudad_user_2=$cod_ciudad_user;
					$cod_departamento_user_2=$cod_departamento_user;
					$departamento_user_2=$departamento_user;
          $latitud_2=$latitud_user;
          $longitud_2=$longitud_user;
          $nombre_2=$nombre_persona;
          $telefono_2=$telefono_user;
          $celular_2=$celular_user;
          $referencias_2=$referencias_user;
          $horario_2=$horario_user;
				}else {
					$sqlDir="SELECT * FROM direcciones WHERE id='$cod_direccion'";
					$resultDir=mysql_query($sqlDir);
					while ($rowDir=mysql_fetch_array($resultDir))
					{
						$direccion_user_2=$rowDir['direccion'];
						$barrio_user_2=$rowDir['barrio'];
						$cod_ciudad_user_2=$rowDir['cod_ciudad'];
						$ciudad_user_2=$rowDir['ciudad'];
						$cod_departamento_user_2=$rowDir['cod_departamento'];
						$departamento_user_2=$rowDir['departamento'];
            $latitud_2=$rowDir['latitud'];
            $longitud_2=$rowDir['longitud'];
            $nombre_2=$rowDir['nombre'];
            $telefono_2=$rowDir['telefono'];
            $celular_2=$rowDir['celular'];
            $referencias_2=$rowDir['referencias'];
            $horario_2=$rowDir['horario'];
					}
				}
				$sqlUpdate="SELECT * FROM carrito_detalles WHERE id_usuario = $fb_id and estado = 0";
				$resultUpdate=mysql_query($sqlUpdate);
				while ($rowUpdate=mysql_fetch_array($resultUpdate))
				{
					$thCarritoId=$rowUpdate['id_carrito'];
				}
				$aux_con_descuento=$TheTotal-$descuento;
				if ($aux_con_descuento<=0) {
					$aux_con_descuento=0;
				}
        $fecha_compra=date('Y-m-d H:i:s');
				$updateSQL="UPDATE carrito SET direccion='$direccion_user_2', barrio='$barrio_user_2', ciudad='$ciudad_user_2', departamento='$departamento_user_2', total='$aux_con_descuento', gift_card='$gift_card',descuento='$descuento', nombre_firmante='$nombre_firmante', ci_firmante='$ci_firmante', telefono_firmante='$telefono_firmante', banco_firmante='$banco_firmante', numero_cuenta_firmante='$numero_cuenta_firmante', fecha_compra='$fecha_compra', latitud='$latitud_2', longitud='$longitud_2', nombre='$nombre_2', telefono='$telefono_2', celular='$celular_2', referencias='$referencias_2', horario='$horario_2', cod_direccion='$cod_direccion' WHERE id='$thCarritoId'";
				mysql_query($updateSQL);
			}
      $inserta_detalles = "UPDATE carrito_detalles SET comentarios = '$comentarios' WHERE id_usuario = '$fb_id' and estado = 0";
			mysql_query($inserta_detalles);

      if ($metodo=='comprar1')
			{
				$metodo_text = 'Efectivo - Contra Entrega';
				$aclaratoria = 'Te contactaremos para confirmar tu pedido y verificar tu pago en efectivo.';
			}
			if ($metodo=='comprar2')
			{
				$metodo_text = 'Cheque - Contra Entrega';
				$aclaratoria = 'Es necesario que este emitido a nombre de Ferretería Industrial S.A.E y que complete los datos del firmante';
			}
			if ($metodo=='comprar4')
			{
				$metodo_text = 'Tarjetas de Crédito - Contra Entrega';
				$aclaratoria = 'Podes pagar con cualquier tarjeta VISA, MASTERCARD, AMERICAN EXPRESS, PANAL, CABAL.';
			}
			if ($metodo=='comprar5')
			{
				$metodo_text = 'Tarjeta de Débito - Contra Entrega';
				$aclaratoria = 'Podes pagar con cualquier tarjeta de débito emitida por Bancos o Financieras que operan en Paraguay.';
			}
      if ($metodo=='comprar6')
			{
				$metodo_text = 'Depósito Bancario';
				$aclaratoria = '<p>Este es el banco y nuestro número de cuenta donde puedes hacer tu deposito o transferencia:</p>
				<br /><ul>
				<li><strong>ITAU:</strong> 300510654</li>
				<li><strong>BNF:</strong> 5300925743/7</li>
				<li><strong>Regional:</strong> 4101020830</li>
				<li><strong>BNA:</strong> 533165</li>
				<li><strong>Visión:</strong> 900389814</li>

        </ul>
        <p>
        <strong>RUC: 80021625-3<br />
        RAZON SOCIAL: FERRETERIA INDUSTRIAL S.A.E.
        </strong>
        </p>
				<br /><p>Los depósitos deben ir a nombre de <strong>Ferretería Industrial S.A.E</strong><br /> Te pedimos que cuando realices tu pago nos envíes por correo o celular la imagen de tu boleta de depósito o nos llames para avisar que ya hiciste el pago, así nosotros podemos verificar en nuestro banco y hacerte la entrega de tu pedido.</p>';
			}
      if ($metodo=='comprar7') {
        $metodo_text = 'Giros Tigo';
        $aclaratoria = '<p>
          Nos podes hacer un Giros Tigo directamente a nuestro número oficial <strong>'.$numero_tigo.'</strong>. Tenés que contemplar que pueden aplicar costos por hacer el Giro, es importante considerar que nosotros debemos recibir el importe total de la venta para poder liberar el pedido.
        </p>';
      }

			if ($metodo=='GiftCard') {
				$metodo_text="Pago Completo vía Gift Card";
				$aclaratoria = 'Felicidades! su Gift Card cubre completamente el importe de su compra procederemos a enviar su carrito.';
			}
			$metodo = $metodo_text;
			$fecha_compra = date('Y-m-d H:i:s');
			$inserta_detalles = "UPDATE carrito SET estado = 1, metodo = '$metodo', fecha = '$fecha_compra', total='$amount' WHERE id_usuario = $fb_id and estado = 0 AND id='$carrito_id_mail'";
			mysql_query("SET NAMES UTF8");
			mysql_query($inserta_detalles);
			$inserta_detalles = "UPDATE carrito_detalles SET estado = 1, comentarios='$comentarios' WHERE id_usuario = '$fb_id' and estado = 0 AND id_carrito='$carrito_id_mail'";
			mysql_query($inserta_detalles);
      include_once('mailer/venta.php');
    }
    // de bancard
    // GET BANCARD
							if(isset($_GET['pago']))
							{
								$process_id_get=$_GET['pago'];
								$sql="SELECT * FROM carrito_detalles WHERE id_usuario = $fb_id and estado = 0";
								$result=mysql_query($sql);
								while ($row=mysql_fetch_array($result))
								{
									$the_id_carrito = ''.$row["id_carrito"].'';
									$comentarios = ''.$row["comentarios"].'';
								}
                $sql_ultimo = "SELECT * FROM vpos WHERE mi_carrito = '$the_id_carrito' order by VpCod DESC LIMIT 1";
								$resultado_ultimo = mysql_query($sql_ultimo);
								while ($row=mysql_fetch_array($resultado_ultimo))
								{
								  $process_id=$row['process_id'];
                  $carrito_id_mail=$row['mi_carrito'];
								}
								$process_id_md5 = md5($process_id);

								if ($process_id_md5==$process_id_get)
								{
									require_once("/var/www/fisae.agenciawebporta.com/pagar/bancard-js.php");
									$bancard = new Bancard();
									// CANCELÓ?
                  $sql_vpos = "SELECT * FROM vpos WHERE process_id = '$process_id'";
                  $resultado_vpos = mysql_query($sql_vpos);
                  while ($vpos=mysql_fetch_array($resultado_vpos))
                  {
                    $DescRespAut = $vpos['response_description'];
                    $CodAut = $vpos['authorization_number'];
                    $ImpNeto = $vpos['VpMonto'];
                    $confirmation_vpos = $vpos['response_code'];
                  }
                  $uuid = $process_id;
                  if ($confirmation_vpos<>'00') {
                    $cancelar=true;
                  }else {
                    $cancelar=false;
                  }

									if(isset($_GET['cancelar']) && $cancelar==true)
									{
										$bancard -> rollback($process_id);
										$uuid = $process_id;
										$DescRespAut = 'Transacción cancelada por el usuario.';
										$cod_error=1;
										$text_error=$DescRespAut.' Hubo un problema al realizar su pago!';
										// require('/var/www/fisae.agenciawebporta.com/mail/cancela.php');
									}
									else
									{
										$sql_vpos = "SELECT * FROM vpos WHERE process_id = '$process_id'";
										$resultado_vpos = mysql_query($sql_vpos);
										while ($vpos=mysql_fetch_array($resultado_vpos))
										{
											$DescRespAut = $vpos['response_description'];
											$CodAut = $vpos['authorization_number'];
											$ImpNeto = $vpos['VpMonto'];
											$confirmation_vpos = $vpos['response_code'];
											$extended_response_description = $vpos['extended_response_description'];
										}
										$uuid = $process_id;
										if ($confirmation_vpos=='00')
										{
											$fecha_compra = date('Y-m-d H:i:s');
											$metodo='Pago Online Bancard ';
											$actualiza_carrito = "UPDATE carrito SET estado = 1, metodo = '$metodo', fecha = '$fecha_compra', uuid = '$process_id', monto_total = '$ImpNeto', respuesta = '$DescRespAut', referencia = '$CodAut' WHERE id_usuario = $fb_id and estado = 0 AND id='$carrito_id_mail'";
											mysql_query($actualiza_carrito);
											$actualiza_detalles = "UPDATE carrito_detalles SET estado = 1 WHERE id_usuario = $fb_id and estado = 0 AND id_carrito='$carrito_id_mail'";
											mysql_query($actualiza_detalles);
                      $comprar=true;
											//Enviamos Mail
											include_once('mailer/venta.php');
									    }
									    else
									    {
											$cod_error=1;
											$text_error=''.$DescRespAut.' '.$extended_response_description.' Hubo un problema al realizar su pago!';
										    $bancard -> rollback($process_id);
									    }
									}
								}
								else
								{
                  $cod_error=1;
                  $text_error='Hubo un problema al realizar su pago! '.$extended_response_description.'';

								}
							}
     ?>


<div id="content" class="site-content" tabindex="-1">
    <div class="container">
        <nav class="woocommerce-breadcrumb"><a href="<?php echo $root;?>">Inicio</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Tu Carrito</nav>
        <div id="" class="content-area">
          <main id="main" class="site-main">
                  <article class="page type-page status-publish hentry mb-4">
                    <?php if ($comprar==true): ?>
                      <header class="entry-header"><h1 itemprop="name" class="entry-title">Resumen <span class="pink_strong">de la compra</span></h1></header><!-- .entry-header -->
                      <div class="alert alert-success alert-dismissible fade in" role="alert"> <strong>¡Felicidades!</strong> Fisae acaba de recibir tu pedido de compra. ¡Muchas gracias por la preferencia! </div>
                      <table class="shop_table shop_table_responsive cart">
                        <thead>
                          <tr>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Producto</th>
                            <th class="product-price">Precio</th>
                            <th class="product-subtotal">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $aux_totalizador=0;
                          $sql_detalle_contado=mysql_query("SELECT * FROM carrito_detalles WHERE id_carrito = '$carrito_id_mail'");
                          while ($row_con=mysql_fetch_array($sql_detalle_contado)) {
                            $id_detalle=$row_con['id'];
                            $foto_producto=$row_con['imagen'];
                            $productoquery=$row_con['titulo'];
                            $carrito_comentario=$row_con['comentarios'];
                            $id_producto=$row_con['id_producto'];
                            $regalo=$row_con['regalo'];
                            $cod_articulo=$row_con['cod_articulo'];
                            $precio=$row_con['precio'];
                            $cantidad=$row_con['cantidad'];
                            $total_item=$precio*$cantidad;
                            $productoquery_url = str_replace($espacios, '-', $productoquery);
                            $productoquery_url=sanear_string($productoquery_url);
                            if (strpos($foto_producto, '.jpg') !== false || strpos($foto_producto, '.JPG') || strpos($foto_producto, '.JPEG') || strpos($foto_producto, '.jpeg') !== false) {
                                $foto_min=$root.'imagen/300__300__'.$foto_producto;
                            }elseif (strpos($foto_producto, '.gif') !== false || strpos($foto_producto, '.GIF') !== false) {
                              $foto_min=$root.'imagen_gif/300__300__'.$foto_producto;
                            }elseif (strpos($foto_producto, '.png') !== false || strpos($foto_producto, '.PNG') !== false) {
                              $foto_min=$root.'imagen_png/300__300__'.$foto_producto;
                            }else {
                              $foto_min=$root.'public/'.$foto_producto;
                            }
                            if ($regalo=='Si') {
                                $cod_lista=$row_con['cod_lista'];
                                $sql_lista=mysql_query("SELECT * FROM listas_regalos WHERE id='$cod_lista'");
                                while ($row_li=mysql_fetch_array($sql_lista)) {
                                  $titulo_lista='';
                                  if ($row_li['tipo_lista']=='bodas') {
                                    $titulo_lista='Ferreteria de '.$row_li['nombre_el'].' para el '.date('d/m/Y',strtotime($row_li['fecha_evento']));
                                  }
                                }
                              }
                            ?>
                            <tr class="cart_item  <?php if($regalo=='Si'){echo 'regalo-item';} ?>"  <?php if ($regalo=='Si') { echo 'data-toggle="tooltip" data-placement="bottom" title="'.$titulo_lista.'"'; } ?>>
                              <td class="product-thumbnail-display" data-title="Imagen">
                                <a href="<?php echo $root.'producto/'.$id_producto.'/'.$productoquery_url?>"><img width="180" height="180" src="<?php echo $foto_min;?>" alt=""></a>
                              </td>
                              <td data-title="Producto" class="product-name">
                                <a href="<?php echo $root.'producto/'.$id_producto.'/'.$productoquery_url?>"><?php echo $productoquery;?></a>
                              </td>
                              <td data-title="Precio" class="product-price">
                                <span class="amount"><?php echo $cantidad.' x Gs. '.number_format ($precio,0,",",".").''; ?></span>
                              </td>
                              <td data-title="Total" class="product-subtotal">
                                <span class="amount"><?php echo 'Gs. '.number_format ($total_item,0,",",".").''; ?></span>
                              </td>
                            </tr>
                            <?php
                            $aux_totalizador+=$total_item;
                            //totalizador no  ofertas
                            $sql_is_oferta=mysql_query("SELECT * FROM productos WHERE cod_articulo='$id_producto' AND oferta<>'1'");
                            if (mysql_num_rows($sql_is_oferta)>=1) {
                              $total_no_oferta+=$total_item;
                            }
                            //totalizador no ofertas
                          } ?>
                          </tbody>
                        </table>
                        <br><br>
                        <?php
                        $sql_datos=mysql_query("SELECT * FROM carrito WHERE id='$carrito_id_mail'");
                        while ($row_data=mysql_fetch_array($sql_datos)) {
                          $carrito_direccion=$row_data['direccion'];
                          $carrito_barrio=$row_data['barrio'];
                          $carrito_ciudad=$row_data['ciudad'];
                          $carrito_departamento=$row_data['departamento'];
                          $carrito_metodo=$row_data['metodo'];
                          $carrito_total=$row_data['total'];
                          $carrito_descuento=$row_data['descuento'];
                          $carrito_gift_card=$row_data['gift_card'];
                          $latitud_res=$row_data['latitud'];
                          $longitud_res=$row_data['longitud'];
                          $nombre_res=$row_data['nombre'];
                          $telefono_res=$row_data['telefono'];
                          $celular_res=$row_data['celular'];
                          $referencias_res=$row_data['referencias'];
                          $cod_direccion_res=$row_data['cod_direccion'];
                          $horario_res=$row_data['horario'];
                          $diferencia=$carrito_total-$aux_totalizador;
                        }
                        ?>
                        <table class="table table-hover">
                          <tr>
                            <th colspan="2"><center><strong>Resumen</strong></center></th>
                          </tr>
                              <tr>
                                <td><strong>Dirección de entrega:</strong></td>
                                <td class="success"><?php echo $carrito_direccion ?></td>
                              </tr>
                              <?php if (strlen($carrito_barrio)>=1): ?>
                                <tr>
                                  <td><strong>Barrio de entrega:</strong></td>
                                  <td class="success"><?php echo $carrito_barrio ?></td>
                                </tr>
                              <?php endif; ?>
                              <tr>
                                <td><strong>Ciudad de entrega:</strong></td>
                                <td class="success"><?php echo $carrito_ciudad ?></td>
                              </tr>
                              <tr>
                                <td><strong>Departamento de entrega:</strong></td>
                                <td class="success"><?php echo $carrito_departamento ?></td>
                              </tr>
                              <tr>
                                <td><strong>Mapa</strong></td>
                                <td>
                                  <input id="latitud" type="text" name="latitud" hidden="" value="<?php echo $latitud_res ?>">
                                  <input id="longitud" type="text" name="longitud" hidden="" value="<?php echo $longitud_res ?>">
                                  <div id="map" style="width: 100%; height: 200px" ></div>
                                  <input id="pac-input-1" class="controls " type="text" placeholder="Buscar referencia">
                                </td>
                              </tr>
                              <tr>
                                <td><strong>Referencias</strong></td>
                                <td><?php echo $referencias_res ?></td>
                              </tr>
                              <tr>
                                <td><strong>Nombre</strong></td>
                                <td><?php echo $nombre_res ?></td>
                              </tr>
                              <?php if (strlen($telefono)>=1): ?>
                                <tr>
                                  <td><strong>Teléfono</strong></td>
                                  <td><?php echo $telefono ?></td>
                                </tr>
                              <?php endif; ?>
                              <?php if (strlen($celular_res)>=1): ?>
                                <tr>
                                  <td><strong>Celular</strong></td>
                                  <td><?php echo $celular_res ?></td>
                                </tr>
                              <?php endif; ?>
                              <tr>
                                <td><strong>Horario disponible para la recepción</strong></td>
                                <td>
                                  <?php if ($horario_res=='1'): ?>
                                      De 08:00 a 12:00
                                    <?php else: ?>
                                      De 13:00 a 17:00
                                  <?php endif; ?>
                                </td>
                              </tr>
                          <tr>
                            <td><strong>Método:</strong></td>
                            <td class="success"><?php echo $carrito_metodo ?></td>
                          </tr>
                          <?php if (strlen($carrito_comentario)>=1): ?>
                            <tr>
                              <td><strong>Comentario:</strong></td>
                              <td class="success"><?php echo $carrito_comentario ?></td>
                            </tr>
                          <?php endif; ?>

                          <?php if ($carrito_descuento>=1): ?>
                            <tr>
                              <td><strong>Descuento:</strong></td>
                              <td class="success">Gs. <?php echo number_format ($carrito_descuento,0,",",".") ?></td>
                            </tr>
                            <tr>
                              <td><strong>Código Descuento:</strong></td>
                              <td class="success"><?php echo $carrito_gift_card ?></td>
                            </tr>
                          <?php endif; ?>

                          <?php if (strtoupper($carrito_metodo)==strtoupper('Efectivo - Contra Entrega')): ?>
                            <tr>
                              <td><strong>Sub Total:</strong></td>
                              <td class="success">Gs. <?php echo number_format (($carrito_total),0,",",".") ?></td>
                            </tr>


                            <?php else: ?>
                              <tr>
                                <td><strong>Sub Total:</strong></td>
                                <td class="success">Gs. <?php echo number_format (($carrito_total-$diferencia),0,",",".") ?></td>
                              </tr>
                              <?php if ($diferencia>=1): ?>
                                <tr>
                                  <td><strong>Envío:</strong></td>
                                  <td class="success">Gs. <?php echo number_format ($diferencia,0,",",".") ?></td>
                                </tr>
                              <?php else: ?>
                                <tr>
                                  <td><strong>Envío:</strong></td>
                                  <td class="success">Sin Costo</td>
                                </tr>
                              <?php endif; ?>

                          <?php endif; ?>
                          <tr>
                            <td><strong>Total:</strong></td>
                            <td class="success"><strong>Gs. <?php echo number_format ($carrito_total,0,",",".") ?></strong></td>
                          </tr>
                        </table>

                        <?php else:
                          $sql_carito_id=mysql_query("SELECT id FROM carrito WHERE id_usuario='$carrito_user_id' and estado='0' ORDER BY id DESC LIMIT 1");
                          while ($row_carrito_id=mysql_fetch_array($sql_carito_id)) {
                            $the_cod_carrito=$row_carrito_id['id'];
                          }
                          $sql_cantidades=mysql_query("SELECT COUNT(*)  as contados FROM carrito_detalles WHERE id_carrito = '$the_cod_carrito'");
                          while ($row_cant=mysql_fetch_array($sql_cantidades)) {
                            $cantidad_de_contados=$row_cant['contados'];
                          }
                          ?>
                          <?php if ($cantidad_de_contados>=1): ?>
                            <header class="entry-header"><h1 itemprop="name" class="entry-title">Tu <span class="pink_strong">Carrito</span></h1></header><!-- .entry-header -->
                            
                            <table class="shop_table shop_table_responsive cart">
                              <thead>
                                <tr>
                                  <th class="product-remove">&nbsp;</th>
                                  <th class="product-thumbnail-display">&nbsp;</th>
                                  <th class="product-name">Producto</th>
                                  <th class="product-price">Precio</th>
                                  <th class="product-quantity">Cantidad</th>
                                  <th class="product-subtotal">Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                // ---------------------- LOS PRODUCTOS ------------------------ //
                                $Sql100="SELECT * from carrito_detalles where id_carrito = '$the_cod_carrito' and estado='0'";
                                $result100=mysql_query($Sql100,$link);
                                $hayitems=mysql_num_rows($result100);
                                $total=0;
                                $total_cuotas=0;
                                while ($row100=mysql_fetch_array($result100))
                                {
                                  $id_detalle=$row100['id'];
                                  $foto_producto=$row100['imagen'];
                                  $productoquery=$row100['titulo'];
                                  $id_producto=$row100['id_producto'];
                                  $cod_articulo=$row100['cod_articulo'];
                                  $regalo=$row100['regalo'];
                                  $precio=$row100['precio'];
                                  $total_item=$row100['total'];
                                  $cantidad=$row100['cantidad'];
                                  $regalo=$row100['regalo'];
                                  if ($regalo=='Si') {
                                      $cod_lista=$row100['cod_lista'];
                                      $sql_lista=mysql_query("SELECT * FROM listas_regalos WHERE id='$cod_lista'");
                                      while ($row_li=mysql_fetch_array($sql_lista)) {
                                        $titulo_lista='';
                                        if ($row_li['tipo_lista']=='bodas') {
                                          $titulo_lista='Ferreteria de '.$row_li['nombre_el'].' para el '.date('d/m/Y',strtotime($row_li['fecha_evento']));
                                        }
                                      }
                                    }
                                  $productoquery_url = str_replace($espacios, '-', $productoquery);
                                  $productoquery_url=sanear_string($productoquery_url);
                                  $monto_cuota=0;
                                  $aux_url='producto';
                                  $cantidad_maxima=0;

                                  $aux_cod_articulo = 0;
                                  $sql_aux_cod_articulo = mysql_query("SELECT cod_articulo FROM productos WHERE id = $cod_articulo");
                                  while ($row_aux_cod_articulo = mysql_fetch_assoc($sql_aux_cod_articulo)) {
                                    $aux_cod_articulo = $row_aux_cod_articulo['cod_articulo'];
                                  }
                              		$sql_cantidad_disponible=mysql_query("SELECT stock FROM stock WHERE cod_articulo='$cod_articulo'");
                              		while ($row_cantidad_disponible=mysql_fetch_array($sql_cantidad_disponible)) {
                              			$cantidad_maxima=$row_cantidad_disponible['stock'];

                              		}   
                                  // echo '<script>console.log("SELECT stock FROM stock WHERE cod_articulo='.$cod_articulo.'")</script>';

                                  if (strpos($foto_producto, '.jpg') !== false || strpos($foto_producto, '.JPG') || strpos($foto_producto, '.JPEG') || strpos($foto_producto, '.jpeg') !== false) {
                                      $foto_min=$root.'imagen/300__300__'.$foto_producto;
                                  }elseif (strpos($foto_producto, '.gif') !== false || strpos($foto_producto, '.GIF') !== false) {
                                    $foto_min=$root.'imagen_gif/300__300__'.$foto_producto;
                                  }elseif (strpos($foto_producto, '.png') !== false || strpos($foto_producto, '.PNG') !== false) {
                                    $foto_min=$root.'imagen_png/300__300__'.$foto_producto;
                                  }else {
                                    $foto_min=$root.'public/'.$foto_producto;
                                  }
                                  ?>

                                  <tr class="cart_item <?php if($regalo=='Si'){echo 'regalo-item';} ?>"  <?php if ($regalo=='Si') { echo 'data-toggle="tooltip" data-placement="bottom" title="'.$titulo_lista.'"'; } ?>>

                                    <td class="product-remove">
                                      <a class="remove reload" href="<?php echo $id_detalle;?>" >×</a>
                                    </td>

                                    <td class="product-thumbnail-display" data-title="Imagen">
                                      <a href="<?php echo $root.'producto/'.$id_producto.'/'.$productoquery_url?>"><img width="180" height="180" src="<?php echo $foto_min;?>" alt=""></a>
                                    </td>

                                    <td data-title="Producto" class="product-name">

                                      <a href="<?php echo $root.'producto/'.$id_producto.'/'.$productoquery_url?>"><?php echo $productoquery;?></a>
                                    </td>

                                    <td data-title="Precio" class="product-price">
                                      <span class="amount"><?php echo 'Gs. '.number_format ($precio,0,",",".").''; ?></span>
                                    </td>

                                    <td data-title="Cantidad" class="product-quantity">
                                      <div class="quantity buttons_added">
                                        <form class="" action="" method="post">
                                          <input type="hidden" name="id_carrito_detalle" value="<?php echo $id_detalle ?>">
                                          <select name="cantidad" class="input-text qty text form-control pull-right" onchange="this.form.submit()">
                                            <?php for ($i=1; $i <=$cantidad_maxima ; $i++) {  ?>
                                              <option value="<?php echo $i ?>" <?php if($cantidad==$i){ echo'selected=""'; } ?>><?php echo $i ?></option>
                                            <?php } ?>
                                          </select>
                                        </form>
                                      </div>
                                    </td>
                                    <?php if ($cuota>1):
                                      $total_cuotas+=($monto_cuota*$cantidad);
                                      ?>
                                      <td data-title="Total" class="product-subtotal">
                                        <span class="amount"><?php echo 'Gs. '.number_format ($monto_cuota*$cantidad,0,",",".").''; ?></span>
                                      </td>
                                    <?php else:
                                      $total+=$total_item;
                                      //totalizador no  ofertas
                                      $sql_is_oferta=mysql_query("SELECT * FROM productos WHERE cod_articulo='$id_producto' AND oferta<>'1'");
                                      if (mysql_num_rows($sql_is_oferta)>=1) {
                                        $total_no_oferta+=$total_item;
                                      }
                                      //totalizador no ofertas
                                      ?>
                                      <td data-title="Total" class="product-subtotal">
                                        <span class="amount"><?php echo 'Gs. '.number_format ($total_item,0,",",".").''; ?></span>
                                      </td>
                                    <?php endif; ?>

                                  </tr>
                                  <?php

                                }
                                ?>
                              </tbody>
                            </table>
                            <p class="mesaje-carrito">*Productos sujetos a disponibilidad de stock</p>
                            <article id="post-8" class="hentry">
                              <div class="entry-content">
                                <div class="woocommerce">
                                  <div class="col2-set" >

                                    <div class="col-1">
                                      <?php if (session_is_live() && $cod_departamento_user_2<>NULL): ?>

                                        <form name="confirmar" action="<?php echo $raiz; ?>carrito" method="post">
                                          <h2>Seleccionar Método de Pago</h2>
                                          <table class="zebra">

                                            <tfoot>

                                              <tr class="metodo">

                                                <td style="width: 200px;">Método de Pago</td>
                                                <td>

                                                  <select id="select" name="metodo" class="form-control">
                                                    <?php
                                                    $metodos="SELECT * FROM ciudades where id = $cod_ciudad_user_2";
                                                    $metodos_sql=mysql_query($metodos,$link);
                                                    while ($rme=mysql_fetch_array($metodos_sql))
                                                    {
                                                      $efectivo = $rme["efectivo"];
                                                      $cheque = $rme["cheque"];
                                                      $t_credito_online = $rme["t_credito_online"];
                                                      $t_credito_entrega = $rme["t_credito_entrega"];
                                                      $t_debito_entrega = $rme["t_debito_entrega"];
                                                      $deposito = $rme["deposito"];
                                                      $cantidad_metodo=0;
                                                      $giros_tigo = $rme["giros_tigo"];
                                                      if ($t_credito_online==1)
                                                      { /*
                                                        if ($_GET['m']=='comprar3') {
                                                          echo '<option class="metodo-pago" selected="" value="comprar3">Pago Online - Tarjetas de Crédito</option>';
                                                        }else {
                                                          echo '<option class="metodo-pago" value="comprar3">Pago Online - Tarjetas de Crédito</option>';
                                                        }
                                                        */
                                                        $cantidad_metodo++;
                                                      }
                                                      if ($efectivo==1)
                                                      {
                                                        if ($_GET['m']=='comprar1') {
                                                          echo '<option class="metodo-pago" selected="" value="comprar1">Efectivo - Contra Entrega</option>';
                                                        }else {
                                                          echo '<option class="metodo-pago" value="comprar1">Efectivo - Contra Entrega</option>';
                                                        }
                                                        $cantidad_metodo++;
                                                      }
                                                      if ($cheque==1)
                                                      {
                                                        if ($_GET['m']=='comprar2') {
                                                          echo '<option class="metodo-pago"  selected="" value="comprar2">Cheque - Contra Entrega</option>';
                                                        }else {
                                                          echo '<option class="metodo-pago" value="comprar2">Cheque - Contra Entrega</option>';
                                                        }
                                                        $cantidad_metodo++;
                                                      }
                                                      if ($t_credito_entrega==1)
                                                      {
                                                        if ($_GET['m']=='comprar4') {
                                                          echo '<option class="metodo-pago"  selected="" value="comprar4">Tarjetas de Crédito - Contra Entrega</option>';
                                                        }else {
                                                          echo '<option class="metodo-pago" value="comprar4">Tarjetas de Crédito - Contra Entrega</option>';
                                                        }
                                                        $cantidad_metodo++;
                                                      }
                                                      if ($t_debito_entrega==1)
                                                      {
                                                        if ($_GET['m']=='comprar5') {
                                                          echo '<option class="metodo-pago"  selected="" value="comprar5">Tarjeta de Débito - Contra Entrega</option>';
                                                        }else {
                                                          echo '<option class="metodo-pago" value="comprar5">Tarjeta de Débito - Contra Entrega</option>';
                                                        }
                                                        $cantidad_metodo++;
                                                      }
                                                      if ($deposito==1)
                                                          {
                                                            if ($_GET['m']=='comprar6') {
                                                              echo '<option class="metodo-pago"  selected="" value="comprar6">Depósito Bancario</option>';
                                                            }else {
                                                              echo '<option class="metodo-pago" value="comprar6">Depósito Bancario</option>';
                                                            }
                                                            $cantidad_metodo++;
                                                          }

                                                          if ($cantidad_metodo>=1) {
                                                            if ($_GET['m']=='comprar3') {
                                                              # code...
                                                            }else {
                                                              # code...
                                                            }
                                                            // echo '<option class="metodo-gratis" value="GiftCard">Pago Completo por Gift Card</option>';
                                                          }
                                                          if ($giros_tigo) {
                                                            if ($_GET['m']=='comprar7') {
                                                              echo '<option class="metodo-pago"  selected="" value="comprar7">Giros Tigo</option>';
                                                            } else {
                                                              echo '<option class="metodo-pago" value="comprar7">Giros Tigo</option>';
                                                            }
                                                          }
                                                    }


                                                    ?>
                                                  </select>

                                                </td>
                                              </tr>

                                              <tr class="metodo" style="display: none;">
                                                <td style="width: 200px;">Descripción</td>
                                                <td id="info-holder"></td>
                                              </tr>
                                              <!-- seccion solo para cheques -->

                                              <!-- <tr class="solo-cheques" style="display: none;">
                                                <td>Nombre del firmante</td>
                                                <td><input type="text" class="form-group with-100" placeholder="Nombre del firmante" name="nombre_firmante" value=""></td>
                                              </tr>
                                              <tr class="solo-cheques" style="display: none;">
                                                <td>C.I.</td>
                                                <td><input type="text" class="form-group with-100" placeholder="C.I." name="ci_firmante" value=""></td>
                                              </tr>
                                              <tr class="solo-cheques" style="display: none;">
                                                <td>Teléfono</td>
                                                <td><input type="text" class="form-group with-100" placeholder="Teléfono" name="telefono_firmante" value=""></td>
                                              </tr>
                                              <tr class="solo-cheques" style="display: none;">
                                                <td>Banco</td>
                                                <td><input type="text" class="form-group with-100" placeholder="Banco" name="banco_firmante" value=""></td>
                                              </tr>
                                              <tr class="solo-cheques" style="display: none;">
                                                <td>Número de cuenta</td>
                                                <td><input type="text" class="form-group with-100" placeholder="Número de cuenta" name="numero_cuenta_firmante" value=""></td>
                                              </tr> -->
                                              <tr class="metodo">

                                                <td style="width: 200px;">Seleccionar Dirección</td>
                                                <td>
                                                  <select id="direccion" name="cod_direccion" class="form-control">

                                                    <option value="propio" <?php if('propio'==$clave){ echo 'selected=""';} ?> ><?php echo ($direccion_user) ?> - <?php echo ($ciudad_user) ?></option>
                                                    <?php
                                                    $sqlDirecciones="SELECT * FROM direcciones WHERE cod_usuario='$fb_id' order by id desc";
                                                    $resultDirecciones=mysql_query($sqlDirecciones);
                                                    while ($rowDirecciones=mysql_fetch_array($resultDirecciones))
                                                    {
                                                      ?>
                                                      <option value="<?php echo $rowDirecciones['id'] ?>" <?php if($rowDirecciones['id']==$clave){ echo 'selected=""';} ?>>
                                                        <?php echo ($rowDirecciones['direccion']) ?> - <?php echo ($rowDirecciones['ciudad']) ?>
                                                      </option>
                                                      <?php
                                                    }
                                                    ?>
                                                    <option value="new"><strong>-- Cargar Nuevo --</strong></option>
                                                  </select>
                                                </td>
                                              </tr>
                                              <?php if ($clave>=1):
                                                $sql_direccion=mysql_query("SELECT * FROM direcciones WHERE id='$clave'");
                                                while ($row_direccion=mysql_fetch_array($sql_direccion)) {
                                                  $recep_nombre=$row_direccion['nombre'];
                                                  $recep_telefono=$row_direccion['telefono'];
                                                  $recep_celular=$row_direccion['celular'];
                                                  $recep_latitud=$row_direccion['latitud'];
                                                  $recep_longitud=$row_direccion['longitud'];
                                                  $recep_referencias=$row_direccion['referencias'];
                                                  $recep_horario=$row_direccion['horario'];
                                                }

                                                ?>
                                                <tr>
                                                  <td>Receptor</td>
                                                  <td><?php echo $recep_nombre ?></td>
                                                </tr>
                                                <tr>
                                                  <td>Teléfono</td>
                                                  <td><?php echo (strlen($recep_celular)>=1)?$recep_celular:$recep_telefono; ?></td>
                                                </tr>
                                                <tr>
                                                  <td>Ubicación</td>
                                                  <td>
                                                    <input id="latitud" type="text" name="latitud" hidden="" value="<?php echo $recep_latitud ?>">
                                                    <input id="longitud" type="text" name="longitud" hidden="" value="<?php echo $recep_longitud ?>">
                                                    <div id="map" style="width: 100%; height: 200px" ></div>
                                                    <input id="pac-input-1" class="controls " type="text" placeholder="Buscar referencia">

                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>Referencias</td>
                                                  <td><?php echo $recep_referencias ?></td>
                                                </tr>

                                                <tr>
                                                  <td>Horario disponible para la recepción</td>
                                                  <td>
                                                    <?php if ($recep_horario==1): ?>
                                                      De 08:00 a 12:00
                                                    <?php else: ?>
                                                      De 13:00 a 17:00
                                                    <?php endif; ?>
                                                  </td>
                                                </tr>
                                              <?php else: ?>
                                                <tr>
                                                  <td>Receptor</td>
                                                  <td><?php echo $nombre_persona ?></td>
                                                </tr>
                                                <tr>
                                                  <td>Teléfono</td>
                                                  <td><?php echo (strlen($celular_user)>=1)?$celular_user:$telefono_user; ?></td>
                                                </tr>
                                                <tr>
                                                  <td>Ubicación</td>
                                                  <td>
                                                    <input id="latitud" type="text" name="latitud" hidden="" value="<?php echo $latitud_user ?>">
                                                    <input id="longitud" type="text" name="longitud" hidden="" value="<?php echo $longitud_user ?>">
                                                    <div id="map" style="width: 100%; height: 200px" ></div>
                                                    <input id="pac-input-1" class="controls " type="text" placeholder="Buscar referencia">

                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>Referencias</td>
                                                  <td><?php echo $referencias_user ?></td>
                                                </tr>

                                                <tr>
                                                  <td>Horario disponible para la recepción</td>
                                                  <td>
                                                    <?php if ($horario_user==1): ?>
                                                      De 08:00 a 12:00
                                                    <?php else: ?>
                                                      De 13:00 a 17:00
                                                    <?php endif; ?>
                                                  </td>
                                                </tr>
                                              <?php endif; ?>
                                              <tr>
                                                <td style="width: 200px;">Comentarios</td>
                                                <td>
                                                  <div class="table_wrap">

                                                    <textarea name="comentarios"  style="height: 100px;" placeholder="Opcional: Comentarios sobre detalles a tener en cuenta en la compra"><?php echo $comentarios; ?></textarea>

                                                  </div>
                                                </td>
                                              </tr>



                                            </tfoot>

                                          </table>

                                        <?php endif; ?>
                                      </div><!-- .col-1 -->

                                      <div class="col-2">



                                        <h2>Totales</h2>

                                        <table class="zebra">
                                          <tfoot>
                                            <?php
                                            if ($cod_departamento_user_2<>NULL)
                                            {
                                              ?>
                                              <tr class="totals">
                                                <td>Sub-Total (IVA Incld.)</td>
                                                <td><?php echo ' Gs. '.number_format ($total,0,",",".").'';?></td>
                                              </tr>
                                              <tr>
                                                <td>Envío a <?php echo ($ciudad_user_2); ?></td>
                                                <?php /*
                                                $cal_sql = "SELECT * FROM ciudades where id = $cod_ciudad_user_2";
                                                $res_cal=mysql_query($cal_sql);
                                                while ($rc=mysql_fetch_array($res_cal))
                                                {
                                                  $cien_millon = ''.$rc["cien_millon"].'';
                                                  $millon_dos = ''.$rc["millon_dos"].'';
                                                  $dos_tres = ''.$rc["dos_tres"].'';
                                                  $tres_cuatro = ''.$rc["tres_cuatro"].'';
                                                  $cuatro_cinco = ''.$rc["cuatro_cinco"].'';
                                                  $mayor_cinco = ''.$rc["mayor_cinco"].'';

                                                  if ($total<100000)
                                                  {
                                                    echo '<td style="color: red;">Debe superar el mínimo <br />de compra por Gs. 100.000</td>';
                                                  }else {
                                                    $triggger_finalizar=true;
                                                  }
                                                  if ($total>=100000 && $total<=1000000)
                                                  {
                                                    $total = $total + $cien_millon;
                                                    if ($cien_millon==0){$texto_envio='Gratis!';}
                                                    else {$texto_envio='Gs. '.number_format ($cien_millon,0,",",".").'';}
                                                    echo '<td style="color: green;">Envío '.$texto_envio.'</td>';
                                                  }elseif ($total>=1000001 && $total<=2000000)
                                                  {
                                                    $total = $total + $millon_dos;
                                                    if ($millon_dos==0){$texto_envio='Gratis!';}
                                                    else {$texto_envio='Gs. '.number_format ($millon_dos,0,",",".").'';}
                                                    echo '<td style="color: green;">Envío '.$texto_envio.'</td>';
                                                  }elseif ($total>=2000001 && $total<=3000000)
                                                  {
                                                    $total = $total + $dos_tres;
                                                    if ($dos_tres==0){$texto_envio='Gratis!';}
                                                    else {$texto_envio='Gs. '.number_format ($dos_tres,0,",",".").'';}
                                                    echo '<td style="color: green;">Envío '.$texto_envio.'</td>';
                                                  }elseif ($total>=3000001 && $total<=4000000)
                                                  {
                                                    $total = $total + $tres_cuatro;
                                                    if ($tres_cuatro==0){$texto_envio='Gratis!';}
                                                    else {$texto_envio='Gs. '.number_format ($tres_cuatro,0,",",".").'';}
                                                    echo '<td style="color: green;">Envío '.$texto_envio.'</td>';
                                                  }elseif($total>=4000001 && $total<=5000000)
                                                  {
                                                    $total = $total + $cuatro_cinco;
                                                    if ($cuatro_cinco==0){$texto_envio='Gratis!';}
                                                    else {$texto_envio='Gs. '.number_format ($cuatro_cinco,0,",",".").'';}
                                                    echo '<td style="color: green;">Envío '.$texto_envio.'</td>';
                                                  }elseif($total>=5000001)
                                                  {
                                                    $total = $total + $mayor_cinco;
                                                    if ($mayor_cinco==0){$texto_envio='Gratis!';}
                                                    else {$texto_envio='Gs. '.number_format ($mayor_cinco,0,",",".").'';}
                                                    echo '<td style="color: green;">Envío '.$texto_envio.'</td>';
                                                  }                                                  
                                                }
                                                */
                                                ?>

                                              </tr>
                                              <tr id="gift-holder">
                                                <td style="width: 200px;">Descuento</td>
                                                <td id="gift-amont"></td>
                                              </tr>

                                              <tr class="totals totales_contado">

                                                <td>Total (IVA Incld.)</td>
                                                <td id="total-holder"><?php echo ' Gs. '.number_format ($total,0,",",".").'';?></td>

                                              </tr>

                                              <?php
                                            }
                                            else
                                            {
                                              ?>
                                              <tr class="totals totales_contado">
                                                <td>Sub-Total (IVA Incld.)</td>
                                                <td><?php echo ' Gs. '.number_format ($total,0,",",".").'';?></td>
                                              </tr>
                                              <?php
                                            }
                                            ?>





                                            <input type="hidden" id="aux_total" value="<?php echo $total ?>">
                                            <input type="hidden" id="fb_id"  value="<?php echo $fb_id ?>">
                                            <input type="hidden" id="id_caarito"  value="<?php echo $carrito_id_cupon ?>">
                                          </tfoot>
                                        </table>

                                        <?php
                                        if ($cod_departamento_user_2<>NULL)
                                        { //inicialmente $total>=100000 
                                          if ($total>=1000 || $total_cuotas>=1)
                                          {

                                            ?>
                                            <input type="hidden" name="amount" id="amount_hidden" value="<?php echo $total; ?>" />
                                            <input type="hidden" name="the_id_carrito" value="<?php echo $the_cod_carrito; ?>" />
                                            <button class="btn btn-primary btn-blue btn-white-new" name="confirmar">COMPRAR!</button>
                                            <div class="single_link_wrap">
                                              <a></a>
                                            </div>

                                            <?php
                                          }
                                          else
                                          {
                                            ?>
                                            <a href="<?php echo $raiz; ?>index" class="btn btn-primary btn-white-new">Sigamos Comprando!</a>
                                            <div class="single_link_wrap">
                                              <p class="before-login-text">Necesitas Gs. 100.000 como mínimo para realizar la compra en línea! <br />Sigamos comprando :D</p>
                                            </div>
                                            <?php
                                          }
                                        }
                                        else
                                        {
                                          ?>
                                          <?php if (session_is_live()):
                                                    $map_perfil=true;
                                                    ?>
                                                    <a href="" data-toggle="modal" data-target="#modal_completar" id="boton_completar" class="btn btn-primary fontwhite">Completa tu Perfil!</a>
                                                    <div class="single_link_wrap customer_login" >
                                                    <br>
                                                    <p class="before-login-text">Lo necesitamos para procesar con mayor exactitud los tiempos y costos de envío de tu compra.</p>
                                                    </div>
                                                  <?php else: ?>
                                                    <a href="" id="boton_registro" data-toggle="modal" data-target=".modal_registro" class="btn btn-primary fontwhite">Registrarse</a>
                                                    <a href="" id="boton_registro" data-toggle="modal" data-target=".modal_ingreso" class="btn btn-primary fontwhite">Iniciar Sesión</a>
                                                    <div class="single_link_wrap customer_login" >
                                                    </div>
                                                  <?php endif; ?>

                                          <?php
                                        }

                                        ?>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </article>
                            <?php else: ?>
                              <header class="entry-header"><h1 itemprop="name" class="entry-title">Tu <span class="destacadonaranja">Carrito</span></h1></header><!-- .entry-header -->

                                  <div class="alert alert-warning alert-dismissible fade in mar-bt-30" role="alert"> <strong><i class="fa fa-exclamation" aria-hidden="true"></i> Este carrito aún no posee ningún producto.</strong> Navegue por nuestra Web y seleccione sus productos favoritos! </div>
                          <?php endif; ?>
                    <?php endif; ?>


                  </article>
                </main>
        </div>
    </div>

	</div>

           <?php
				include 'footer-new.php';
		   ?>

        </div>
		        <!-- Modales -->
        <div class="modal fade" id="edittodoItemForm" aria-hidden="true" aria-labelledby="edittodoItemForm" role="dialog" tabindex="-1" data-show="false">
          <div class="modal-dialog" style="width:900px;">
            <form class="" action="" method="post">
              <div id="id-receptor">

              </div>
            </form>
          </div>
        </div>

        <div id="modal_cliente_datos" class="modal fade modal_ingreso no-border" role="dialog" style="z-index:999999">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" >
              <button type="button" class="btn btn-default" data-dismiss="modal">x</button>
              <div class="modal-body">
                <div class="row" id="customer_login">

                  <div class="col-sm-12">

                    <h2>Iniciar Sesión</h2>

                    <form method="post" class="login" id="form_ingreso">

                      <p class="before-login-text">Bienvenido! Inicia sesión con su cuenta</p>
                      <!-- <div class="g-signin2" data-onsuccess="onSignIn" style="display: inline-flex;margin-right: 10px;">
                      </div>
                      <fb:login-button
                      	scope="public_profile,email"
                    	>
                      Iniciar Sesión
                    </fb:login-button> -->

                    <p class="form-row form-row-wide">
                      <label for="username">Correo Electrónico<span class="required">*</span></label>
                      <input type="text" class="input-text" name="login" id="username" value="" />
                    </p>

                    <p class="form-row form-row-wide">
                      <label for="password">Contraseña<span class="required">*</span></label>
                      <input class="input-text" type="password" name="password" id="password" />
                    </p>

                    <p class="form-row">
                      <?php if (strlen($redirect_to)>=1): ?>
                        <input type="hidden" name="redirect_to" value="<?php echo $redirect_to ?>">
                      <?php endif; ?>
                      <input class="button" type="submit" value="Iniciar Sesión" id="boton_inicio_session" name="login_btn">

                    </p>
                    <input type="hidden" name="ingresar_usuario" />
                    <p class="lost_password"><a href="<?php echo $raiz ?>login/recuperar" class="the-link">Ha olvidado su contraseña?</a></p><br>
                  </form>

                </div>

              </div>
              <!-- .col2-set -->

            </div>

          </div>

        </div>
      </div>
    <div id="modal_cliente_datos" class="modal fade modal_registro no-border" role="dialog" style="z-index:999999">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" >
          <button type="button" class="btn btn-default" data-dismiss="modal">x</button>
          <div class="modal-body">
            <div class="row" id="customer_login">

              <div class="col-sm-12">

                <h2>Registrarse</h2>

                <form method="post" class="register" id="form_register">

                  <p class="before-register-text">Crea tu propia cuenta</p>
                  <!-- <div class="g-signin2" data-onsuccess="onSignIn" style="display: inline-flex;margin-right: 10px;">
                  </div>
                  <fb:login-button
                  	scope="public_profile,email"
                	>
                  Registrarse
                </fb:login-button> -->

                <p class="form-row form-row-wide">
                  <label for="reg_email">Correo Electrónico<span class="required">*</span></label>
                  <input type="email" class="input-text" name="email" id="reg_email" value="" />
                </p>
                <p class="form-row form-row-wide">
                  <label for="password">Contraseña<span class="required">*</span></label>
                  <input class="input-text" type="password" name="password" id="password" />
                </p>

                <p class="form-row form-row-wide">
                  <label for="nombre">Nombre<span class="required">*</span></label>
                  <input type="text" class="input-text" name="last_name" id="nombre" value="" />
                </p>
                <p class="form-row form-row-wide">
                  <label for="apellido">Apellido<span class="required">*</span></label>
                  <input type="text" class="input-text" name="first_name" id="apellido" value="" />
                </p>
                <p class="form-row form-row-wide">
                  <label for="ruc">Número de <abbr title="Cédula de Identidad">C.I.</abbr> o <abbr title="Registro Único de Contribuyente">R.U.C</abbr></label>
                  <input type="text" class="input-text" name="ruc" id="ruc" value="" required="" />
                </p>
                <?php if (strlen($redirect_to)>=1): ?>
                  <input type="hidden" name="redirect_to" value="<?php echo $redirect_to ?>">
                <?php endif; ?>

                <p class="form-row">
                  <input type="submit" class="button" name="create_account_btn" value="Registrarse" />
                </p>

                <div class="register-benefits">
                  <h3>Registrate hoy y podras acceder a:</h3>
                  <ul>
                    <li>Comprar de forma segura y rápida.</li>
                    <li>Seguir el estado de tu pedido de forma fácil.</li>
                    <li>Mantener un historial de todas tus compras.</li>
                  </ul>
                </div>

              </form>

            </div>
            <!-- .col-2 -->

          </div>
          <!-- .col2-set -->

        </div>

      </div>

    </div>
  </div>

		<div id="modal_completar" class="modal fade" role="dialog" style="z-index:999999">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
        <form class="" action="" method="post" id="from-modificar-datos">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Modificar datos</h4>
			  </div>
			  <div class="modal-body">

  				<div class="row hide" data-step="1" data-title="Primer Paso">
  				  <div class="jumbotron" style="background-color: inherit;">
              <div class="col-1">
                <p class="form-row form-row-wide">
                    <label for="nombre">Nombre <span class="required">*</span></label>
                    <input type="text" class="input-text" name="nombres" id="nombre" value="<?php echo $last_name ?>" focus="on" required=""/>
                </p>
                <p class="form-row form-row-wide">
                    <label for="apellido">Apellido <span class="required">*</span></label>
                    <input type="text" class="input-text" name="apellidos" id="apellido" value="<?php echo $first_name ?>" required=""/>
                </p>

                <p class="form-row form-row-wide">
                    <label for="ci_user">C.I. / R.U.C. <span class="required">*</span></label>
                    <input type="text" class="input-text" name="ci" id="ci_user" value="<?php echo $ci_user ?>"/>
                </p>
                <p class="form-row form-row-wide">
                    <label for="email_user">Dirección de E-Mail <span class="required">*</span></label>
                    <input type="text" class="input-text" name="email" id="email_user" value="<?php echo $email_user ?>" required=""/>
                </p>
                <p class="form-row form-row-wide">
                    <label for="telefono_user">Teléfono</label>
                    <input type="text" class="input-text" name="telefono" id="telefono_user" value="<?php echo $telefono_user ?>"/>
                </p>

                <p class="form-row form-row-wide">
                    <label for="celular_user">Celular <span class="required">*</span></label>
                    <input type="text" class="input-text" name="celular" id="celular_user" value="<?php echo $celular_user ?>" required=""/>
                </p>


              </div>

            </div>
  				</div>
  				<div class="row hide" data-step="2" data-title="Segundo Paso">
  				  <div class="jumbotron" style="background-color: inherit;">
              <div class="col-1">
                <p class="form-row form-row-wide">
                    <label for="ciudad_user">Ciudad <span class="required">*</span></label>

                    <select name="cod_ciudad" id="select2-1 " class="form-control input-text" required="">
                        <?php
                        if ($cod_ciudad_user==NULL)
                        {
                          echo '<option value=" ">--- Seleccionar Ciudad ---</option>';
                          $sql = "SELECT * FROM ciudades order by id asc";
                        }
                        else
                        {
                          echo '<option value="'.$cod_ciudad_user.'">'.($ciudad_user).' ('.($departamento_user).')</option>';
                          $sql = "SELECT * FROM ciudades WHERE id <> $cod_ciudad_user order by id asc";
                        }
                        $query = mysql_query($sql);
                        while ( $results[] = mysql_fetch_object ( $query ) );
                        array_pop ( $results );
                        foreach ( $results as $option ) : ?>
                            <option value="<?php echo $option->id; ?>"><?php echo ($option->departamento); ?> >> <?php echo ($option->ciudad); ?></option>
                        <?php endforeach; ?>
                      </select>
                </p>

                <p class="form-row form-row-wide">
                    <label for="barrio_user">Barrio</label>
                    <input type="text" class="input-text" name="barrio" id="barrio_user" value="<?php echo $barrio_user ?>"/>
                </p>
                <p class="form-row form-row-wide">
                    <label for="direccion_user">Dirección <span class="required">*</span></label>
                    <input type="text" class="input-text" name="direccion" id="direccion_user" value="<?php echo $direccion_user ?>" required=""/>
                </p>
                <p class="form-row form-row-wide">
                    <label for="referencias">Referencias para llegar <span class="required">*</span></label>
                    <textarea name="referencias" id="referencias"  class="input-text" style="min-height: 1em;"><?php echo $referencias_user ?></textarea>
                </p>

                <p class="form-row form-row-wide">
                    <label for="horario">Horario disponible para la recepción <span class="required">*</span></label>
                    <select class="input-text" name="horario" id="horario" >
                      <option value="1" <?php if($horario_user=='1'){ echo 'selected=""';} ?> >De 08:00 a 12:00</option>
                      <option value="2" <?php if($horario_user=='2'){ echo 'selected=""';} ?> >De 13:00 a 17:00</option>
                    </select>
                </p>


              </div>
            </div>
  				</div>
  				<div class="row hide" data-step="3" data-title="Tercer Paso">
  				  <div class="jumbotron" style="background-color: inherit;">
              <div id="map" style="width: 100%; height: 200px" ></div>
              <input id="pac-input-1" class="controls " type="text" placeholder="Buscar referencia">
              <input id="latitud" type="text" name="latitud" value="<?php echo $latitud_user; ?>" hidden="">
            <input id="longitud" type="text" name="longitud" value="<?php echo $longitud_user; ?>" hidden="">
            </div>
  				</div>
			  </div>
			  <div class="modal-footer">
          <input type="hidden" name="fb_id" value="<?php echo $fb_id ?>">
				<button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"></button>
				<button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button>
				<button type="button" class="btn btn-success js-btn-step" data-orientation="next"></button>
			  </div>
      </form>
			</div>

		  </div>
		</div>

		<?php
			include "scripts-new.php"
		?>


    <script>
    window.fbAsyncInit = function() {
    FB.init({
    appId      : '1947344618864153',
    cookie     : true,
    xfbml      : true,
    version    : 'v2.10'
    });
    FB.AppEvents.logPageView();
    };

    (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/es_LA/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    

    <script type="text/javascript">
      $(document).ready(function(){
        // $('.abcRioButtonContents').children("span")
        setTimeout(function () {
          $($('.abcRioButtonContents').children("span")[0]).html('Iniciar Sesión');
          $($('.abcRioButtonContents').children("span")[1]).html('Iniciar Sesión');
          $($('.abcRioButtonContents').children("span")[2]).html('Registrarse');
          $($('.abcRioButtonContents').children("span")[3]).html('Registrarse');
        }, 1500);
      });
    </script>


	<script>
      var marker;
			$('#modal_completar').modalSteps({
				btnCancelHtml: 'Cerrar',
				btnPreviousHtml: 'Anterior',
				btnNextHtml: 'Siguiente',
				btnLastStepHtml: 'Actualizar datos',
				disableNextButton: false,
				completeCallback: function(){
          var lat = marker.getPosition().lat();
          var lng = marker.getPosition().lng();
          $('#longitud').val(lat);
          $('#latitud').val(lng);
          $('#from-modificar-datos').submit();
        },
				callbacks: {}
				});



      $(document).ready(function(){

        $("#from-modificar-datos").submit(function(e){
              e.preventDefault();
              e.stopPropagation();
              var form = $("#from-modificar-datos").serialize();
              $.ajax( {
                  type: "POST",
                  url: "<?php echo $raiz;?>ajax/actualizar_datos.php",
                  data: form,
                  success: function( data ) {
                    if (data.length>=8) {
                      swal(
                        'Error',
                        data,
                        'error'
                      );
                    }else {
                      window.location.reload();
                    }
                  }
                } );
          })


        $('.js-btn-step').click(function(){
          google.maps.event.trigger(map, "resize");
        });
          $('select').select2();
        $(".no_tengo_cuenta").on("click",function(){
          $("#modal_cliente_datos").find(".col-1").css("display","none");
          $("#modal_cliente_datos").find(".col-2").fadeIn();

        });
        $(".ya_tengo_cuenta").on("click",function(){

          $("#modal_cliente_datos").find(".col-2").css("display","none");
          $("#modal_cliente_datos").find(".col-1").fadeIn();


        });
        function addPuntos(nStr)
        {
          nStr += '';
          var x = nStr.split('.');
          var x1 = x[0];
          var x2 = x.length > 1 ? '.' + x[1] : '';
          var rgx = /(\d+)(\d{3})/;
          while (rgx.test(x1)) {
              x1 = x1.replace(rgx, '$1' + '.' + '$2');
          }
          return x1 + x2;
        }

        $('#the-cupon').keyup(function(){
          var var_1=$(this).val();
          var var_2='<?php echo $total; ?>';
          var var_4='<?php echo $the_cod_carrito; ?>';
          $.ajax( {
              type: "POST",
              url: "<?php echo $raiz;?>ajax/cupon.php",
              data: {var_1:var_1, var_2:var_2, var_3:'<?php echo cifrar($carrito_user_id) ?>', var_4:var_4},
              success: function( data ) {
                data=Number(data);
                if (data>=100) {
                  $('#total-holder').html('Gs. '+addPuntos(Math.round(var_2-data)));
                  $('#gift-holder').show();
                  $('#gift-amont').html('Gs. '+addPuntos(Math.round(data)));
                }else {
                  $('#total-holder').html('Gs. '+addPuntos(Math.round(var_2)));
                  $('#gift-holder').hide();
                }

                }
            } );
        });

      });

		</script>
	<script type="text/javascript">
        $(document).ready(function(){
          $('#form_ingreso').submit(function(event){
            event.preventDefault();
            event.stopPropagation();
            var form = $('#form_ingreso').serialize();
            $.ajax( {
                type: "POST",
                url: "<?php echo $raiz;?>ajax/login.php",
                data: form,
                success: function( data ) {
                  if (data.length>=8) {
                    swal(
                      'Error',
                      data,
                      'error'
                    );
                  }else {
                    window.location.reload();
                  }
                }
              } );
          });
          $('#form_register').submit(function(event){
            event.preventDefault();
            event.stopPropagation();
            var form = $('#form_register').serialize();
            $.ajax( {
                type: "POST",
                url: "<?php echo $raiz;?>ajax/register.php",
                data: form,
                success: function( data ) {
                  if (data.length>=8) {
                    swal(
                      'Error',
                      data,
                      'error'
                    );
                  }else {
                    window.location.reload();
                  }
                }
              } );
          });
        });
      </script>
    <script>
  jQuery("#departments-menu-toggle").on("click",function(){
    jQuery("#menu-vertical-menu").fadeIn(800);
  }).on("focusout",function(){
    jQuery("#menu-vertical-menu").fadeOut(800);
  })
  $(document).ready(function(){
    $('#gift-holder').hide();
$('.metodo-gratis').attr('style', 'display:none');
$('#gift-input').keydown(function(){
  var usuario=$('#fb_id').val();
  var carrito=$('#id_caarito').val();
  //Le pasamos el valor del input al ajax
  setTimeout(function () {
    var hash = $('#gift-input').val();
    var precio=$('#aux_total').val();
    var dataString = 'hash='+hash+'&precio='+precio+'&usuario='+usuario+'&carrito='+carrito;
    $.ajax({
        type: "POST",
        url: "<?php echo $raiz; ?>ajax/hash.php",
        data: dataString,
        success: function(data) {
          var total= $('#aux_total').val();
          if (data.length>=1) {
            $('#gift-holder').fadeIn();
            $('#gift-amont').html('Gs. '+conComas(Math.round(data)));
            if (total-data>=0) {
              var aux = total-data;
              $('.metodo-pago').attr('style', 'display:inline');
              $('.metodo-gratis').attr('style', 'display:none');
              $('#select').get(0).selectedIndex = 0;
              $('#select').change();
            }else {
              var aux = 0;
              $('.metodo-pago').attr('style', 'display:none');
              $('.metodo-gratis').attr('style', 'display:inline');
              $('#select').val('GiftCard');
              $('#select').change();
            }
            $('#total-holder').html('Gs. '+conComas(Math.round(aux)));
          }else {
            $('#gift-holder').fadeOut();
            $('#total-holder').html('Gs. '+conComas(Math.round(total)));
            $('.metodo-pago').attr('style', 'display:inline');
            $('.metodo-gratis').attr('style', 'display:none');
            $('#select').get(0).selectedIndex = 0;
            $('#select').change();
          }
          // $('#gift-holder').html('<p>Gift Card con valor de: '+data+'<p/>');
        }
    });
  }, 100);
});
    $('#direccion').change(function(){
      var valor =$( this ).val();
    if (valor=='new') {
      window.location.href='mis_direcciones/c/';
    }else{
      if (!(valor.length)>=2) {
        valor='propio';
      }
      window.location.href='<?php echo $raiz ?>carrito/'+valor+'/<?php echo str_replace('.php', '', $_GET['m']); ?>/';
    }
    });
    $('#select').change(function(){
      <?php
        $location_aux=str_replace('.php', '', $_GET['c']);
        $location_aux=(strlen($location_aux)>=1)?$location_aux:'propio';
       ?>
    window.location.href='<?php echo $raiz ?>carrito/<?php echo $location_aux; ?>/'+$( this ).val()+'/';
  });
    validarInfo= function(){
  var val=$('#select').val();
  var info_display="";
  if (val=='comprar1'){
    info_display = 'Te contactaremos para confirmar tu pedido y verificar tu pago en efectivo.';
  }
  if (val=='comprar2'){
    info_display = 'Es necesario que este emitido a nombre de Ferretería Industrial S.A.E y que complete los datos del firmante';
    $('.solo-cheques').fadeIn(500);
  }else {
    $('.solo-cheques').fadeOut(500);
  }
  if (val=='comprar3'){
    info_display = '<img src="<?php echo $raiz ?>assets/images/bancard.png"></img>';
  }
  if (val=='comprar4'){
    info_display = 'Podes pagar con cualquier tarjeta VISA, MASTERCARD, AMERICAN EXPRESS, PANAL, CABAL.';
  }
  if (val=='comprar5'){
    info_display = 'Podes pagar con cualquier tarjeta de débito emitida por Bancos o Financieras que operan en Paraguay.';
  }
  if (val=='comprar6'){
				info_display = '<p>Este es el banco y nuestro número de cuenta donde puedes hacer tu deposito o transferencia:</p><br /> <ul><li><strong>ITAU:</strong> 300510654</li><li><strong>BNF:</strong> 5300925743/7</li><li><strong>Regional:</strong> 4101020830</li><li><strong>BNA:</strong> 533165</li><li><strong>Visión:</strong> 900389814</li></ul> <br /><p><strong>RUC: 80021625-3<br />RAZON SOCIAL: FERRETERIA INDUSTRIAL S.A.E.</strong></p><p>Los depósitos deben ir a nombre de <strong>Ferretería Industrial S.A.E</strong><br /> Te pedimos que cuando realices tu pago nos envíes por correo o celular la imagen de tu boleta de depósito o nos llames para avisar que ya hiciste el pago, así nosotros podemos verificar en nuestro banco y hacerte la entrega de tu pedido.</p>';
			}
  if (val=='comprar7'){
  	info_display = 'Nos podes hacer un Giros Tigo directamente a nuestro número oficial <strong><?php echo $numero_tigo; ?></strong>.<br /><br /> Tenés que contemplar que pueden aplicar costos por hacer el Giro, es importante considerar que nosotros debemos recibir el importe total de la venta para poder liberar el pedido.';
  }
  if (val=='GiftCard') {
    info_display = 'Felicidades! su Gift Card cubre completamente el importe de su compra procederemos a enviar su carrito.';
  }
  $('#info-holder').html(info_display);
}
$('#select').change(function(){
  validarInfo();
});
validarInfo();
  });
  <?php if ($comprar==true): ?>
  <?php if (isset($_POST['generar_solicitud'])): ?>
  swal("Gracias por su preferencia!", " Analizaremos tu solicitud de crédito y nos pondremos en contacto para confirmar tu compra.", "success")
  <?php else: ?>
  swal("Gracias por su preferencia!", "Pronto estaremos en contacto contigo para confirmar su compra.", "success")
  <?php endif; ?>
  <?php endif; ?>
  $('.edit-detalle').on('click', function(){
    var valor=$(this).data('id');
    var dataString = 'id='+valor;
    $.ajax( {
        type: "POST",
        url: "<?php echo $raiz;?>ajax/get_detalle_carrito.php",
        data: dataString,
        success: function( data ) {
          if (data.length>=1) {
                   $('#id-receptor').html(data);
                   $('#edittodoItemForm').modal('show');
                 }
      }
      } );
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

<?php if ($cod_error>=1): ?>
      <script type="text/javascript">
        swal("ERROR","<?php echo $text_error; ?>","error");
      </script>
    <?php endif; ?>
    <?php if (isset($_POST['generar_solicitud'])): ?>
      <script type="text/javascript">
      function calcularResidencia() {
        var valor =$('#casa_propia').val();
        if (valor==1) {
          $('.solo-propia').fadeIn(500);
        }else {
          $('.solo-propia').fadeOut(500);
        }
      }
        $(document).ready(function(){
          $('select').select2();
          $('#casa_propia').change(function(){
            calcularResidencia();
          });
          calcularResidencia();
        });
      </script>
    <?php endif; ?>
              <script type="text/javascript">
              $(document).ready(function(){
                // var marker;
                var marker2;
                var latitud='-57.6129257';
                var longitud='-25.302357';
                var mapProp = {
                  center:new google.maps.LatLng(Number(longitud),Number(latitud)),
                  zoom:16,
                  mapTypeId:google.maps.MapTypeId.ROADMAP
                };
                var map=new google.maps.Map(document.getElementById("map"),mapProp);
                var pos = {
                  lng: Number(latitud),
                  lat: Number(longitud)
                };
                     marker = new google.maps.Marker({
                  position: pos,
                  map: map,
                  <?php if ($map_perfil==true): ?>
                  draggable:true,
                  <?php else: ?>
                  draggable:false,
                  <?php endif; ?>
                });
                if ($('#latitud').val().length>=1 && $('#longitud').val().length>=1) {
                  var pos = {
                    lng: Number($('#latitud').val()),
                    lat: Number($('#longitud').val())
                  };
                  map.setCenter(pos);
                  marker.setPosition(pos);
                }else {
                  if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                      };
                      map.setCenter(pos);
                      marker.setPosition(pos);
                    }, function() {
                      // handleLocationError(true, infoWindow, map.getCenter());
                    });
                  }
                }
                $('#crear_direccion').submit(function( event ) {
                  // event.preventDefault();
                  var lat = marker.getPosition().lat();
                  var lng = marker.getPosition().lng();
                  $('#longitud').val(lat);
                  $('#latitud').val(lng);
                });
                $('#actualizar_direccion').submit(function( event ) {
                  // event.preventDefault();
                  var lat = marker.getPosition().lat();
                  var lng = marker.getPosition().lng();
                  $('#longitud').val(lat);
                  $('#latitud').val(lng);
                });
                // input 1
                var input = document.getElementById('pac-input-1');
                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                map.addListener('bounds_changed', function() {
                  searchBox.setBounds(map.getBounds());
                });
                searchBox.addListener('places_changed', function() {
                  var places = searchBox.getPlaces();
                  if (places.length == 0) {
                    return;
                  }
                  var bounds = new google.maps.LatLngBounds();
                  places.forEach(function(place) {
                    var icon = {
                      url: place.icon,
                      size: new google.maps.Size(71, 71),
                      origin: new google.maps.Point(0, 0),
                      anchor: new google.maps.Point(17, 34),
                      scaledSize: new google.maps.Size(25, 25)
                    };
                    var pos = {
                      lat: place.geometry.location.lat(),
                      lng: place.geometry.location.lng()
                    };
                    map.setCenter(pos);
                    marker.setPosition(pos);

                    if (place.geometry.viewport) {
                      // Only geocodes have viewport.
                      bounds.union(place.geometry.viewport);
                    } else {
                      bounds.extend(place.geometry.location);
                    }
                  });
                });
              });
            </script>


            <script type="text/javascript">
              $(document).ready(function(){
                var valor = $('#select').val();
                if (valor=='comprar1') {
                  $('#amount_hidden').val('<?php echo $total-($total_no_oferta*0.10); ?>');
                  $('.totales_contado').html('');
                  $('.totales_contado').after(`

                    <tr class="totals totales_contado">
                      <td>Total (IVA Incld.)</td>
                      <td><?php echo ' Gs. '.number_format ($total-($total_no_oferta*0.10),0,",",".").'';?></td>
                    </tr>
                    `);
                }
              });
            </script>
			            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" />
        <script type="text/javascript">
              $(document).ready(function(){
                $('.datepicker').datepicker({
                  language: "es",
                  autoclose: true,
                   todayHighlight: true,
                   startDate: "<?php echo date('d/m/Y',strtotime($fecha_entrega)); ?>",
                   daysOfWeekDisabled:'0'
                });
              });
            </script>


            <script>
        			setTimeout(function () {
                $('.hopscotch-bubble-close').on('click',function(){
          			  $('.overlay_tuto').fadeOut();
          			});
        			}, 2700);
        		</script>

    </body>
</html>
