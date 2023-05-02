<!DOCTYPE html>
<html lang="es-PY" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php
$p = "Bienvenidos";
$actual = "Inicio";
include 'head-new.php';
$espacios = array('"', ' ');

include_once('config.php');
?>

<body class="home-v2 index">
	<div id="page" class="hfeed site">
		<?php
		include 'menu-new.php';
		?>

		<section class="banner-principal banner-principal-first">
			<div id="slider" style="margin-bottom:0;">
				<div id="rev_slider_30_1_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="POLO Homepage" style="background-color:transparent;padding:0px;">
					<div id="rev_slider_30_1" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.1">
						<ul>
							<?php 
							$SqlBanners="SELECT * from banners";
							$resultSqlBanners=mysql_query($SqlBanners,$link);
							while ($banner=mysql_fetch_array($resultSqlBanners)) {
								?>
								<li data-transition="zoomout" data-slotamount="default" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000" data-rotate="0" data-saveperformance="off" data-title="" data-description="">
									<img src="images/slider/dummy.png" alt="" width="1920" height="1080" data-lazyload="<?php echo $root;?>/public/<?php echo $banner['imagen']; ?>" data-bgposition="center center" data-kenburns="on" data-duratio
									n="10000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="110" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0" class="rev-slidebg" data-no-retina style="border:1px solid blue;">
								</li>
								<?php
							}							
							?>
						</ul>
						<div class="tp-static-layers">
						</div>
						<div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
					</div>
				</div>
			</div>
		</section>

		<!-- <div id="content" class="site-content nmb background_pattern_trans" tabindex="-1">
			<div class="container">
				<div class="home-v1-slider">
					<div class="layerslider full_width" style="width:100%; height: 470px;">
						<?php
						$Sql100="SELECT * from banners order by orden asc";
						$result100=mysql_query($Sql100,$link);
						
						while ($row100=mysql_fetch_array($result100))
						{
							$banner = $row100["imagen"];
							$banner_descripcion = $row100["descripcion"];
							$banner_enlace = $row100["enlace"];
							$banner_titulo = $row100["nombre"];
							if (strpos($banner, '.jpg') !== false || strpos($banner, '.JPG') || strpos($banner, '.JPEG') || strpos($banner, '.jpeg') !== false) {
								$foto_min=$root.'imagen/1920__470__'.$banner;
							}elseif (strpos($banner, '.gif') !== false || strpos($banner, '.GIF') !== false) {
								if ($banner == 'd74673abab14bbede97cffd9b3771ad0.gif') { 
									$foto_min = $root.'public/'.$banner;
								} else {
									$foto_min=$root.'imagen_gif/1920__470__'.$banner;
								}
							} elseif (strpos($banner, '.png') !== false || strpos($banner, '.PNG') !== false) {
								$foto_min=$root.'imagen_png/1920__470__'.$banner;
							}else {
								$foto_min=$root.'public/'.$banner;
							}
							?>
							<div class="ls-slide" data-ls="transition2d: 10, 27, 63, 67, 69;" onclick="window.open('<?php echo $banner_enlace ?>', '_self');" style="cursor:pointer">

								<img class="ls-bg" src="<?php echo $foto_min; ?>" >

								<div class="ls-l layer_1" style="left: 80px; top: 168px;" data-ls="offsetxin: -60; durationin: 650; easingin: easeOutBack;"><?php echo $banner_titulo; ?></div>
								<div class="ls-l layer_2" style="left: 80px; top: 228px; font-size: 22px; color: #fff;" data-ls="offsetxin: -60; durationin: 650; easingin: easeOutBack; delayin: 150;"><?php echo $banner_descripcion; ?></div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div> -->

		<section class="nosotros-index">
			<div class="container">
				<div class="row row-nosotros mb-0">
					<div class="col-12 col-md-5">
						<div class="container-text-nosotros">
							<h2 class="text-nosotros">Sobre Nosotros</h2>
							<h1 class="nosotros">Somos una empresa importadora y de servicios paraguaya, con presencia y trayectoria en el mercado desde 1995 suministrando equipos, herramientas e instrumentos de la más alta calidad para el montaje y mantenimiento industrial y el desarrollo del sector agrícola.</h1>
							<a href="<?php echo $root;?>nosotros-new.php" class="btn-principal mb-0">Ver más</a>
						</div>
					</div>
					<div class="col-md-5 nosotros-images-container">
						<img class="img-nosotros-logo" src="<?php echo $root;?>/assets/images/banner/experienciaFisae.png" alt="">
					</div>
				</div>
			</div>
		</section>

		<section class="unidades-negocio-index">
			<div class="container">
				<h2 class="title-logos pt-0">Conoce nuestras unidades de negocio</h2>
				<div class="row row-nosotros mb-0">
					<div class="col-md-4 mb-2">
						<img src="<?php echo $root;?>/assets/images/logo-fisagro.png" alt="" class="images-unidades">
					</div>
					<div class="col-md-4 mb-2">
						<img src="<?php echo $root;?>/assets/images/logo-gotomarket.png" alt="" class="images-unidades">
					</div>
				</div>
			</div>
		</section>
		
		<section class="marcas">
			<div class="container">
				<div class="row row-nosotros">
					<div class="col-12 col-md-11">
						<h2 class="title-marcas">Nuestras Marcas</h2>
						<div class="owl-marcas owl-carousel owl-theme">
							<?php 
								$SqlMarcas="SELECT * from marcas  where visible=1";
								$resultSqlMarcas=mysql_query($SqlMarcas, $link);
								while ($Marca=mysql_fetch_array($resultSqlMarcas)){
								?>
								<div class="item">
									<a href="<?php echo $root;?>marca.php?id=<?php echo $Marca['id']; ?>" class="content-marcas">
										<img class="img-marcas" src="<?php echo $root;?>/public/<?php echo$Marca['logo'] ?>" alt="<?php echo $Marca['marca'] ?>">
									</a>
								</div>
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="productos pb-0">
			<div class="container">
				<h2 class="title-marcas">Productos</h2>
				<div class="row row-nosotros">
					<div class="col-md-11">
						<div class="owl-productos-ecommerce owl-carousel owl-theme">
							<?php 
							$Sqlproductos="SELECT * from productos where visible=1 and recomendado=1";
							$resultSqlproductos=mysql_query($Sqlproductos, $link);
							while ($Producto=mysql_fetch_array($resultSqlproductos))
							{	
								$cod_articulo = $Producto['cod_articulo'];
								$stock=0;
								$sql_stock=mysql_query("SELECT stock FROM stock WHERE COD_ARTICULO='$cod_articulo'");
								while ($row_stock=mysql_fetch_array($sql_stock)) {
									$stock=$row_stock['stock'];
								}
								// ---------------------- EL PRECIO ------------------------ //
								$preciosql="SELECT * FROM precios where COD_ARTICULO = '$cod_articulo' order by precio asc limit 1";
								$precioresult=mysql_query($preciosql,$link);
								$preciohay=mysql_num_rows($precioresult); 
								if ($preciohay==0){$precio=0;}
								else
								{
									while ($prec=mysql_fetch_array($precioresult))
									{
										$precio = ''.$prec["precio"].'';
										$precio_tachado = ''.$prec["precio_lista"].'';
									}
								}
								?>
								<div class="item">
									<div class="producto">
										<div class="producto-image">
											<a href="<?php echo $root; ?>producto.php?id=<?php echo $Producto['cod_articulo']; ?>">
												<img class="img-nosotros" src="<?php echo $root;?>/public/<?php echo $Producto['foto1']; ?>" alt="">
											</a>
										</div>
										<div class="producto-texto">
											<a href="<?php echo $root; ?>producto.php?id=<?php echo $Producto['cod_articulo']; ?>" class="titulo-producto"><?php echo $Producto['producto']; ?></a>
											<p class="precio-producto"> <?php if($precio>0): echo "Gs.". number_format($precio, 0, ",", ".").''; endif; ?>  </p>
											<?php if ($stock>=1 && $precio>=1): ?>											
											<a href="<?php echo $Producto['id'];?>" class="btn-producto add_to_cart_button" data-toggle="modal" data-target="#productosModal" data-image="<?php echo $root;?>/public/<?php echo $Producto['foto1']; ?>" data-title="<?php echo $Producto['producto']; ?>" >
												<img src="../assets/images/cart-3.svg" alt="">
												Agregar al carrito 
											</a>
											<?php endif; ?>										
											<?php if ($precio==0): ?>											
												<a href="<?php echo $root; ?>producto.php?id=<?php echo $cod_articulo; ?>" class="btn-producto" style="color:#fff;">
												<img src="../assets/images/cart-3.svg" alt="">
												Cotizar 
											</a>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="blog">
			<div class="container">
				<div class="row row-nosotros">
						<div class="col-12 col-md-11">
							<h2 class="title-marcas">Nuestro Blog</h2>
							<div class="owl-blog owl-carousel owl-theme">
								<?php 
								$SqlBlogs="SELECT * from blog WHERE estado = 1 LIMIT 9";
								$resultSqlBlogs=mysql_query($SqlBlogs, $link);
								while ($Blog=mysql_fetch_array($resultSqlBlogs)){
									?>
									<div class="item">
										<div class="item-grid-blog">
											<div class="content-img-blog">
												<img src="<?php echo $root;?>/public/<?php echo $Blog['imagen'] ?>" alt="">
											</div>
											<div class="content-text-blog">
												<h5><a href="<?php echo $root; ?>blog-new?id=<?php echo $Blog['id']; ?>"><?php echo $Blog['titulo'] ?></a></h5>
												<p class="text-noticias"> <?php echo substr($Blog['descripcion'],0,80) ?> </p>
											</div>
										</div>
									</div>
									<?php
									}
								?>
							</div>
							<a href="blogs-new.php" class="btn-principal btn-noticias">Todas las noticias</a>
						</div>
				</div>
			</div>
		</section>

		<section class="contacto" id="contacto">
			<div class="container">
				<h2 class="title-marcas title-contacto">Contacto</h2>
				<h4 class="subtitle-contacto">Completá el formulario con tus datos y nos comunicaremos contigo en la brevedad.</h4>
				<div class="row row-contacto">
					<div class="col-12 col-md-11">
						<div class="grid-contacto-info">
							<div class="item-grid-contacto">
								<a href="https://goo.gl/maps/4wJFBRVyayZwPW5M9" target="_blank" class="item-contacto">
									<div class="container-icon icon-color-principal">
										<img src="<?php echo $root;?>/assets/images/map.svg" alt="">
									</div>
									Avda. Perón esq. El Trabajador. Asunción
								</a>
							</div>
							<div class="item-grid-contacto">
								<div class="item-contacto">
									<div class="container-icon icon-color-secundario">
										<img src="<?php echo $root;?>/assets/images/phone.svg" alt="">
									</div>
									<div class="container-numeros">
										<a href="tel:+59521301551" class="item-contacto">
											(021) 301-551 
										</a>
										<span>—</span>
										<a href="tel:+59521331230" class="item-contacto">
											(021) 331-230
										</a>
									</div>
								</div>
							</div>
							<div class="item-grid-contacto">
								<a href="mailto:info@fisae.com.py" class="item-contacto">
									<div class="container-icon icon-color-principal">
										<img src="<?php echo $root;?>/assets/images/mail.svg" alt="">
									</div>
									info@fisae.com.py
								</a>
							</div>
							<div class="item-grid-contacto">
								<a href="#" class="item-contacto">
									<div class="container-icon icon-color-secundario">
										<img src="<?php echo $root;?>/assets/images/clock.svg" alt="">
									</div>
									Lunes a Viernes: 07:30 - 17:30
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row row-contacto mt-3">
					<div class="col-12 col-md-11">
						<div class="grid-form">
							<div class="item-grid-form">
								<form action="#" class="form-section-contact">
									<div class="form-group">
										<label class="title-input" for="nombre">Nombre</label>
										<input type="text" id="nombre" class="form-control" placeholder="Escriba su nombre">
									</div>
									<div class="form-group">
										<label class="title-input" for="email">Email</label>
										<input type="email" id="email" class="form-control" placeholder="Escriba su email">
									</div>
									<div class="form-group">
										<label class="title-input" for="telefono">Teléfono</label>
										<input type="text" id="telefono" class="form-control" placeholder="Escriba su teléfono">
									</div>
									<div class="form-group">
										<label class="title-input" for="telefono">Asunto</label>
										<input type="text" id="telefono" class="form-control" placeholder="Escriba el asunto">
									</div>
									<div class="form-group">
										<label class="title-input" for="mensaje">Mensaje</label>
										<textarea name="mensaje" id="mensaje" cols="50" rows="10" class="form-control" placeholder="Escriba su mensaje"></textarea>
									</div>
									<div class="form-group form-container-button">
										<button class="btn-principal btn-enviar">Enviar mensaje</button>
									</div>
								</form>
							</div>
							<div class="item-grid-form">
								<div class="container-mapa">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3606.1808970633597!2d-57.632021785494466!3d-25.331710135220046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x945da94523e3a147%3A0x86298314b3eb3b1d!2sFISAE%20-%20Ferreteria%20Industrial%20S.A.E.!5e0!3m2!1ses-419!2spy!4v1647266368030!5m2!1ses-419!2spy" width="100%" height="385" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
								
		<section class="newsletter">
			<div class="container">
				<div class="row row-contacto">
					<div class="col-12 col-md-11 text-center">
						<h2 class="title-marcas title-newsletter">¿Querés recibir nuestras ofertas?</h2>
						<h3 class="subtitle-newsletter">Ofertas exclusivas de FISAE</h3>
						<form method="post" class="form-newsletter">
							<div class="form-group form-group-newsletter mb-0">
								<div class="form-container">
									<input type="email" name="mail_novedad" required="" class="form-control input-newsletter" placeholder="Dirección de email">
									<img class="icon-newsletter" src="<?php echo $root;?>/assets/images/mail.svg" alt="Icono de Correo">
								</div>
								<button class="btn-principal btn-registro" type="submit" name="suscribirse" id="registro">Registrarse</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<img class="image-overlay" src="<?php echo $root;?>/assets/images/iso.svg" alt="">
	  </section>

		<?php
		include 'footer-new.php';
		?>
		
	</div>


	<!-- Modal -->
<div class="modal fade" id="productosModal" tabindex="-1" role="dialog" aria-labelledby="productosModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body rounded p-4">
        <div class="modal-addtocart position-relative">
          <h5 class="title-modal text-center mt-1">
            ¡Producto agregado a tu carrito!
          </h5>
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 col-lg-6 text-center">
              <div>
                <div class="product-img-wrapper mb-2">
                  <img id="card-image" src="" alt="">
                </div>
                <h5 id="card-title" class="title-producto-modal"></h5>
                <div>
                  Cant: <span>1</span>
                </div>
              </div>
              
            </div>
            <div class="col-12 col-lg-6 text-center">
              <p class="cantidad-modal">Hay 1 artículos en tu carrito</p>
              
              <a class="btn-principal btn-catalogo-outline justify-content-center mt-3" href="<?php echo $root;?>index-compra.php">Ver más productos</a>
              <a href="<?php echo $root;?>carrito.php" class="btn-principal btn-catalogo justify-content-center mt-3">Comprar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->

	<?php
	include "scripts-new.php";
	?>
	<!-- <script>
	if ($('.layerslider').length) {
		$('.layerslider').layerSlider({
			responsive: true,
			responsiveUnder: 1140,
			layersContainer: 1140,
			skinsPath: 'assets/js/layerslider/skins/',
			hoverPrevNext: false,
			navButtons: false,
			navStartStop: false,
			showCircleTimer: false
		});
	}
	</script> -->
	<script type="text/javascript">
     var tpj = jQuery;

     var revapi30;
     tpj(document).ready(function() {
         if (tpj("#rev_slider_30_1").revolution == undefined) {
             revslider_showDoubleJqueryError("#rev_slider_30_1");
         } else {
             revapi30 = tpj("#rev_slider_30_1").show().revolution({
                 sliderType: "standard",
                 jsFileLocation: "js/plugins/revolution/js/",
                 sliderLayout: "fullscreen",
                 dottedOverlay: "none",
                 delay: 9000,
                 navigation: {
                     keyboardNavigation: "off",
                     keyboard_direction: "horizontal",
                     mouseScrollNavigation: "off",
                     onHoverStop: "on",
                     touch: {
                         touchenabled: "on",
                         swipe_threshold: 75,
                         swipe_min_touches: 50,
                         swipe_direction: "horizontal",
                         drag_block_vertical: false
                     },
                     arrows: {
                         style: "hermes",
                         enable: true,
                         hide_onmobile: true,
                         hide_under: 600,
                         hide_onleave: true,
                         hide_delay: 200,
                         hide_delay_mobile: 1200,
                         tmp: '<div class="tp-arr-allwrapper">	<div class="tp-arr-imgholder"></div>	<div class="tp-arr-titleholder">{{title}}</div>	</div>',
                         left: {
                             h_align: "left",
                             v_align: "center",
                             h_offset: 0,
                             v_offset: 0
                         },
                         right: {
                             h_align: "right",
                             v_align: "center",
                             h_offset: 0,
                             v_offset: 0
                         }
                     }
                 },
								 responsiveLevels: [1240, 1024, 778, 480],
                 visibilityLevels: [1240, 1024, 778, 480],
                 gridwidth: [1240, 1024, 778, 480],
                 gridheight: [868, 768, 960, 720],
                 lazyType: "smart",
                 shadow: 0,
                 spinner: "off",
                 stopLoop: "off",
                 stopAfterLoops: -1,
                 stopAtSlide: -1,
                 shuffle: "off",
                 autoHeight: "off",
                 fullScreenAutoWidth: "off",
                 fullScreenAlignForce: "off",
                 fullScreenOffsetContainer: "",
                 fullScreenOffset: "",
                 disableProgressBar: "on",
                 hideThumbsOnMobile: "off",
                 hideSliderAtLimit: 0,
                 hideCaptionAtLimit: 0,
                 hideAllCaptionAtLilmit: 0,
                 debugMode: false,
                 fallbacks: {
                     simplifyAll: "off",
                     nextSlideOnWindowFocus: "off",
                     disableFocusListener: false,
                 }
             });
         }
     }); /*ready*/
		 jQuery('#rev-slider').revpause();

		 $('.owl-productos').owlCarousel({
					loop:true,
					margin:25,
					nav:true,
					dots:false,
  				navText: ["<img src='../assets/images/left-arrow.svg'>","<img src='../assets/images/right-arrow.svg'>"],
					autoplay:true,
    			autoplayTimeout:8000,
					responsive:{
							0:{
									items:1
							},
							600:{
									items:2
							},
							1000:{
									items:3
							}
					}
			});
		 $('.owl-marcas').owlCarousel({
					loop:true,
					margin:5,
					nav:false,
					dots:false,
  				navText: ["<img src='../assets/images/left-arrow.svg'>","<img src='../assets/images/right-arrow.svg'>"],
					responsive:{
							0:{
									items:2
							},
							600:{
									items:2
							},
							1000:{
									items:6
							}
					}
			});
			$('.owl-blog').owlCarousel({
					loop:true,
					margin:25,
					nav:true,
					dots:false,
  				navText: ["<img src='../assets/images/left-arrow.svg'>","<img src='../assets/images/right-arrow.svg'>"],
					autoplay:true,
    			autoplayTimeout:8000,
					responsive:{
							0:{
									items:1
							},
							600:{
									items:2
							},
							1000:{
									items:3
							}
					}
			});
			$('.owl-productos-ecommerce').owlCarousel({
					loop:true,
					margin:20,
					nav:true,
					dots:false,
  				navText: ["<img src='../assets/images/left-arrow.svg'>","<img src='../assets/images/right-arrow.svg'>"],
					autoplay:true,
    			autoplayTimeout:8000,
					responsive:{
							0:{
									items:1
							},
							450:{
								items:1
							},
							768:{
									items:2
							},							
							990:{
									items:3
							},							
							1200:{
									items:4
							}
					}
			});

	$('#productosModal').on('show.bs.modal', function(e) { 
		var link     = $(e.relatedTarget) ,
			modal    = $(this),
			image 	 = link.data("image"),
			title    = link.data("title");

			$("#card-title").text(title);
			$("#card-image").attr("src",image);
	});
 </script>
</body>
</html>
