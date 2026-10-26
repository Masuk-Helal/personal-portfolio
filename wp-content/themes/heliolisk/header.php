<?php
/**
 * Document head and the opening of the page body.
 *
 * The visible header itself is template-parts/header/site-header.php, or the
 * Elementor Header picked in the Customizer / Page Settings (inc/builder.php).
 * <main> opened here is closed in footer.php.
 *
 * @package Heliolisk
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'heliolisk' ); ?></a>

<div class="scroll-progress" id="scrollProgress"></div>

<?php
heliolisk_render_site_header();

if ( heliolisk_is_enabled( 'header_search_enable' ) ) {
	get_template_part( 'template-parts/header/search-overlay' );
}

// Optional banner set in Appearance → Customize → Header Image.
if ( get_header_image() ) {
	?>
	<div class="site-header-image">
		<img src="<?php echo esc_url( get_header_image() ); ?>" alt="">
	</div>
	<?php
}
?>

<div class="page-body" id="page">
<main id="content" class="site-main">
