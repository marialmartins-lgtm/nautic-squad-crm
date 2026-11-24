<?php
/**
 * Title: Faixa em movimento
 * Slug: nautic-squad/marquee
 * Categories: nautic-squad
 * Description: Palavras-chave em movimento contínuo.
 */
$ns_items = array( 'Sem comprar barco', 'Reserva online', 'Vela &amp; motor', 'Marina de Oeiras', 'Manutenção incluída', 'Partilha com um amigo' );
$ns_html  = '';
foreach ( array_merge( $ns_items, $ns_items ) as $ns_item ) {
	$ns_html .= '<span class="ns-marquee__item">' . $ns_item . '</span>';
}
?>
<!-- wp:html -->
<div class="ns-marquee alignfull" aria-hidden="true"><div class="ns-marquee__track"><?php echo $ns_html; // phpcs:ignore ?></div></div>
<!-- /wp:html -->
