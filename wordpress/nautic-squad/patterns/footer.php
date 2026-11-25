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
<div><a class="ns-footer__logo" href="<?php echo $ns_h; ?>"><img src="<?php echo esc_url( nautic_squad_img( 'logo-branco' ) ); ?>" alt="Nautic Squad" width="140"></a>
<p style="max-width:34ch;margin-top:1.4rem">Clube de vela para skippers. Sailing Club, Sailing Academy e Power Club nas marinas de Oeiras e Cascais.</p>
<div class="ns-social"><a href="<?php echo esc_url( nautic_squad_info( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo nautic_squad_svg( 'instagram' ); ?></a><a href="<?php echo esc_url( nautic_squad_info( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo nautic_squad_svg( 'facebook' ); ?></a><a href="<?php echo esc_url( nautic_squad_info( 'linkedin' ) ); ?>" target="_blank" rel="noopener" aria-label="Linkedin"><?php echo nautic_squad_svg( 'linkedin' ); ?></a></div></div>
<div><h4>Clubes</h4><ul><li><a href="<?php echo $ns_h; ?>sailing-club/">Sailing Club</a></li><li><a href="<?php echo $ns_h; ?>sailing-academy/">Sailing Academy</a></li><li><a href="<?php echo $ns_h; ?>power-club/">Power Club</a></li><li><a href="<?php echo $ns_h; ?>#planos">Tipos de associação</a></li></ul></div>
<div><h4>Nautic Squad</h4><ul><li><a href="<?php echo $ns_h; ?>#frota">Frota</a></li><li><a href="<?php echo $ns_h; ?>#quem-somos">Quem somos</a></li><li><a href="<?php echo $ns_h; ?>#galeria">Galeria</a></li><li><a href="<?php echo $ns_h; ?>#faq">FAQ</a></li></ul></div>
<div><h4>Contactos</h4><ul><li><a href="<?php echo nautic_squad_info( 'telefone_link' ); ?>"><?php echo nautic_squad_info( 'telefone' ); ?></a></li><li><a href="mailto:<?php echo nautic_squad_info( 'email' ); ?>"><?php echo nautic_squad_info( 'email' ); ?></a></li><li><?php echo nautic_squad_info( 'escritorio' ); ?></li></ul></div>
</div>
<div class="ns-footer__big" aria-hidden="true">Nautic <em>Squad</em></div>
<div class="ns-footer__bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Nautic Squad</span><span><a href="<?php echo $ns_h; ?>politica-de-privacidade/">Privacidade</a> · <a href="https://www.livroreclamacoes.pt" target="_blank" rel="noopener">Livro de Reclamações</a></span></div>
</footer>
<!-- /wp:html -->