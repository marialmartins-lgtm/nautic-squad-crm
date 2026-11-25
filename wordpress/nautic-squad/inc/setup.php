<?php
/**
 * Importação do conteúdo inicial da Nautic Squad (um clique) e
 * redirecionamentos dos endereços antigos do site Wix.
 *
 * Depois de ativar o tema aparece um aviso no painel com o botão
 * "Importar conteúdo da Nautic Squad". A importação:
 *  - cria os 5 barcos (com foto, ficha técnica e descrição);
 *  - cria as páginas Início, Sailing Club, Sailing Academy, Power Club
 *    e Política de privacidade (rascunho);
 *  - define a página inicial e o título/descrição do site.
 * Pode ser executada mais do que uma vez: não duplica o que já existe.
 *
 * @package NauticSquad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Dados (textos do site atual nauticsquad.com)
 * ---------------------------------------------------------------------- */

function nautic_squad_seed_boats() {
	return array(
		array(
			'slug'   => 'oceanbliss',
			'title'  => 'Oceanbliss',
			'tipo'   => 'Vela',
			'img'    => 'oceanbliss',
			'order'  => 1,
			'meta'   => array( 'ns_modelo' => 'Jeanneau Sun Odyssey 350', 'ns_comprimento' => '', 'ns_capacidade' => 'Dupla roda de leme', 'ns_ano' => '', 'ns_marina' => 'Sailing Club · Marina de Oeiras' ),
			'resumo' => 'Sun Odyssey 350 de casco totalmente novo, silhueta moderna e excelente desempenho ao leme.',
			'texto'  => 'O OCEANBLISS é um Sun Odyssey 350 que se destaca pelo seu casco totalmente novo, silhueta moderna e excelente desempenho ao leme, oferecendo manobras fáceis e maior conforto no cockpit. O layout inteligente, com passadiços laterais contínuos e dupla roda de leme, garante segurança, fluidez de movimentos e boa visibilidade. No interior, os espaços luminosos e acolhedores, com design contemporâneo e mais de 1,85 m de altura livre, tornam este veleiro ideal para cruzeiros em família com conforto, bem-estar e tranquilidade.',
		),
		array(
			'slug'   => 'oceanescape',
			'title'  => 'Oceanescape',
			'tipo'   => 'Vela',
			'img'    => 'oceanescape',
			'order'  => 2,
			'meta'   => array( 'ns_modelo' => 'Beneteau Oceanis 37 Limited Edition', 'ns_comprimento' => '', 'ns_capacidade' => '3 cabines', 'ns_ano' => '2013', 'ns_marina' => 'Sailing Club · Marina de Oeiras' ),
			'resumo' => 'Beneteau Oceanis 37 Limited Edition: aerodinâmico, rápido, seguro e confortável, com três cabines.',
			'texto'  => "O OCEANESCAPE é um BENETEAU OCEANIS 37 LIMITED EDITION muito sedutor, construído em 2013. O Oceanis 37 chama a atenção pelo seu design inovador e exclusivo, com equilíbrio perfeito entre linhas fluidas e layout. Um veleiro aerodinâmico, rápido, prático e, sobretudo, seguro e confortável no mar.\n\nCom três cabines, cozinha espaçosa e um confortável salão, o OCEANESCAPE é o convite irrecusável para escapar da monotonia do dia a dia e criar memórias incríveis, únicas e especiais com os seus convidados de eleição.",
		),
		array(
			'slug'   => 'oceanvibes',
			'title'  => 'Oceanvibes',
			'tipo'   => 'Vela',
			'img'    => 'oceanvibes',
			'order'  => 3,
			'meta'   => array( 'ns_modelo' => 'Dufour 45 Classic', 'ns_comprimento' => '13,67 m', 'ns_capacidade' => '', 'ns_ano' => '1998', 'ns_marina' => 'Sailing Club · Marina de Cascais' ),
			'resumo' => 'Dufour 45 Classic de 13,67 m, ancorado na Marina de Cascais: elegância intemporal.',
			'texto'  => 'O OCEANVIBES é um DUFOUR 45 CLASSIC de 1998, ancorado na Marina de Cascais. Com 13,67 metros de elegância intemporal, combina desempenho sólido com o conforto de um veleiro clássico. A sua construção robusta e design equilibrado garantem estabilidade e prazer em cada milha navegada. Com um interior acolhedor e espaçoso, é o refúgio perfeito para quem procura momentos inesquecíveis no mar, onde a liberdade e a tranquilidade se encontram em perfeita harmonia.',
		),
		array(
			'slug'   => 'oceanfun',
			'title'  => 'Oceanfun',
			'tipo'   => 'Vela',
			'img'    => 'oceanfun',
			'order'  => 4,
			'meta'   => array( 'ns_modelo' => 'Jeanneau Sun 2500', 'ns_comprimento' => '7,50 m', 'ns_capacidade' => 'Sailing Academy', 'ns_ano' => '', 'ns_marina' => 'Sailing Academy · Marina de Oeiras' ),
			'resumo' => 'Jeanneau Sun 2500 versátil, ágil e fácil de manobrar — o barco da Sailing Academy.',
			'texto'  => 'O OCEANFUN é um JEANNEAU SUN 2500, um veleiro versátil, ágil e fácil de manobrar, que proporciona uma experiência de navegação dinâmica, segura e divertida. Ideal tanto para quem está a dar os primeiros passos na vela como para quem pretende aperfeiçoar as suas competências, combina conforto, estabilidade e um excelente desempenho à vela. Com 7,50 metros de comprimento, o OCEANFUN destaca-se pelo seu design funcional, cockpit ergonómico e facilidade de manobra.',
		),
		array(
			'slug'   => 'fifty-fifty',
			'title'  => 'Fifty Fifty',
			'tipo'   => 'Motor',
			'img'    => 'fiftyfifty',
			'order'  => 5,
			'meta'   => array( 'ns_modelo' => 'Quicksilver Activ 875', 'ns_comprimento' => '8,7 m', 'ns_capacidade' => '12 pessoas', 'ns_ano' => '', 'ns_marina' => 'Power Club · Marina de Oeiras' ),
			'resumo' => 'Quicksilver Activ 875 com 8,7 m e capacidade para 12 pessoas — a lancha do Power Club.',
			'texto'  => "A FIFTY FIFTY é uma QUICKSILVER ACTIV 875, com 8,7 m e capacidade para 12 pessoas, oferecendo uma experiência de navegação versátil e emocionante.\n\nOferece um interior moderno, funcional e surpreendentemente espaçoso para a sua categoria. A cabine principal é luminosa e bem ventilada, com uma cama confortável na proa e arrumação integrada. No geral, combina praticidade, conforto e um design inteligente — ideal para quem procura uma lancha versátil, confortável e pronta para desfrutar do mar com total liberdade.",
		),
	);
}

