<?php
/**
 * Title: Cabeçalho
 * Slug: nautic-squad/header
 * Categories: nautic-squad, header
 * Block Types: core/template-part/header
 * Inserter: no
 */
$ns_h = esc_url( home_url( '/' ) );
?>
<!-- wp:html -->
<div class="ns-loader" aria-hidden="true"><div class="ns-loader__inner"><img class="ns-loader__logo" src="<?php echo esc_url( nautic_squad_img( 'logo-teal' ) ); ?>" alt="" width="120"><div class="ns-loader__bar"></div></div></div><div class="ns-grain" aria-hidden="true"></div>
<!-- /wp:html -->

<!-- wp:html -->
<div class="ns-topbar"><div class="ns-topbar__inner"><span><?php echo nautic_squad_svg( 'pin' ); ?> Marina de Oeiras · Marina de Cascais</span><a href="tel:+351911924555"><?php echo nautic_squad_svg( 'phone' ); ?> 911 924 555</a><a href="mailto:sales@nauticsquad.com"><?php echo nautic_squad_svg( 'mail' ); ?> sales@nauticsquad.com</a><span class="ns-topbar__social"><a href="<?php echo esc_url( nautic_squad_info( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo nautic_squad_svg( 'instagram' ); ?></a><a href="<?php echo esc_url( nautic_squad_info( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo nautic_squad_svg( 'facebook' ); ?></a><a href="<?php echo esc_url( nautic_squad_info( 'linkedin' ) ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><?php echo nautic_squad_svg( 'linkedin' ); ?></a></span></div></div>
<!-- /wp:html -->

<!-- wp:group {"tagName":"header","className":"ns-header","layout":{"type":"default"}} -->
<header class="wp-block-group ns-header"><!-- wp:group {"className":"ns-header__inner","layout":{"type":"default"}} -->
<div class="wp-block-group ns-header__inner"><!-- wp:html -->
<a class="ns-logo" href="<?php echo $ns_h; ?>" aria-label="Nautic Squad — início"><img class="ns-logo--branco" src="<?php echo esc_url( nautic_squad_img( 'logo-branco' ) ); ?>" alt="Nautic Squad" width="96"><img class="ns-logo--cor" src="<?php echo esc_url( nautic_squad_img( 'logo-teal' ) ); ?>" alt="" aria-hidden="true" width="96"></a>
<!-- /wp:html -->

<!-- wp:group {"className":"ns-header__right","layout":{"type":"default"}} -->
<div class="wp-block-group ns-header__right"><!-- wp:paragraph {"className":"ns-header__meta"} -->
<p class="ns-header__meta"><a href="<?php echo $ns_h; ?>#clubes">Clubes</a> · <a href="<?php echo $ns_h; ?>#frota">Frota</a> · <a href="<?php echo $ns_h; ?>#planos">Associação</a> · <a href="<?php echo $ns_h; ?>#contacto">Contactos</a></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-ghost"} -->
<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo $ns_h; ?>#contacto">Agendar visita</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:navigation {"overlayMenu":"always","overlayBackgroundColor":"abismo","overlayTextColor":"espuma","className":"ns-nav-block","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"Sailing Club","url":"<?php echo $ns_h; ?>sailing-club/","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Sailing Academy","url":"<?php echo $ns_h; ?>sailing-academy/","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Power Club","url":"<?php echo $ns_h; ?>power-club/","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Frota","url":"<?php echo $ns_h; ?>#frota","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Quem somos","url":"<?php echo $ns_h; ?>#quem-somos","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Galeria","url":"<?php echo $ns_h; ?>#galeria","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Contactos","url":"<?php echo $ns_h; ?>#contacto","kind":"custom"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></header>
<!-- /wp:group -->
