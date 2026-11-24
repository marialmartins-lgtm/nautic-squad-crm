<?php
/**
 * Imagens e vídeos do tema.
 *
 * Para usar fotos próprias, coloque ficheiros em assets/img/ com o nome do
 * "slot" (ex.: assets/img/hero.jpg) — o tema passa a usá-los automaticamente.
 * Também pode substituir qualquer imagem diretamente no editor do WordPress.
 *
 * Enquanto não existirem ficheiros locais, são usadas fotos provisórias
 * (Unsplash). Por baixo de cada imagem há sempre um fundo escuro, por isso
 * se uma foto não carregar o layout mantém-se.
 *
 * @package NauticSquad
 */

if ( ! function_exists( 'nautic_squad_media_slots' ) ) {
	function nautic_squad_media_slots() {
		$u = 'https://images.unsplash.com/photo-';
		$q = '?auto=format&fit=crop&w=2000&q=80';
		return array(
			'hero'      => $u . '1500514966906-fe245eea9344' . $q,
			'passo-1'   => $u . '1534008897995-27a23e859048' . $q,
			'passo-2'   => $u . '1559599746-8823b38544c6' . $q,
			'passo-3'   => $u . '1528154291023-a6525fabe5b4' . $q,
			'incluido'  => $u . '1505118380757-91f5f5632de0' . $q,
			'power'     => $u . '1569263979104-865ab7cd8d13' . $q,
			'vela-1'    => $u . '1520645521318-f03a712f0e67' . $q,
			'vela-2'    => $u . '1540946485063-a40da27545f8' . $q,
			'motor-1'   => $u . '1567899378494-47b22a2ae96a' . $q,
			'momento-1' => $u . '1507525428034-b723cf961d3e' . $q,
			'momento-2' => $u . '1544551763-46a013bb70d5' . $q,
			'momento-3' => $u . '1473116763249-2faaef81ccda' . $q,
			'momento-4' => $u . '1502680390469-be75c86b636f' . $q,
			'momento-5' => $u . '1605281317010-fe5ffe798166' . $q,
			'academia'  => $u . '1473496169904-658ba7c44d8a' . $q,
			'contacto'  => $u . '1500930287596-c1ecaa373bb2' . $q,
		);
	}
}

if ( ! function_exists( 'nautic_squad_img' ) ) {
	/**
	 * URL da imagem de um slot (ficheiro local se existir, senão a provisória).
	 */
	function nautic_squad_img( $slot ) {
		foreach ( array( 'jpg', 'jpeg', 'webp', 'png' ) as $ext ) {
			$rel = 'assets/img/' . $slot . '.' . $ext;
			if ( file_exists( nautic_squad_dir() . '/' . $rel ) ) {
				return nautic_squad_uri() . '/' . $rel;
			}
		}
		$slots = nautic_squad_media_slots();
		return isset( $slots[ $slot ] ) ? $slots[ $slot ] : '';
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
