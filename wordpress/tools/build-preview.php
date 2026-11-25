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

$sections = array( 'hero', 'manifesto', 'clubes', 'como-funciona', 'incluido', 'frota', 'numeros', 'planos', 'quem-somos', 'cta', 'momentos', 'faq', 'contacto' );

// Frota estática (no WordPress vem de Frota → Barcos). Dados do site atual.
$boats = array(
	array( 'oceanbliss', 'Vela', 'Oceanbliss', 'Jeanneau Sun Odyssey 350', array( 'Dupla roda de leme', 'Marina de Oeiras' ) ),
	array( 'oceanescape', 'Vela', 'Oceanescape', 'Beneteau Oceanis 37 Limited Edition', array( '3 cabines', 'Marina de Oeiras' ) ),
	array( 'oceanvibes', 'Vela', 'Oceanvibes', 'Dufour 45 Classic', array( '13,67 m', 'Marina de Cascais' ) ),
	array( 'oceanfun', 'Vela · Academy', 'Oceanfun', 'Jeanneau Sun 2500', array( '7,50 m', 'Marina de Oeiras' ) ),
	array( 'fiftyfifty', 'Motor · Power Club', 'Fifty Fifty', 'Quicksilver Activ 875', array( '8,7 m', '12 pessoas', 'Marina de Oeiras' ) ),
);
$fleet = '<div class="ns-fleet__grid reveal-stagger">';
foreach ( $boats as $i => $b ) {
	$fleet .= '<article class="ns-boat"><figure class="ns-boat__img"><img src="' . nautic_squad_img( $b[0] ) . '" alt="' . $b[2] . '"></figure>'
		. '<div class="ns-boat__body"><span class="ns-boat__tag">' . $b[1] . '</span>'
		. '<h3>' . $b[2] . '</h3><p class="ns-boat__model">' . $b[3] . '</p><div class="ns-specs">';
	foreach ( $b[4] as $s ) {
		$fleet .= '<span>' . $s . '</span>';
	}
	$fleet .= '</div></div><a class="ns-boat__link" href="#contacto" aria-label="' . $b[2] . '"></a></article>';
}
$fleet .= '</div>';

$body = '';
foreach ( $sections as $s ) {
	$html  = ns_render( $theme . '/patterns/' . $s . '.php' );
	$html  = preg_replace( '/<!-- wp:query .*?<!-- \/wp:query -->/s', $fleet, $html );
	$body .= ns_apply_backgrounds( $html );
}
$footer = ns_render( $theme . '/patterns/footer.php' );

// Cabeçalho: o mesmo padrão do tema; o bloco Navegação é trocado por um menu estático.
$menu  = array( 'como-funciona' => 'Sailing Club', 'frota' => 'Frota', 'power-club' => 'Power Club', 'quem-somos' => 'Quem somos', 'galeria' => 'Galeria', 'planos' => 'Associação', 'contacto' => 'Contactos' );
$links = '';
foreach ( $menu as $id => $label ) {
	$links .= '<a href="#' . $id . '"><span>' . $label . '</span></a>';
}
$header = ns_render( $theme . '/patterns/header.php' );
$header = preg_replace( '/<!-- wp:navigation .*?<!-- \/wp:navigation -->/s', '<button class="ns-menu-btn" data-menu-toggle aria-label="Abrir menu">Menu <i></i></button>', $header );
$header .= '<div class="ns-overlay" style="--ns-overlay-img:url(\'' . nautic_squad_img( 'momento-1' ) . '\')"><nav class="ns-overlay__nav">' . $links . '</nav>
<div class="ns-overlay__aside"><p class="ns-label">Nautic Squad</p><p>Marina de Oeiras · Marina de Cascais<br><a href="tel:+351911924555">911 924 555</a><br><a href="mailto:sales@nauticsquad.com">sales@nauticsquad.com</a></p></div>
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
<title>Nautic Squad — Proposta de novo site</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

// Embute as imagens (data URI) para a pré-visualização abrir sozinha, num único ficheiro.
$page = preg_replace_callback(
	'#\.\./nautic-squad/(assets/img/[a-z0-9-]+\.(jpg|png))#',
	function ( $m ) use ( $theme ) {
		$mime = 'png' === $m[2] ? 'image/png' : 'image/jpeg';
		return 'data:' . $mime . ';base64,' . base64_encode( file_get_contents( $theme . '/' . $m[1] ) );
	},
	$page
);

$out = dirname( __DIR__ ) . '/preview/index.html';
file_put_contents( $out, $page );
echo "Pré-visualização gerada: $out\n";
