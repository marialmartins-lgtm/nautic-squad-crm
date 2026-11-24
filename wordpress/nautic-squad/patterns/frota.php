<?php
/**
 * Title: Frota (dinâmica)
 * Slug: nautic-squad/frota
 * Categories: nautic-squad, query
 * Description: Mostra automaticamente os barcos criados em "Frota" no painel.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"frota","className":"ns-section","layout":{"type":"default"}} -->
<section id="frota" class="wp-block-group alignfull ns-section"><!-- wp:group {"className":"ns-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group ns-wrap"><!-- wp:group {"className":"ns-section__head reveal","layout":{"type":"default"}} -->
<div class="wp-block-group ns-section__head reveal"><!-- wp:paragraph {"className":"ns-eyebrow"} -->
<p class="ns-eyebrow">A frota</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Escolhe o teu barco.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-lead"} -->
<p class="ns-lead">Veleiros para quem vive o vento, lancha para quem procura velocidade. Todos prontos a sair da Marina de Oeiras.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":11,"query":{"perPage":6,"pages":0,"offset":0,"postType":"barco","order":"asc","orderBy":"menu_order","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"ns-fleet"} -->
<div class="wp-block-query ns-fleet"><!-- wp:post-template {"className":"reveal-stagger"} -->
<!-- wp:group {"className":"ns-boat","layout":{"type":"default"}} -->
<div class="wp-block-group ns-boat"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:post-terms {"term":"tipo_barco"} /-->

<!-- wp:group {"className":"ns-boat__body","layout":{"type":"default"}} -->
<div class="wp-block-group ns-boat__body"><!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"ns_modelo"}}}},"className":"ns-boat__model"} -->
<p class="ns-boat__model"></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"ns-specs","layout":{"type":"default"}} -->
<div class="wp-block-group ns-specs"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"ns_comprimento"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"ns_capacidade"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"ns_ano"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Ainda não há barcos publicados. No painel, vá a <strong>Frota → Adicionar barco</strong>.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:buttons {"className":"reveal","style":{"spacing":{"margin":{"top":"2.5rem"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons reveal" style="margin-top:2.5rem"><!-- wp:button {"className":"is-style-ghost"} -->
<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>frota/">Ver toda a frota</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