/**
 * Secção de introdução (blocos) para as páginas dos clubes.
 */
function nautic_squad_intro_block( $label, $titulo, $lead, $paragrafos ) {
	$ps = '';
	foreach ( $paragrafos as $p ) {
		$ps .= "\n\n<!-- wp:paragraph -->\n<p>" . $p . "</p>\n<!-- /wp:paragraph -->";
	}
	return '<!-- wp:group {"tagName":"section","align":"full","className":"ns-section ns-intro","layout":{"type":"default"}} -->
<section class="wp-block-group alignfull ns-section ns-intro"><!-- wp:group {"className":"ns-wrap ns-intro__grid","layout":{"type":"default"}} -->
<div class="wp-block-group ns-wrap ns-intro__grid"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"ns-label"} -->
<p class="ns-label">' . $label . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"ns-split"} -->
<h2 class="wp-block-heading ns-split">' . $titulo . '</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"reveal","layout":{"type":"default"}} -->
<div class="wp-block-group reveal"><!-- wp:paragraph {"className":"ns-lead"} -->
<p class="ns-lead">' . $lead . '</p>
<!-- /wp:paragraph -->' . $ps . '</div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->';
}

function nautic_squad_pattern_ref( $slug ) {
	return '<!-- wp:pattern {"slug":"nautic-squad/' . $slug . '"} /-->';
}

