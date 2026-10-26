<?php
/**
 * Theme Options page, built with the Codestar Framework plugin.
 *
 * Appearance → Theme Options lists the same settings as the Customizer panel
 * so the site can be managed from one screen. Values live in a single
 * theme_mod (HELIOLISK_THEME_OPTIONS_KEY) and heliolisk_get_option() reads
 * them before the Customizer: what is saved here wins, an untouched field
 * keeps the Customizer value and the theme default.
 *
 * The panel needs the Codestar Framework plugin. Without it the Customizer
 * alone drives the theme and nothing changes.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Theme_mod key holding every Theme Options value (CSF stores one array). */
define( 'HELIOLISK_THEME_OPTIONS_KEY', 'heliolisk_theme_options' );

/**
 * The Theme Options value for one setting, or null when the panel has never
 * saved it. A cleared field counts as saved: '' means "theme default".
 *
 * @param string $key Option key.
 * @return mixed|null
 */
function heliolisk_theme_option( $key ) {
	$options = get_theme_mod( HELIOLISK_THEME_OPTIONS_KEY );

	if ( ! is_array( $options ) || ! array_key_exists( $key, $options ) ) {
		return null;
	}

	return $options[ $key ];
}

/**
 * Header / Footer template choices for the panel's selects.
 *
 * CSF resolves a callable string when the field renders (it passes the search
 * term and query args, both ignored here), which is late enough for the
 * hl_header / hl_footer post types to be registered — the panel itself is
 * registered on after_setup_theme, before init.
 *
 * @param mixed $term       Ignored search term.
 * @param array $query_args Ignored query arguments.
 * @return array<string, string>
 */
function heliolisk_theme_option_header_choices( $term = false, $query_args = array() ) {
	return heliolisk_get_builder_choices( 'hl_header' );
}

/**
 * @param mixed $term       Ignored search term.
 * @param array $query_args Ignored query arguments.
 * @return array<string, string>
 */
function heliolisk_theme_option_footer_choices( $term = false, $query_args = array() ) {
	return heliolisk_get_builder_choices( 'hl_footer' );
}

/**
 * The current value of every theme option: the Customizer value where one was
 * set, the registered default otherwise.
 *
 * Used as CSF's "defaults" so the panel opens showing what the site actually
 * does, and saving it commits what is on screen instead of wiping a
 * Customizer choice.
 *
 * @return array<string, mixed>
 */
function heliolisk_theme_option_seed() {
	$defaults = heliolisk_get_option_defaults();
	$mods     = get_theme_mods();
	$seed     = array();

	foreach ( $defaults as $key => $value ) {
		$seed[ $key ] = ( is_array( $mods ) && array_key_exists( $key, $mods ) ) ? $mods[ $key ] : $value;
	}

	return $seed;
}

/**
 * Registers the panel and its sections with the Codestar Framework.
 *
 * Hooked before CSF's own setup on the same hook, admin requests only — the
 * front end never needs the panel, it only reads the theme_mod.
 */
function heliolisk_register_theme_options() {
	if ( ! is_admin() || ! class_exists( 'CSF' ) ) {
		return;
	}

	$prefix = HELIOLISK_THEME_OPTIONS_KEY;

	CSF::createOptions(
		$prefix,
		array(
			'framework_title'    => __( 'Heliolisk Theme Options', 'heliolisk' ),
			'menu_title'         => __( 'Theme Options', 'heliolisk' ),
			'menu_slug'          => 'heliolisk-theme-options',
			'menu_type'          => 'submenu',
			'menu_parent'        => 'themes.php',
			'menu_icon'          => 'dashicons-admin-customizer',
			'menu_capability'    => 'edit_theme_options',
			'database'           => 'theme_mod',
			'defaults'           => heliolisk_theme_option_seed(),
			'show_reset_all'     => true,
			'show_reset_section' => true,
		)
	);

	heliolisk_theme_options_general();
	heliolisk_theme_options_header();
	heliolisk_theme_options_footer();
	heliolisk_theme_options_blog();
}
add_action( 'after_setup_theme', 'heliolisk_register_theme_options', 1 );

/**
 * General section: color scheme.
 */
function heliolisk_theme_options_general() {
	CSF::createSection(
		HELIOLISK_THEME_OPTIONS_KEY,
		array(
			'title'       => __( 'General', 'heliolisk' ),
			'icon'        => 'fas fa-sliders-h',
			'description' => __( 'Settings saved on this screen take precedence over the Customizer. The Customizer keeps driving anything left untouched here.', 'heliolisk' ),
			'fields'      => array(
				array(
					'id'       => 'color_scheme',
					'type'     => 'radio',
					'title'    => __( 'Color Scheme', 'heliolisk' ),
					'desc'     => __( 'Light is a clean white blog look. Dark is the portfolio look the Heliolisk Elementor widgets are designed for.', 'heliolisk' ),
					'options'  => array(
						'light' => __( 'Light', 'heliolisk' ),
						'dark'  => __( 'Dark', 'heliolisk' ),
					),
					'default'  => 'light',
					'sanitize' => 'sanitize_key',
				),
			),
		)
	);
}

