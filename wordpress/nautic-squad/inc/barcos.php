<?php
/**
 * Tipo de conteúdo "Barcos" — a frota é gerida no painel e aparece
 * automaticamente na página inicial e no arquivo /frota.
 *
 * @package NauticSquad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Campos de cada barco (meta). Ficam disponíveis no editor e na REST API,
 * e são mostrados nos templates através de "block bindings" (WP 6.5+).
 */
function nautic_squad_barco_fields() {
	return array(
		'ns_modelo'      => __( 'Modelo (ex.: Jeanneau Sun Odyssey 349)', 'nautic-squad' ),
		'ns_comprimento' => __( 'Comprimento (ex.: 10,3 m)', 'nautic-squad' ),
		'ns_capacidade'  => __( 'Capacidade (ex.: 8 pessoas)', 'nautic-squad' ),
		'ns_ano'         => __( 'Ano (ex.: 2020)', 'nautic-squad' ),
		'ns_marina'      => __( 'Marina (ex.: Marina de Oeiras)', 'nautic-squad' ),
	);
}

function nautic_squad_register_barcos() {
	register_post_type(
		'barco',
		array(
			'labels'        => array(
				'name'          => __( 'Barcos', 'nautic-squad' ),
				'singular_name' => __( 'Barco', 'nautic-squad' ),
				'add_new_item'  => __( 'Adicionar barco', 'nautic-squad' ),
				'edit_item'     => __( 'Editar barco', 'nautic-squad' ),
				'all_items'     => __( 'Todos os barcos', 'nautic-squad' ),
				'menu_name'     => __( 'Frota', 'nautic-squad' ),
			),
			'public'        => true,
			'has_archive'   => 'frota',
			'rewrite'       => array( 'slug' => 'frota' ),
			'menu_icon'     => 'dashicons-sos',
			'menu_position' => 5,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'tipo_barco',
		'barco',
		array(
			'labels'            => array(
				'name'          => __( 'Tipos de barco', 'nautic-squad' ),
				'singular_name' => __( 'Tipo de barco', 'nautic-squad' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'tipo' ),
		)
	);

	foreach ( array_keys( nautic_squad_barco_fields() ) as $key ) {
		register_post_meta(
			'barco',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'nautic_squad_register_barcos' );

/**
 * Cria os termos "Vela" e "Motor" na ativação do tema.
 */
function nautic_squad_activate() {
	nautic_squad_register_barcos();
	foreach ( array( 'Vela', 'Motor' ) as $term ) {
		if ( ! term_exists( $term, 'tipo_barco' ) ) {
			wp_insert_term( $term, 'tipo_barco' );
		}
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'nautic_squad_activate' );

/**
 * Caixa "Ficha técnica" no editor do barco.
 */
function nautic_squad_barco_metabox() {
	add_meta_box( 'ns_ficha', __( 'Ficha técnica', 'nautic-squad' ), 'nautic_squad_barco_metabox_html', 'barco', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'nautic_squad_barco_metabox' );

function nautic_squad_barco_metabox_html( $post ) {
	wp_nonce_field( 'ns_ficha_save', 'ns_ficha_nonce' );
	foreach ( nautic_squad_barco_fields() as $key => $label ) {
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
}

function nautic_squad_barco_save( $post_id ) {
	if ( ! isset( $_POST['ns_ficha_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ns_ficha_nonce'] ), 'ns_ficha_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array_keys( nautic_squad_barco_fields() ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_barco', 'nautic_squad_barco_save' );

/**
 * Esconde o painel genérico "Campos personalizados" (usamos a Ficha técnica).
 */
function nautic_squad_hide_custom_fields_panel() {
	remove_meta_box( 'postcustom', 'barco', 'normal' );
}
add_action( 'add_meta_boxes', 'nautic_squad_hide_custom_fields_panel', 20 );

/**
 * Arquivo /frota: ordenar pelo campo "Ordem" (como na página inicial).
 */
function nautic_squad_barco_order( $q ) {
	if ( ! is_admin() && $q->is_main_query() && ( $q->is_post_type_archive( 'barco' ) || $q->is_tax( 'tipo_barco' ) ) ) {
		$q->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
	}
}
add_action( 'pre_get_posts', 'nautic_squad_barco_order' );
