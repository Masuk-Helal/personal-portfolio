<?php
/**
 * Regular (non-Elementor) page content. The title is in the page banner, so
 * it is only printed here when the banner is hidden.
 *
 * @package Heliolisk
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<?php if ( ! heliolisk_show_page_banner() ) : ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<?php endif; ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry-media"><?php the_post_thumbnail( 'large' ); ?></figure>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'heliolisk' ) . '"><span class="page-links-title">' . esc_html__( 'Pages:', 'heliolisk' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>
</article>