/**
 * Header section: template, logo, search, nav color and social links.
 */
function heliolisk_theme_options_header() {
	$fields = array(
		array(
			'id'       => 'header_template_id',
			'type'     => 'select',
			'title'    => __( 'Header Template', 'heliolisk' ),
			'desc'     => __( 'Pick a Header built with Elementor (Heliolisk → Header) to replace the theme header, or keep the default.', 'heliolisk' ),
			'options'  => 'heliolisk_theme_option_header_choices',
			'default'  => '0',
			'sanitize' => 'sanitize_key',
		),
		array(
			'id'       => 'header_logo_image',
			'type'     => 'upload',
			'title'    => __( 'Logo Image', 'heliolisk' ),
			'sanitize' => 'esc_url_raw',
		),
		array(
			'id'       => 'header_logo_text',
			'type'     => 'text',
			'title'    => __( 'Logo Text', 'heliolisk' ),
			'desc'     => __( 'Leave empty to use the site title (Settings → General).', 'heliolisk' ),
			'sanitize' => 'sanitize_text_field',
		),
		array(
			'id'       => 'header_logo_link',
			'type'     => 'text',
			'title'    => __( 'Logo Link', 'heliolisk' ),
			'desc'     => __( 'e.g. "#home" to scroll to the top of the front page, or a full URL.', 'heliolisk' ),
			'sanitize' => 'heliolisk_sanitize_link',
		),
		array(
			'id'       => 'header_search_enable',
			'type'     => 'switcher',
			'title'    => __( 'Show Search Button', 'heliolisk' ),
			'sanitize' => 'heliolisk_sanitize_checkbox',
		),
		array(
			'id'       => 'search_placeholder',
			'type'     => 'text',
			'title'    => __( 'Search Placeholder', 'heliolisk' ),
			'sanitize' => 'sanitize_text_field',
		),
		array(
			'id'       => 'nav_link_color',
			'type'     => 'color',
			'title'    => __( 'Nav Menu Text Color', 'heliolisk' ),
			'desc'     => __( 'Leave empty to use the color scheme\'s color.', 'heliolisk' ),
			'sanitize' => 'sanitize_hex_color',
		),
		array(
			'type'  => 'subheading',
			'title' => __( 'Social Links', 'heliolisk' ),
		),
	);

	$social_fields = array(
		'social_linkedin_url'  => __( 'LinkedIn URL', 'heliolisk' ),
		'social_github_url'    => __( 'GitHub URL', 'heliolisk' ),
		'social_twitter_url'   => __( 'Twitter / X URL', 'heliolisk' ),
		'social_facebook_url'  => __( 'Facebook URL', 'heliolisk' ),
		'social_instagram_url' => __( 'Instagram URL', 'heliolisk' ),
		'social_youtube_url'   => __( 'YouTube URL', 'heliolisk' ),
	);

	foreach ( $social_fields as $key => $label ) {
		$fields[] = array(
			'id'       => $key,
			'type'     => 'text',
			'title'    => $label,
			'desc'     => __( 'Leave empty to hide this icon.', 'heliolisk' ),
			'sanitize' => 'esc_url_raw',
		);
	}

	$fields[] = array(
		'id'       => 'social_email',
		'type'     => 'text',
		'title'    => __( 'Email Address', 'heliolisk' ),
		'desc'     => __( 'Leave empty to hide this icon.', 'heliolisk' ),
		'sanitize' => 'sanitize_email',
	);

	$fields[] = array(
		'id'       => 'social_icon_color',
		'type'     => 'color',
		'title'    => __( 'Social Icon Color', 'heliolisk' ),
		'sanitize' => 'sanitize_hex_color',
	);

	$fields[] = array(
		'id'       => 'social_icon_hover_color',
		'type'     => 'color',
		'title'    => __( 'Social Icon Hover Color', 'heliolisk' ),
		'sanitize' => 'sanitize_hex_color',
	);

	CSF::createSection(
		HELIOLISK_THEME_OPTIONS_KEY,
		array(
			'title'  => __( 'Header', 'heliolisk' ),
			'icon'   => 'fas fa-window-maximize',
			'fields' => $fields,
		)
	);
}

/**
 * Footer section: template, text, colors and back-to-top.
 */
