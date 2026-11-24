<?php
/**
 * Gera wordpress/preview/index.html — pré-visualização estática da página
 * inicial, montada a partir dos MESMOS padrões, CSS e JS do tema.
 *
 * Uso:  php wordpress/tools/build-preview.php
 */

function esc_html( $s ) { return htmlspecialchars( $s, ENT_QUOTES ); }
function esc_attr( $s ) { return htmlspecialchars( $s, ENT_QUOTES ); }
function esc_url( $s ) { return $s; }
function home_url( $p = '' ) { return '#'; }
function admin_url( $p = '' ) { return '#'; }

$theme = dirname( __DIR__ ) . '/nautic-squad';
require $theme . '/inc/media.php';
require $theme . '/inc/svg.php';

function ns_render( $file ) {
	ob_start();
	include $file;
	return ob_get_clean();
}

/**
 * Faz o que o WordPress faz no servidor: aplica a imagem de fundo do bloco
 * Grupo (atributo style.background) como style inline.
 */
function ns_apply_backgrounds( $html ) {
	return preg_replace_callback(
		'/<!-- wp:group (\{.*?\}) -->\s*<(section|div|header|main)([^>]*)>/s',
		function ( $m ) {
			$a = json_decode( $m[1], true );
			$url = $a['style']['background']['backgroundImage']['url'] ?? '';
			if ( ! $url ) {
				return $m[0];
			}
			$style = 'background-image:url(\'' . $url . '\');background-size:cover;background-position:50% 50%';
			return '<' . $m[2] . $m[3] . ' style="' . $style . '">';
		},
		$html
	);
}

$sections = array( 'hero', 'manifesto', 'como-funciona', 'frota', 'incluido', 'power-club', 'momentos', 'planos', 'academia', 'faq', 'contacto' );

// Frota estática (no WordPress vem de Frota → Barcos).
$boats = array(
	array( 'vela-1', 'Sailing Club · Oeiras', 'Oceanbliss', 'Jeanneau Sun Odyssey 350', array( 'Vela', 'Cockpit duplo leme', 'Oeiras' ) ),
	array( 'vela-2', 'Sailing Club · Oeiras', 'Oceanescape', 'Beneteau Oceanis 37 Limited Edition', array( '3 cabines', '2013', 'Oeiras' ) ),
	array( 'passo-3', 'Sailing Club · Cascais', 'Oceanvibes', 'Dufour 45 Classic', array( '13,67 m', '1998', 'Cascais' ) ),
	array( 'oceanfun', 'Sailing Academy · Oeiras', 'Oceanfun', 'Jeanneau Sun 2500', array( '7,50 m', 'Academia', 'Oeiras' ) ),
	array( 'motor-1', 'Power Club · Oeiras', 'Fifty Fifty', 'Quicksilver Activ 875', array( '8,7 m', '12 pessoas', 'Oeiras' ) ),
);
$fleet = '<div class="ns-track">';
foreach ( $boats as $i => $b ) {
	$fleet .= '<article class="ns-boat"><figure class="ns-boat__img"><img src="' . nautic_squad_img( $b[0] ) . '" alt="" loading="lazy"></figure>'
		. '<span class="ns-boat__tag">' . $b[1] . '</span><span class="ns-boat__idx">0' . ( $i + 1 ) . '</span>'
		. '<h3>' . $b[2] . '</h3><p class="ns-boat__model">' . $b[3] . '</p><div class="ns-specs">';
	foreach ( $b[4] as $s ) {
		$fleet .= '<span>' . $s . '</span>';
	}
	$fleet .= '</div><a class="ns-boat__link" href="#contacto" aria-label="' . $b[2] . '"></a></article>';
}
$fleet .= '<article class="ns-boat ns-boat--end"><p class="ns-label">Próxima saída</p><h3>O teu lugar <em>a bordo.</em></h3><a class="ns-btn" href="#contacto">Falar connosco</a></article></div>';

$body = '';
foreach ( $sections as $s ) {
	$html  = ns_render( $theme . '/patterns/' . $s . '.php' );
	$html  = preg_replace( '/<!-- wp:query .*?<!-- \/wp:query -->/s', $fleet, $html );
	$body .= ns_apply_backgrounds( $html );
}
$footer = ns_render( $theme . '/patterns/footer.php' );

$logo   = nautic_squad_svg( 'logo' );
$menu   = array( 'como-funciona' => 'Como funciona', 'frota' => 'Frota', 'power-club' => 'Power Club', 'momentos' => 'Momentos', 'planos' => 'Planos', 'contacto' => 'Contacto' );
$links  = '';
foreach ( $menu as $id => $label ) {
	$links .= '<a href="#' . $id . '"><span>' . $label . '</span></a>';
}
$header = '<div class="ns-loader" aria-hidden="true"><div class="ns-loader__inner"><div class="ns-loader__word"><span>Nautic Squad</span></div><div class="ns-loader__bar"></div></div></div><div class="ns-grain" aria-hidden="true"></div>
<header class="ns-header"><div class="ns-header__inner">
<a class="ns-logo" href="#">' . $logo . 'Nautic Squad</a>
<div class="ns-header__right"><span class="ns-header__meta">Oeiras · Cascais</span><div class="wp-block-buttons"><div class="wp-block-button is-style-ghost"><a class="wp-block-button__link" href="#contacto">Ser sócio</a></div></div>
<button class="ns-menu-btn" data-menu-toggle aria-label="Abrir menu">Menu <i></i></button></div>
</div></header>
<div class="ns-overlay" style="--ns-overlay-img:url(\'' . nautic_squad_img( 'passo-3' ) . '\')"><nav class="ns-overlay__nav">' . $links . '</nav>
<div class="ns-overlay__aside"><p class="ns-label">Marina de Oeiras</p><p>Avenida Marginal, 2780-267 Oeiras<br><a href="tel:+351911924555">+351 911 924 555</a><br><a href="https://www.instagram.com/nautic.squad/">@nautic.squad</a></p></div>
<button class="ns-menu-btn ns-overlay__close" data-menu-toggle aria-label="Fechar menu">Fechar <i></i></button></div>';

$html = $header . '<main class="ns-home">' . $body . '</main>' . $footer;
$html = preg_replace( '/<!-- \/?wp:[^>]*-->\s*/', '', $html );
$html = preg_replace( '/\n{2,}/', "\n", $html );

$css   = file_get_contents( $theme . '/assets/css/main.css' );
$lenis = file_get_contents( $theme . '/assets/vendor/lenis.min.js' );
$js    = file_get_contents( $theme . '/assets/js/main.js' );

$page = '<!doctype html>
<html lang="pt-PT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nautic Squad — Proposta cinematográfica</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Equivalentes mínimos dos estilos base do WordPress */
.wp-block-image{margin:0}.wp-block-image img{height:auto}
.wp-block-list{margin:0}
' . $css . '
</style>
</head>
<body class="ns-site">
' . $html . '
<script>' . $lenis . '</script>
<script>' . $js . '</script>
</body>
</html>
';

$out = dirname( __DIR__ ) . '/preview/index.html';
file_put_contents( $out, $page );
echo "Pré-visualização gerada: $out\n";
