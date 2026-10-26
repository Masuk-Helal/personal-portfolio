<?php
/**
 * The theme's own site header: logo, primary menu, search button, social
 * links and the mobile menu toggle.
 *
 * The menu (and its mobile toggle) only render once a menu is assigned to
 * the "Primary Menu" location; the logo falls back to the site title.
 *
 * @package Heliolisk
 */

$heliolisk_logo_image = heliolisk_get_option( 'header_logo_image' );
$heliolisk_logo_text  = heliolisk_get_option( 'header_logo_text' );
$heliolisk_logo_text  = $heliolisk_logo_text ? $heliolisk_logo_text : get_bloginfo( 'name' );
$heliolisk_logo_link  = heliolisk_resolve_anchor_url( (string) heliolisk_get_option( 'header_logo_link' ) );
$heliolisk_has_menu   = has_nav_menu( 'primary' );
// Site Identity logo wins over the theme's own logo option.
$heliolisk_custom_logo = (int) get_theme_mod( 'custom_logo' );
?>
<header class="site-header" id="siteHeader">
	<div class="container d-flex align-items-center justify-content-between gap-4">

		<a href="<?php echo esc_url( $heliolisk_logo_link ? $heliolisk_logo_link : home_url( '/' ) ); ?>" class="logo d-flex align-items-center gap-3" rel="home">
			<?php if ( $heliolisk_custom_logo ) : ?>
				<span class="logo-mark d-flex align-items-center justify-content-center"><?php echo wp_get_attachment_image( $heliolisk_custom_logo, 'full', false, array( 'alt' => $heliolisk_logo_text ) ); ?></span>
			<?php elseif ( $heliolisk_logo_image ) : ?>
				<span class="logo-mark d-flex align-items-center justify-content-center"><img src="<?php echo esc_url( $heliolisk_logo_image ); ?>" alt="<?php echo esc_attr( $heliolisk_logo_text ); ?>"></span>
			<?php endif; ?>
			<span class="logo-word"><?php echo esc_html( $heliolisk_logo_text ); ?></span>
		</a>

		<?php if ( $heliolisk_has_menu ) : ?>
			<div class="nav-backdrop" id="navBackdrop"></div>

			<nav class="nav-links d-flex align-items-center gap-5" id="navLinks" aria-label="<?php esc_attr_e( 'Primary', 'heliolisk' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'menu-primary',
						'menu_class'     => 'nav-links-list',
						'container'      => false,
						'depth'          => 2,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>

		<div class="header-right d-flex align-items-center gap-4">
			<?php if ( heliolisk_is_enabled( 'header_search_enable' ) ) : ?>
				<button type="button" class="header-search-toggle" id="searchToggle" aria-label="<?php esc_attr_e( 'Open search', 'heliolisk' ); ?>" aria-controls="searchOverlay" aria-expanded="false">
					<?php heliolisk_icon( 'search' ); ?>
				</button>
			<?php endif; ?>

			<?php heliolisk_social_links(); ?>

			<?php if ( $heliolisk_has_menu ) : ?>
				<button type="button" class="nav-toggle" id="navToggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'heliolisk' ); ?>" aria-controls="navLinks" aria-expanded="false">
					<span class="nav-toggle-bar"></span>
					<span class="nav-toggle-bar"></span>
					<span class="nav-toggle-bar"></span>
				</button>
			<?php endif; ?>
		</div>

	</div>
</header>
