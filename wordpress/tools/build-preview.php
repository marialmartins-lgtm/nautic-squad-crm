<?php
/**
 * Gera wordpress/preview/index.html — uma pré-visualização estática da página
 * inicial, montada a partir dos MESMOS padrões, CSS e JS do tema.
 *
 * Uso:  php wordpress/tools/build-preview.php
 *
 * Só para pré-visualização: no WordPress, a frota vem do tipo de conteúdo
 * "Barcos" e o menu do bloco Navegação.
 */

// Stubs mínimos das funções do WordPress usadas pelos padrões.
function esc_html( $s ) { return htmlspecialchars( $s, ENT_QUOTES ); }
function esc_attr( $s ) { return htmlspecialchars( $s, ENT_QUOTES ); }
function esc_url( $s ) { return $s; }
function home_url( $p = '' ) { return '#'; }
function admin_url( $p = '' ) { return '#'; }

$theme = dirname( __DIR__ ) . '/nautic-squad';
require $theme . '/inc/svg.php';

function ns_render( $file ) {
	ob_start();
	include $file;
	return ob_get_clean();
}

$sections = array( 'hero', 'marquee', 'como-funciona', 'numeros', 'incluido', 'frota', 'power-club', 'planos', 'academia', 'faq', 'contacto' );

// Cartões estáticos da frota (no WordPress vêm de Frota → Barcos).
$boats = array(
	array( 'Vela', 'sailboat-card', 'Jeanneau Sun Odyssey 349', 'Veleiro de cruzeiro · 2020', array( '10,3 m', 'Vela', '2020' ), false ),
	array( 'Vela', 'sailboat-card', 'Beneteau Oceanis 37', 'Limited Edition · 2013', array( '11,5 m', 'Vela', '2013' ), false ),
	array( 'Motor · Power Club', 'motorboat-card', 'FIFTY FIFTY', 'Quicksilver Activ 875', array( '8,7 m', '12 pessoas', 'Oeiras' ), true ),
);
$fleet = '<div class="ns-fleet reveal-stagger">';
foreach ( $boats as $b ) {
	$fleet .= '<article class="ns-boat' . ( $b[5] ? ' is-featured' : '' ) . '"><div class="ns-boat__media">' . nautic_squad_svg( $b[1] ) . '<span class="ns-boat__tag">' . $b[0] . '</span></div>'
		. '<div class="ns-boat__body"><h3>' . $b[2] . '</h3><p class="ns-boat__model">' . $b[3] . '</p><div class="ns-specs">';
	foreach ( $b[4] as $s ) {
		$fleet .= '<span class="ns-spec">' . $s . '</span>';
	}
	$fleet .= '</div></div><a class="ns-boat__link" href="#" aria-label="' . $b[2] . '"></a></article>';
}
$fleet .= '</div>';

$body = '';
foreach ( $sections as $s ) {
	$html = ns_render( $theme . '/patterns/' . $s . '.php' );
	$html = preg_replace( '/<!-- wp:query .*?<!-- \/wp:query -->/s', $fleet, $html );
	$body .= $html;
}
$body .= ns_render( $theme . '/patterns/footer.php' );

$header = '<div class="ns-progress" aria-hidden="true"></div>
<header class="ns-header"><div class="ns-header__inner">
<a class="ns-logo" href="#">' . nautic_squad_svg( 'logo' ) . 'Nautic Squad</a>
<button class="ns-burger" aria-label="Menu" aria-expanded="false"><span></span><span></span><span></span></button>
<nav class="ns-nav"><a href="#como-funciona">Como funciona</a><a href="#frota">Frota</a><a href="#power-club">Power Club</a><a href="#planos">Planos</a><a href="#faq">FAQ</a><a class="ns-btn" href="#contacto">Ser sócio</a></nav>
</div></header>';

$html = $header . '<main class="ns-home">' . $body;
// Fecha o <main> antes do rodapé.
$html = str_replace( '<footer class="ns-footer">', '</main><footer class="ns-footer">', $html );
// Remove os comentários de bloco.
$html = preg_replace( '/<!-- \/?wp:[^>]*-->\s*/', '', $html );
$html = preg_replace( '/\n{2,}/', "\n", $html );

$css = file_get_contents( $theme . '/assets/css/main.css' );
$js  = file_get_contents( $theme . '/assets/js/main.js' );

$page = '<!doctype html>
<html lang="pt-PT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nautic Squad — Proposta de redesign</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:var(--ns-font-text);font-size:1.0625rem;line-height:1.65;color:#071A2C;background:#fff}
h1,h2,h3,h4{font-family:var(--ns-font-title);font-weight:700;line-height:1.1;letter-spacing:-.02em}
h2{font-size:clamp(1.9rem,3.6vw,3rem)}h3{font-size:clamp(1.2rem,1.6vw,1.5rem)}
.wp-block-buttons{display:flex;flex-wrap:wrap;gap:.8rem}
.wp-block-button__link{background:var(--ns-sol);color:var(--ns-abismo);padding:.95rem 1.7rem;font-size:1rem}
.ns-hero .wp-block-button__link{}
.wp-block-buttons[style*="margin-top"]{justify-content:center}
.wp-block-list{padding-left:0}
' . $css . '
</style>
</head>
<body class="ns-site">
' . $html . '
<script>' . $js . '</script>
</body>
</html>
';

$out = dirname( __DIR__ ) . '/preview/index.html';
file_put_contents( $out, $page );
echo "Pré-visualização gerada: $out\n";
