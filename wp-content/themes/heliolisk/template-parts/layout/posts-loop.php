<?php
/**
 * Post listing shared by the blog index, archives and search results: a card
 * grid beside the sidebar(s), then pagination.
 *
 * Card template: template-parts/content/content-search.php on search,
 * content-quote.php for quote format posts, otherwise content-{post type}.php,
 * falling back to content.php.
 *
 * @package Heliolisk
 */

$heliolisk_grid_cols = heliolisk_post_grid_columns();
?>
<section class="content-area section">
	<div class="container">
		<div class="row g-5">

			<div class="<?php echo esc_attr( heliolisk_content_column_class() ); ?>">
				<?php if ( have_posts() ) : ?>

					<?php // .reveal on the grid, not the cards: GSAP's inline transform would cancel the cards' hover lift. ?>
					<div class="post-grid post-grid--cols-<?php echo esc_attr( $heliolisk_grid_cols ); ?> reveal">
						<?php
						while ( have_posts() ) :
							the_post();

							if ( is_search() ) {
								get_template_part( 'template-parts/content/content', 'search' );
							} elseif ( 'quote' === get_post_format() ) {
								get_template_part( 'template-parts/content/content', 'quote' );
							} else {
								get_template_part( 'template-parts/content/content', get_post_type() );
							}
						endwhile;
						?>
					</div>

					<?php heliolisk_pagination(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
</section>
