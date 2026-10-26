<?php
/**
 * Up to three more posts from the current post's categories.
 *
 * @package Heliolisk
 */

$heliolisk_categories = wp_get_post_categories( get_the_ID() );

if ( ! $heliolisk_categories ) {
	return;
}

$heliolisk_related = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_the_ID() ),
		'category__in'        => $heliolisk_categories,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $heliolisk_related->have_posts() ) {
	return;
}
?>
<section class="related-posts reveal" aria-labelledby="related-posts-title">
	<h2 class="section-subhead" id="related-posts-title"><?php esc_html_e( 'Keep reading', 'heliolisk' ); ?></h2>

	<div class="row g-3">
		<?php
		while ( $heliolisk_related->have_posts() ) :
			$heliolisk_related->the_post();
			?>
			<div class="col-md-4">
				<a class="related-card d-block h-100" href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<span class="related-card-media d-block"><?php the_post_thumbnail( 'heliolisk-thumb', array( 'loading' => 'lazy', 'alt' => '' ) ); ?></span>
					<?php endif; ?>
					<span class="related-card-date d-block"><?php echo esc_html( get_the_date() ); ?></span>
					<span class="related-card-title d-block"><?php the_title(); ?></span>
				</a>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</section>
