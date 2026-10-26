<?php
/**
 * Single blog post: header, media, content, then the optional extras
 * (tags, share, author box, previous / next, related posts) and comments.
 * Each extra can be switched off in Customizer → Blog & Layout.
 *
 * @package Heliolisk
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--single' ); ?>>

	<?php // The category kicker, the <h1> and the breadcrumb sit in the page banner above (template-parts/layout/page-banner.php). ?>
	<header class="entry-header entry-header--meta">
		<div class="reveal">
			<?php get_template_part( 'template-parts/post/post-meta', null, array( 'items' => array( 'author', 'date', 'reading', 'comments' ) ) ); ?>
		</div>
	</header>

	<?php get_template_part( 'template-parts/post/post-media', null, array( 'size' => 'full' ) ); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'heliolisk' ) . '"><span class="page-links-title">' . esc_html__( 'Pages:', 'heliolisk' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php heliolisk_post_tags(); ?>

		<?php
		if ( heliolisk_is_enabled( 'single_show_share' ) ) {
			get_template_part( 'template-parts/post/post-share' );
		}
		?>
	</footer>

	<?php
	if ( heliolisk_is_enabled( 'single_show_author' ) ) {
		get_template_part( 'template-parts/post/post-author' );
	}

	if ( heliolisk_is_enabled( 'single_show_nav' ) ) {
		get_template_part( 'template-parts/post/post-navigation' );
	}

	if ( heliolisk_is_enabled( 'single_show_related' ) ) {
		get_template_part( 'template-parts/post/post-related' );
	}

	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>

</article>
