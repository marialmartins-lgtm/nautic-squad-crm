<?php
/**
 * Title: Abertura
 * Slug: nautic-squad/hero
 * Categories: nautic-squad, banner
 * Description: Foto em ecrã inteiro com canto arredondado e cartões de destaque sobrepostos. Para vídeo, coloque assets/video/hero.mp4.
 */
$ns_video = nautic_squad_video( 'hero' );
?>
<!-- wp:group {"tagName":"section","align":"full","className":"ns-hero-wrap","layout":{"type":"default"}} -->
<section class="wp-block-group alignfull ns-hero-wrap"><!-- wp:group {"className":"ns-hero ns-media","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url( nautic_squad_img( 'hero' ) ); ?>","source":"file","title":"hero"},"backgroundSize":"cover","backgroundPosition":"50% 50%"}},"layout":{"type":"default"}} -->
<div class="wp-block-group ns-hero ns-media"><?php if ( $ns_video ) : ?><!-- wp:html -->
<video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( nautic_squad_img( 'hero' ) ); ?>"><source src="<?php echo esc_url( $ns_video ); ?>" type="video/mp4"></video>
<!-- /wp:html --><?php endif; ?>

<!-- wp:group {"className":"ns-hero__content","layout":{"type":"default"}} -->
<div class="wp-block-group ns-hero__content"><!-- wp:paragraph {"className":"ns-kicker ns-kicker--light reveal"} -->
<p class="ns-kicker ns-kicker--light reveal">Clube de vela para skippers · Oeiras &amp; Cascais</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"ns-split"} -->
<h1 class="wp-block-heading ns-split">A vela é uma paixão.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-lead reveal"} -->
<p class="ns-lead reveal">Mas a falta de tempo e os custos associados são um obstáculo? Na Nautic Squad tem a liberdade de velejar quando quiser, com conforto e segurança, tal como se tivesse o barco próprio — por uma fração do custo e da dor de cabeça.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"reveal"} -->
<div class="wp-block-buttons reveal"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contacto">Agende a sua visita</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-ghost"} -->
<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="#clubes">Conhecer os clubes</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="ns-features reveal"><div class="ns-feature"><span class="ns-feature__ico"><?php echo nautic_squad_svg( 'pin' ); ?></span><h3>Oeiras e Cascais</h3><p>Veleiros e lancha prontos a sair de duas marinas.</p></div><div class="ns-feature"><span class="ns-feature__ico"><?php echo nautic_squad_svg( 'shield' ); ?></span><h3>Tudo incluído</h3><p>Marina, seguro, manutenção, limpeza e taxas.</p></div><div class="ns-feature"><span class="ns-feature__ico"><?php echo nautic_squad_svg( 'calendar' ); ?></span><h3>Reserva online</h3><p>Agende as saídas na aplicação, quando quiser.</p></div><div class="ns-feature"><span class="ns-feature__ico"><?php echo nautic_squad_svg( 'users' ); ?></span><h3>Comunidade</h3><p>Eventos e apoio na evolução como skipper.</p></div></div>
<!-- /wp:html --></section>
<!-- /wp:group -->
