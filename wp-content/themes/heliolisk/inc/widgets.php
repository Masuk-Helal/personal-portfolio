<?php
/**
 * Widget areas and the built-in sidebar.
 *
 * Two areas, named after where they appear. Which of them shows on a given
 * request is decided in inc/layout.php. Every sidebar opens with the search
 * form (see sidebar.php), so a Search widget is optional.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wrapper markup shared by the widget areas and the built-in sidebar.
 *
 * The title is an <h3> inside .widget-title, which draws the accent
 * underline beneath it.
 *
 * @return array<string, string>
 */
function heliolisk_widget_wrap_args() {
	return array(
		'before_widget' => '<section id="%1$s" class="widget sidebar-widget hl-sidebar-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
	);
}

/**
 * Registers the Left and Right sidebars.
 */
function heliolisk_widgets_init() {
	$shared = heliolisk_widget_wrap_args();

	register_sidebar(
		array_merge(
			$shared,
			array(
				'name'        => __( 'Right Sidebar', 'heliolisk' ),
				// Kept from the theme's first version so widgets already placed here stay put.
				'id'          => 'blog-sidebar',
				'description' => __( 'Shown to the right of the content when the layout is "Right Sidebar" or "Left & Right Sidebars".', 'heliolisk' ),
			)
		)
	);

	register_sidebar(
		array_merge(
			$shared,
			array(
				'name'        => __( 'Left Sidebar', 'heliolisk' ),
				'id'          => 'sidebar-left',
				'description' => __( 'Shown to the left of the content when the layout is "Left Sidebar" or "Left & Right Sidebars".', 'heliolisk' ),
			)
		)
	);

}
add_action( 'widgets_init', 'heliolisk_widgets_init' );

/**
 * Built-in sidebar shown until any widget is placed: Categories, Top Stories
 * and Tags, in the same markup as real widgets. The search form is printed
 * before it by sidebar.php.
 */
function heliolisk_default_sidebar() {
	$args = heliolisk_widget_wrap_args();

	// The widgets come from the Heliolisk plugin; without it the sidebar holds only the search box.
	if ( ! class_exists( 'Heliolisk_Widget_Categories' ) ) {
		return;
	}

	// the_widget() fills a single %s with the widget class; there is no widget ID.
	$args['before_widget'] = '<section class="widget sidebar-widget hl-sidebar-widget %s">';

	the_widget( 'Heliolisk_Widget_Categories', array( 'title' => __( 'Categories', 'heliolisk' ) ), $args );
	the_widget( 'Heliolisk_Widget_Top_Stories', array( 'title' => __( 'Top Stories', 'heliolisk' ) ), $args );
	the_widget( 'Heliolisk_Widget_Tags', array( 'title' => __( 'Tags', 'heliolisk' ) ), $args );
}

/**
 * Prints the sidebar search box that opens every sidebar column.
 */
function heliolisk_sidebar_search() {
	echo '<section class="widget sidebar-widget hl-sidebar-widget widget_search sidebar-widget--search">';
	get_search_form( array( 'aria_label' => __( 'Search the blog', 'heliolisk' ) ) );
	echo '</section>';
}

/**
 * Whether a widget area already holds a search box (the classic Search
 * widget or a Search block), so sidebar.php does not print a second one.
 *
 * @param string $area Widget area ID.
 * @return bool
 */
function heliolisk_area_has_search( $area ) {
	$areas  = wp_get_sidebars_widgets();
	$blocks = null;

	if ( empty( $areas[ $area ] ) ) {
		return false;
	}

	foreach ( (array) $areas[ $area ] as $widget_id ) {
		if ( 0 === strpos( $widget_id, 'search-' ) ) {
			return true;
		}

		if ( preg_match( '/^block-(\d+)$/', $widget_id, $match ) ) {
			if ( null === $blocks ) {
				$blocks = (array) get_option( 'widget_block', array() );
			}

			$content = isset( $blocks[ $match[1] ]['content'] ) ? $blocks[ $match[1] ]['content'] : '';

			if ( false !== strpos( $content, '<!-- wp:search' ) ) {
				return true;
			}
		}
	}

	return false;
}
