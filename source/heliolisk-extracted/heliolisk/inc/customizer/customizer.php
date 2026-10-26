<?php
/**
 * Customizer: "Heliolisk Options" panel with Header, Footer and
 * Blog & Layout sections.
 *
 * Menu items live in Appearance → Menus; widgets in Appearance → Widgets.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds one setting and its control.
 *
 * $args are control arguments plus:
 *   - sanitize: sanitize callback (required).
 *   - type:     'color' and 'image' map to the core color / image controls;
 *               anything else is passed to the default control.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @param string               $id           Setting / control ID (theme_mod key).
 * @param array                $args         See above.
 */
function heliolisk_customize_add( $wp_customize, $id, $args ) {
	$defaults = heliolisk_get_option_defaults();

	$wp_customize->add_setting(
		$id,
		array(
			'default'           => isset( $defaults[ $id ] ) ? $defaults[ $id ] : '',
			'sanitize_callback' => $args['sanitize'],
			'transport'         => 'refresh',
		)
	);

	unset( $args['sanitize'] );

	if ( isset( $args['type'] ) && 'color' === $args['type'] ) {
		unset( $args['type'] );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, $args ) );
	} elseif ( isset( $args['type'] ) && 'image' === $args['type'] ) {
		unset( $args['type'] );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, $args ) );
	} else {
		$wp_customize->add_control( $id, $args );
	}
}

