<?php
/**
 * Filters and actions that adjust WordPress's own output.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds layout classes to <body>.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function heliolisk_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$classes[] = 'heliolisk-layout-' . heliolisk_get_layout();
	$classes[] = 'heliolisk-scheme-' . heliolisk_get_color_scheme();

	return $classes;
}
add_filter( 'body_class', 'heliolisk_body_classes' );

/**
 * Adds a pingback discovery link on single posts that accept pingbacks.
 */
function heliolisk_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'heliolisk_pingback_header' );

/**
 * Excerpt length, set in Customizer → Blog & Layout.
 *
 * @return int
 */
function heliolisk_excerpt_length() {
	return max( 5, (int) heliolisk_get_option( 'excerpt_length' ) );
}
add_filter( 'excerpt_length', 'heliolisk_excerpt_length' );

/**
 * Replaces the default "[…]" after trimmed excerpts.
 *
 * @return string
 */
function heliolisk_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'heliolisk_excerpt_more' );

/**
 * Moves the post count of the Categories widget inside its link as a
 * <span class="count">, so the whole row is clickable and the count can sit
 * on the right.
 *
 * @param string $output wp_list_categories() markup.
 * @return string
 */
function heliolisk_category_count_markup( $output ) {
	return preg_replace( '/<\/a>\s*\(([\d,.]+)\)/', ' <span class="count">$1</span></a>', $output );
}
add_filter( 'wp_list_categories', 'heliolisk_category_count_markup' );

/**
 * Renders the Search block with the theme's searchform.php, so every search
 * box on the site (sidebar widget, block, overlay, 404) looks the same.
 *
 * @param string $block_content Block markup.
 * @return string
 */
function heliolisk_search_block_markup( $block_content ) {
	return get_search_form( array( 'echo' => false ) );
}
add_filter( 'render_block_core/search', 'heliolisk_search_block_markup' );

/**
 * Same as heliolisk_category_count_markup(), for the Archives widget.
 *
 * @param string $link_html One archive link.
 * @return string
 */
function heliolisk_archive_count_markup( $link_html ) {
	return preg_replace( '/<\/a>(?:&nbsp;|\s)*\(([\d,.]+)\)/', ' <span class="count">$1</span></a>', $link_html );
}
add_filter( 'get_archives_link', 'heliolisk_archive_count_markup' );
