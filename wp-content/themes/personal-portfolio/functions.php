<?php
/**
 * Personal Portfolio theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'PERSONAL_PORTFOLIO_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function personal_portfolio_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'personal-portfolio' ),
		)
	);
}
add_action( 'after_setup_theme', 'personal_portfolio_setup' );

/**
 * Prints the original hardcoded section links.
 *
 * Used as wp_nav_menu()'s fallback so the header still renders (and the
 * desktop nav does not collapse) until a menu is assigned to the
 * "Primary Menu" location under Appearance → Menus.
 */
function personal_portfolio_primary_menu_fallback() {
	$home_url = home_url( '/' );

	$sections = array(
		'home'          => __( 'Home', 'personal-portfolio' ),
		'about'         => __( 'About', 'personal-portfolio' ),
		'analytics'     => __( 'Analytics', 'personal-portfolio' ),
		'work'          => __( 'Work', 'personal-portfolio' ),
		'experience'    => __( 'Experience', 'personal-portfolio' ),
		'skills'        => __( 'Skills', 'personal-portfolio' ),
		'collaborators' => __( 'Collaborators', 'personal-portfolio' ),
		'contact'       => __( 'Contact', 'personal-portfolio' ),
	);

	echo '<ul id="menu-primary" class="nav-links-list">';

	foreach ( $sections as $anchor => $label ) {
		$href = is_front_page() ? '#' . $anchor : $home_url . '#' . $anchor;

		printf(
			'<li class="menu-item"><a class="nav-anchor" href="%1$s">%2$s</a></li>',
			esc_url( $href ),
			esc_html( $label )
		);
	}

	echo '</ul>';
}

/**
 * Keeps the theme's anchor-based menu items working from every template.
 *
 * A menu item added as a Custom Link with just "#work" would resolve to the
 * current URL, so on inner pages the browser would look for a "#work" anchor
 * that does not exist there. Those links are rewritten to the front page so
 * they always land on the right section, and are tagged with .nav-anchor for
 * the scroll-spy in assets/js/script.js.
 */
function personal_portfolio_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( empty( $atts['href'] ) || '#' !== substr( $atts['href'], 0, 1 ) ) {
		return $atts;
	}

	if ( isset( $args->theme_location ) && 'primary' !== $args->theme_location ) {
		return $atts;
	}

	$atts['href'] = is_front_page() ? $atts['href'] : home_url( '/' . $atts['href'] );

	$atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' nav-anchor' : 'nav-anchor';

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'personal_portfolio_nav_menu_link_attributes', 10, 4 );

/**
 * Enqueues theme styles and scripts.
 */
function personal_portfolio_scripts() {
	$theme_uri = get_template_directory_uri();
	$theme_dir = get_template_directory();

	// Version own assets by modification time so browsers pick up edits
	// instead of serving a stale cached copy.
	$style_ver  = filemtime( $theme_dir . '/assets/css/style.css' );
	$script_ver = filemtime( $theme_dir . '/assets/js/script.js' );

	wp_enqueue_style( 'personal-portfolio-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=Barlow+Condensed:wght@500;600&display=swap', array(), null );
	wp_enqueue_style( 'personal-portfolio-bootstrap', $theme_uri . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), PERSONAL_PORTFOLIO_VERSION );
	wp_enqueue_style( 'personal-portfolio-style', $theme_uri . '/assets/css/style.css', array( 'personal-portfolio-bootstrap' ), $style_ver );
	wp_enqueue_style( 'personal-portfolio-theme', get_stylesheet_uri(), array(), PERSONAL_PORTFOLIO_VERSION );

	wp_enqueue_script( 'personal-portfolio-bootstrap', $theme_uri . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array(), PERSONAL_PORTFOLIO_VERSION, true );
	wp_enqueue_script( 'personal-portfolio-gsap', $theme_uri . '/assets/vendor/gsap/gsap.min.js', array(), PERSONAL_PORTFOLIO_VERSION, true );
	wp_enqueue_script( 'personal-portfolio-scrolltrigger', $theme_uri . '/assets/vendor/gsap/ScrollTrigger.min.js', array( 'personal-portfolio-gsap' ), PERSONAL_PORTFOLIO_VERSION, true );
	wp_enqueue_script( 'personal-portfolio-main', $theme_uri . '/assets/js/script.js', array( 'personal-portfolio-bootstrap', 'personal-portfolio-scrolltrigger' ), $script_ver, true );
}
add_action( 'wp_enqueue_scripts', 'personal_portfolio_scripts' );