/**
 * Registers the panel and its sections.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function heliolisk_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'heliolisk_options',
		array(
			'title'    => __( 'Heliolisk Options', 'heliolisk' ),
			'priority' => 150,
		)
	);

	heliolisk_customize_general( $wp_customize );
	heliolisk_customize_header( $wp_customize );
	heliolisk_customize_footer( $wp_customize );
	heliolisk_customize_blog( $wp_customize );
}
add_action( 'customize_register', 'heliolisk_customize_register' );

/**
 * General section: color scheme.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function heliolisk_customize_general( $wp_customize ) {
	$wp_customize->add_section(
		'heliolisk_general',
		array(
			'title'    => __( 'Color Scheme', 'heliolisk' ),
			'panel'    => 'heliolisk_options',
			'priority' => 5,
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'color_scheme',
		array(
			'label'       => __( 'Color Scheme', 'heliolisk' ),
			'description' => __( 'Light is a clean white blog look. Dark is the portfolio look the Heliolisk Elementor widgets are designed for.', 'heliolisk' ),
			'section'     => 'heliolisk_general',
			'type'        => 'radio',
			'choices'     => array(
				'light' => __( 'Light', 'heliolisk' ),
				'dark'  => __( 'Dark', 'heliolisk' ),
			),
			'sanitize'    => 'heliolisk_sanitize_choice',
		)
	);
}

/**
 * Header section: template, logo, search, nav color and social links.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function heliolisk_customize_header( $wp_customize ) {
	$section = 'heliolisk_header';

	$wp_customize->add_section(
		$section,
		array(
			'title' => __( 'Header', 'heliolisk' ),
			'panel' => 'heliolisk_options',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'header_template_id',
		array(
			'label'       => __( 'Header Template', 'heliolisk' ),
			'description' => __( 'Pick a Header built with Elementor (Heliolisk → Header) to replace the theme header, or keep the default.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'select',
			'choices'     => heliolisk_get_builder_choices( 'hl_header' ),
			'sanitize'    => 'heliolisk_sanitize_choice',
		)
	);

	// ---- Logo ----

	heliolisk_customize_add(
		$wp_customize,
		'header_logo_image',
		array(
			'label'    => __( 'Logo Image', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'image',
			'sanitize' => 'esc_url_raw',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'header_logo_text',
		array(
			'label'    => __( 'Logo Text', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'header_logo_link',
		array(
			'label'       => __( 'Logo Link', 'heliolisk' ),
			'description' => __( 'e.g. "#home" to scroll to the top of the front page, or a full URL.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'text',
			'sanitize'    => 'heliolisk_sanitize_link',
		)
	);

	// ---- Search + navigation ----

	heliolisk_customize_add(
		$wp_customize,
		'header_search_enable',
		array(
			'label'    => __( 'Show Search Button', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'checkbox',
			'sanitize' => 'heliolisk_sanitize_checkbox',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'search_placeholder',
		array(
			'label'    => __( 'Search Placeholder', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'nav_link_color',
		array(
			'label'       => __( 'Nav Menu Text Color', 'heliolisk' ),
			'description' => __( 'Add, rename, reorder or remove menu items under Appearance → Menus, or pick the menu in Menu Locations.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'color',
			'sanitize'    => 'sanitize_hex_color',
		)
	);

	// ---- Social links ----

	$social_fields = array(
		'social_linkedin_url'  => __( 'LinkedIn URL', 'heliolisk' ),
		'social_github_url'    => __( 'GitHub URL', 'heliolisk' ),
		'social_email'         => __( 'Email Address', 'heliolisk' ),
		'social_twitter_url'   => __( 'Twitter / X URL', 'heliolisk' ),
		'social_facebook_url'  => __( 'Facebook URL', 'heliolisk' ),
		'social_instagram_url' => __( 'Instagram URL', 'heliolisk' ),
		'social_youtube_url'   => __( 'YouTube URL', 'heliolisk' ),
	);

	foreach ( $social_fields as $key => $label ) {
		$is_email = 'social_email' === $key;

		heliolisk_customize_add(
			$wp_customize,
			$key,
			array(
				'label'       => $label,
				'description' => __( 'Leave empty to hide this icon.', 'heliolisk' ),
				'section'     => $section,
				'type'        => $is_email ? 'email' : 'url',
				'sanitize'    => $is_email ? 'sanitize_email' : 'esc_url_raw',
			)
		);
	}

	heliolisk_customize_add(
		$wp_customize,
		'social_icon_color',
		array(
			'label'    => __( 'Social Icon Color', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'color',
			'sanitize' => 'sanitize_hex_color',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'social_icon_hover_color',
		array(
			'label'    => __( 'Social Icon Hover Color', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'color',
			'sanitize' => 'sanitize_hex_color',
		)
	);
}

/**
 * Footer section: template, text, colors and back-to-top.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function heliolisk_customize_footer( $wp_customize ) {
	$section = 'heliolisk_footer';

	$wp_customize->add_section(
		$section,
		array(
			'title' => __( 'Footer', 'heliolisk' ),
			'panel' => 'heliolisk_options',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'footer_template_id',
		array(
			'label'       => __( 'Footer Template', 'heliolisk' ),
			'description' => __( 'Pick a Footer built with Elementor (Heliolisk → Footer) to replace the default footer below, or keep the default.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'select',
			'choices'     => heliolisk_get_builder_choices( 'hl_footer' ),
			'sanitize'    => 'heliolisk_sanitize_choice',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'footer_copyright_text',
		array(
			'label'       => __( 'Copyright Text', 'heliolisk' ),
			'description' => __( 'Links, <strong> and <br> are allowed.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'text',
			'sanitize'    => 'heliolisk_sanitize_inline_html',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'footer_location_text',
		array(
			'label'    => __( 'Location Text', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
		)
	);

	$colors = array(
		'footer_text_color'   => __( 'Text Color', 'heliolisk' ),
		'footer_bg_color'     => __( 'Background Color', 'heliolisk' ),
		'footer_border_color' => __( 'Top Border Color', 'heliolisk' ),
	);

	foreach ( $colors as $key => $label ) {
		heliolisk_customize_add(
			$wp_customize,
			$key,
			array(
				'label'    => $label,
				'section'  => $section,
				'type'     => 'color',
				'sanitize' => 'sanitize_hex_color',
			)
		);
	}

	heliolisk_customize_add(
		$wp_customize,
		'back_to_top_enable',
		array(
			'label'    => __( 'Show "Back to Top" Button', 'heliolisk' ),
			'section'  => $section,
			'type'     => 'checkbox',
			'sanitize' => 'heliolisk_sanitize_checkbox',
		)
	);
}

/**
 * Blog & Layout section: sidebar layouts, banner, excerpts and single post
 * extras.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function heliolisk_customize_blog( $wp_customize ) {
	$section = 'heliolisk_blog';
	$layouts = heliolisk_sidebar_layout_choices();

	$wp_customize->add_section(
		$section,
		array(
			'title'       => __( 'Blog & Layout', 'heliolisk' ),
			'description' => __( 'Sidebars show the widgets placed in the Left Sidebar / Right Sidebar areas (Appearance → Widgets). A side with no widgets is hidden automatically. Each page and post can override its layout.', 'heliolisk' ),
			'panel'       => 'heliolisk_options',
		)
	);

	$layout_settings = array(
		'blog_layout'   => __( 'Blog, Archive & Search Layout', 'heliolisk' ),
		'single_layout' => __( 'Single Post Layout', 'heliolisk' ),
		'page_layout'   => __( 'Page Layout', 'heliolisk' ),
	);

	foreach ( $layout_settings as $key => $label ) {
		heliolisk_customize_add(
			$wp_customize,
			$key,
			array(
				'label'    => $label,
				'section'  => $section,
				'type'     => 'select',
				'choices'  => $layouts,
				'sanitize' => 'heliolisk_sanitize_choice',
			)
		);
	}

	heliolisk_customize_add(
		$wp_customize,
		'page_banner_enable',
		array(
			'label'       => __( 'Show Page Banner', 'heliolisk' ),
			'description' => __( 'The title + breadcrumb strip above blog, archive, search and regular pages. Never shown on Elementor pages.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'checkbox',
			'sanitize'    => 'heliolisk_sanitize_checkbox',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'blog_title',
		array(
			'label'       => __( 'Blog Title', 'heliolisk' ),
			'description' => __( 'Used when no "Posts page" is set under Settings → Reading.', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'text',
			'sanitize'    => 'sanitize_text_field',
		)
	);

	heliolisk_customize_add(
		$wp_customize,
		'excerpt_length',
		array(
			'label'       => __( 'Excerpt Length (words)', 'heliolisk' ),
			'section'     => $section,
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 5,
				'max'  => 80,
				'step' => 1,
			),
			'sanitize'    => 'absint',
		)
	);

	$single_toggles = array(
		'single_show_share'   => __( 'Single Post: Share Buttons', 'heliolisk' ),
		'single_show_author'  => __( 'Single Post: Author Box', 'heliolisk' ),
		'single_show_nav'     => __( 'Single Post: Previous / Next Links', 'heliolisk' ),
		'single_show_related' => __( 'Single Post: Related Posts', 'heliolisk' ),
	);

	foreach ( $single_toggles as $key => $label ) {
		heliolisk_customize_add(
			$wp_customize,
			$key,
			array(
				'label'    => $label,
				'section'  => $section,
				'type'     => 'checkbox',
				'sanitize' => 'heliolisk_sanitize_checkbox',
			)
		);
	}
}
