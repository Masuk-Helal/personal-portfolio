<?php
/**
 * One Click Demo Import setup.
 *
 * Registers the bundled demo (demo-data/) with the One Click Demo Import
 * plugin, serves the demo images from the theme folder, and, once the import
 * is done, assigns the menu, front page and header / footer templates.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The demo offered on Appearance → Import Demo Data.
 *
 * @return array[]
 */
function heliolisk_ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => __( 'Heliolisk Portfolio', 'heliolisk' ),
			'local_import_file'          => HELIOLISK_THEME_DIR . '/demo-data/content.xml',
			'local_import_widget_file'   => HELIOLISK_THEME_DIR . '/demo-data/widget.wie',
			'local_import_customizer_file' => HELIOLISK_THEME_DIR . '/demo-data/customizer.dat',
			'import_notice'              => __( 'Importing adds the demo pages, projects, posts, menu, widgets and Customizer settings. Existing content is kept. For a clean result, run it on a fresh site.', 'heliolisk' ),
		),
	);
}
add_filter( 'ocdi/import_files', 'heliolisk_ocdi_import_files' );

/**
 * Points the demo images at the copies in demo-data/media/.
 *
 * The export names a placeholder host, so each attachment is fetched from this
 * site's own theme folder instead.
 *
 * @param array $data Post data read from the import file.
 * @return array
 */
function heliolisk_ocdi_local_attachment_url( $data ) {
	if ( empty( $data['post_type'] ) || 'attachment' !== $data['post_type'] ) {
		return $data;
	}

	$source = ! empty( $data['attachment_url'] ) ? $data['attachment_url'] : ( isset( $data['guid'] ) ? $data['guid'] : '' );
	$file   = basename( (string) wp_parse_url( $source, PHP_URL_PATH ) );

	if ( '' !== $file && file_exists( HELIOLISK_THEME_DIR . '/demo-data/media/' . $file ) ) {
		$data['attachment_url'] = get_theme_file_uri( 'demo-data/media/' . rawurlencode( $file ) );
	}

	return $data;
}
add_filter( 'wxr_importer.pre_process.post', 'heliolisk_ocdi_local_attachment_url', 5 );

/**
 * Finds a published post by its title and type.
 *
 * @param string $title     Post title.
 * @param string $post_type Post type.
 * @return int Post ID, or 0.
 */
function heliolisk_ocdi_find_post_id( $title, $post_type ) {
	$posts = get_posts(
		array(
			'post_type'        => $post_type,
			'title'            => $title,
			'post_status'      => 'publish',
			'numberposts'      => 1,
			'fields'           => 'ids',
			'suppress_filters' => true,
		)
	);

	return $posts ? (int) $posts[0] : 0;
}

/**
 * Menu, front page, and header / footer templates, assigned after the import.
 */
function heliolisk_ocdi_after_import() {
	$menu = get_term_by( 'name', 'Heliolisk Demo Menu', 'nav_menu' );

	if ( $menu ) {
		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	$home = heliolisk_ocdi_find_post_id( 'Home', 'page' );

	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
	}

	// The Customizer file carries 0 for both, as post IDs differ per site.
	$options = get_theme_mod( HELIOLISK_THEME_OPTIONS_KEY );
	$options = is_array( $options ) ? $options : array();

	$options['header_template_id'] = (string) heliolisk_ocdi_find_post_id( 'Header', 'hl_header' );
	$options['footer_template_id'] = (string) heliolisk_ocdi_find_post_id( 'Footer', 'hl_footer' );
	set_theme_mod( HELIOLISK_THEME_OPTIONS_KEY, $options );

	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}
}
add_action( 'ocdi/after_import', 'heliolisk_ocdi_after_import' );

// The theme's own Install Plugins screen is the single place plugins are set up.
add_filter( 'ocdi/register_plugins', '__return_empty_array' );
