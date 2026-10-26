<?php
/**
 * 404 — page not found.
 *
 * @package Heliolisk
 */

get_header();
?>

<section class="error-404 section">
	<div class="container text-center">
		<p class="error-404-code reveal" aria-hidden="true">404</p>
		<p class="page-banner-kicker justify-content-center reveal"><span class="bar" aria-hidden="true"></span><?php esc_html_e( 'Page not found', 'heliolisk' ); ?></p>
		<h1 class="error-404-title reveal"><?php esc_html_e( 'This page took a wrong turn.', 'heliolisk' ); ?></h1>
		<p class="error-404-text reveal"><?php esc_html_e( 'The link may be broken or the page may have moved. Try a search, or head back home.', 'heliolisk' ); ?></p>

		<div class="error-404-search reveal">
			<?php get_search_form(); ?>
		</div>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary reveal">
			<?php esc_html_e( 'Back to Home', 'heliolisk' ); ?>
			<?php heliolisk_icon( 'arrow-right' ); ?>
		</a>
	</div>
</section>

<?php
get_footer();