function nautic_squad_seed_pages() {
	$socio = 'Ao tornar-se sócio da Nautic Squad, passa a ter acesso a um barco específico, partilhado com outros membros que partilham o mesmo amor pelo mar, com utilização mensal garantida de acordo com a disponibilidade. Poderá navegar quando e para onde quiser, com tempo para chegar a praias isoladas, desfrutar de sunsets românticos ou reunir amigos e família para refeições a bordo.';
	$sonho = 'Ser membro da Nautic Squad proporciona o mesmo prazer de ter um barco próprio — um passeio ao pôr do sol, uma saída de sexta-feira, um fim de semana ou uma semana inteira no mar — sem preocupações com manutenção ou reparações. Parece um sonho, mas é realidade. O número de inscrições é limitado à disponibilidade de cada barco.';

	return array(
		'sailing-club'    => array(
			'title'   => 'Sailing Club',
			'content' => implode(
				"\n\n",
				array(
					nautic_squad_intro_block( 'Sailing Club — Oeiras &amp; Cascais', 'Junte-se ao <em>Sailing Club.</em>', 'Um clube de vela pensado para skippers que querem desfrutar da liberdade de navegar com amigos ou família, sem os custos e responsabilidades de ter um barco próprio.', array( $socio, $sonho ) ),
					nautic_squad_pattern_ref( 'incluido' ),
					nautic_squad_pattern_ref( 'como-funciona' ),
					nautic_squad_pattern_ref( 'planos' ),
					nautic_squad_pattern_ref( 'frota' ),
					nautic_squad_pattern_ref( 'faq' ),
					nautic_squad_pattern_ref( 'contacto' ),
				)
			),
		),
		'sailing-academy' => array(
			'title'   => 'Sailing Academy',
			'content' => implode(
				"\n\n",
				array(
					nautic_squad_intro_block( 'Sailing Academy — Marina de Oeiras', 'A aventura está ao alcance <em>de uma vela.</em>', 'A alternativa perfeita para os marinheiros que desejam ganhar experiência prática de navegação, que adoram uma competição ou que sonham em fazer passeios tranquilos.', array( 'Na Sailing Academy, os sócios têm acesso a um veleiro menor, leve e de controlo fácil — o OCEANFUN, um Jeanneau Sun 2500 — projetado para oferecer a melhor experiência de aprendizagem e desempenho competitivo.', $sonho ) ),
					nautic_squad_pattern_ref( 'como-funciona' ),
					nautic_squad_pattern_ref( 'planos' ),
					nautic_squad_pattern_ref( 'faq' ),
					nautic_squad_pattern_ref( 'contacto' ),
				)
			),
		),
		'power-club'      => array(
			'title'   => 'Power Club',
			'content' => implode(
				"\n\n",
				array(
					nautic_squad_intro_block( 'Power Club — Marina de Oeiras', 'Paixão pelo mar <em>e pela velocidade.</em>', 'O Power Club foi criado para quem vive a paixão pelo mar, pela velocidade e por experiências exclusivas.', array( 'Este clube oferece acesso a uma lancha de alto desempenho, cuidadosamente mantida e pronta para proporcionar momentos de pura adrenalina e conforto — num ambiente exclusivo, onde cada experiência é adaptada às preferências dos membros.', $sonho ) ),
					nautic_squad_pattern_ref( 'power-club' ),
					nautic_squad_pattern_ref( 'planos' ),
					nautic_squad_pattern_ref( 'faq' ),
					nautic_squad_pattern_ref( 'contacto' ),
				)
			),
		),
	);
}

/* -------------------------------------------------------------------------
 * Importação
 * ---------------------------------------------------------------------- */

/**
 * Copia uma imagem do tema para a Biblioteca de multimédia (uma só vez).
 */
