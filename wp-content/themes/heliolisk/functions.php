<?php
/**
 * Heliolisk theme bootstrap.
 *
 * This file only defines the theme constants and loads inc/, where each file
 * owns a single concern (setup, assets, layout, customizer, …). Markup lives in
 * the root templates and in template-parts/.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELIOLISK_THEME_VERSION', '1.2.0' );
define( 'HELIOLISK_THEME_DIR', get_template_directory() );
define( 'HELIOLISK_THEME_URI', get_template_directory_uri() );
define( 'HELIOLISK_THEME_INC', HELIOLISK_THEME_DIR . '/inc/' );

$heliolisk_includes = array(
	'helpers.php',              // Option reader, asset versioning, kses rules.
	'theme-options.php',        // Appearance → Theme Options (Codestar Framework).
	'icons.php',                // Inline SVG icon set.
	'setup.php',                // Theme supports, menus, image sizes.
	'enqueue.php',              // Front-end styles and scripts.
	'widgets.php',              // Left / Right sidebar widget areas.
	'menus.php',                // Primary menu fallback + one-page anchor links.
	'layout.php',               // Sidebar layout resolution (left / right / both / none).
	'builder.php',              // Elementor-built header / footer templates.
	'breadcrumb.php',           // Page banner title + breadcrumb trail.
	'template-tags.php',        // Small output helpers used inside templates.
	'template-hooks.php',       // Filters that adjust core output.
	'comments.php',             // Comment list callback + comment form fields.
	'metaboxes.php',            // Per page / post settings (Pure Metafields).
	'cmb2-metaboxes.php',       // Per page footer choice (CMB2).
	'plugins.php',              // Required / recommended plugins (TGM Plugin Activation).
	'demo-import.php',          // One Click Demo Import: demo files, images, post-import setup.
	'customizer/defaults.php', // Default value of every theme option.
	'customizer/sanitize.php',  // Customizer sanitize callbacks.
	'customizer/customizer.php',// Customizer panel, sections and controls.
	'customizer/inline-css.php',// Customizer colors printed as inline CSS.
);

foreach ( $heliolisk_includes as $heliolisk_file ) {
	require_once HELIOLISK_THEME_INC . $heliolisk_file;
}

unset( $heliolisk_includes, $heliolisk_file );
