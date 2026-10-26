<?php
/**
 * Full-screen search, opened by the header's search button.
 *
 * @package Heliolisk
 */

?>
<div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'heliolisk' ); ?>" hidden>
	<div class="search-overlay-backdrop" data-search-close></div>

	<div class="search-overlay-panel container">
		<div class="d-flex align-items-center justify-content-between search-overlay-top">
			<p class="search-overlay-kicker mb-0"><span class="bar" aria-hidden="true"></span><?php esc_html_e( 'Search', 'heliolisk' ); ?></p>
			<button type="button" class="search-overlay-close" data-search-close aria-label="<?php esc_attr_e( 'Close search', 'heliolisk' ); ?>">
				<?php heliolisk_icon( 'close' ); ?>
			</button>
		</div>

		<?php
		get_search_form(
			array(
				'aria_label' => __( 'Site search', 'heliolisk' ),
				'variant'    => 'overlay',
			)
		);
		?>

		<p class="search-overlay-hint mb-0"><?php esc_html_e( 'Press Enter to search, Esc to close.', 'heliolisk' ); ?></p>
	</div>
</div>
