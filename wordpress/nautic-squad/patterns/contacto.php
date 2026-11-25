<?php
/**
 * Title: Contactos
 * Slug: nautic-squad/contacto
 * Categories: nautic-squad, call-to-action
 * Description: Foto de fundo, contactos oficiais e formulário (envia email para o administrador).
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"contacto","className":"ns-contact ns-media is-darker","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url( nautic_squad_img( 'contacto' ) ); ?>","source":"file","title":"contacto"},"backgroundSize":"cover","backgroundPosition":"50% 50%"}},"layout":{"type":"default"}} -->
<section id="contacto" class="wp-block-group alignfull ns-contact ns-media is-darker"><!-- wp:group {"className":"ns-contact__grid","layout":{"type":"default"}} -->
<div class="wp-block-group ns-contact__grid"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"ns-label reveal"} -->
<p class="ns-label reveal">Contactos</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"ns-split"} -->
<h2 class="wp-block-heading ns-split">Está na hora <em>de zarpar.</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-lead reveal"} -->
<p class="ns-lead reveal">A Nautic Squad navega consigo em cada etapa. Agende uma visita, peça mais informações ou junte-se ao clube.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<ul class="ns-contact__list reveal">
<li><small>Telefone</small><a href="<?php echo nautic_squad_info( 'telefone_link' ); ?>"><?php echo nautic_squad_info( 'telefone' ); ?></a></li>
<li><small>Email</small><a href="mailto:<?php echo nautic_squad_info( 'email' ); ?>"><?php echo nautic_squad_info( 'email' ); ?></a></li>
<li><small>Escritório</small><?php echo nautic_squad_info( 'escritorio' ); ?></li>
<li><small>Embarcações</small>Marina de Oeiras · Marina de Cascais</li>
</ul>
<div class="ns-quick reveal"><a class="ns-link" href="<?php echo esc_url( nautic_squad_info( 'form_visita' ) ); ?>" target="_blank" rel="noopener">Agendar visita</a><a class="ns-link" href="<?php echo esc_url( nautic_squad_info( 'form_info' ) ); ?>" target="_blank" rel="noopener">Mais informações</a><a class="ns-link" href="<?php echo esc_url( nautic_squad_info( 'form_aderir' ) ); ?>" target="_blank" rel="noopener">Aderir / lista de espera</a></div>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:html -->
<form class="ns-form reveal" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<h3>Fale <em>connosco</em></h3>
<input type="hidden" name="action" value="ns_contacto">
<input type="text" name="ns_website" class="ns-hp" tabindex="-1" autocomplete="off" aria-hidden="true">
<div class="row"><div><label for="ns_nome">Nome</label><input id="ns_nome" name="ns_nome" required autocomplete="name"></div>
<div><label for="ns_telefone">Telefone</label><input id="ns_telefone" name="ns_telefone" type="tel" autocomplete="tel"></div></div>
<label for="ns_email">Email</label><input id="ns_email" name="ns_email" type="email" required autocomplete="email">
<label for="ns_interesse">Pedido</label>
<select id="ns_interesse" name="ns_interesse"><option>Agendar uma visita</option><option>Mais informações sobre o clube</option><option>Aderir ao clube / lista de espera</option><option>Sailing Academy</option><option>Power Club</option></select>
<label for="ns_mensagem">Mensagem</label><textarea id="ns_mensagem" name="ns_mensagem" rows="3"></textarea>
<button type="submit" class="ns-btn">Enviar pedido</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
