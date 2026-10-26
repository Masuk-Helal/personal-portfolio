<?php
/**
 * Registers the "Project" custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Project_CPT {

	const POST_TYPE = 'hl_project';

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
			'name'                  => __( 'Projects', 'heliolisk' ),
			'singular_name'         => __( 'Project', 'heliolisk' ),
			'menu_name'             => __( 'Projects', 'heliolisk' ),
			'name_admin_bar'        => __( 'Project', 'heliolisk' ),
			'add_new'               => __( 'Add New', 'heliolisk' ),
			'add_new_item'          => __( 'Add New Project', 'heliolisk' ),
			'new_item'              => __( 'New Project', 'heliolisk' ),
			'edit_item'             => __( 'Edit Project', 'heliolisk' ),
			'view_item'             => __( 'View Project', 'heliolisk' ),
			'all_items'             => __( 'All Projects', 'heliolisk' ),
			'search_items'          => __( 'Search Projects', 'heliolisk' ),
			'not_found'             => __( 'No projects found.', 'heliolisk' ),
			'not_found_in_trash'    => __( 'No projects found in Trash.', 'heliolisk' ),
			'featured_image'        => __( 'Project Image', 'heliolisk' ),
			'set_featured_image'    => __( 'Set project image', 'heliolisk' ),
			'remove_featured_image' => __( 'Remove project image', 'heliolisk' ),
			'use_featured_image'    => __( 'Use as project image', 'heliolisk' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Portfolio project entries.', 'heliolisk' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_in_admin_bar'  => true,
			'show_in_rest'       => true,
			'menu_icon'          => Heliolisk_Icon::menu_icon(),
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
			'has_archive'        => 'projects',
			'rewrite'            => array( 'slug' => 'project', 'with_front' => false ),
			'query_var'          => true,
			'menu_position'      => 5,
		);

		register_post_type( self::POST_TYPE, $args );

		// Reuse WordPress's built-in Tags taxonomy for per-project skill/tool
		// pills (e.g. "R", "Regression Analysis") — separate from
		// Project Category, which is the broader grouping.
		register_taxonomy_for_object_type( 'post_tag', self::POST_TYPE );
	}
}
