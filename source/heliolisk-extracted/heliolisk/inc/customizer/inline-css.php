<?php
/**
 * Customizer colors, printed as inline CSS right after the main stylesheet
 * so they override the color scheme's own colors without editing any CSS.
 *
 * A color left empty in the Customizer prints nothing, so the active color
 * scheme (light / dark) decides it.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds the CSS for the header / footer colors that have been set.
 *
 * Values are sanitize_hex_color()'d on save; they are checked again here
 * because theme mods can also be written by imports.
 *
 * @return string
 */
function heliolisk_get_inline_css() {
	$color = static function ( $key ) {
		return (string) sanitize_hex_color( heliolisk_get_option( $key ) );
	};

	$nav          = $color( 'nav_link_color' );
	$social       = $color( 'social_icon_color' );
	$social_hover = $color( 'social_icon_hover_color' );
	$footer_bg    = $color( 'footer_bg_color' );
	$footer_line  = $color( 'footer_border_color' );
	$footer_text  = $color( 'footer_text_color' );

	$rules = array();

	if ( $nav ) {
		$rules['.site-header .nav-links a']       = 'color:' . $nav;
		// Same specificity as the rule above, so the stylesheet's hover must be repeated after it.
		$rules['.site-header .nav-links a:hover'] = 'color:var(--red-bright)';
	}
	if ( $social ) {
		$rules['.socials a'] = 'color:' . $social;
	}
	if ( $social_hover ) {
		$rules['.socials a:hover'] = 'color:' . $social_hover;
	}
	if ( $footer_bg ) {
		$rules['.footer'][] = 'background-color:' . $footer_bg;
	}
	if ( $footer_line ) {
		$rules['.footer'][] = 'border-top-color:' . $footer_line;
	}
	if ( $footer_text ) {
		$rules['.footer-bottom'] = 'color:' . $footer_text;
	}

	$css = '';

	foreach ( $rules as $selector => $declarations ) {
		$css .= $selector . '{' . implode( ';', (array) $declarations ) . '}';
	}

	return $css;
}

/**
 * Attaches the Customizer CSS to the main stylesheet.
 */
function heliolisk_enqueue_inline_css() {
	$css = heliolisk_get_inline_css();

	if ( $css ) {
		wp_add_inline_style( 'heliolisk-main', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'heliolisk_enqueue_inline_css', 20 );
