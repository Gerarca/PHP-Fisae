<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php
include_once 'config.php';
if(isset($_GET['id'])){ $id="{$_GET['id']}";} else {$id=NULL;}
if(isset($_GET['t'])){ $t="{$_GET['t']}";} else {$t=NULL;}
// ---------------------- EL DETALLE ------------------------ //
$Sql1001="SELECT * from blog where estado=1 and id = '$id'";
$result1001=mysql_query($Sql1001,$link);
while ($row1001=mysql_fetch_array($result1001))
{
  $id_blog_main=$row1001['id'];
  $titulo_main=$row1001['titulo'];
  $created_main=$row1001['created'];
  $descripcion_main=$row1001['descripcion'];
  $imagen_main=$row1001['imagen'];
  $estado_main=$row1001['estado'];
  $relacionados_main=$row1001['relacion'];
  $es_blog=true;
  $p=$titulo_main;
  $descripcion_facebook = explode('<hr />', $descripcion_main);
  $descripcion_facebook = $descripcion_facebook[0];

}
$meta='<meta content="'.$root.'public/'.$imagen_main.'" property="og:image"/>
<meta name="description" content="'.$titulo_main.'">
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@fisae" />
<meta name="twitter:description" content="'.$titulo_main.'" />
<meta name="twitter:image" content="'.$root.'public/'.$imagen_main.'" />
';
echo $meta;
if ($id==NULL || $estado_main<>1)
{
  echo '<script>window.location = "'.$root.'";</script>';
}else {
  mysql_query("UPDATE blog SET visitas=visitas+1 WHERE id='$id'");
}


$p = $titulo_main;
include 'head-new.php';

