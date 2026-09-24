<?php
/**
 * Core plugin class.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Heliolisk {

	/**
	 * Singleton instance.
	 *
	 * @var Heliolisk|null
	 */
	private static $instance = null;

	/**
	 * Returns the singleton instance, creating it on first call.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Wires up plugin hooks.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'init' ) );

		new Heliolisk_Header_CPT();
		new Heliolisk_Footer_CPT();
		new Heliolisk_Project_CPT();
		new Heliolisk_Project_Category_Taxonomy();
		new Heliolisk_Admin_Menu();
		new Heliolisk_Elementor();
	}

	/**
	 * Fires on WordPress init.
	 */
	public function init() {
		load_plugin_textdomain( 'heliolisk', false, dirname( plugin_basename( HELIOLISK_PLUGIN_FILE ) ) . '/languages' );
	}
}
