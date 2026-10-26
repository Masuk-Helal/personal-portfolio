<?php
/**
 * Featured image of a post: linked in cards, captioned on the single view.
 *
 * $args:
 *   - size (string) Image size. Default 'heliolisk-card'.
 *
 * @package Heliolisk
 */

$heliolisk_size   = isset( $args['size'] ) ? $args['size'] : 'heliolisk-card';
$heliolisk_single = is_singular() && get_the_ID() === get_queried_object_id();

if ( ! has_post_thumbnail() ) {
	return;
}

$heliolisk_figure_class = $heliolisk_single ? 'entry-media reveal' : 'post-card-media';
?>
<figure class="<?php echo esc_attr( $heliolisk_figure_class ); ?>">
	<?php if ( $heliolisk_single ) : ?>
		<?php the_post_thumbnail( $heliolisk_size ); ?>
		<?php if ( get_the_post_thumbnail_caption() ) : ?>
			<figcaption><?php the_post_thumbnail_caption(); ?></figcaption>
		<?php endif; ?>
	<?php else : ?>
		<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( $heliolisk_size, array( 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>
</figure>
