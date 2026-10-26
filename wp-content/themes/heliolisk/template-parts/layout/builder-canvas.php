<?php
/**
 * Blank canvas for editing a Header / Footer template in Elementor.
 *
 * Without it WordPress falls back to index.php, which never calls
 * the_content(), so Elementor reports "the content area was not found". The
 * site header and footer are left out on purpose so only the template being
 * edited is shown.
 *
 * @package Heliolisk
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
