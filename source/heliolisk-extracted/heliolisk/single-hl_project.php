<?php
/**
 * Single template for the "Project" custom post type (hl_project).
 *
 * Full width, in the same dark, minimal language as the rest of the theme
 * (eyebrow kicker, .tag pills, .reveal scroll-in).
 *
 * @package Heliolisk
 */

get_header();

// Breadcrumb only: the article below already carries the <h1>.
get_template_part( 'template-parts/layout/page-banner', null, array( 'show_title' => false ) );

while ( have_posts() ) :
	the_post();

	$heliolisk_terms    = get_the_terms( get_the_ID(), 'project_category' );
	$heliolisk_cat_name = ( $heliolisk_terms && ! is_wp_error( $heliolisk_terms ) ) ? $heliolisk_terms[0]->name : '';
	$heliolisk_tags     = get_the_tags();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'section project-single' ); ?>>
		<div class="container">

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="project-back reveal">
				<?php heliolisk_icon( 'arrow-left' ); ?>
				<?php esc_html_e( 'Back to Home', 'heliolisk' ); ?>
			</a>

			<?php if ( $heliolisk_cat_name ) : ?>
				<p class="project-single-kicker reveal"><span class="bar"></span><?php echo esc_html( $heliolisk_cat_name ); ?></p>
			<?php endif; ?>

			<h1 class="project-single-title reveal"><?php the_title(); ?></h1>

			<?php if ( $heliolisk_tags ) : ?>
				<div class="d-flex flex-wrap gap-2 project-single-tags reveal stagger">
					<?php foreach ( $heliolisk_tags as $heliolisk_tag ) : ?>
						<span class="tag"><?php echo esc_html( $heliolisk_tag->name ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="project-single-media reveal">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="project-single-content reveal">
				<?php the_content(); ?>
			</div>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-ghost project-single-cta reveal">
				<?php esc_html_e( 'Back to Home', 'heliolisk' ); ?>
				<?php heliolisk_icon( 'arrow-right' ); ?>
			</a>

		</div>
	</article>

	<?php
endwhile;

get_footer();
