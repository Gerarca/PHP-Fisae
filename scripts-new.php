<?php

// funciones de seguridad
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijmotherABCDEFGHIJKLMNOPQRSTUVfuckthissjitWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
   $randomString=md5($randomString);
   $randomString=substr($randomString,0,5);
  return $randomString;
}

function cifrar($string){
  return generateRandomString().md5($string).generateRandomString().generateRandomString();
}
// funciones de seguridad


 ?>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/tether.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/bootstrap-hover-dropdown.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/echo.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/wow.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/jquery.easing.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/jquery.waypoints.min.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/electro.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/pretty.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/animsition.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/swal.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/layer1.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/layer2.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/layer3.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/justy.js"></script>
        <script type="text/javascript" src="<?php echo $raiz;?>assets/js/steps_boots.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/es.js"></script>

         <!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
        <link rel="stylesheet" type="text/css" href="../assets/js/plugins/revolution/css/settings.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../assets/js/plugins/revolution/css/layers.css">
        <link rel="stylesheet" type="text/css" href="../assets/js/plugins/revolution/css/navigation.css">

        <script type="text/javascript" src="../assets/js/plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>

        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.migration.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/revolution/js/extensions/revolution.extension.video.min.js"></script>

        <script src="assets/js/jquery.zoom.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script>

function contar_items(){
var cantidad = jQuery("#preview_bag_1 li").length;
$(".cant_items").html(cantidad);
}

jQuery(window).on("load",function(){
contar_items();
})

