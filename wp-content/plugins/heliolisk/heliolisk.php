<?php
/**
 * Plugin Name:       Heliolisk
 * Plugin URI:        https://personal-portfolio.test
 * Description:       Custom plugin for the Personal Portfolio WordPress project.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Diganta
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELIOLISK_VERSION', '1.0.0' );
define( 'HELIOLISK_PLUGIN_FILE', __FILE__ );
define( 'HELIOLISK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HELIOLISK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once HELIOLISK_PLUGIN_DIR . 'includes/class-heliolisk-icon.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/class-heliolisk-admin-menu.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/post-types/class-header-cpt.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/post-types/class-footer-cpt.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/post-types/class-project-cpt.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/taxonomies/class-project-category-taxonomy.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/elementor/class-heliolisk-elementor.php';
require_once HELIOLISK_PLUGIN_DIR . 'includes/class-heliolisk.php';

/**
 * Runs on plugin activation.
 */
function heliolisk_activate() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'heliolisk_activate' );

/**
 * Runs on plugin deactivation.
 */
function heliolisk_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'heliolisk_deactivate' );

/**
 * Boots the plugin.
 */
function heliolisk_run() {
	return Heliolisk::instance();
}
heliolisk_run();
