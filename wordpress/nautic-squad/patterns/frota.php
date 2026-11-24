<?php
/**
 * Title: Frota (scroll horizontal, dinâmica)
 * Slug: nautic-squad/frota
 * Categories: nautic-squad, query
 * Description: Os barcos criados em "Frota" deslizam na horizontal enquanto se faz scroll.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"frota","className":"ns-hscroll","layout":{"type":"default"}} -->
<section id="frota" class="wp-block-group alignfull ns-hscroll"><!-- wp:group {"className":"ns-hscroll__sticky","layout":{"type":"default"}} -->
<div class="wp-block-group ns-hscroll__sticky"><!-- wp:group {"className":"ns-hscroll__head","layout":{"type":"default"}} -->
<div class="wp-block-group ns-hscroll__head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"ns-label"} -->
<p class="ns-label">A frota</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"ns-split"} -->
<h2 class="wp-block-heading ns-split">Escolhe <em>o teu barco.</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="ns-hscroll__progress" aria-hidden="true"><i></i></div>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":11,"query":{"perPage":8,"pages":0,"offset":0,"postType":"barco","order":"asc","orderBy":"menu_order","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"ns-track"} -->
<div class="wp-block-query ns-track"><!-- wp:post-template -->
<!-- wp:group {"className":"ns-boat","layout":{"type":"default"}} -->
<div class="wp-block-group ns-boat"><!-- wp:post-featured-image {"isLink":true} /-->

<!-- wp:post-terms {"term":"tipo_barco"} /-->

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

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"ns_ano"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
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
