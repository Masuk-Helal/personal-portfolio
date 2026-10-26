<?php
/**
 * Post card, used in the blog / archive list: featured image with the
 * category pill on it, author + date, title, excerpt and "Continue Reading".
 *
 * Without a featured image the category moves into the meta row.
 *
 * @package Heliolisk
 */

$heliolisk_author_id = (int) get_the_author_meta( 'ID' );
$heliolisk_excerpt   = wp_strip_all_tags( get_the_excerpt() );
$heliolisk_category  = get_the_category();
$heliolisk_category  = $heliolisk_category ? $heliolisk_category[0] : null;
$heliolisk_has_thumb = has_post_thumbnail();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

	<?php if ( $heliolisk_has_thumb ) : ?>
		<div class="post-thumb">
			<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php the_post_thumbnail( 'heliolisk-card', array( 'loading' => 'lazy' ) ); ?>
			</a>
			<?php if ( $heliolisk_category ) : ?>
				<a class="post-category" href="<?php echo esc_url( get_category_link( $heliolisk_category ) ); ?>"><?php echo esc_html( $heliolisk_category->name ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="post-content-wrap">
		<ul class="post-card-meta">
			<?php // Imported posts can have no author (post_author 0); skip the item rather than show an empty link. ?>
			<?php if ( $heliolisk_author_id ) : ?>
				<li><a href="<?php echo esc_url( get_author_posts_url( $heliolisk_author_id ) ); ?>"><?php the_author(); ?></a></li>
				<li class="sep" aria-hidden="true"></li>
			<?php endif; ?>
			<li class="date">
				<a href="<?php the_permalink(); ?>"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></time></a>
			</li>
			<?php if ( ! $heliolisk_has_thumb && $heliolisk_category ) : ?>
				<li class="sep" aria-hidden="true"></li>
				<li><a class="post-category post-category--inline" href="<?php echo esc_url( get_category_link( $heliolisk_category ) ); ?>"><?php echo esc_html( $heliolisk_category->name ); ?></a></li>
			<?php endif; ?>
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<li><span class="post-badge"><?php esc_html_e( 'Featured', 'heliolisk' ); ?></span></li>
			<?php endif; ?>
		</ul>

		<div class="post-content">
			<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<?php if ( $heliolisk_excerpt ) : ?>
				<p class="post-card-excerpt"><?php echo esc_html( $heliolisk_excerpt ); ?></p>
			<?php endif; ?>

			<a class="underline-btn" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Continue Reading', 'heliolisk' ); ?>
				<span class="screen-reader-text"><?php the_title(); ?></span>
			</a>
		</div>
	</div>

</article>
