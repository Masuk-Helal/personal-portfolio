<?php
/**
 * Registers the "Header" custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Header_CPT {

	const POST_TYPE = 'hl_header';

	/**
	 * Wires up the registration hook.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Registers the post type.
	 */
	public function register() {
		$labels = array(
			'name'                  => __( 'Headers', 'heliolisk' ),
			'singular_name'         => __( 'Header', 'heliolisk' ),
			'menu_name'             => __( 'Header', 'heliolisk' ),
			'name_admin_bar'        => __( 'Header', 'heliolisk' ),
			'add_new'               => __( 'Add New', 'heliolisk' ),
			'add_new_item'          => __( 'Add New Header', 'heliolisk' ),
			'new_item'              => __( 'New Header', 'heliolisk' ),
			'edit_item'             => __( 'Edit Header', 'heliolisk' ),
			'view_item'             => __( 'View Header', 'heliolisk' ),
			'all_items'             => __( 'All Headers', 'heliolisk' ),
			'search_items'          => __( 'Search Headers', 'heliolisk' ),
			'not_found'             => __( 'No headers found.', 'heliolisk' ),
			'not_found_in_trash'    => __( 'No headers found in Trash.', 'heliolisk' ),
			'featured_image'        => __( 'Preview Image', 'heliolisk' ),
			'set_featured_image'    => __( 'Set preview image', 'heliolisk' ),
			'remove_featured_image' => __( 'Remove preview image', 'heliolisk' ),
			'use_featured_image'    => __( 'Use as preview image', 'heliolisk' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Custom header templates.', 'heliolisk' ),
			'public'             => false,
			// Not listed/indexed anywhere, but still resolvable by direct
			// URL — required for Elementor's editor preview iframe to load
			// the post at all (same setup Elementor uses for its own
			// template post type). Without this, "Edit with Elementor"
			// 404s on the preview.
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_in_admin_bar'  => false,
			'show_in_nav_menus'  => false,
			'show_in_rest'       => true,
			'menu_icon'          => Heliolisk_Icon::menu_icon(),
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
			'has_archive'        => false,
			'rewrite'            => false,
			'query_var'          => false,
		);

		register_post_type( self::POST_TYPE, $args );

		// Elementor only offers "Edit with Elementor" on post types that
		// explicitly declare support for it (page/post get it by default).
		add_post_type_support( self::POST_TYPE, 'elementor' );
	}
}
