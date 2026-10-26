<?php
/**
 * Primary menu helpers.
 *
 * A one-page front page reaches its sections through "#anchor" links; these
 * helpers keep those links working from every other template too. With no
 * menu assigned, the header simply shows no navigation (see
 * template-parts/header/site-header.php).
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Points a "#section" link at the front page when used on any other page.
 *
 * A bare "#work" would resolve to the current URL, so on inner pages the
 * browser would look for an anchor that does not exist there.
 *
 * @param string $href Link target.
 * @return string
 */
function heliolisk_resolve_anchor_url( $href ) {
	if ( '' === $href || '#' !== $href[0] || is_front_page() ) {
		return $href;
	}

	return home_url( '/' . $href );
}

/**
 * Rewrites the primary menu's "#section" Custom Links to the front page and
 * tags them with .nav-anchor for the scroll-spy in assets/js/script.js.
 *
 * @param array    $atts  Link attributes.
 * @param WP_Post  $item  Menu item (unused).
 * @param stdClass $args  wp_nav_menu() arguments.
 * @return array
 */
function heliolisk_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( empty( $atts['href'] ) || '#' !== substr( $atts['href'], 0, 1 ) ) {
		return $atts;
	}

	if ( isset( $args->theme_location ) && 'primary' !== $args->theme_location ) {
		return $atts;
	}

	$atts['href']  = heliolisk_resolve_anchor_url( $atts['href'] );
	$atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' nav-anchor' : 'nav-anchor';

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'heliolisk_nav_menu_link_attributes', 10, 3 );
