<?php
/**
 * Single template for regular blog posts.
 *
 * Reuses the project-single layout/CSS (see single-hl_project.php) so blog
 * posts and project pages share one look, with the post's category as the
 * kicker and its publish date under the title.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$categories = get_the_category();
	$cat_name   = $categories ? $categories[0]->name : '';
	$tags       = get_the_tags();
	?>

	<article class="section project-single">
		<div class="container">

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="project-back reveal">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
				<?php esc_html_e( 'Back to Home', 'personal-portfolio' ); ?>
			</a>

			<?php if ( $cat_name ) : ?>
				<p class="project-single-kicker reveal"><span class="bar"></span><?php echo esc_html( $cat_name ); ?></p>
			<?php endif; ?>

			<h1 class="project-single-title reveal"><?php the_title(); ?></h1>

			<p class="post-single-date reveal"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>

			<?php if ( $tags ) : ?>
				<div class="d-flex flex-wrap gap-2 project-single-tags reveal stagger">
					<?php foreach ( $tags as $tag ) : ?>
						<span class="tag"><?php echo esc_html( $tag->name ); ?></span>
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
				<?php esc_html_e( 'Back to Home', 'personal-portfolio' ); ?>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
			</a>

		</div>
	</article>

	<?php
endwhile;
?>

</main>
<?php get_footer(); ?>
