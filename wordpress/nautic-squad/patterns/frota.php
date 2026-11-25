<?php
/**
 * Title: Frota (dinâmica)
 * Slug: nautic-squad/frota
 * Categories: nautic-squad, query
 * Description: Grelha com os barcos criados em "Frota". Cada foto mantém o seu formato.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"frota","className":"ns-section is-foam","layout":{"type":"default"}} -->
<section id="frota" class="wp-block-group alignfull ns-section is-foam"><!-- wp:group {"className":"ns-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group ns-wrap"><!-- wp:group {"className":"ns-head reveal","layout":{"type":"default"}} -->
<div class="wp-block-group ns-head reveal"><!-- wp:paragraph {"className":"ns-kicker"} -->
<p class="ns-kicker">A frota</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"ns-title"} -->
<h2 class="wp-block-heading ns-title">Escolha o seu barco</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-sub"} -->
<p class="ns-sub">Veleiros nas marinas de Oeiras e Cascais, o veleiro da Sailing Academy e a lancha do Power Club.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":11,"query":{"perPage":9,"pages":0,"offset":0,"postType":"barco","order":"asc","orderBy":"menu_order","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"ns-fleet"} -->
<div class="wp-block-query ns-fleet"><!-- wp:post-template {"className":"ns-fleet__grid reveal-stagger"} -->
<!-- wp:group {"className":"ns-boat","layout":{"type":"default"}} -->
<div class="wp-block-group ns-boat"><!-- wp:post-featured-image {"isLink":true} /-->

<!-- wp:group {"className":"ns-boat__body","layout":{"type":"default"}} -->
<div class="wp-block-group ns-boat__body"><!-- wp:post-terms {"term":"tipo_barco"} /-->

<!-- wp:post-title {"level":3,"isLink":true} /-->

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

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"ns_marina"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Adicione barcos no painel: <strong>Frota → Adicionar barco</strong>.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->