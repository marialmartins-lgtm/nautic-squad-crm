<?php
/**
 * SVG reutilizáveis (ondas, ícones, ilustrações). Usados pelos padrões.
 *
 * @package NauticSquad
 */

if ( ! function_exists( 'nautic_squad_svg' ) ) {
	/**
	 * Devolve o markup SVG pedido.
	 *
	 * @param string $name Nome do SVG.
	 * @param string $mod  Modificador (ex.: cor das ondas).
	 * @return string
	 */
	function nautic_squad_svg( $name, $mod = '' ) {
		$wave = 'M0 60 C 150 100 350 0 600 50 C 850 100 1050 10 1200 50 C 1350 90 1550 0 1800 50 C 2050 100 2250 10 2400 50 L2400 140 L0 140 Z';
		$wave2 = 'M0 80 C 200 30 400 120 600 80 C 800 40 1000 120 1200 80 C 1400 40 1600 120 1800 80 C 2000 40 2200 120 2400 80 L2400 140 L0 140 Z';
		$wave3 = 'M0 100 C 300 70 300 130 600 100 C 900 70 900 130 1200 100 C 1500 70 1500 130 1800 100 C 2100 70 2100 130 2400 100 L2400 140 L0 140 Z';

		switch ( $name ) {
			case 'waves':
				$cls = $mod ? ' is-' . $mod : '';
				return '<div class="ns-waves' . $cls . '" aria-hidden="true">'
					. '<svg class="w1" viewBox="0 0 2400 140" preserveAspectRatio="none"><path d="' . $wave . '"/></svg>'
					. '<svg class="w2" viewBox="0 0 2400 140" preserveAspectRatio="none"><path d="' . $wave2 . '"/></svg>'
					. '<svg class="w3" viewBox="0 0 2400 140" preserveAspectRatio="none"><path d="' . $wave3 . '"/></svg>'
					. '</div>';

			case 'logo':
				return '<svg class="ns-logo__mark" viewBox="0 0 40 40" aria-hidden="true"><circle cx="20" cy="20" r="19" fill="none" stroke="currentColor" stroke-width="2"/><path d="M21 7 L21 27 L31 27 Z" fill="#25C2CB"/><path d="M19 11 L19 27 L11 27 Z" fill="currentColor"/><path d="M8 30 Q14 34 20 30 T32 30" fill="none" stroke="#FFB547" stroke-width="2.2" stroke-linecap="round"/></svg>';

			case 'boat':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v13"/><path d="M12 4l7 11h-7"/><path d="M10 6 5 15h5"/><path d="M3 18c2 2 4 2 6 0 2 2 4 2 6 0 2 2 4 2 6 0"/></svg>';

			case 'calendar':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="3"/><path d="M8 3v4M16 3v4M3 10h18"/><path d="m9 15 2 2 4-4"/></svg>';

			case 'compass':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="m15.5 8.5-2 5-5 2 2-5z"/></svg>';

			case 'pin':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>';

			case 'phone':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>';

			case 'instagram':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor"/></svg>';

			case 'facebook':
				return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.3-1.5 1.5-1.5h1.5V4.4c-.3 0-1.2-.1-2.2-.1-2.2 0-3.8 1.4-3.8 3.9v2.3H8v3h2.5V21h3z"/></svg>';

			case 'linkedin':
				return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.8H3.8V20h3.1V8.8zM5.3 3.8a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6zM20.2 13.6c0-3-1.6-4.9-4.2-4.9-1.5 0-2.4.8-2.8 1.5V8.8h-3V20h3.1v-5.9c0-1.5.6-2.6 1.9-2.6 1.3 0 1.9 1 1.9 2.6V20h3.1v-6.4z"/></svg>';

			case 'mail':
				return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>';

			case 'sailboat-scene':
				return '<svg viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">'
					. '<defs><linearGradient id="nsSky" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#0C3556"/><stop offset=".55" stop-color="#1673B8"/><stop offset="1" stop-color="#25C2CB"/></linearGradient>'
					. '<linearGradient id="nsSea" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#0C3556"/><stop offset="1" stop-color="#071A2C"/></linearGradient></defs>'
					. '<rect width="400" height="500" fill="url(#nsSky)"/>'
					. '<circle cx="300" cy="120" r="46" fill="#FFB547" opacity=".9"/>'
					. '<circle cx="300" cy="120" r="80" fill="#FFB547" opacity=".12"/>'
					. '<g class="ns-sail"><path d="M200 120 L200 330 L290 330 Z" fill="#fff"/><path d="M192 140 L192 330 L120 330 Z" fill="#F3F8FB" opacity=".85"/><path d="M110 340 L300 340 L280 372 L135 372 Z" fill="#071A2C"/><rect x="196" y="110" width="4" height="232" fill="#071A2C"/></g>'
					. '<path d="M0 360 Q50 345 100 360 T200 360 T300 360 T400 360 V500 H0 Z" fill="url(#nsSea)"/>'
					. '<path d="M0 395 Q50 382 100 395 T200 395 T300 395 T400 395" stroke="#25C2CB" stroke-opacity=".35" stroke-width="3" fill="none"/>'
					. '<path d="M0 430 Q50 417 100 430 T200 430 T300 430 T400 430" stroke="#fff" stroke-opacity=".15" stroke-width="3" fill="none"/>'
					. '</svg>';

			case 'sailboat-card':
				return '<svg viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" aria-hidden="true">'
					. '<rect width="400" height="300" fill="#1673B8"/><circle cx="320" cy="70" r="30" fill="#FFB547" opacity=".85"/>'
					. '<g class="ns-sail"><path d="M200 50 L200 205 L268 205 Z" fill="#fff"/><path d="M193 66 L193 205 L140 205 Z" fill="#F3F8FB" opacity=".85"/><path d="M130 212 L275 212 L260 236 L148 236 Z" fill="#071A2C"/></g>'
					. '<path d="M0 230 Q50 218 100 230 T200 230 T300 230 T400 230 V300 H0 Z" fill="#0C3556"/>'
					. '<path d="M0 258 Q50 246 100 258 T200 258 T300 258 T400 258" stroke="#25C2CB" stroke-opacity=".4" stroke-width="3" fill="none"/>'
					. '</svg>';

			case 'motorboat-card':
				return '<svg viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" aria-hidden="true">'
					. '<rect width="400" height="300" fill="#0C3556"/><circle cx="80" cy="70" r="28" fill="#FFB547" opacity=".85"/>'
					. '<g class="ns-sail"><path d="M95 200 L300 200 L325 178 L230 178 L205 160 L150 160 L135 178 L95 178 Z" fill="#fff"/><path d="M160 166 L200 166 L215 178 L150 178 Z" fill="#25C2CB"/><path d="M88 200 L330 200 L310 228 L110 228 Z" fill="#071A2C"/></g>'
					. '<path d="M0 222 Q50 210 100 222 T200 222 T300 222 T400 222 V300 H0 Z" fill="#071A2C"/>'
					. '<path d="M330 214 Q360 206 400 214" stroke="#fff" stroke-opacity=".5" stroke-width="3" fill="none"/>'
					. '</svg>';
		}
		return '';
	}
}
