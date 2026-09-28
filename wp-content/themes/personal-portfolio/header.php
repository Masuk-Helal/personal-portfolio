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

<div class="scroll-progress" id="scrollProgress"></div>

<?php
$personal_portfolio_header_defaults = personal_portfolio_header_defaults();

$personal_portfolio_logo_image = get_theme_mod( 'header_logo_image', $personal_portfolio_header_defaults['header_logo_image'] );
$personal_portfolio_logo_text  = get_theme_mod( 'header_logo_text', $personal_portfolio_header_defaults['header_logo_text'] );
$personal_portfolio_logo_link  = get_theme_mod( 'header_logo_link', $personal_portfolio_header_defaults['header_logo_link'] );

// Fixed icon set — the Customizer only supplies the URL/email for each; the
// icon markup itself stays in code so every icon keeps the same stroke
// style. An empty value hides that icon entirely.
$personal_portfolio_social_links = array(
	array(
		'url'   => get_theme_mod( 'social_linkedin_url', $personal_portfolio_header_defaults['social_linkedin_url'] ),
		'label' => __( 'LinkedIn', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 10v7M7 7v.01M12 17v-4.5a2.5 2.5 0 0 1 5 0V17M12 10v7"/></svg>',
	),
	array(
		'url'   => get_theme_mod( 'social_github_url', $personal_portfolio_header_defaults['social_github_url'] ),
		'label' => __( 'GitHub', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.6 2.8 5.5 3.1 5.5 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4.1 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"/></svg>',
	),
	array(
		'url'   => get_theme_mod( 'social_twitter_url', $personal_portfolio_header_defaults['social_twitter_url'] ),
		'label' => __( 'Twitter / X', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
	),
	array(
		'url'   => get_theme_mod( 'social_facebook_url', $personal_portfolio_header_defaults['social_facebook_url'] ),
		'label' => __( 'Facebook', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
	),
	array(
		'url'   => get_theme_mod( 'social_instagram_url', $personal_portfolio_header_defaults['social_instagram_url'] ),
		'label' => __( 'Instagram', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
	),
	array(
		'url'   => get_theme_mod( 'social_youtube_url', $personal_portfolio_header_defaults['social_youtube_url'] ),
		'label' => __( 'YouTube', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>',
	),
	array(
		'url'   => ( $email = get_theme_mod( 'social_email', $personal_portfolio_header_defaults['social_email'] ) ) ? 'mailto:' . $email : '',
		'label' => __( 'Email', 'personal-portfolio' ),
		'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="14" rx="1"/><path d="m3 7 9 6 9-6"/></svg>',
		'no_target' => true,
	),
);
?>

<!-- ============ HEADER ============ -->
<header class="site-header" id="siteHeader">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="<?php echo esc_url( $personal_portfolio_logo_link ); ?>" class="logo d-flex align-items-center gap-3" style="text-decoration: none;"><span class="logo-mark d-flex align-items-center justify-content-center"><img src="<?php echo esc_url( $personal_portfolio_logo_image ); ?>" alt="<?php echo esc_attr( $personal_portfolio_logo_text ); ?>"></span><span class="logo-word"><?php echo esc_html( $personal_portfolio_logo_text ); ?></span></a>
    <div class="nav-backdrop" id="navBackdrop"></div>
    <?php // Items are managed in Appearance → Menus ("Primary Menu") or Customize → Menu Locations; falls back to the theme's own section links when no menu is assigned. ?>
    <nav class="nav-links d-flex align-items-center gap-5" id="navLinks" aria-label="<?php esc_attr_e( 'Primary', 'personal-portfolio' ); ?>">
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'menu_id'        => 'menu-primary',
          'menu_class'     => 'nav-links-list',
          'container'      => false,
          'depth'          => 2,
          'fallback_cb'    => 'personal_portfolio_primary_menu_fallback',
        )
      );
      ?>
    </nav>
    <div class="header-right d-flex align-items-center gap-4">
      <div class="socials d-flex gap-3">
        <?php foreach ( $personal_portfolio_social_links as $social ) :
          if ( empty( $social['url'] ) ) {
            continue;
          }
          $is_mailto = 0 === strpos( $social['url'], 'mailto:' );
          ?>
          <a href="<?php echo esc_url( $social['url'] ); ?>"<?php echo ( ! $is_mailto ) ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr( $social['label'] ); ?>"><?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed, trusted inline SVG markup. ?></a>
        <?php endforeach; ?>
      </div>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
      </button>
    </div>
  </div>
</header>

<div class="page-body">
<main>
