<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php
$p = "Contacto";
$actual = "Contacto";
include 'head.php';

$espacios = array('"', ' ');

if (isset($_POST['enviar_mail'])) {
  $nombre=mysql_real_escape_string($_POST['nombre']);
  $email=mysql_real_escape_string($_POST['email']);
  $mensaje=mysql_real_escape_string($_POST['mensaje']);
  $asunto=mysql_real_escape_string($_POST['asunto']);
  if (strlen($nombre)>=1 && strlen($email)>=1 && strlen($mensaje)>=1) {
    include('mailer/contacto.php');
  }else {
    $error=true;
  }
}
?>
<body class="page-template-default page page-id-2513 wpb-js-composer js-comp-ver-5.0.1 vc_responsive  pace-done">
  <div id="page" class="hfeed site">
    <?php

    include 'menu.php';

    ?>

    <div id="content" class="site-content" tabindex="-1">
      <div class="container">
        <nav class="woocommerce-breadcrumb"><a href="<?php echo $root;?>">Inicio</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Contacto</nav>
        <div id="primary" class="content-area">
          <main id="main" class="site-main">

            <article class="hentry">

              <div class="entry-content">
                <div class="row">
                  <div class="col-sm-7">
                    <div class="wpb_wrapper outer-bottom-xs">
                      <h2 class="contact-page-title">Formulario de <span class="destacadonaranja">Contacto</span></h2>

                    </div>

                    <div role="form" class="wpcf7">
                      <div class="screen-reader-response"></div>
                      <form action="" method="post" class="wpcf7-form">

                        <div class="form-group row">
                          <div class="col-xs-12 col-md-6">
                            <label>Nombre*</label><br />
                            <span class="wpcf7-form-control-wrap first-name">
                              <input type="text" name="nombre" required="" value="" size="40" class="wpcf7-form-control input-text" aria-required="true" aria-invalid="false" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-md-6">
                            <label>Mail*</label><br />
                            <span class="wpcf7-form-control-wrap last-name">
                              <input type="email" name="email" required="" value="" size="40" class="wpcf7-form-control input-text" aria-required="true" aria-invalid="false" />
                            </span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label>Asunto</label><br />
                          <span class="wpcf7-form-control-wrap subject"><input type="text" name="asunto" value="" size="40" class="wpcf7-form-control input-text" aria-invalid="false" /></span>
                        </div>

                        <div class="form-group">
                          <label>Mensaje</label><br />
                          <span class="wpcf7-form-control-wrap your-message"><textarea required="" name="mensaje" cols="40" rows="10" class="wpcf7-form-control input-text wpcf7-textarea" aria-invalid="false"></textarea></span>
                        </div>

                        <div class="form-group clearfix">
                          <p><input type="submit" value="Enviar" name="enviar_mail" class="wpcf7-form-control wpcf7-submit" /></p>
                        </div>
                      </form>
                    </div>
                  </div><!-- .col -->

                  <div class="store-info store-info-v2 col-sm-5">
                    <div class="vc_column-inner ">
                      <div class="wpb_wrapper">
                        <div class="inner-left-xs">
                          <div class="wpb_wrapper">
                            <h2 class="contact-page-title">Donde <span class="destacadonaranja">Encontrarnos</span></h2>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1803.0871940375614!2d-57.6296288!3d-25.3319286!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x945da83055f481a5%3A0xd67986ecf727a83e!2sAvenida+Juan+Domingo+Per%C3%B3n+%26+El+Trabajador%2C+Asunci%C3%B3n!5e0!3m2!1ses!2spy!4v1527176572563" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                            <p>Avda. Perón esq. El Trabajador. Asunción<br />
                              Telefonos: <a href="tel:+59521301551">021301551</a> - <a href="tel:+59521331230">021331230</a><br />
                              Email: <a href="mailto:info@fisae.com.py">info@fisae.com.py</a>
                            </p>
                            <h3>Horario de Atención</h3>
                            <p>
                              Lunes a Viernes: 07:30 - 17:30<br />
                            </p>


                          </div>
                        </div>
                        <div class="inner-left-xs outer-bottom-xs">


                        </div>
                      </div>
                    </div>
                  </div><!-- .col -->
                </div><!-- .row -->
              </div><!-- .entry-content -->

            </article><!-- #post-## -->

          </main><!-- #main -->
        </div>

      </div>

    </div>


    <?php
    include 'footer.php';
    ?>

  </div>

  <?php
  include "scripts.php"
  ?>
  <script>

  jQuery("#departments-menu-toggle").on("click",function(){
    jQuery("#menu-vertical-menu").fadeIn(800);
  }).on("focusout",function(){
    jQuery("#menu-vertical-menu").fadeOut(800);
  })
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
    var calcularCV=function() {
      var valor=$('#asunto').val();
      if (valor=='recursos') {
        $('.solo-cv').fadeIn(400);
      }else {
        $('.solo-cv').fadeOut(400);
      }
    }
    calcularCV();
    $('#asunto').change(function(){
      calcularCV();
    });
  });




  </script>
  <?php if (isset($_POST['enviar_mail'])): ?>
    <script type="text/javascript">
    <?php if ($error == false): ?>
    swal("EXITO","MENSAJE ENVIADO","success");
    <?php else: ?>
    swal("ERROR","NO SE PUDO ENVIAR EL MENSAJE","error");
    <?php endif; ?>
    </script>
  <?php endif; ?>
</body>
</html>
