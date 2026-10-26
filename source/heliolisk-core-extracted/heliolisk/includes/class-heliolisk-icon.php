<?php
/**
 * Shared admin menu icon for the plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Icon {

	/**
	 * Returns the base64-encoded gold bolt SVG used across Heliolisk admin menus.
	 */
	public static function menu_icon() {
		$svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">'
			. '<defs><linearGradient id="bolt-gradient" x1="0" y1="0" x2="0" y2="1">'
			. '<stop offset="0%" stop-color="#FCE8A8"></stop>'
			. '<stop offset="45%" stop-color="#D4AF37"></stop>'
			. '<stop offset="100%" stop-color="#9C6E17"></stop>'
			. '</linearGradient></defs>'
			. '<path d="M13 2 4 14h6l-2 8 9-12h-6l2-8Z" fill="url(#bolt-gradient)"></path></svg>';

		return 'data:image/svg+xml;base64,' . base64_encode( $svg );
	}
}
