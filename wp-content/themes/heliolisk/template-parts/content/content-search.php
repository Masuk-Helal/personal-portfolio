<?php
/**
 * Search result card. Results can be posts, pages or projects, so the post
 * type is shown instead of a category.
 *
 * @package Heliolisk
 */

$heliolisk_type = get_post_type_object( get_post_type() );
$heliolisk_type = $heliolisk_type ? $heliolisk_type->labels->singular_name : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card post-card--search' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumb">
			<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php the_post_thumbnail( 'heliolisk-card', array( 'loading' => 'lazy' ) ); ?>
			</a>
			<span class="post-category"><?php echo esc_html( $heliolisk_type ); ?></span>
		</div>
	<?php endif; ?>

	<div class="post-content-wrap">
		<ul class="post-card-meta">
			<?php if ( ! has_post_thumbnail() ) : ?>
				<li><span class="post-category post-category--inline"><?php echo esc_html( $heliolisk_type ); ?></span></li>
			<?php endif; ?>
			<?php if ( 'post' === get_post_type() ) : ?>
				<?php if ( ! has_post_thumbnail() ) : ?>
					<li class="sep" aria-hidden="true"></li>
				<?php endif; ?>
				<li class="date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></time></li>
			<?php endif; ?>
		</ul>

		<div class="post-content">
			<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<p class="post-card-excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>

			<a class="underline-btn" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Continue Reading', 'heliolisk' ); ?>
				<span class="screen-reader-text"><?php the_title(); ?></span>
			</a>
		</div>
	</div>

</article>
