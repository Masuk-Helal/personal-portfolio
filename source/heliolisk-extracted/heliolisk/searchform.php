<?php
/**
 * Search form, used by get_search_form(): the sidebar, the header search
 * overlay, the "nothing found" and 404 screens. Every one shares the sidebar
 * look: a plain field with the search icon button inside it on the right.
 *
 * Pass 'variant' => 'overlay' in get_search_form()'s $args for the large
 * version.
 *
 * @package Heliolisk
 */

$heliolisk_form_id  = wp_unique_id( 'search-field-' );
$heliolisk_variant  = isset( $args['variant'] ) ? sanitize_html_class( $args['variant'] ) : 'default';
$heliolisk_aria     = ! empty( $args['aria_label'] ) ? $args['aria_label'] : __( 'Search', 'heliolisk' );
?>
<form role="search" method="get" class="search-form search-form--<?php echo esc_attr( $heliolisk_variant ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $heliolisk_aria ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $heliolisk_form_id ); ?>"><?php esc_html_e( 'Search for:', 'heliolisk' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $heliolisk_form_id ); ?>" class="search-field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( heliolisk_get_option( 'search_placeholder' ) ); ?>" autocomplete="off" required>
	<button type="submit" class="search-submit search-btn" aria-label="<?php esc_attr_e( 'Search', 'heliolisk' ); ?>">
		<?php heliolisk_icon( 'search' ); ?>
	</button>
</form>
