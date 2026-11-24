<?php
/**
 * Title: Contacto
 * Slug: nautic-squad/contacto
 * Categories: nautic-squad, call-to-action
 * Description: Imagem de fundo, contactos e formulário (envia email para o administrador).
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"contacto","className":"ns-contact ns-media is-darker","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url( nautic_squad_img( 'contacto' ) ); ?>","source":"file","title":"contacto"},"backgroundSize":"cover","backgroundPosition":"50% 50%"}},"layout":{"type":"default"}} -->
<section id="contacto" class="wp-block-group alignfull ns-contact ns-media is-darker"><!-- wp:group {"className":"ns-contact__grid","layout":{"type":"default"}} -->
<div class="wp-block-group ns-contact__grid"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"ns-label reveal"} -->
<p class="ns-label reveal">Contacto</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"ns-split"} -->
<h2 class="wp-block-heading ns-split">Vamos <em>para o mar?</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-lead reveal"} -->
<p class="ns-lead reveal">Diz-nos como gostas de navegar e com que frequência. Respondemos com a proposta ideal para ti.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<ul class="ns-contact__list reveal">
<li><small>Marina</small>Avenida Marginal, Marina de Oeiras<br>2780-267 Oeiras</li>
<li><small>Telefone</small><a href="tel:+351911924555">+351 911 924 555</a></li>
<li><small>Instagram</small><a href="https://www.instagram.com/nautic.squad/" target="_blank" rel="noopener">@nautic.squad</a></li>
</ul>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:html -->
<form class="ns-form reveal" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<h3>Pede <em>informações</em></h3>
<input type="hidden" name="action" value="ns_contacto">
<input type="text" name="ns_website" class="ns-hp" tabindex="-1" autocomplete="off" aria-hidden="true">
<div class="row"><div><label for="ns_nome">Nome</label><input id="ns_nome" name="ns_nome" required autocomplete="name"></div>
<div><label for="ns_telefone">Telefone</label><input id="ns_telefone" name="ns_telefone" type="tel" autocomplete="tel"></div></div>
<label for="ns_email">Email</label><input id="ns_email" name="ns_email" type="email" required autocomplete="email">
<label for="ns_interesse">Interesse</label>
<select id="ns_interesse" name="ns_interesse"><option>Clube de vela</option><option>Power Club</option><option>Plano Team</option><option>Sailing Academy</option><option>Outro assunto</option></select>
<label for="ns_mensagem">Mensagem</label><textarea id="ns_mensagem" name="ns_mensagem" rows="3" placeholder="Quantas saídas por mês gostavas de fazer?"></textarea>
<button type="submit" class="ns-btn">Enviar pedido</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
