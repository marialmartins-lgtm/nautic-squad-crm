<?php
/**
 * Nautic Squad — funções do tema.
 *
 * @package NauticSquad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NAUTIC_SQUAD_VERSION', '2.0.0' );

require_once get_template_directory() . '/inc/media.php';
require_once get_template_directory() . '/inc/svg.php';
require_once get_template_directory() . '/inc/barcos.php';
require_once get_template_directory() . '/inc/contacto.php';

/**
 * Suportes do tema.
 */
function nautic_squad_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_editor_style( array( 'assets/css/main.css' ) );

	register_nav_menus(
		array(
			'principal' => __( 'Menu principal', 'nautic-squad' ),
		)
	);
}
add_action( 'after_setup_theme', 'nautic_squad_setup' );

/**
 * Tipos de letra (Google Fonts).
 * Para RGPD, pode instalá-los localmente em Aparência → Editor → Estilos → Tipografia
 * e remover esta função.
 */
function nautic_squad_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Manrope:wght@300;400;500;600;700&display=swap';
}

/**
 * Estilos e scripts no site.
 */
function nautic_squad_assets() {
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'nautic-squad-fonts', nautic_squad_fonts_url(), array(), null );
	wp_enqueue_style( 'nautic-squad-main', $uri . '/assets/css/main.css', array(), NAUTIC_SQUAD_VERSION );
	wp_enqueue_script( 'lenis', $uri . '/assets/vendor/lenis.min.js', array(), '1.1.20', array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_enqueue_script( 'nautic-squad-main', $uri . '/assets/js/main.js', array( 'lenis' ), NAUTIC_SQUAD_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
}
add_action( 'wp_enqueue_scripts', 'nautic_squad_assets' );

/**
 * Tipos de letra no editor.
 */
function nautic_squad_editor_assets() {
	wp_enqueue_style( 'nautic-squad-fonts', nautic_squad_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'nautic_squad_editor_assets' );

/**
 * Pré-ligação ao Google Fonts.
 */
function nautic_squad_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'nautic_squad_resource_hints', 10, 2 );

/**
 * Categoria própria para os padrões de secções.
 */
function nautic_squad_pattern_categories() {
	register_block_pattern_category(
		'nautic-squad',
		array( 'label' => __( 'Nautic Squad', 'nautic-squad' ) )
	);
}
add_action( 'init', 'nautic_squad_pattern_categories' );

/**
 * Estilos de bloco extra (selecionáveis no editor).
 */
function nautic_squad_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'ghost',
			'label' => __( 'Contorno', 'nautic-squad' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'glass',
			'label' => __( 'Vidro', 'nautic-squad' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'card',
			'label' => __( 'Cartão', 'nautic-squad' ),
		)
	);
}
add_action( 'init', 'nautic_squad_block_styles' );

/**
 * Classe "reveal": no editor os elementos ficam sempre visíveis.
 */
function nautic_squad_body_class( $classes ) {
	$classes[] = 'ns-site';
	return $classes;
}
add_filter( 'body_class', 'nautic_squad_body_class' );
