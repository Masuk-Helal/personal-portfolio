<?php
/**
 * Per page header and footer choice, rendered by the CMB2 plugin.
 *
 * Stored in the meta keys the theme has always read (heliolisk_page_header /
 * heliolisk_page_footer, see heliolisk_get_builder_template_id()), so pages
 * keep the header and footer they already had.
 *
 * Nothing is saved for "Use Customizer Setting", so the Customizer's template
 * applies; "Default (Theme Template)" saves 0 and forces the theme's own one.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the "Page Header & Footer" box on pages.
 */
function heliolisk_register_cmb2_metaboxes() {
	$box = new_cmb2_box(
		array(
			'id'           => 'heliolisk_page_template_box',
			'title'        => __( 'Page Header & Footer', 'heliolisk' ),
			'object_types' => array( 'page' ),
			'context'      => 'side',
			'priority'     => 'default',
		)
	);

	$box->add_field(
		array(
			'name'             => __( 'Header', 'heliolisk' ),
			'desc'             => __( 'Header template (built with Elementor) shown on this page.', 'heliolisk' ),
			'id'               => 'heliolisk_page_header',
			'type'             => 'select',
			'show_option_none' => __( 'Use Customizer Setting', 'heliolisk' ),
			'options_cb'       => static function () {
				return heliolisk_get_builder_choices( 'hl_header' );
			},
		)
	);

	$box->add_field(
		array(
			'name'             => __( 'Footer', 'heliolisk' ),
			'desc'             => __( 'Footer template (built with Elementor) shown on this page.', 'heliolisk' ),
			'id'               => 'heliolisk_page_footer',
			'type'             => 'select',
			'show_option_none' => __( 'Use Customizer Setting', 'heliolisk' ),
			'options_cb'       => static function () {
				return heliolisk_get_builder_choices( 'hl_footer' );
			},
		)
	);
}
add_action( 'cmb2_admin_init', 'heliolisk_register_cmb2_metaboxes' );
