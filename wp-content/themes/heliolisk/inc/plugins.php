<?php
/**
 * Required / recommended plugins, installed through TGM Plugin Activation
 * (inc/class-tgm-plugin-activation.php, v2.6.1).
 *
 * Shows an admin notice and an "Appearance → Install Plugins" screen listing
 * the plugins below. The Heliolisk companion plugin and the Codestar Framework
 * are not on wordpress.org, so their zip files ship in this theme's plugins/
 * folder and are installed from there by TGMPA. Rebuild plugins/heliolisk.zip
 * (tools/build-themeforest.py) and bump HELIOLISK_BUNDLED_PLUGIN_VERSION
 * whenever the plugin changes, so sites running an older copy are offered the
 * update.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once HELIOLISK_THEME_INC . 'class-tgm-plugin-activation.php';

// Version of the Heliolisk plugin inside plugins/heliolisk.zip.
define( 'HELIOLISK_BUNDLED_PLUGIN_VERSION', '1.2.0' );

// Bundled plugin archives, installed by TGMPA.
define( 'HELIOLISK_BUNDLED_PLUGIN_ZIP', HELIOLISK_THEME_DIR . '/plugins/heliolisk.zip' );

// The Codestar archive keeps its "codestar-framework-master" folder name so
// the TGMPA slug matches the folder that is installed.
define( 'HELIOLISK_CODESTAR_ZIP', HELIOLISK_THEME_DIR . '/plugins/codestar-framework.zip' );

/**
 * Registers the plugin list with TGMPA.
 */
function heliolisk_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => __( 'Heliolisk (Elementor widgets, Projects, Header & Footer builder)', 'heliolisk' ),
			'slug'     => 'heliolisk',
			'source'   => HELIOLISK_BUNDLED_PLUGIN_ZIP,
			'version'  => HELIOLISK_BUNDLED_PLUGIN_VERSION,
			'required' => true,
		),
		array(
			'name'     => __( 'Elementor Website Builder', 'heliolisk' ),
			'slug'     => 'elementor',
			'required' => true,
		),
		array(
			'name'     => __( 'Codestar Framework (Theme Options panel)', 'heliolisk' ),
			'slug'     => 'codestar-framework-master',
			'source'   => HELIOLISK_CODESTAR_ZIP,
			'required' => true,
		),
		array(
			'name'     => __( 'One Click Demo Import', 'heliolisk' ),
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),
		array(
			'name'     => __( 'CMB2 (per-page footer setting)', 'heliolisk' ),
			'slug'     => 'cmb2',
			'required' => false,
		),
		array(
			'name'     => __( 'Classic Editor', 'heliolisk' ),
			'slug'     => 'classic-editor',
			'required' => false,
		),
		array(
			'name'     => __( 'Classic Widgets', 'heliolisk' ),
			'slug'     => 'classic-widgets',
			'required' => false,
		)
	);

	$config = array(
		'id'           => 'heliolisk',             // Unique ID, so dismissed notices don't clash with other TGMPA themes/plugins.
		'default_path' => '',
		'menu'         => 'heliolisk-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'heliolisk' ),
			'menu_title'                      => __( 'Install Plugins', 'heliolisk' ),
			/* translators: %s: plugin name. */
			'installing'                      => __( 'Installing Plugin: %s', 'heliolisk' ),
			/* translators: %s: plugin name. */
			'updating'                        => __( 'Updating Plugin: %s', 'heliolisk' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'heliolisk' ),
			/* translators: 1: plugin name(s). */
			'notice_can_install_required'     => _n_noop( 'Heliolisk requires the following plugin: %1$s.', 'Heliolisk requires the following plugins: %1$s.', 'heliolisk' ),
			/* translators: 1: plugin name(s). */
			'notice_can_install_recommended'  => _n_noop( 'Heliolisk recommends the following plugin: %1$s.', 'Heliolisk recommends the following plugins: %1$s.', 'heliolisk' ),
			/* translators: 1: plugin name(s). */
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'heliolisk' ),
			/* translators: 1: plugin name(s). */
			'notice_ask_to_update_maybe'      => _n_noop( 'There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'heliolisk' ),
			/* translators: 1: plugin name(s). */
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'heliolisk' ),
			/* translators: 1: plugin name(s). */
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'heliolisk' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'heliolisk' ),
			'update_link'                     => _n_noop( 'Begin updating plugin', 'Begin updating plugins', 'heliolisk' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'heliolisk' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'heliolisk' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'heliolisk' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'heliolisk' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'heliolisk' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'heliolisk' ),
			/* translators: 1: dashboard link. */
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'heliolisk' ),
			'dismiss'                         => __( 'Dismiss this notice', 'heliolisk' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'heliolisk' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'heliolisk' ),
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'heliolisk_register_required_plugins' );
