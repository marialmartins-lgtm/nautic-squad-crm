<?php
/**
 * Imagens e vídeos do tema.
 *
 * As fotografias vêm do site atual da Nautic Squad e estão em assets/img/
 * com o nome do "slot" (ex.: assets/img/hero.jpg). Para trocar uma foto basta
 * substituir o ficheiro com o mesmo nome — ou trocar a imagem no editor.
 *
 * Para um vídeo na abertura, coloque assets/video/hero.mp4.
 *
 * @package NauticSquad
 */

if ( ! function_exists( 'nautic_squad_img' ) ) {
	/**
	 * URL da imagem de um slot em assets/img/ (jpg, jpeg, webp ou png).
	 */
	function nautic_squad_img( $slot ) {
		foreach ( array( 'jpg', 'jpeg', 'webp', 'png' ) as $ext ) {
			$rel = 'assets/img/' . $slot . '.' . $ext;
			if ( file_exists( nautic_squad_dir() . '/' . $rel ) ) {
				return nautic_squad_uri() . '/' . $rel;
			}
		}
		return '';
	}
}

if ( ! function_exists( 'nautic_squad_video' ) ) {
	/**
	 * URL de um vídeo local (assets/video/<slot>.mp4) ou string vazia.
	 */
	function nautic_squad_video( $slot ) {
		$rel = 'assets/video/' . $slot . '.mp4';
		return file_exists( nautic_squad_dir() . '/' . $rel ) ? nautic_squad_uri() . '/' . $rel : '';
	}
}

if ( ! function_exists( 'nautic_squad_dir' ) ) {
	function nautic_squad_dir() {
		return function_exists( 'get_template_directory' ) ? get_template_directory() : dirname( __DIR__ );
	}
}

if ( ! function_exists( 'nautic_squad_uri' ) ) {
	function nautic_squad_uri() {
		return function_exists( 'get_template_directory_uri' ) ? get_template_directory_uri() : '../nautic-squad';
	}
}

/**
 * Contactos e ligações oficiais (usados em vários padrões).
 */
if ( ! function_exists( 'nautic_squad_info' ) ) {
	function nautic_squad_info( $key ) {
		$info = array(
			'telefone'      => '911 924 555',
			'telefone_link' => 'tel:+351911924555',
			'email'         => 'sales@nauticsquad.com',
			'escritorio'    => 'Av. Marquês de Tomar, nº 35, 7º andar<br>1050-153 Lisboa',
			'instagram'     => 'https://www.instagram.com/nautic.squad/',
			'facebook'      => 'https://www.facebook.com/Nautic-Squad-108675230929293/',
			'linkedin'      => 'https://www.linkedin.com/company/nauticsquad/',
			'form_info'     => 'https://forms.office.com/e/6nTuwHtfwU',
			'form_visita'   => 'https://forms.office.com/e/ugmNhFpCvC',
			'form_aderir'   => 'https://forms.office.com/e/0076apC7rm',
		);
		return isset( $info[ $key ] ) ? $info[ $key ] : '';
	}
}
