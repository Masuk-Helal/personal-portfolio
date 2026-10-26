<?php
/**
 * Previous / next post links.
 *
 * Built by hand rather than with the_post_navigation(): core wraps that in
 * .nav-links, the class the header's mobile drawer uses.
 *
 * @package Heliolisk
 */

// Labels follow the blog listing (newest first), not post dates: "Next" is the
// older post, the one that comes after this in the list.
$heliolisk_prev = get_next_post();
$heliolisk_next = get_previous_post();

if ( ! $heliolisk_prev && ! $heliolisk_next ) {
	return;
}
?>
<nav class="post-nav reveal" aria-label="<?php esc_attr_e( 'More posts', 'heliolisk' ); ?>">
	<div class="row g-3">
		<div class="col-sm-6">
			<?php if ( $heliolisk_prev ) : ?>
				<a class="post-nav-link" href="<?php echo esc_url( get_permalink( $heliolisk_prev ) ); ?>" rel="prev">
					<span class="post-nav-dir"><?php heliolisk_icon( 'arrow-left' ); ?><?php esc_html_e( 'Previous', 'heliolisk' ); ?></span>
					<span class="post-nav-title"><?php echo esc_html( get_the_title( $heliolisk_prev ) ); ?></span>
				</a>
			<?php endif; ?>
		</div>
		<div class="col-sm-6">
			<?php if ( $heliolisk_next ) : ?>
				<a class="post-nav-link post-nav-link--next" href="<?php echo esc_url( get_permalink( $heliolisk_next ) ); ?>" rel="next">
					<span class="post-nav-dir"><?php esc_html_e( 'Next', 'heliolisk' ); ?><?php heliolisk_icon( 'arrow-right' ); ?></span>
					<span class="post-nav-title"><?php echo esc_html( get_the_title( $heliolisk_next ) ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</nav>
