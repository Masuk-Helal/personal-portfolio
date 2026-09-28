<?php
/**
 * Template for a single Footer (hl_footer) post.
 *
 * Only used for Elementor's editor/preview of a footer. Without it WordPress
 * falls back to index.php, which never calls the_content(), so Elementor
 * reports "the content area was not found". The site header and footer are
 * left out on purpose so only the footer being edited is shown.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
while ( have_posts() ) :
	the_post();
	the_content();
endwhile;
?>

<?php wp_footer(); ?>
</body>
</html>
