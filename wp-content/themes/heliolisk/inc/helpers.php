<?php
/**
 * Generic helpers shared by the rest of inc/ and the templates.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reads a theme option and falls back to its registered default.
 *
 * Every default lives in inc/customizer/defaults.php, so templates never
 * repeat a default value next to a get_theme_mod() call.
 *
 * Resolution order: the Theme Options panel (inc/theme-options.php, when the
 * Codestar Framework plugin saved a value), then the Customizer, then the
 * registered default.
 *
 * @param string $key Option key.
 * @return mixed
 */
function heliolisk_get_option( $key ) {
	$defaults = heliolisk_get_option_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	$panel = heliolisk_theme_option( $key );

	if ( null !== $panel ) {
		return $panel;
	}

	return get_theme_mod( $key, $default );
}

/**
 * Returns a boolean option. Theme mods saved by the Customizer's checkbox
 * control can come back as '', '1', true or false.
 *
 * @param string $key Option key.
 * @return bool
 */
function heliolisk_is_enabled( $key ) {
	return (bool) heliolisk_get_option( $key );
}

/**
 * Active color scheme: 'light' or 'dark'.
 *
 * @return string
 */
function heliolisk_get_color_scheme() {
	return 'dark' === heliolisk_get_option( 'color_scheme' ) ? 'dark' : 'light';
}

/**
 * Cache-busting version for a theme asset: the file's modification time, so
 * browsers pick up edits instead of serving a stale cached copy.
 *
 * @param string $relative_path Path relative to the theme root.
 * @return string
 */
function heliolisk_asset_version( $relative_path ) {
	$file = HELIOLISK_THEME_DIR . '/' . ltrim( $relative_path, '/' );

	return file_exists( $file ) ? (string) filemtime( $file ) : HELIOLISK_THEME_VERSION;
}

/**
 * The post / page whose per-item settings (sidebar, banner, header, footer)
 * apply to the current request.
 *
 * On the blog index that is the "Posts page" chosen under Settings → Reading,
 * not the first post of the loop.
 *
 * @return int 0 when the request has no single owning post.
 */
function heliolisk_get_context_id() {
	if ( is_home() && ! is_front_page() ) {
		return (int) get_option( 'page_for_posts' );
	}

	if ( is_singular() ) {
		return (int) get_queried_object_id();
	}

	return 0;
}

/**
 * Reads a per-item meta value for the current request.
 *
 * @param string $key Meta key.
 * @return string '' when unset or when the request has no owning post.
 */
function heliolisk_get_context_meta( $key ) {
	$id = heliolisk_get_context_id();

	if ( ! $id ) {
		return '';
	}

	$value = get_post_meta( $id, $key, true );

	return is_scalar( $value ) ? (string) $value : '';
}

/**
 * Whether a post is built with Elementor, in which case its content is laid
 * out full-bleed with no banner or sidebars around it.
 *
 * @param int $post_id Post ID; defaults to the current post.
 * @return bool
 */
function heliolisk_is_elementor_post( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	return $post_id && 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/**
 * Tags allowed in admin-entered short text (copyright line, banner titles).
 *
 * @param string $text Raw text.
 * @return string
 */
function heliolisk_kses_inline( $text ) {
	return wp_kses(
		$text,
		array(
			'a'      => array(
				'href'   => true,
				'title'  => true,
				'target' => true,
				'rel'    => true,
				'class'  => true,
			),
			'span'   => array( 'class' => true ),
			'strong' => array(),
			'em'     => array(),
			'b'      => array(),
			'i'      => array(),
			'br'     => array(),
		)
	);
}
