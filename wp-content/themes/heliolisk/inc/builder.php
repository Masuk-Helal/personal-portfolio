<?php
/**
 * Elementor-built Header and Footer templates.
 *
 * The Heliolisk plugin registers the hl_header and hl_footer post types; a
 * post of either type, designed with Elementor, can replace the theme's own
 * header / footer — site-wide from the Customizer, or per page from the
 * "Page Settings" box. Without Elementor (or with nothing picked) the theme's
 * template-parts/header|footer markup is used.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Select options for a template picker: "theme default" plus every published
 * template of the given type.
 *
 * @param string $post_type 'hl_header' or 'hl_footer'.
 * @return array<string, string> Post ID (as string) => title.
 */
function heliolisk_get_builder_choices( $post_type ) {
	$choices = array(
		'0' => __( 'Default (Theme Template)', 'heliolisk' ),
	);

	if ( ! post_type_exists( $post_type ) ) {
		return $choices;
	}

	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	foreach ( $posts as $template ) {
		$choices[ (string) $template->ID ] = $template->post_title;
	}

	return $choices;
}

/**
 * The template post ID to render for the current request, or 0 for the
 * theme default. A page's own setting wins over the Customizer's.
 *
 * @param string $part 'header' or 'footer'.
 * @return int
 */
function heliolisk_get_builder_template_id( $part ) {
	$page_value = heliolisk_get_context_meta( 'heliolisk_page_' . $part );

	if ( '' !== $page_value ) {
		return (int) $page_value;
	}

	return (int) heliolisk_get_option( $part . '_template_id' );
}

/**
 * Elementor's rendered markup for a template post, or '' when it cannot be
 * used (Elementor inactive, wrong post type, unpublished).
 *
 * @param int    $template_id Template post ID.
 * @param string $post_type   Expected post type.
 * @return string
 */
function heliolisk_get_builder_html( $template_id, $post_type ) {
	if ( ! $template_id || ! did_action( 'elementor/loaded' ) ) {
		return '';
	}

	$template = get_post( $template_id );

	if ( ! $template || $post_type !== $template->post_type || 'publish' !== $template->post_status ) {
		return '';
	}

	return (string) \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
}

/**
 * Prints the site header: the chosen Elementor Header, or the theme's own.
 */
function heliolisk_render_site_header() {
	$html = heliolisk_get_builder_html( heliolisk_get_builder_template_id( 'header' ), 'hl_header' );

	if ( $html ) {
		// Elementor sanitises template markup when it is saved; the result still
		// carries <script>/<style> blocks and data-* attributes that kses would
		// strip, so it is printed verbatim through a fixed format string.
		printf( '%s', $html );
		return;
	}

	get_template_part( 'template-parts/header/site-header' );
}

/**
 * Prints the site footer: the chosen Elementor Footer, or the theme's own.
 */
function heliolisk_render_site_footer() {
	$html = heliolisk_get_builder_html( heliolisk_get_builder_template_id( 'footer' ), 'hl_footer' );

	if ( $html ) {
		// Same as the header: Elementor markup printed verbatim, see above.
		printf( '%s', $html );
		return;
	}

	get_template_part( 'template-parts/footer/site-footer' );
}
