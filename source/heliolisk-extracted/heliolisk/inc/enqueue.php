<?php
/**
 * Front-end styles and scripts.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues theme styles and scripts.
 *
 * Vendor files are versioned by the theme version; the theme's own files by
 * their modification time (see heliolisk_asset_version()).
 */
function heliolisk_enqueue_assets() {
	$uri = HELIOLISK_THEME_URI;

	// ---- Styles ----
	wp_enqueue_style( 'heliolisk-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=Barlow+Condensed:wght@500;600&display=swap', array(), null );
	wp_enqueue_style( 'heliolisk-bootstrap', $uri . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), HELIOLISK_THEME_VERSION );
	wp_enqueue_style( 'heliolisk-nice-select', $uri . '/assets/vendor/nice-select/css/nice-select.css', array( 'heliolisk-bootstrap' ), HELIOLISK_THEME_VERSION );
	wp_enqueue_style( 'heliolisk-content', $uri . '/assets/css/content.css', array( 'heliolisk-nice-select' ), heliolisk_asset_version( 'assets/css/content.css' ) );
	wp_enqueue_style( 'heliolisk-main', $uri . '/assets/css/style.css', array( 'heliolisk-content' ), heliolisk_asset_version( 'assets/css/style.css' ) );
	wp_enqueue_style( 'heliolisk-blog', $uri . '/assets/css/blog.css', array( 'heliolisk-main' ), heliolisk_asset_version( 'assets/css/blog.css' ) );
	if ( 'light' === heliolisk_get_color_scheme() ) {
		wp_enqueue_style( 'heliolisk-scheme-light', $uri . '/assets/css/scheme-light.css', array( 'heliolisk-blog' ), heliolisk_asset_version( 'assets/css/scheme-light.css' ) );
	}
	wp_enqueue_style( 'heliolisk-theme', get_stylesheet_uri(), array( 'heliolisk-blog' ), HELIOLISK_THEME_VERSION );

	// ---- Scripts ----
	wp_enqueue_script( 'heliolisk-bootstrap', $uri . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array(), HELIOLISK_THEME_VERSION, true );
	wp_enqueue_script( 'heliolisk-gsap', $uri . '/assets/vendor/gsap/gsap.min.js', array(), HELIOLISK_THEME_VERSION, true );
	wp_enqueue_script( 'heliolisk-scrolltrigger', $uri . '/assets/vendor/gsap/ScrollTrigger.min.js', array( 'heliolisk-gsap' ), HELIOLISK_THEME_VERSION, true );
	wp_enqueue_script( 'heliolisk-main', $uri . '/assets/js/script.js', array( 'heliolisk-bootstrap', 'heliolisk-scrolltrigger' ), heliolisk_asset_version( 'assets/js/script.js' ), true );

	// Styled <select> for the Categories / Archives dropdowns (see assets/js/nice-select-init.js).
	wp_enqueue_script( 'heliolisk-nice-select', $uri . '/assets/vendor/nice-select/js/jquery.nice-select.min.js', array( 'jquery' ), HELIOLISK_THEME_VERSION, true );
	wp_enqueue_script( 'heliolisk-nice-select-init', $uri . '/assets/js/nice-select-init.js', array( 'heliolisk-nice-select' ), heliolisk_asset_version( 'assets/js/nice-select-init.js' ), true );

	wp_localize_script(
		'heliolisk-main',
		'heliolisk',
		array(
			'i18n' => array(
				'copied' => __( 'Link copied', 'heliolisk' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'heliolisk_enqueue_assets' );
