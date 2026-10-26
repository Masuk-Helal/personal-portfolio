<?php
/**
 * Default value of every theme option.
 *
 * The single source of truth for defaults: both the Customizer registration
 * and heliolisk_get_option() read from here. Option keys from the theme's
 * first version are unchanged, so saved settings carry over.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header defaults.
 *
 * Neutral on purpose: a fresh install shows the site title as the logo and
 * no social icons until they are filled in.
 *
 * @return array<string, mixed>
 */
function heliolisk_header_defaults() {
	return array(
		'header_template_id'      => '0',
		'header_logo_image'       => '',
		'header_logo_text'        => '', // Empty = the site title (Settings → General).
		'header_logo_link'        => '', // Empty = the home page.
		'header_search_enable'    => true,
		// Colors: empty = the color scheme's own color (see inc/customizer/inline-css.php).
		'nav_link_color'          => '',
		'social_linkedin_url'     => '',
		'social_github_url'       => '',
		'social_email'            => '',
		'social_twitter_url'      => '',
		'social_facebook_url'     => '',
		'social_instagram_url'    => '',
		'social_youtube_url'      => '',
		'social_icon_color'       => '',
		'social_icon_hover_color' => '',
	);
}

/**
 * Footer defaults.
 *
 * @return array<string, mixed>
 */
function heliolisk_footer_defaults() {
	return array(
		'footer_template_id'    => '0',
		/* translators: 1: current year, 2: site title. */
		'footer_copyright_text' => sprintf( __( '© %1$s %2$s. All rights reserved.', 'heliolisk' ), wp_date( 'Y' ), get_bloginfo( 'name' ) ),
		'footer_location_text'  => '',
		'footer_text_color'     => '',
		'footer_bg_color'       => '',
		'footer_border_color'   => '',
		'back_to_top_enable'    => true,
	);
}

/**
 * Blog & layout defaults.
 *
 * @return array<string, mixed>
 */
function heliolisk_blog_defaults() {
	return array(
		'blog_layout'          => 'right',
		'single_layout'        => 'right',
		'page_layout'          => 'none',
		'page_banner_enable'   => true,
		'blog_title'           => __( 'Blog', 'heliolisk' ),
		'excerpt_length'       => 26,
		'single_show_share'    => true,
		'single_show_author'   => true,
		'single_show_nav'      => true,
		'single_show_related'  => true,
		'search_placeholder'   => __( 'Search…', 'heliolisk' ),
	);
}

/**
 * General defaults.
 *
 * @return array<string, mixed>
 */
function heliolisk_general_defaults() {
	return array(
		// 'light': clean white blog look (fresh installs). 'dark': the portfolio look.
		'color_scheme' => 'light',
	);
}

/**
 * Every default, merged.
 *
 * @return array<string, mixed>
 */
function heliolisk_get_option_defaults() {
	return array_merge( heliolisk_general_defaults(), heliolisk_header_defaults(), heliolisk_footer_defaults(), heliolisk_blog_defaults() );
}