function heliolisk_theme_options_footer() {
	CSF::createSection(
		HELIOLISK_THEME_OPTIONS_KEY,
		array(
			'title'  => __( 'Footer', 'heliolisk' ),
			'icon'   => 'fas fa-shoe-prints',
			'fields' => array(
				array(
					'id'       => 'footer_template_id',
					'type'     => 'select',
					'title'    => __( 'Footer Template', 'heliolisk' ),
					'desc'     => __( 'Pick a Footer built with Elementor (Heliolisk → Footer) to replace the default footer below, or keep the default.', 'heliolisk' ),
					'options'  => 'heliolisk_theme_option_footer_choices',
					'default'  => '0',
					'sanitize' => 'sanitize_key',
				),
				array(
					'id'       => 'footer_copyright_text',
					'type'     => 'text',
					'title'    => __( 'Copyright Text', 'heliolisk' ),
					'desc'     => __( 'Links, <strong> and <br> are allowed.', 'heliolisk' ),
					'sanitize' => 'heliolisk_sanitize_inline_html',
				),
				array(
					'id'       => 'footer_location_text',
					'type'     => 'text',
					'title'    => __( 'Location Text', 'heliolisk' ),
					'sanitize' => 'sanitize_text_field',
				),
				array(
					'id'       => 'footer_text_color',
					'type'     => 'color',
					'title'    => __( 'Footer Text Color', 'heliolisk' ),
					'sanitize' => 'sanitize_hex_color',
				),
				array(
					'id'       => 'footer_bg_color',
					'type'     => 'color',
					'title'    => __( 'Footer Background Color', 'heliolisk' ),
					'sanitize' => 'sanitize_hex_color',
				),
				array(
					'id'       => 'footer_border_color',
					'type'     => 'color',
					'title'    => __( 'Footer Top Border Color', 'heliolisk' ),
					'sanitize' => 'sanitize_hex_color',
				),
				array(
					'id'       => 'back_to_top_enable',
					'type'     => 'switcher',
					'title'    => __( 'Show "Back to Top" Button', 'heliolisk' ),
					'sanitize' => 'heliolisk_sanitize_checkbox',
				),
			),
		)
	);
}

/**
 * Blog & Layout section: sidebar layouts, banner, excerpts and single post
 * extras.
 */
function heliolisk_theme_options_blog() {
	$defaults = heliolisk_get_option_defaults();

	$fields = array();

	$layout_labels = array(
		'blog_layout'   => __( 'Blog, Archive & Search Layout', 'heliolisk' ),
		'single_layout' => __( 'Single Post Layout', 'heliolisk' ),
		'page_layout'   => __( 'Page Layout', 'heliolisk' ),
	);

	foreach ( $layout_labels as $key => $label ) {
		$fields[] = array(
			'id'       => $key,
			'type'     => 'select',
			'title'    => $label,
			'options'  => heliolisk_sidebar_layout_choices(),
			'default'  => $defaults[ $key ],
			'sanitize' => 'sanitize_key',
		);
	}

	$fields[] = array(
		'id'       => 'page_banner_enable',
		'type'     => 'switcher',
		'title'    => __( 'Show Page Banner', 'heliolisk' ),
		'desc'     => __( 'The title + breadcrumb strip above blog, archive, search and regular pages. Never shown on Elementor pages.', 'heliolisk' ),
		'sanitize' => 'heliolisk_sanitize_checkbox',
	);

	$fields[] = array(
		'id'       => 'blog_title',
		'type'     => 'text',
		'title'    => __( 'Blog Title', 'heliolisk' ),
		'desc'     => __( 'Used when no "Posts page" is set under Settings → Reading.', 'heliolisk' ),
		'sanitize' => 'sanitize_text_field',
	);

	$fields[] = array(
		'id'       => 'excerpt_length',
		'type'     => 'number',
		'title'    => __( 'Excerpt Length (words)', 'heliolisk' ),
		'min'      => 5,
		'max'      => 80,
		'step'     => 1,
		'sanitize' => 'absint',
	);

	$single_fields = array(
		'single_show_share'   => __( 'Single Post: Share Buttons', 'heliolisk' ),
		'single_show_author'  => __( 'Single Post: Author Box', 'heliolisk' ),
		'single_show_nav'     => __( 'Single Post: Previous / Next Links', 'heliolisk' ),
		'single_show_related' => __( 'Single Post: Related Posts', 'heliolisk' ),
	);

	foreach ( $single_fields as $key => $label ) {
		$fields[] = array(
			'id'       => $key,
			'type'     => 'switcher',
			'title'    => $label,
			'sanitize' => 'heliolisk_sanitize_checkbox',
		);
	}

	CSF::createSection(
		HELIOLISK_THEME_OPTIONS_KEY,
		array(
			'title'       => __( 'Blog & Layout', 'heliolisk' ),
			'icon'        => 'fas fa-newspaper',
			'description' => __( 'Sidebars show the widgets placed in the Left Sidebar / Right Sidebar areas (Appearance → Widgets). A side with no widgets is hidden automatically. Each page and post can override its layout.', 'heliolisk' ),
			'fields'      => $fields,
		)
	);
}
