<?php
/**
 * Customizer sanitize callbacks.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checkbox → bool.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function heliolisk_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Keeps a select / radio value only if it is one of the control's choices,
 * otherwise falls back to the setting's default.
 *
 * @param string               $value   Raw value.
 * @param WP_Customize_Setting $setting Setting being saved.
 * @return string
 */
function heliolisk_sanitize_choice( $value, $setting ) {
	$control = $setting->manager->get_control( $setting->id );
	$choices = $control ? $control->choices : array();

	return array_key_exists( $value, $choices ) ? $value : $setting->default;
}

/**
 * Short text that may contain simple inline markup (links, <strong>, <br>).
 *
 * @param string $value Raw value.
 * @return string
 */
function heliolisk_sanitize_inline_html( $value ) {
	return heliolisk_kses_inline( $value );
}

/**
 * Logo link: a "#section" anchor or a URL.
 *
 * @param string $value Raw value.
 * @return string
 */
function heliolisk_sanitize_link( $value ) {
	$value = trim( (string) $value );

	return ( '' !== $value && '#' === $value[0] ) ? sanitize_text_field( $value ) : esc_url_raw( $value );
}
