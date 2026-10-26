<?php
/**
 * Pages.
 *
 * Elementor-built pages render full-bleed with nothing around them, so
 * Elementor controls the whole layout. Any other page gets the banner and the
 * sidebar layout chosen in the Customizer, the page's own settings, or its
 * page template (page-templates/).
 *
 * @package Heliolisk
 */

get_header();

while ( have_posts() ) :
	the_post();

	if ( heliolisk_is_elementor_post() ) :
		the_content();
		continue;
	endif;

	get_template_part( 'template-parts/layout/page-banner' );
	?>

	<section class="content-area section section--page">
		<div class="container">
			<div class="row g-5">

				<div class="<?php echo esc_attr( heliolisk_content_column_class() ); ?>">
					<?php
					get_template_part( 'template-parts/content/content', 'page' );

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
