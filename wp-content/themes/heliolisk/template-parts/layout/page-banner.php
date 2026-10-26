<?php
/**
 * Page banner: kicker, title and breadcrumb (see inc/breadcrumb.php).
 *
 * Post listings (blog index, archives, search) get the split blog header:
 * kicker + large title on the left, a short description on the right.
 * Pages keep the centered banner.
 *
 * $args:
 *   - show_title (bool) Default true. Pass false for the breadcrumb row alone,
 *                       for templates whose own header carries the <h1>
 *                       (single-hl_project.php).
 *
 * @package Heliolisk
 */

if ( ! heliolisk_show_page_banner() ) {
	return;
}

$heliolisk_show_title = ! isset( $args['show_title'] ) || $args['show_title'];
$heliolisk_kicker     = $heliolisk_show_title ? heliolisk_get_banner_kicker() : '';
$heliolisk_desc       = ( $heliolisk_show_title && is_archive() ) ? get_the_archive_description() : '';
$heliolisk_listing    = $heliolisk_show_title && ( is_home() || is_archive() || is_search() );

if ( $heliolisk_listing ) :
	if ( ! $heliolisk_kicker ) {
		$heliolisk_kicker = __( 'Latest posts', 'heliolisk' );
	}

	if ( ! $heliolisk_desc && is_home() ) {
		$heliolisk_desc = get_bloginfo( 'description' );
	}
	?>
	<section class="page-banner page-banner--blog">
		<div class="container">
			<div class="page-banner-info">
				<div class="page-banner-content">
					<p class="page-banner-eyebrow reveal"><?php echo esc_html( $heliolisk_kicker ); ?></p>
					<h1 class="page-banner-title reveal"><?php echo wp_kses_post( heliolisk_get_banner_title() ); ?></h1>
					<?php
					if ( ! is_front_page() ) {
						heliolisk_breadcrumb();
					}
					?>
				</div>

				<?php if ( $heliolisk_desc ) : ?>
					<div class="page-banner-content page-banner-desc reveal"><?php echo wp_kses_post( wpautop( $heliolisk_desc ) ); ?></div>
				<?php endif; ?>

				<img class="page-banner-arrow d-none d-xl-block" src="<?php echo esc_url( HELIOLISK_THEME_URI . '/assets/images/blog/arrow-dark.svg' ); ?>" alt="" aria-hidden="true">
			</div>
		</div>

		<div class="animated-dots" aria-hidden="true">
			<span class="dot dot-left-right"></span>
			<span class="dot dot-up-down"></span>
			<span class="dot dot-up-down"></span>
			<span class="dot dot-rotate-center"></span>
			<span class="dot dot-left-right"></span>
			<span class="dot dot-rotate-center"></span>
		</div>
	</section>
	<?php
	return;
endif;
?>
<?php
// Single posts keep the article's title scale, so the banner reads as the post header.
$heliolisk_banner_class = 'page-banner';

if ( ! $heliolisk_show_title ) {
	$heliolisk_banner_class .= ' page-banner--compact';
} elseif ( is_singular( 'post' ) ) {
	$heliolisk_banner_class .= ' page-banner--single';
}
?>
<section class="<?php echo esc_attr( $heliolisk_banner_class ); ?>">
	<div class="container">
		<?php if ( $heliolisk_show_title ) : ?>
			<?php if ( $heliolisk_kicker ) : ?>
				<p class="page-banner-kicker reveal"><span class="bar" aria-hidden="true"></span><?php echo esc_html( $heliolisk_kicker ); ?></p>
			<?php endif; ?>

			<h1 class="page-banner-title reveal"><?php echo wp_kses_post( heliolisk_get_banner_title() ); ?></h1>

			<?php if ( $heliolisk_desc ) : ?>
				<div class="page-banner-desc reveal"><?php echo wp_kses_post( $heliolisk_desc ); ?></div>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		// On a blog front page the trail would only read "Home / Blog".
		if ( ! is_front_page() ) {
			heliolisk_breadcrumb();
		}
		?>
	</div>
</section>
