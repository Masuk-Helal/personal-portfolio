<?php
/**
 * Registers the "Project Category" taxonomy for the Project post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Project_Category_Taxonomy {

	const TAXONOMY = 'project_category';

	/**
	 * Wires up the registration hook.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Registers the taxonomy.
	 */
	public function register() {
		$labels = array(
			'name'                       => __( 'Project Categories', 'heliolisk' ),
			'singular_name'              => __( 'Project Category', 'heliolisk' ),
			'menu_name'                  => __( 'Categories', 'heliolisk' ),
			'all_items'                  => __( 'All Categories', 'heliolisk' ),
			'edit_item'                  => __( 'Edit Category', 'heliolisk' ),
			'view_item'                  => __( 'View Category', 'heliolisk' ),
			'update_item'                => __( 'Update Category', 'heliolisk' ),
			'add_new_item'               => __( 'Add New Category', 'heliolisk' ),
			'new_item_name'              => __( 'New Category Name', 'heliolisk' ),
			'parent_item'                => __( 'Parent Category', 'heliolisk' ),
			'parent_item_colon'          => __( 'Parent Category:', 'heliolisk' ),
			'search_items'               => __( 'Search Categories', 'heliolisk' ),
			'not_found'                  => __( 'No categories found.', 'heliolisk' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'publicly_queryable' => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
			'show_tagcloud'     => false,
			'rewrite'           => array( 'slug' => 'project-category', 'with_front' => false ),
			'query_var'         => true,
		);

		register_taxonomy( self::TAXONOMY, array( Heliolisk_Project_CPT::POST_TYPE ), $args );
	}
}
