<?php
/**
 * Title: Como funciona (3 passos)
 * Slug: nautic-squad/como-funciona
 * Categories: nautic-squad
 * Description: Três cartões com os passos para ser sócio.
 */
$ns_steps = array(
	array( 'boat', 'Escolhe o barco e o plano', 'Decide em que barco queres navegar e quantas saídas queres fazer por mês. O plano adapta-se a ti.' ),
	array( 'calendar', 'Reserva na app', 'Marca as tuas datas na aplicação online, a qualquer hora e onde quer que estejas.' ),
	array( 'compass', 'Larga amarras', 'Chegas à marina e o barco está pronto. Tu só tens de navegar — nós tratamos do resto.' ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"como-funciona","className":"ns-section","layout":{"type":"default"}} -->
<section id="como-funciona" class="wp-block-group alignfull ns-section"><!-- wp:group {"className":"ns-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group ns-wrap"><!-- wp:group {"className":"ns-section__head is-center reveal","layout":{"type":"default"}} -->
<div class="wp-block-group ns-section__head is-center reveal"><!-- wp:paragraph {"className":"ns-eyebrow"} -->
<p class="ns-eyebrow">Como funciona</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Três passos até ao mar.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-lead"} -->
<p class="ns-lead">Ser sócio da Nautic Squad é ter um barco à tua espera, sem o comprar e sem te preocupares com a manutenção.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ns-steps reveal-stagger","layout":{"type":"default"}} -->
<div class="wp-block-group ns-steps reveal-stagger"><?php foreach ( $ns_steps as $ns_step ) : ?><!-- wp:group {"className":"ns-step","layout":{"type":"default"}} -->
<div class="wp-block-group ns-step"><!-- wp:html -->
<div class="ns-step__icon"><?php echo nautic_squad_svg( $ns_step[0] ); ?></div>
<!-- /wp:html -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $ns_step[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $ns_step[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
