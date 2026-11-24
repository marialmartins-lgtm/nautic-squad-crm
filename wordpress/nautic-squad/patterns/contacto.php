<?php
/**
 * Title: Contacto + formulário
 * Slug: nautic-squad/contacto
 * Categories: nautic-squad, call-to-action
 * Description: Contactos e formulário que envia email para o administrador do site.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"contacto","className":"ns-section is-dark","layout":{"type":"default"}} -->
<section id="contacto" class="wp-block-group alignfull ns-section is-dark"><!-- wp:group {"className":"ns-contact","layout":{"type":"default"}} -->
<div class="wp-block-group ns-contact"><!-- wp:group {"className":"reveal","layout":{"type":"default"}} -->
<div class="wp-block-group reveal"><!-- wp:paragraph {"className":"ns-eyebrow"} -->
<p class="ns-eyebrow">Contacto</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Vamos para o mar?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ns-lead"} -->
<p class="ns-lead">Diz-nos como gostas de navegar e com que frequência. Respondemos com a proposta ideal para ti.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<ul class="ns-contact__list">
<li><span class="ico"><?php echo nautic_squad_svg( 'pin' ); ?></span><div><small>Morada</small>Avenida Marginal, Marina de Oeiras<br>2780-267 Oeiras</div></li>
<li><span class="ico"><?php echo nautic_squad_svg( 'phone' ); ?></span><div><small>Telefone</small><a href="tel:+351911924555">911 924 555</a></div></li>
<li><span class="ico"><?php echo nautic_squad_svg( 'instagram' ); ?></span><div><small>Instagram</small><a href="https://www.instagram.com/nautic.squad/" target="_blank" rel="noopener">@nautic.squad</a></div></li>
</ul>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:html -->
<form class="ns-form reveal" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<h3>Pede informações</h3>
<input type="hidden" name="action" value="ns_contacto">
<input type="text" name="ns_website" class="ns-hp" tabindex="-1" autocomplete="off" aria-hidden="true">
<div class="row"><div><label for="ns_nome">Nome</label><input id="ns_nome" name="ns_nome" required autocomplete="name"></div>
<div><label for="ns_telefone">Telefone</label><input id="ns_telefone" name="ns_telefone" type="tel" autocomplete="tel"></div></div>
<label for="ns_email">Email</label><input id="ns_email" name="ns_email" type="email" required autocomplete="email">
<label for="ns_interesse">Tenho interesse em</label>
<select id="ns_interesse" name="ns_interesse"><option>Clube de vela</option><option>Power Club</option><option>Plano TEAM</option><option>Sailing Academy</option><option>Outro assunto</option></select>
<label for="ns_mensagem">Mensagem</label><textarea id="ns_mensagem" name="ns_mensagem" rows="4" placeholder="Quantas saídas por mês gostavas de fazer?"></textarea>
<button type="submit" class="ns-btn">Enviar pedido</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