</script>
<script type="text/javascript">
function conComas(valor) {
    var nums = new Array();
    var simb = "."; //Éste es el separador
    valor = valor.toString();
    valor = valor.replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
    nums = valor.split(""); //Se vacia el valor en un arreglo
    var long = nums.length - 1; // Se saca la longitud del arreglo
    var patron = 3; //Indica cada cuanto se ponen las comas
    var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
    var res = "";

    while (long > prox) {
        nums.splice((long - prox),0,simb); //Se agrega la coma
        prox += patron; //Se incrementa la posición próxima para colocar la coma
    }

    for (var i = 0; i <= nums.length-1; i++) {
        res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
    }

    return res;
}
</script>

		<script type="text/javascript" charset="utf-8">
		  	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
				theme: "light_square",
				default_width: 700,
				default_height: 400,
			});



		</script>
    <?php if ($p=="Carrito"): ?>

    <?php endif; ?>
		<script type="text/javascript" charset="utf-8">
		  	var $ = jQuery;
			$("#mygallery").justifiedGallery({
				lastRow : 'justify',
			});


			function llamar_preview() {
				$(".carrito_barra").fadeIn(800,function(){

				});
			}

			$(".carrito_barra").on("mouseenter",function(){
					$(".carrito_barra").css("display","block");
			})


      traer_carrito_productos=function(){
        $("#preview_bag").empty();
        $("#preview_bag_1").empty();
        $(".ul_preview").find('.bordeado_soft').remove();
        $("#preview_bag").empty();
        var contador_de_productos = $(".dropdown-menu-mini-cart li").length;
        $.ajax( {
					  type: "POST",
					  url: "<?php echo $raiz;?>ajax/get_productos_carrito.php",
					  dataType:'json',
					  data: {var_1:'<?php echo cifrar($carrito_user_id) ?>'},
					  success: function( data ) {
              var total_sumador=0;
              var cantidadTotal=0;
              for (var i = 0, len = data.length; i < len; i++) {
                theData=data[i];
              var imagen_producto = theData.imagen;
              var precio_producto = theData.precio;
              var precio_total_producto = theData.precio_total;
              var nombre_producto = theData.nombre;
              var cantidad_producto = theData.cantidad;
              var id_producto = theData.id;
              cantidadTotal = parseFloat(cantidadTotal) + parseFloat(cantidad_producto);

                  <?php if ($p=="Carrito"): ?>
                    $("#preview_bag_1").append('<li class="mini_cart_item"><span class="qty_item">'+cantidad_producto+'</span><a title="Quitar" class="remove reload" href="'+id_producto+'">×</a><a href=""><img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="'+imagen_producto+'" alt=""></a><span class="quantity"><span class="precio_item">Gs. '+precio_total_producto+'</span></span></li>');
                    $("#preview_bag").append('<li class="mini_cart_item"><span class="qty_item">'+cantidad_producto+'</span><a title="Quitar" class="remove reload" href="'+id_producto+'">×</a><a href=""><img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="'+imagen_producto+'" alt=""></a><span class="quantity"><span class="precio_item">Gs. '+precio_total_producto+'</span></span></li>');
                        <?php else: ?>
                        $("#preview_bag_1").append('<li class="mini_cart_item"><span class="qty_item">'+cantidad_producto+'</span><a title="Quitar" class="remove" href="'+id_producto+'">×</a><a href=""><img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="'+imagen_producto+'" alt=""></a><span class="quantity"><span class="precio_item">Gs. '+precio_total_producto+'</span></span></li>');
                        $("#preview_bag").append('<li class="mini_cart_item"><span class="qty_item">'+cantidad_producto+'</span><a title="Quitar" class="remove" href="'+id_producto+'">×</a><a href=""><img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="'+imagen_producto+'" alt=""></a><span class="quantity"><span class="precio_item">Gs. '+precio_total_producto+'</span></span></li>');
                    <?php endif; ?>
                    $(".cart-items-count").empty().text(data.length);
                  total_sumador=theData.super_total;
                }
              total_sumador=conComas(total_sumador);
              $('.total').html('Sub total: GS. '+total_sumador);
              $("#cart-count2").text(cantidadTotal); 
              contar_items();        
					  }
					} );


				//traer el total del carrito

					$.ajax( {
  					  type: "POST",
  					  url: "<?php echo $raiz;?>ajax/get_total_carrito.php",
  					  dataType:'json',
  					  data: {var_1:'<?php echo cifrar($carrito_user_id) ?>'},
  					  success: function( data ) {
						$(".cont_precio").text("Gs "+data.valor);

            $(".total-price span").text("Gs "+data.valor);

  					}
  					} );


      }


      $(document).on("click",".add_to_cart_button",function(event){
				event.preventDefault();
				event.stopPropagation();
        var var_2=$('#the-cantidad-selector').val();
        if (!(var_2>=1)) {
          var_2=1;
        }
        if ($(this).data('regalo')==true) {
          var var_4=$(this).data('lista');
        }else {
          var var_4=0;
        }
				var var_1 = $(this).attr("href");
				$.ajax( {
					  type: "POST",
					  url: "<?php echo $raiz;?>ajax/get_producto_prev.php",
					  dataType:'json',
					  data: {var_1: var_1,var_2: var_2,var_3:'<?php echo cifrar($carrito_user_id) ?>', var_4: var_4},
					  success: function( data ) {
              if (data.valor=='SUCCESS') {
                swal(
                     {
                       title: "Listo!",
                       text: "Hemos añadido este producto a su carrito!",
                       timer: 3000,
                       type: "success",
                       confirmButtonColor:"#004482"
                     }
                   );
                traer_carrito_productos();               
              }else {
                swal(
                     {
                       title: "No se pudo agregar el producto",
                       text: data.desc,
                       timer: 3000,
                       type: "error",
                       confirmButtonColor:"#004482"
                     }
                     );
              }

					}
					} );
				llamar_preview();
			});

      $(document).on("click",".add_to_wishlist_button",function(event){
				event.preventDefault();
				event.stopPropagation();
        var var_2=$('#the-cantidad-selector').val();
        if (!(var_2>=1)) {
          var_2=1;
        }
				var var_1 = $(this).data("prod");
        var var_4 = $(this).data('paquete');
				var var_5 = $(this).data('cantidad');
				$.ajax( {
					  type: "POST",
					  url: "<?php echo $root;?>ajax/get_producto_wish.php",
					  dataType:'json',
					  data: {var_1: var_1,var_2: var_2,var_3:'<?php echo cifrar($carrito_user_id) ?>', var_4: var_4, var_5: var_5},
					  success: function( data ) {
              if (data.valor=='SUCCESS') {
                swal(
                     {
                       title: "Listo!",
                       text: "Hemos añadido este producto a su lista de deseos!",
                       timer: 3000,
                       type: "success",
                       confirmButtonColor:"#004482"
                     }
                   );
                traer_carrito_productos();
              }else {
                alert('Ha ocurrido un error')
              }

					}
					} );
				llamar_preview();
			});

      $(document).on("click",".remove",function(event){
      event.preventDefault();
      event.stopPropagation();
      var var_1 = $(this).attr("href");
      var este = $(this).attr("class");
      $.ajax( {
          type: "POST",
          url: "<?php echo $raiz;?>ajax/eliminar_producto_carrito.php",
          dataType:'json',
          data: {var_1: var_1,var_2:'<?php echo cifrar($carrito_user_id) ?>'},
          success: function( data ) {
          if (data.valor=='SUCCESS') {                      
            traer_carrito_productos();
          //  here  .reload
          if(este == "remove reload"){
            location.reload();
          }else{

          }
          }else {
          alert('Ha ocurrido un error')
          }


        }
        } );        
      });


      traer_carrito_productos();



		</script>

    <script type="text/javascript" src="<?php echo $raiz;?>assets/js/jquery.jscroll.js"></script>

		<script type="text/javascript">
		$(document).ready(function() {

			//Al escribr dentro del input con id="service"
      // $('#search').keypress(function(){
			$('#search').keyup(function(){
        if (typeof($("#suggestions").jscroll.destroy) !== 'undefined') {
          $("#suggestions").jscroll.destroy();
          $('#suggestions').fadeOut(30).html('');
        }
				//Obtenemos el value del input
				var service = $(this).val();
        if (service.length>=1) {
          service=service.split(" ").join("___");
          $('#suggestions').fadeIn(30).html('<a href="<?php echo $raiz;?>buscador_fancy_paginacion.php?page=1&query='+service+'" style="display:none">Siguiente página</a>');
          $('#suggestions').jscroll({
            loadingHtml:''
          });
        }else {
          if (typeof($("#suggestions").jscroll.destroy) !== 'undefined') {
            $("#suggestions").jscroll.destroy();
            $('#suggestions').fadeOut(30).html('');
          }
        }
			}).focusout(function(){
        setTimeout(function () {

          if (typeof($("#suggestions").jscroll.destroy) !== 'undefined') {
            $("#suggestions").jscroll.destroy();
            $('#suggestions').fadeOut(30).html('');
          }
        }, 500);

						});

		});

		</script>
		<script>

		if ($(window).width() > 991) {

		$(window).scroll(function() {
			if ($(this).scrollTop() > 7) {
				$(".cont_men").attr("style","position:fixed;top:0;width:100%;");
				$("#menu-navbar-primary li a").css("transition","all ease 0.8s").css("padding","0.8em 1.375em");
				$(".header-logo-link .maxw17").css("transition","all ease 0.7s").css("transform","scale(0.95)");
				$(".header-v3").css("transition","all ease 0.7s").css("padding-top","1em");
				$(".cont_men").addClass("min_fix");
			}else {
				$(".cont_men").attr("style","");
				$(".header-logo-link .maxw17").css("transition","all ease 0.7s").css("transform","scale(1)")
				$("#menu-navbar-primary li a").css("transition","all ease 0.2s").css("padding","1em");
				$(".header-v3").css("transition","all ease 0.7s").css("padding-top","2em");
				$(".cont_men").removeClass("min_fix");
			}
		})
		}


		</script>
				<script>
			$("#boton_trigger_men").on("click",function(){
				var estado_menu = $(this).find("i").attr("class");
				if(estado_menu == "fa fa-bars"){
					$(".nuevo_menu_respo").fadeIn();
					$(this).find("i").removeClass("fa-bars").addClass("fa-close");
					$("body").css("overflow","hidden");
				}else {
					$(".nuevo_menu_respo").fadeOut();
					$(this).find("i").removeClass("fa-close").addClass("fa-bars");
					$("body").css("overflow","");
				}

			})
			$("#search_in_responsive").on("click",function(){
				var estado_buscador = $(this).find("i").attr("class");

				if(estado_buscador == "fa fa-search"){
					$("#the_buscador").fadeIn();
					$(this).find("i").removeClass("fa-search").addClass("fa-close");
				}else {
					$("#the_buscador").fadeOut();
					$(".overlay_buscador_respo").fadeOut();
					$(this).find("i").removeClass("fa-close").addClass("fa-search");
				}



			})
			if ($(window).width() < 991) {
			$(window).scroll(function() {
				if ($(this).scrollTop() > 40) {
					$(".cont_men").css("top","0");
				}else {
					$(".cont_men").css("top","");
				}
			})
			}

      <?php
        $sql_carito_id=mysql_query("SELECT id FROM carrito WHERE id_usuario='$carrito_user_id' and estado='0' ORDER BY id DESC LIMIT 1");
        while ($row_carrito_id=mysql_fetch_array($sql_carito_id)) {
          $the_cod_carrito=$row_carrito_id['id'];
        }
        $Sql100="SELECT SUM(cantidad) from carrito_detalles where id_carrito = '$the_cod_carrito' and estado='0'";
        $result100=mysql_query($Sql100,$link);
        $hayitems=mysql_num_rows($result100);
        $cantidadtotal=0;
        while ($row100=mysql_fetch_array($result100))
        {
          $cantidadtotal = $row100[0]; 
        } 
      ?>
      $("#cart-count2").text(<?php echo $cantidadtotal; ?>);


		</script>
