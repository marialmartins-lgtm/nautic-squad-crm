<?php
/**
 * Formulário de contacto do tema (sem plugins).
 * Envia um email para o endereço de administração do WordPress
 * (Definições → Geral) e redireciona de volta com uma mensagem.
 *
 * Para ligar ao HubSpot/CRM, use o filtro "nautic_squad_contacto_enviado".
 *
 * @package NauticSquad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nautic_squad_handle_contacto() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'contacto', $back );

	// Anti-spam: campo escondido que só robôs preenchem.
	if ( ! empty( $_POST['ns_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contacto', 'ok', $back ) . '#contacto' );
		exit;
	}

	$dados = array(
		'nome'      => isset( $_POST['ns_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['ns_nome'] ) ) : '',
		'email'     => isset( $_POST['ns_email'] ) ? sanitize_email( wp_unslash( $_POST['ns_email'] ) ) : '',
		'telefone'  => isset( $_POST['ns_telefone'] ) ? sanitize_text_field( wp_unslash( $_POST['ns_telefone'] ) ) : '',
		'interesse' => isset( $_POST['ns_interesse'] ) ? sanitize_text_field( wp_unslash( $_POST['ns_interesse'] ) ) : '',
		'mensagem'  => isset( $_POST['ns_mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ns_mensagem'] ) ) : '',
	);

	if ( '' === $dados['nome'] || ! is_email( $dados['email'] ) ) {
		wp_safe_redirect( add_query_arg( 'contacto', 'erro', $back ) . '#contacto' );
		exit;
	}

	$corpo = sprintf(
		"Novo pedido de contacto pelo site\n\nNome: %s\nEmail: %s\nTelefone: %s\nInteresse: %s\n\nMensagem:\n%s\n",
		$dados['nome'],
		$dados['email'],
		$dados['telefone'],
		$dados['interesse'],
		$dados['mensagem']
	);

	$para = apply_filters( 'nautic_squad_contacto_destino', get_option( 'admin_email' ) );
	$ok   = wp_mail(
		$para,
		'[Site] Contacto: ' . $dados['nome'] . ( $dados['interesse'] ? ' — ' . $dados['interesse'] : '' ),
		$corpo,
		array( 'Reply-To: ' . $dados['nome'] . ' <' . $dados['email'] . '>' )
	);

	do_action( 'nautic_squad_contacto_enviado', $dados );

	wp_safe_redirect( add_query_arg( 'contacto', $ok ? 'ok' : 'erro', $back ) . '#contacto' );
	exit;
}
add_action( 'admin_post_nopriv_ns_contacto', 'nautic_squad_handle_contacto' );
add_action( 'admin_post_ns_contacto', 'nautic_squad_handle_contacto' );

/**
 * Mostra a mensagem de sucesso/erro acima do formulário.
 */
function nautic_squad_contacto_notice() {
	if ( empty( $_GET['contacto'] ) ) {
		return;
	}
	$ok  = 'ok' === $_GET['contacto'];
	$msg = $ok ? 'Obrigado! Recebemos a tua mensagem e vamos responder em breve.' : 'Não foi possível enviar. Confirma o nome e o email e tenta de novo.';
	printf(
		'<script>document.addEventListener("DOMContentLoaded",function(){var f=document.querySelector(".ns-form");if(!f)return;var p=document.createElement("p");p.className="ns-form__notice %s";p.textContent=%s;f.prepend(p);});</script>',
		$ok ? 'is-ok' : 'is-error',
		wp_json_encode( $msg )
	);
}
add_action( 'wp_footer', 'nautic_squad_contacto_notice' );
