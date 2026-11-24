<?php
/**
 * Title: Hero cinematográfico
 * Slug: nautic-squad/hero
 * Categories: nautic-squad, banner
 * Description: Abertura em ecrã inteiro com imagem/vídeo, barras de cinema e título gigante. Troque a imagem em Bloco → Estilos → Imagem de fundo, ou coloque assets/video/hero.mp4 no tema.
 */
$ns_video = nautic_squad_video( 'hero' );
?>
<!-- wp:group {"tagName":"section","align":"full","className":"ns-hero ns-media","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url( nautic_squad_img( 'hero' ) ); ?>","source":"file","title":"hero"},"backgroundSize":"cover","backgroundPosition":"50% 50%"}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignfull ns-hero ns-media"><?php if ( $ns_video ) : ?><!-- wp:html -->
<video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( nautic_squad_img( 'hero' ) ); ?>"><source src="<?php echo esc_url( $ns_video ); ?>" type="video/mp4"></video>
<!-- /wp:html --><?php endif; ?>

<!-- wp:group {"className":"ns-hero__content","layout":{"type":"default"}} -->
<div class="wp-block-group ns-hero__content"><!-- wp:paragraph {"className":"ns-label reveal"} -->
<p class="ns-label reveal">Sailing Club · Academy · Power Club — Oeiras &amp; Cascais</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"ns-split"} -->
<h1 class="wp-block-heading ns-split">O mar <em>é teu.</em></h1>
<!-- /wp:heading -->

<!-- wp:group {"className":"ns-hero__row","layout":{"type":"default"}} -->
<div class="wp-block-group ns-hero__row"><!-- wp:paragraph {"className":"ns-lead reveal"} -->
<p class="ns-lead reveal">Navega quando quiseres, sem teres um barco. A Nautic Squad dá-te a frota, a marina e a tranquilidade — tu só tens de largar amarras.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"reveal"} -->
<div class="wp-block-buttons reveal"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contacto">Marcar visita</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-ghost"} -->
<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#frota">Ver a frota</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="ns-bars" aria-hidden="true"><i></i><i></i></div><div class="ns-hero__bottom reveal"><span>38°41′ N — 9°19′ W</span><span>Vela · Motor · Academia</span><a class="ns-scroll" href="#manifesto" style="text-decoration:none">Descer <i></i></a></div>
<!-- /wp:html --></section>
<!-- /wp:group -->
