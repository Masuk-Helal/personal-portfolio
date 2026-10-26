<?php
/**
 * Sidebar columns for the current layout (see inc/layout.php).
 *
 * Called with get_sidebar() inside a content template's .row, right after
 * the main content column. Prints nothing for full-width layouts. While no
 * widgets are placed anywhere, a column shows the built-in default sidebar.
 *
 * Every column opens with the search box, unless its widget area already
 * holds a Search widget / block.
 *
 * @package Heliolisk
 */

foreach ( heliolisk_get_sidebar_columns() as $heliolisk_side => $heliolisk_area ) :
	if ( ! $heliolisk_area ) {
		continue;
	}

	$heliolisk_is_default = HELIOLISK_DEFAULT_SIDEBAR === $heliolisk_area;
	?>
	<aside class="<?php echo esc_attr( heliolisk_sidebar_column_class( $heliolisk_side ) ); ?>" aria-label="<?php echo esc_attr( 'left' === $heliolisk_side ? __( 'Left sidebar', 'heliolisk' ) : __( 'Right sidebar', 'heliolisk' ) ); ?>">
		<div class="widget-area sidebar-area hl-blog-sidebar">
			<?php
			if ( $heliolisk_is_default || ! heliolisk_area_has_search( $heliolisk_area ) ) {
				heliolisk_sidebar_search();
			}

			if ( $heliolisk_is_default ) {
				heliolisk_default_sidebar();
			} else {
				dynamic_sidebar( $heliolisk_area );
			}
			?>
		</div>
	</aside>
	<?php
endforeach;