/**
 * Header defaults, shared between the Customizer registration and the
 * fallback values used wherever a header theme_mod is read.
 */
function personal_portfolio_header_defaults() {
	return array(
		'header_logo_image'        => get_template_directory_uri() . '/assets/images/image1.png',
		'header_logo_text'         => 'REFAT AREFIN',
		'header_logo_link'         => '#home',
		'nav_link_color'           => '#8A8A8A',
		'social_linkedin_url'      => 'https://www.linkedin.com/in/shantoszz',
		'social_github_url'        => 'https://github.com/Shantoszz',
		'social_email'             => 'refatshanto94@gmail.com',
		'social_twitter_url'       => '',
		'social_facebook_url'      => '',
		'social_instagram_url'     => '',
		'social_youtube_url'       => '',
		'social_icon_color'        => '#8A8A8A',
		'social_icon_hover_color'  => '#a78bfa',
	);
}

/**
 * Footer defaults, shared between the Customizer registration and the
 * fallback values used wherever a footer theme_mod is read.
 */
function personal_portfolio_footer_defaults() {
	return array(
		'footer_copyright_text' => '© 2026 S.M. Refat Arefin. All rights reserved.',
		'footer_location_text'  => 'Dhaka, Bangladesh',
		'footer_text_color'     => '#8A8A8A',
		'footer_bg_color'       => '#080808',
		'footer_border_color'   => '#242438',
	);
}

/**
 * Registers "Header" and "Footer" sections in the Customizer.
 *
 * Header: logo image/text/link and the right-side social links are fully
 * editable. The nav menu's items live in Appearance → Menus (or Customize →
 * Menu Locations) under the "primary" location; only its colors are exposed
 * here — see header.php for how it is rendered.
 *
 * Footer: the copyright/location text and the footer's colors can be
 * edited without touching code.
 */
