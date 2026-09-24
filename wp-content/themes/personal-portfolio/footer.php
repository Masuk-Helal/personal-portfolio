
<?php
$personal_portfolio_footer_template_id = (int) get_theme_mod( 'footer_template_id', 0 );
$personal_portfolio_custom_footer_html = '';

if ( $personal_portfolio_footer_template_id && class_exists( '\Elementor\Plugin' ) ) {
	$personal_portfolio_footer_post = get_post( $personal_portfolio_footer_template_id );

	if (
		$personal_portfolio_footer_post
		&& 'hl_footer' === $personal_portfolio_footer_post->post_type
		&& 'publish' === $personal_portfolio_footer_post->post_status
	) {
		$personal_portfolio_custom_footer_html = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $personal_portfolio_footer_template_id );
	}
}
?>

<?php if ( $personal_portfolio_custom_footer_html ) : ?>

	<?php echo $personal_portfolio_custom_footer_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own sanitized builder output. ?>

<?php else :
	$personal_portfolio_footer_defaults = personal_portfolio_footer_defaults();
	?>
	<!-- ============ FOOTER ============ -->
	<footer class="footer footer--minimal">
	  <div class="container footer-bottom d-flex justify-content-between flex-wrap gap-2 reveal">
	    <p class="mb-0"><?php echo esc_html( get_theme_mod( 'footer_copyright_text', $personal_portfolio_footer_defaults['footer_copyright_text'] ) ); ?></p>
	    <p class="mb-0"><?php echo esc_html( get_theme_mod( 'footer_location_text', $personal_portfolio_footer_defaults['footer_location_text'] ) ); ?></p>
	  </div>
	</footer>
<?php endif; ?>
</div>


<?php wp_footer(); ?>
</body>
</html>
