<?php
/**
 * Quote post card, used in the blog / archive list for posts with the "quote"
 * format: the quote itself instead of the usual thumbnail, title and excerpt.
 *
 * The whole card links to the post through an overlay link, so the cite link
 * inside the quote stays clickable (and stays valid markup).
 *
 * @package Heliolisk
 */

$heliolisk_quote = heliolisk_get_quote_markup();

if ( ! $heliolisk_quote ) {
	get_template_part( 'template-parts/content/content' );
	return;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card post-card--quote' ); ?>>
	<div class="post-quote">
		<?php echo wp_kses_post( $heliolisk_quote ); ?>
		<a class="post-quote-link" href="<?php the_permalink(); ?>">
			<span class="screen-reader-text"><?php the_title(); ?></span>
		</a>
	</div>
</article>