function personal_portfolio_customize_register( $wp_customize ) {
	$header_defaults = personal_portfolio_header_defaults();

	$wp_customize->add_section(
		'personal_portfolio_header',
		array(
			'title'    => __( 'Header', 'personal-portfolio' ),
			'priority' => 155,
		)
	);

	// ---- Logo ----

	$wp_customize->add_setting(
		'header_logo_image',
		array(
			'default'           => $header_defaults['header_logo_image'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'header_logo_image',
			array(
				'label'   => __( 'Logo Image', 'personal-portfolio' ),
				'section' => 'personal_portfolio_header',
			)
		)
	);

	$wp_customize->add_setting(
		'header_logo_text',
		array(
			'default'           => $header_defaults['header_logo_text'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'header_logo_text',
		array(
			'label'   => __( 'Logo Text', 'personal-portfolio' ),
			'section' => 'personal_portfolio_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'header_logo_link',
		array(
			'default'           => $header_defaults['header_logo_link'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'header_logo_link',
		array(
			'label'       => __( 'Logo Link', 'personal-portfolio' ),
			'description' => __( 'e.g. "#home" to scroll to the top of this page, or a full URL.', 'personal-portfolio' ),
			'section'     => 'personal_portfolio_header',
			'type'        => 'text',
		)
	);

	// ---- Navigation (items: Appearance → Menus / Menu Locations; style here) ----

	$wp_customize->add_setting(
		'nav_link_color',
		array(
			'default'           => $header_defaults['nav_link_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'nav_link_color',
			array(
				'label'       => __( 'Nav Menu Text Color', 'personal-portfolio' ),
				'description' => __( 'Add, rename, reorder or remove menu items in the Main Menu under Appearance → Menus, or pick the menu in Menu Locations below.', 'personal-portfolio' ),
				'section'     => 'personal_portfolio_header',
			)
		)
	);

	// ---- Social Links (right side) ----

	$social_fields = array(
		'social_linkedin_url'  => __( 'LinkedIn URL', 'personal-portfolio' ),
		'social_github_url'    => __( 'GitHub URL', 'personal-portfolio' ),
		'social_email'         => __( 'Email Address', 'personal-portfolio' ),
		'social_twitter_url'   => __( 'Twitter / X URL', 'personal-portfolio' ),
		'social_facebook_url'  => __( 'Facebook URL', 'personal-portfolio' ),
		'social_instagram_url' => __( 'Instagram URL', 'personal-portfolio' ),
		'social_youtube_url'   => __( 'YouTube URL', 'personal-portfolio' ),
	);

	foreach ( $social_fields as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $header_defaults[ $key ],
				'sanitize_callback' => 'social_email' === $key ? 'sanitize_email' : 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'       => $label,
				'description' => 'social_email' === $key ? '' : __( 'Leave empty to hide this icon.', 'personal-portfolio' ),
				'section'     => 'personal_portfolio_header',
				'type'        => 'social_email' === $key ? 'email' : 'url',
			)
		);
	}

	$wp_customize->add_setting(
		'social_icon_color',
		array(
			'default'           => $header_defaults['social_icon_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'social_icon_color',
			array(
				'label'   => __( 'Social Icon Color', 'personal-portfolio' ),
				'section' => 'personal_portfolio_header',
			)
		)
	);

	$wp_customize->add_setting(
		'social_icon_hover_color',
		array(
			'default'           => $header_defaults['social_icon_hover_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'social_icon_hover_color',
			array(
				'label'   => __( 'Social Icon Hover Color', 'personal-portfolio' ),
				'section' => 'personal_portfolio_header',
			)
		)
	);

	$defaults = personal_portfolio_footer_defaults();

	$wp_customize->add_section(
		'personal_portfolio_footer',
		array(
			'title'    => __( 'Footer', 'personal-portfolio' ),
			'priority' => 160,
		)
	);

	// ---- Template ----

	$footer_choices = array(
		'0' => __( 'Default (Theme Footer)', 'personal-portfolio' ),
	);

	if ( post_type_exists( 'hl_footer' ) ) {
		$footer_posts = get_posts(
			array(
				'post_type'      => 'hl_footer',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		foreach ( $footer_posts as $footer_post ) {
			$footer_choices[ (string) $footer_post->ID ] = $footer_post->post_title;
		}
	}

	$wp_customize->add_setting(
		'footer_template_id',
		array(
			'default'           => '0',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'footer_template_id',
		array(
			'label'       => __( 'Footer Template', 'personal-portfolio' ),
			'description' => __( 'Pick a Footer built with Elementor (Heliolisk → Footer) to replace the default footer below, or keep the default.', 'personal-portfolio' ),
			'section'     => 'personal_portfolio_footer',
			'type'        => 'select',
			'choices'     => $footer_choices,
		)
	);

	// ---- Text ----

	$wp_customize->add_setting(
		'footer_copyright_text',
		array(
			'default'           => $defaults['footer_copyright_text'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'footer_copyright_text',
		array(
			'label'   => __( 'Copyright Text', 'personal-portfolio' ),
			'section' => 'personal_portfolio_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'footer_location_text',
		array(
			'default'           => $defaults['footer_location_text'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'footer_location_text',
		array(
			'label'   => __( 'Location Text', 'personal-portfolio' ),
			'section' => 'personal_portfolio_footer',
			'type'    => 'text',
		)
	);

	// ---- Style ----

	$wp_customize->add_setting(
		'footer_text_color',
		array(
			'default'           => $defaults['footer_text_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_text_color',
			array(
				'label'   => __( 'Text Color', 'personal-portfolio' ),
				'section' => 'personal_portfolio_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_bg_color',
		array(
			'default'           => $defaults['footer_bg_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_bg_color',
			array(
				'label'   => __( 'Background Color', 'personal-portfolio' ),
				'section' => 'personal_portfolio_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_border_color',
		array(
			'default'           => $defaults['footer_border_color'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_border_color',
			array(
				'label'   => __( 'Top Border Color', 'personal-portfolio' ),
				'section' => 'personal_portfolio_footer',
			)
		)
	);
}
add_action( 'customize_register', 'personal_portfolio_customize_register' );

/**
 * Outputs the Customizer's header color choices as CSS, scoped to the nav
 * menu and social icons, so they override the theme's own defaults without
 * editing style.css.
 */
function personal_portfolio_header_customizer_css() {
	$defaults = personal_portfolio_header_defaults();

	$nav_color          = get_theme_mod( 'nav_link_color', $defaults['nav_link_color'] );
	$social_color       = get_theme_mod( 'social_icon_color', $defaults['social_icon_color'] );
	$social_hover_color = get_theme_mod( 'social_icon_hover_color', $defaults['social_icon_hover_color'] );
	?>
	<style id="personal-portfolio-header-customizer-css">
		.nav-links a{
			color: <?php echo esc_html( $nav_color ); ?>;
		}
		.nav-links a:hover{
			color: var(--red-bright);
		}
		.socials a{
			color: <?php echo esc_html( $social_color ); ?>;
		}
		.socials a:hover{
			color: <?php echo esc_html( $social_hover_color ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'personal_portfolio_header_customizer_css' );

/**
 * Outputs the Customizer's footer color choices as CSS, scoped to .footer,
 * so they override the theme's own defaults without editing style.css.
 */
function personal_portfolio_footer_customizer_css() {
	$defaults = personal_portfolio_footer_defaults();

	$text_color   = get_theme_mod( 'footer_text_color', $defaults['footer_text_color'] );
	$bg_color     = get_theme_mod( 'footer_bg_color', $defaults['footer_bg_color'] );
	$border_color = get_theme_mod( 'footer_border_color', $defaults['footer_border_color'] );
	?>
	<style id="personal-portfolio-footer-customizer-css">
		.footer{
			background-color: <?php echo esc_html( $bg_color ); ?>;
			border-top-color: <?php echo esc_html( $border_color ); ?>;
		}
		.footer-bottom{
			color: <?php echo esc_html( $text_color ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'personal_portfolio_footer_customizer_css' );

/**
 * Registers a "Page Settings" metabox (via the Pure Metafields plugin) that
 * lets each page pick its own Footer, overriding the Customizer's global
 * Footer Template choice. See footer.php for how it is resolved.
 *
 * A plain select is used rather than select_posts because the plugin skips
 * saving empty select_posts values, which would make it impossible to switch
 * a page back to the global footer.
 */
function personal_portfolio_page_meta_boxes( $meta_boxes ) {
	$footer_choices = array(
		'0' => __( 'Default (Theme Footer)', 'personal-portfolio' ),
	);

	if ( post_type_exists( 'hl_footer' ) ) {
		$footer_posts = get_posts(
			array(
				'post_type'      => 'hl_footer',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		foreach ( $footer_posts as $footer_post ) {
			$footer_choices[ (string) $footer_post->ID ] = $footer_post->post_title;
		}
	}

	$meta_boxes[] = array(
		'metabox_id' => 'personal_portfolio_page_settings',
		'title'      => __( 'Page Settings', 'personal-portfolio' ),
		'post_type'  => 'page',
		'context'    => 'normal',
		'priority'   => 'default',
		'columns'    => 1,
		'fields'     => array(
			array(
				'label'       => __( 'Footer', 'personal-portfolio' ),
				'id'          => 'personal_portfolio_page_footer',
				'type'        => 'select',
				'placeholder' => __( 'Use Customizer Setting', 'personal-portfolio' ),
				'default'     => '',
				'options'     => $footer_choices,
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'tp_meta_boxes', 'personal_portfolio_page_meta_boxes' );

/**
 * Returns the hl_footer post ID to render for the current request, or 0 for
 * the theme's default footer. A page's own "Footer" setting wins; otherwise
 * the Customizer's Footer Template is used.
 */
function personal_portfolio_get_footer_template_id() {
	if ( is_page() ) {
		$page_footer = get_post_meta( get_queried_object_id(), 'personal_portfolio_page_footer', true );

		if ( '' !== $page_footer && ! is_array( $page_footer ) ) {
			return (int) $page_footer;
		}
	}

	return (int) get_theme_mod( 'footer_template_id', 0 );
}
