<?php
/**
 * Single blog post, beside the sidebar(s) chosen for single posts.
 *
 * Other post types get their own single-{post type}.php (see
 * single-hl_project.php).
 *
 * @package Heliolisk
 */

get_header();

get_template_part( 'template-parts/layout/page-banner' );
?>

<section class="content-area section section--single">
	<div class="container">
		<div class="row g-5">

			<div class="<?php echo esc_attr( heliolisk_content_column_class() ); ?>">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content-single', get_post_type() );
				endwhile;
				?>
			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
</section>

<?php
get_footer();
