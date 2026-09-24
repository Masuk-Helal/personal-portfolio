<?php
/**
 * Template for standard WordPress pages (including Elementor-built pages).
 *
 * The homepage keeps its dedicated one-page design in index.php; any other
 * page — including ones built with Elementor — renders through the normal
 * WordPress Loop here so the_content() (and therefore Elementor's own
 * content filter) actually runs.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$is_elementor_page = 'builder' === get_post_meta( get_the_ID(), '_elementor_edit_mode', true );
	?>
	<div class="page-content-wrap<?php echo $is_elementor_page ? '' : ' container'; ?>" style="<?php echo $is_elementor_page ? '' : 'padding: 64px 24px;'; ?>">
		<?php if ( ! $is_elementor_page ) : ?>
			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php endif; ?>
		<div class="page-content">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
