<?php
/**
 * Theme setup: supported WordPress features, menus and image sizes.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers theme supports, menu locations and image sizes.
 */
function heliolisk_setup() {
	load_theme_textdomain( 'heliolisk', HELIOLISK_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'post-formats', array( 'quote' ) );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// Logo uploaded in Appearance → Customize → Site Identity; the header uses
	// it when set and falls back to the theme's own logo option.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Optional banner image above the site header (Appearance → Customize →
	// Header Image). Rendered by template-parts/header/site-header.php.
	add_theme_support(
		'custom-header',
		array(
			'default-image' => '',
			'width'          => 1920,
			'height'         => 420,
			'flex-width'     => true,
			'flex-height'    => true,
		)
	);

	// Solid colour / image behind the page (Appearance → Customize → Background).
	add_theme_support( 'custom-background' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'heliolisk' ),
		)
	);

	// Blog cards and the small thumbnails used by related posts.
	add_image_size( 'heliolisk-card', 960, 600, true );
	add_image_size( 'heliolisk-thumb', 320, 220, true );
}
add_action( 'after_setup_theme', 'heliolisk_setup' );

/**
 * Sets the content width embeds and full-size images are scaled to.
 *
 * Priority 0 so it is available to every later after_setup_theme callback.
 */
function heliolisk_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'heliolisk_content_width', 820 ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- core global.
}
add_action( 'after_setup_theme', 'heliolisk_content_width', 0 );

/**
 * Makes the block editor follow the Customizer's color scheme.
 *
 * editor-style.css is the light scheme; the dark one is added on top.
 *
 * @param array $settings Block editor settings.
 * @return array
 */
function heliolisk_editor_dark_scheme( $settings ) {
	if ( 'dark' === heliolisk_get_color_scheme() ) {
		$settings['styles'][] = array(
			'css' => '.editor-styles-wrapper{--hl-bg:#080808;--hl-text:#f4f5fb;--hl-text-mut:#8a8a8a;--hl-border:#2a2a2a;}',
		);
	}

	return $settings;
}
add_filter( 'block_editor_settings_all', 'heliolisk_editor_dark_scheme' );

/**
 * Registers the theme's block style and block patterns for the block editor.
 */
function heliolisk_register_block_assets() {
	register_block_style(
		'core/quote',
		array(
			'name'  => 'heliolisk-accent',
			'label' => __( 'Accent border', 'heliolisk' ),
		)
	);

	register_block_pattern_category(
		'heliolisk',
		array(
			'label' => __( 'Heliolisk', 'heliolisk' ),
		)
	);

	register_block_pattern(
		'heliolisk/section-heading',
		array(
			'title'       => __( 'Section heading', 'heliolisk' ),
			'description' => __( 'Heading and intro paragraph for a new section.', 'heliolisk' ),
			'categories'  => array( 'heliolisk' ),
			'content'     => <<<BLOCKS
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Section title</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Add a short introduction for this section.</p>
<!-- /wp:paragraph -->
BLOCKS,
		)
	);
}
add_action( 'init', 'heliolisk_register_block_assets' );
