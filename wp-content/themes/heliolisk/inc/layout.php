<?php
/**
 * Sidebar layout resolution.
 *
 * Every content template (blog, archive, search, single post, page) asks this
 * file two questions: which layout applies, and which widget area goes in
 * each sidebar column. Templates never read the options themselves.
 *
 * Layout priority, highest first:
 *   1. The page template (page-templates/*) chosen for a page.
 *   2. The "Sidebar Layout" setting on that page / post.
 *   3. The Customizer default for the kind of view (blog, single post, page).
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Available layouts, keyed by the value stored in options and post meta.
 *
 * @return array<string, string>
 */
function heliolisk_sidebar_layout_choices() {
	return array(
		'right' => __( 'Right Sidebar', 'heliolisk' ),
		'left'  => __( 'Left Sidebar', 'heliolisk' ),
		'both'  => __( 'Left & Right Sidebars', 'heliolisk' ),
		'none'  => __( 'No Sidebar (Full Width)', 'heliolisk' ),
	);
}

/**
 * Page templates that force a layout.
 *
 * @return array<string, string> Template file => layout.
 */
function heliolisk_layout_page_templates() {
	return array(
		'page-templates/template-right-sidebar.php' => 'right',
		'page-templates/template-left-sidebar.php'  => 'left',
		'page-templates/template-both-sidebars.php' => 'both',
		'page-templates/template-full-width.php'    => 'none',
	);
}

/**
 * The layout requested for the current view, before checking whether its
 * widget areas actually have widgets.
 *
 * @return string One of the keys of heliolisk_sidebar_layout_choices().
 */
function heliolisk_get_requested_layout() {
	$choices = heliolisk_sidebar_layout_choices();

	if ( is_page() ) {
		$template  = get_page_template_slug( get_queried_object_id() );
		$templates = heliolisk_layout_page_templates();

		if ( isset( $templates[ $template ] ) ) {
			return $templates[ $template ];
		}
	}

	$override = heliolisk_get_context_meta( 'heliolisk_sidebar_layout' );

	if ( isset( $choices[ $override ] ) ) {
		return $override;
	}

	if ( is_page() ) {
		$layout = heliolisk_get_option( 'page_layout' );
	} elseif ( is_singular( 'post' ) ) {
		$layout = heliolisk_get_option( 'single_layout' );
	} elseif ( is_singular() ) {
		// Projects and other custom post types keep their own full-width design.
		$layout = 'none';
	} else {
		$layout = heliolisk_get_option( 'blog_layout' );
	}

	return isset( $choices[ $layout ] ) ? $layout : 'right';
}

/**
 * Pseudo widget-area ID for the built-in sidebar (Search, Recent Posts,
 * Recent Comments) shown while no widgets have been placed at all — e.g.
 * right after activating the theme. See sidebar.php.
 */
const HELIOLISK_DEFAULT_SIDEBAR = 'heliolisk-default';

/**
 * Which widget area fills each sidebar column for the current view.
 *
 * A column whose area has no widgets falls back to the other area. When
 * neither area has widgets, one column shows the built-in default sidebar
 * (HELIOLISK_DEFAULT_SIDEBAR) instead.
 *
 * @return array{left: string, right: string} Widget area IDs; '' for no column.
 */
function heliolisk_get_sidebar_columns() {
	$left_active  = is_active_sidebar( 'sidebar-left' );
	$right_active = is_active_sidebar( 'blog-sidebar' );
	$fallback     = ( $left_active || $right_active ) ? '' : HELIOLISK_DEFAULT_SIDEBAR;
	$columns      = array(
		'left'  => '',
		'right' => '',
	);

	switch ( heliolisk_get_requested_layout() ) {
		case 'left':
			$columns['left'] = $left_active ? 'sidebar-left' : ( $right_active ? 'blog-sidebar' : $fallback );
			break;

		case 'right':
			$columns['right'] = $right_active ? 'blog-sidebar' : ( $left_active ? 'sidebar-left' : $fallback );
			break;

		case 'both':
			$columns['left']  = $left_active ? 'sidebar-left' : '';
			$columns['right'] = $right_active ? 'blog-sidebar' : $fallback;
			break;
	}

	return apply_filters( 'heliolisk_sidebar_columns', $columns );
}

/**
 * The layout that will actually render, after empty areas are dropped.
 *
 * @return string 'left', 'right', 'both' or 'none'.
 */
function heliolisk_get_layout() {
	$columns = heliolisk_get_sidebar_columns();

	if ( $columns['left'] && $columns['right'] ) {
		return 'both';
	}

	if ( $columns['left'] ) {
		return 'left';
	}

	return $columns['right'] ? 'right' : 'none';
}

/**
 * Bootstrap column classes for the main content column.
 *
 * @return string
 */
function heliolisk_content_column_class() {
	$classes = array(
		'none'  => 'col-12',
		'left'  => 'col-lg-8',
		'right' => 'col-lg-8',
		'both'  => 'col-lg-6',
	);

	return 'heliolisk-main-col ' . $classes[ heliolisk_get_layout() ];
}

/**
 * Bootstrap column classes for one sidebar column.
 *
 * Sidebars come after the content in the markup (content first on phones and
 * for screen readers); the left one is moved before it visually on desktop.
 *
 * @param string $side 'left' or 'right'.
 * @return string
 */
function heliolisk_sidebar_column_class( $side ) {
	$classes   = array( 'heliolisk-sidebar-col', 'heliolisk-sidebar-col--' . $side );
	$classes[] = 'both' === heliolisk_get_layout() ? 'col-lg-3' : 'col-lg-4';

	if ( 'left' === $side ) {
		$classes[] = 'order-lg-first';
	}

	return implode( ' ', $classes );
}

/**
 * Number of blog cards per row for the current layout: one full-width card
 * per row beside a sidebar, two side by side when the page is full width.
 *
 * @return int
 */
function heliolisk_post_grid_columns() {
	$columns = array(
		'none'  => 2,
		'left'  => 1,
		'right' => 1,
		'both'  => 1,
	);

	return (int) apply_filters( 'heliolisk_post_grid_columns', $columns[ heliolisk_get_layout() ] );
}
