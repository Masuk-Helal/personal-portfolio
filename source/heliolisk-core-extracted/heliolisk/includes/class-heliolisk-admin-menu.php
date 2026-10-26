<?php
/**
 * Builds the top-level "Heliolisk" admin menu with the Header, Footer and
 * Project post types nested underneath it as submenus.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Admin_Menu {

	/**
	 * Wires up the registration hook.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register' ) );
	}

	/**
	 * Registers the parent menu and its child post type screens.
	 */
	public function register() {
		$header_slug  = 'edit.php?post_type=' . Heliolisk_Header_CPT::POST_TYPE;
		$footer_slug  = 'edit.php?post_type=' . Heliolisk_Footer_CPT::POST_TYPE;
		$project_slug = 'edit.php?post_type=' . Heliolisk_Project_CPT::POST_TYPE;

		add_menu_page(
			__( 'Heliolisk', 'heliolisk' ),
			__( 'Heliolisk', 'heliolisk' ),
			'edit_posts',
			$header_slug,
			'',
			Heliolisk_Icon::menu_icon(),
			25
		);

		add_submenu_page(
			$header_slug,
			__( 'Header', 'heliolisk' ),
			__( 'Header', 'heliolisk' ),
			'edit_posts',
			$header_slug
		);

		add_submenu_page(
			$header_slug,
			__( 'Footer', 'heliolisk' ),
			__( 'Footer', 'heliolisk' ),
			'edit_posts',
			$footer_slug
		);

		add_submenu_page(
			$header_slug,
			__( 'Projects', 'heliolisk' ),
			__( 'Projects', 'heliolisk' ),
			'edit_posts',
			$project_slug
		);
	}
}
