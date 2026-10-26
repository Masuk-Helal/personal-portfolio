<?php
/**
 * Closes <main>, prints the site footer and closes the document.
 *
 * The visible footer is template-parts/footer/site-footer.php, or the
 * Elementor Footer picked in the Customizer / Page Settings (inc/builder.php).
 *
 * @package Heliolisk
 */

?>
</main>

<?php heliolisk_render_site_footer(); ?>
</div>

<?php if ( heliolisk_is_enabled( 'back_to_top_enable' ) ) : ?>
	<button type="button" class="back-to-top" id="backToTop" aria-label="<?php esc_attr_e( 'Back to top', 'heliolisk' ); ?>">
		<?php heliolisk_icon( 'arrow-up' ); ?>
	</button>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
