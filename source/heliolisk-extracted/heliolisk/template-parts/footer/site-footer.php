<?php
/**
 * The theme's own site footer: copyright and (optional) location line.
 *
 * @package Heliolisk
 */

$heliolisk_location = heliolisk_get_option( 'footer_location_text' );
?>
<footer class="footer footer--minimal">
	<div class="container footer-bottom d-flex justify-content-between flex-wrap gap-2">
		<p class="mb-0"><?php echo heliolisk_kses_inline( heliolisk_get_option( 'footer_copyright_text' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by heliolisk_kses_inline(). ?></p>
		<?php if ( $heliolisk_location ) : ?>
			<p class="mb-0"><?php echo esc_html( $heliolisk_location ); ?></p>
		<?php endif; ?>
	</div>
</footer>
