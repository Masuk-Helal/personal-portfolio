<?php
/**
 * Per page / post settings, rendered by the Pure Metafields plugin.
 *
 * Each field defaults to "Use Customizer Setting", so a page only differs
 * from the site-wide options where someone changed it on purpose.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sidebar layout options with a leading "follow the Customizer" choice.
 *
 * @return array<string, string>
 */
function heliolisk_meta_layout_options() {
	return array( 'default' => __( 'Use Customizer Setting', 'heliolisk' ) ) + heliolisk_sidebar_layout_choices();
}

/**
 * Registers the "Page Settings" and "Post Settings" boxes.
 *
 * The per page Header / Footer choice lives in inc/cmb2-metaboxes.php (CMB2).
 *
 * @param array $meta_boxes Registered boxes.
 * @return array
 */
function heliolisk_register_meta_boxes( $meta_boxes ) {
	$layout_field = array(
		'label'   => __( 'Sidebar Layout', 'heliolisk' ),
		'id'      => 'heliolisk_sidebar_layout',
		'type'    => 'select',
		'default' => 'default',
		'options' => heliolisk_meta_layout_options(),
	);

	$meta_boxes[] = array(
		'metabox_id' => 'heliolisk_page_settings',
		'title'      => __( 'Page Settings', 'heliolisk' ),
		'post_type'  => 'page',
		'context'    => 'normal',
		'priority'   => 'default',
		'columns'    => 2,
		'fields'     => array(
			$layout_field,
			array(
				'label'   => __( 'Page Banner', 'heliolisk' ),
				'id'      => 'heliolisk_page_banner',
				'type'    => 'select',
				'default' => 'default',
				'options' => array(
					'default' => __( 'Use Customizer Setting', 'heliolisk' ),
					'show'    => __( 'Show', 'heliolisk' ),
					'hide'    => __( 'Hide', 'heliolisk' ),
				),
			),
		),
	);

	$meta_boxes[] = array(
		'metabox_id' => 'heliolisk_post_settings',
		'title'      => __( 'Post Settings', 'heliolisk' ),
		'post_type'  => 'post',
		'context'    => 'side',
		'priority'   => 'default',
		'columns'    => 1,
		'fields'     => array( $layout_field ),
	);

	return $meta_boxes;
}
add_filter( 'tp_meta_boxes', 'heliolisk_register_meta_boxes' );