function nautic_squad_import_image( $slot, $post_id = 0, $title = '' ) {
	$existing = get_posts(
		array(
			'post_type'   => 'attachment',
			'meta_key'    => '_ns_slot',
			'meta_value'  => $slot,
			'numberposts' => 1,
			'fields'      => 'ids',
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}
	$file = '';
	foreach ( array( 'jpg', 'png' ) as $ext ) {
		$f = get_template_directory() . '/assets/img/' . $slot . '.' . $ext;
		if ( file_exists( $f ) ) {
			$file = $f;
			break;
		}
	}
	if ( ! $file ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( basename( $file ) );
	copy( $file, $tmp );
	$id = media_handle_sideload(
		array(
			'name'     => 'nautic-squad-' . basename( $file ),
			'tmp_name' => $tmp,
		),
		$post_id,
		$title ? $title : 'Nautic Squad'
	);
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore
		return 0;
	}
	update_post_meta( $id, '_ns_slot', $slot );
	update_post_meta( $id, '_wp_attachment_image_alt', $title ? $title : 'Nautic Squad' );
	return (int) $id;
}

function nautic_squad_run_import() {
	$log = array();

	// Barcos.
	foreach ( nautic_squad_seed_boats() as $b ) {
		$post = get_page_by_path( $b['slug'], OBJECT, 'barco' );
		if ( $post ) {
			$log[] = 'Barco já existia: ' . $b['title'];
			continue;
		}
		$paras = '';
		foreach ( explode( "\n\n", $b['texto'] ) as $p ) {
			$paras .= "<!-- wp:paragraph -->\n<p>" . esc_html( $p ) . "</p>\n<!-- /wp:paragraph -->\n\n";
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'barco',
				'post_status'  => 'publish',
				'post_title'   => $b['title'],
				'post_name'    => $b['slug'],
				'post_excerpt' => $b['resumo'],
				'post_content' => trim( $paras ),
				'menu_order'   => $b['order'],
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		foreach ( $b['meta'] as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		wp_set_object_terms( $id, $b['tipo'], 'tipo_barco' );
		$img = nautic_squad_import_image( $b['img'], $id, $b['title'] );
		if ( $img ) {
			set_post_thumbnail( $id, $img );
		}
		$log[] = 'Barco criado: ' . $b['title'];
	}

	// Páginas dos clubes (modelo "Página larga").
	foreach ( nautic_squad_seed_pages() as $slug => $pg ) {
		if ( get_page_by_path( $slug ) ) {
			$log[] = 'Página já existia: ' . $pg['title'];
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $pg['title'],
				'post_name'    => $slug,
				'post_content' => $pg['content'],
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-full' );
			$log[] = 'Página criada: ' . $pg['title'];
		}
	}

	// Página inicial.
	$home = get_page_by_path( 'inicio' );
	if ( ! $home ) {
		$home_id = wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => 'Início',
				'post_name'   => 'inicio',
			)
		);
	} else {
		$home_id = $home->ID;
	}
	if ( $home_id && ! is_wp_error( $home_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	// Política de privacidade (rascunho para preencher — texto legal não incluído).
	if ( ! get_page_by_path( 'politica-de-privacidade' ) ) {
		$pid = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_title'   => 'Política de privacidade',
				'post_name'    => 'politica-de-privacidade',
				'post_content' => "<!-- wp:paragraph -->\n<p>[Preencher com a política de privacidade da Nautic Squad antes de publicar.]</p>\n<!-- /wp:paragraph -->",
			)
		);
		if ( $pid && ! is_wp_error( $pid ) ) {
			update_option( 'wp_page_for_privacy_policy', $pid );
			$log[] = 'Rascunho criado: Política de privacidade';
		}
	}

	// Identidade do site.
	update_option( 'blogname', 'Nautic Squad' );
	update_option( 'blogdescription', 'Clube de Vela para Skippers — Oeiras e Cascais' );
	$icon = nautic_squad_import_image( 'icone-vela', 0, 'Nautic Squad' );
	if ( $icon && ! get_option( 'site_icon' ) ) {
		update_option( 'site_icon', $icon );
	}

	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	flush_rewrite_rules();
	update_option( 'nautic_squad_imported', time() );

	return $log;
}

/* -------------------------------------------------------------------------
 * Aviso no painel + ação
 * ---------------------------------------------------------------------- */

function nautic_squad_import_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_GET['ns_import'] ) ) { // phpcs:ignore
		echo '<div class="notice notice-success is-dismissible"><p><strong>Nautic Squad:</strong> conteúdo importado. <a href="' . esc_url( home_url( '/' ) ) . '">Ver o site</a> · <a href="' . esc_url( admin_url( 'edit.php?post_type=barco' ) ) . '">Ver a frota</a></p></div>';
		return;
	}
	if ( get_option( 'nautic_squad_imported' ) ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=ns_import' ), 'ns_import' );
	echo '<div class="notice notice-info"><p><strong>Tema Nautic Squad ativo.</strong> Importe num clique a frota (5 barcos com fotos), as páginas Sailing Club, Sailing Academy e Power Club e a página inicial.</p><p><a class="button button-primary" href="' . esc_url( $url ) . '">Importar conteúdo da Nautic Squad</a></p></div>';
}
add_action( 'admin_notices', 'nautic_squad_import_notice' );

function nautic_squad_import_action() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sem permissões.' );
	}
	check_admin_referer( 'ns_import' );
	nautic_squad_run_import();
	wp_safe_redirect( admin_url( 'index.php?ns_import=1' ) );
	exit;
}
add_action( 'admin_post_ns_import', 'nautic_squad_import_action' );

/* -------------------------------------------------------------------------
 * Redirecionamentos dos endereços antigos (Wix)
 * ---------------------------------------------------------------------- */

function nautic_squad_old_urls() {
	$path = trim( (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ), '/' ); // phpcs:ignore
	$map  = array(
		'home'                    => '',
		'en'                      => '',
		'en/home'                 => '',
		'copy-of-sailing-club'    => 'power-club/',
		'en/copy-of-sailing-club' => 'power-club/',
		'en/sailing-club'         => 'sailing-club/',
		'en/sailing-academy'      => 'sailing-academy/',
	);
	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( '/' . $map[ $path ] ), 301 );
		exit;
	}
	if ( is_404() && 0 === strpos( $path, 'en/' ) ) {
		wp_safe_redirect( home_url( '/' . substr( $path, 3 ) . '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'nautic_squad_old_urls' );