$espacios = array('"', ' ');
?>
<body class="single-post right-sidebar">
  <div id="page" class="hfeed site">
    <?php

    include 'menu-new.php';

    if (strpos($imagen_main, '.jpg') !== false || strpos($imagen_main, '.JPG') || strpos($imagen_main, '.JPEG') || strpos($imagen_main, '.jpeg') !== false) {
      $foto_min=$root.'imagen/1144__600__'.$imagen_main;
    }elseif (strpos($imagen_main, '.gif') !== false || strpos($imagen_main, '.GIF') !== false) {
      $foto_min=$root.'imagen_gif/1144__600__'.$imagen_main;
    }elseif (strpos($imagen_main, '.png') !== false || strpos($imagen_main, '.PNG') !== false) {
      $foto_min=$root.'imagen_png/1144__600__'.$imagen_main;
    }else {
      $foto_min=$root.'public/'.$imagen_main;
    }

    ?>
    <div id="content" class="site-content" tabindex="-1">
      <div class="container">
        <nav class="woocommerce-breadcrumb"><a href="<?php echo $root;?>">Inicio</a><span class="delimiter"><i class="fa fa-angle-right"></i></span><a href="<?php echo $root;?>blogs">Blogs</a><span class="delimiter"><i class="fa fa-angle-right"></i></span><?php echo $titulo_main ?></nav>
        <div id="primary" class="content-area">
          <main id="main" class="site-main">

            <article class="post type-post status-publish format-gallery has-post-thumbnail hentry" >
              <div class="media-attachment">
                <div class="media-attachment-gallery">
                  <div class=" ">
                    <div class="item">
                      <figure>
                        <img width="1144" height="600" src="<?php echo $foto_min ?>" class="attachment-post-thumbnail size-post-thumbnail" alt="1" />
                      </figure>
                    </div><!-- /.item -->
                  </div>
                </div><!-- /.media-attachment-gallery -->
              </div>

              <header class="entry-header">
                <div class="entry-meta">
                  <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2016-03-04T07:34:20+00:00"><?php echo date('d/m/Y',strtotime($created_main)); ?></time></a></span>
                </div>
                <h1 class="entry-title" itemprop="name headline"><?php echo $titulo_main ?></h1>
              </header><!-- .entry-header -->

              <div class="entry-content" itemprop="articleBody">
                <?php echo $descripcion_main ?>
              </div><!-- .entry-content -->
              <?php
              $Sql100="SELECT * FROM productos WHERE visible='1' and id in ($relacionados_main) order by producto asc";

              $result100=mysql_query($Sql100,$link);

              if (mysql_num_rows($result100)>=1): ?>
              <br><hr><br><br>
              <section class="section_offset animated transparent" data-animation="fadeInDown">

                <h3 class="offset_title">Productos Relacionados</h3>

                <!-- - - - - - - - - - - - - - Carousel of featured products - - - - - - - - - - - - - - - - -->

                <div class="owl-carousel five_items pt20">

                  <?php
                  while ($row100=mysql_fetch_array($result100))
                  {
                    $cod_articulo_q=$row100["cod_articulo"];
                    $aux_foto=$row100["foto1"];
                    if (strpos($aux_foto, '.jpg') !== false || strpos($aux_foto, '.JPG') || strpos($aux_foto, '.JPEG') || strpos($aux_foto, '.jpeg') !== false) {
                      $foto_min=$root.'imagen/300__300__'.$aux_foto;
                    }elseif (strpos($aux_foto, '.gif') !== false || strpos($aux_foto, '.GIF') !== false) {
                      $foto_min=$root.'imagen_gif/300__300__'.$aux_foto;
                    }elseif (strpos($aux_foto, '.png') !== false || strpos($aux_foto, '.PNG') !== false) {
                      $foto_min=$root.'imagen_png/300__300__'.$aux_foto;
                    }else {
                      $foto_min=$root.'public/'.$aux_foto;
                    }
                    $stock = 0;
                    $sql_stock_prod = mysql_query("SELECT stock FROM stock WHERE cod_articulo = '$cod_articulo_q'");
                    while ($row_stock_prod = mysql_fetch_assoc($sql_stock_prod)) {
                      $stock = $row_stock_prod['stock'];
                    }
                    ?>

                    <div class="product_item type_3">
                      <?php if ($stock <= 0) { ?><a href="<?php echo $root ?>producto/<?php echo ''.$row100["id"].'/'.sanear_string($row100["producto"]).'';?>"><div class="ribbon2 ribbon-top-right"><span>SIN STOCK</span></div></a><?php } else { ?>

                      <?php if ($row100["oferta"] == 1) { ?><a href="<?php echo $root ?>producto/<?php echo ''.$row100["id"].'/'.sanear_string($row100["producto"]).'';?>"><div class="ribbon ribbon-top-right"><span>oferta</span></div></a><?php } } ?>

                      <div class="image_wrap">

                        <img src="<?php echo $foto_min; ?>" alt="">

                      </div><!--/. image_wrap-->



                      <!-- - - - - - - - - - - - - - Product title & price - - - - - - - - - - - - - - - - -->

                      <div class="description centrado">

                        <a href="<?php echo $root ?>producto/<?php echo ''.$row100["id"].'/'.sanear_string($row100["producto"]).'';?>"><?php echo $row100["producto"]; ?></a>

                        <div class="clearfix product_info">

                          <?php
                          $preciosql="SELECT * from precios where COD_ARTICULO = '$cod_articulo_q' order by precio asc limit 1";
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

                          <p class="product_price">
                            <b><?php echo 'Gs. '.number_format ($precio,0,",",".").''; ?></b><br>
                            <del><?php echo 'Gs. '.number_format ($precio_tachado,0,",","."); ?></del>
                          </p>

                        </div>

                      </div>

                      <!-- - - - - - - - - - - - - - End of product title & price - - - - - - - - - - - - - - - - -->

                    </div><!--/ .product_item-->

                    <?php
                  }

                  ?>


                  <!-- - - - - - - - - - - - - - End product - - - - - - - - - - - - - - - - -->


                </div><!--/ .owl_carousel-->

                <!-- - - - - - - - - - - - - - End of carousel of bestseller - - - - - - - - - - - - - - - - -->

              </section>

            <?php endif; ?>
            <div class="v_centered mt-3">

              <span class="title">Compartir:</span>
              <div id="share"></div>


            </div>


          </article>
          <!-- <section class="section_offset">

            <h3>Comentarios</h3>

            <div class="fb-comments" data-href="<?php echo $actual_link ?>" data-width="850" data-numposts="25"></div>

          </section> -->
        </main>

      </div>

      <!-- <div id="sidebar" class="sidebar" role="complementary">
        <aside class="widget electro_recent_posts_widget">
          <h3 class="title-aside">Últimas Publicaciones</h3>
          <ul class="lista-aside">
            <?php
            $sql_last_post=mysql_query("SELECT * FROM blog WHERE estado='1' ORDER by id desc limit 3 ");
            while ($row_last_post=mysql_fetch_array($sql_last_post)) {
              $id_blog=$row_last_post['id'];
              $titulo=$row_last_post['titulo'];
              $created=$row_last_post['created'];
              $imagen=$row_last_post['imagen'];
              $query_sann=sanear_string(str_replace(' ', '-', $titulo));
              if (strpos($imagen, '.jpg') !== false || strpos($imagen, '.JPG') || strpos($imagen, '.JPEG') || strpos($imagen, '.jpeg') !== false) {
                $foto_min=$root.'imagen/150__150__'.$imagen;
              }elseif (strpos($imagen, '.gif') !== false || strpos($imagen, '.GIF') !== false) {
                $foto_min=$root.'imagen_gif/150__150__'.$imagen;
              }elseif (strpos($imagen, '.png') !== false || strpos($imagen, '.PNG') !== false) {
                $foto_min=$root.'imagen_png/150__150__'.$imagen;
              }else {
                $foto_min=$root.'public/'.$imagen;
              }
              ?>
              <li>
              
                <div class="post-content">
                  <a class ="post-name post-title" href="<?php echo $raiz.'blog/'.$id_blog.'/'.$query_sann; ?>"><?php echo $titulo ?></a>
                </div>
              </li>
            <?php } ?>
          </ul>
        </aside>
        <aside id="electro_product_categories_widget-1" class="widget woocommerce widget_product_categories electro_widget_product_categories">
          <h3 class="title-aside">Categorías</h3>
          <ul class="lista-categorias">
            <?php
            $smv = "SELECT * from rubros order by rubro";
            $smvr = mysql_query($smv,$link);
            while($rowmv = mysql_fetch_array($smvr)){
              $idmv = $rowmv['id'];
              $nombremv = $rowmv['rubro'];
              $imagenmv = $rowmv['imagen'];
              $urlmv = str_replace(" ","_",$nombremv);
              $urlmv = sanear_string($nombremv);
              ?>
              <li class="cat-item ">
                <a href="<?php echo $root;?>rubros/<?php echo $idmv;?>/<?php echo $urlmv;?>">
                  <?php echo $nombremv;?>
                </a>
              </li>
              <?php
            }
            ?>
          </ul>
        </aside>
      </div> -->
    </div>
  </div>

  <?php
  include 'footer-new.php';
  ?>
</div>

<?php
include "scripts-new.php"
?>
<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>assets/js/share/jssocials.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>assets/js/share/jssocials-theme-flat.css" />
<script src="<?php echo $root ?>assets/js/share/jssocials.min.js"></script>
<script type="text/javascript" src="<?php echo $root;?>assets/js/jquery.jscroll.js"></script>
<script>

jQuery("#departments-menu-toggle").on("click",function(){
  jQuery("#menu-vertical-menu").fadeIn(800);
}).on("focusout",function(){
  jQuery("#menu-vertical-menu").fadeOut(800);
})
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({
    margin:10,
    nav:true,
    responsive:{
      0:{
        items:1
      },
      600:{
        items:3
      },
      1000:{
        items:5
      }
    }
  });


  $('.scroll').jscroll({
    loadingHtml:'<center><img src="<?php echo $root;?>public/shopping.gif" alt=""></center>'
  });

  $("#share").jsSocials({
    showLabel: false,
    showCount: false,
    shares: ["email", "twitter", "facebook", "googleplus", "whatsapp"]
  });
});
</script>

</body>
</html>
