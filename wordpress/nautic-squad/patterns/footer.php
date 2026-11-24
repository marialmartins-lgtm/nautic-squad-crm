<?php
/**
 * Title: Rodapé
 * Slug: nautic-squad/footer
 * Categories: nautic-squad, footer
 * Block Types: core/template-part/footer
 * Inserter: no
 */
$ns_h = esc_url( home_url( '/' ) );
?>
<!-- wp:html -->
<footer class="ns-footer">
<div class="ns-footer__grid">
<div><a class="ns-logo" href="<?php echo $ns_h; ?>"><?php echo nautic_squad_svg( 'logo' ); ?>Nautic Squad</a>
<p style="max-width:34ch;margin-top:1.4rem">O clube para quem quer navegar sem ter barco. Vela e motor, a partir da Marina de Oeiras.</p></div>
<div><h4>Clube</h4><ul><li><a href="<?php echo $ns_h; ?>#como-funciona">Como funciona</a></li><li><a href="<?php echo $ns_h; ?>#frota">Frota</a></li><li><a href="<?php echo $ns_h; ?>#power-club">Power Club</a></li><li><a href="<?php echo $ns_h; ?>#planos">Planos</a></li></ul></div>
<div><h4>Aprender</h4><ul><li><a href="<?php echo $ns_h; ?>sailing-academy/">Sailing Academy</a></li><li><a href="<?php echo $ns_h; ?>#faq">Perguntas frequentes</a></li><li><a href="https://www.instagram.com/nautic.squad/" target="_blank" rel="noopener">Instagram</a></li></ul></div>
<div><h4>Marina</h4><ul><li>Avenida Marginal<br>Marina de Oeiras<br>2780-267 Oeiras</li><li><a href="tel:+351911924555">+351 911 924 555</a></li></ul></div>
</div>
<div class="ns-footer__big" aria-hidden="true">Nautic <em>Squad</em></div>
<div class="ns-footer__bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Nautic Squad</span><span><a href="<?php echo $ns_h; ?>politica-de-privacidade/">Privacidade</a> · <a href="https://www.livroreclamacoes.pt" target="_blank" rel="noopener">Livro de Reclamações</a></span></div>
</footer>
<!-- /wp:html -->
