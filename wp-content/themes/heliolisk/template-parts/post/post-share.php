<?php
/**
 * Share links for the current post. "Copy link" is handled in
 * assets/js/script.js.
 *
 * @package Heliolisk
 */

$heliolisk_url   = rawurlencode( get_permalink() );
$heliolisk_title = rawurlencode( wp_strip_all_tags( get_the_title() ) );

$heliolisk_networks = array(
	'linkedin' => array( __( 'Share on LinkedIn', 'heliolisk' ), 'https://www.linkedin.com/sharing/share-offsite/?url=' . $heliolisk_url ),
	'twitter'  => array( __( 'Share on X', 'heliolisk' ), 'https://twitter.com/intent/tweet?url=' . $heliolisk_url . '&text=' . $heliolisk_title ),
	'facebook' => array( __( 'Share on Facebook', 'heliolisk' ), 'https://www.facebook.com/sharer/sharer.php?u=' . $heliolisk_url ),
);
?>
<div class="entry-share d-flex flex-wrap align-items-center gap-2">
	<span class="entry-tags-label"><?php esc_html_e( 'Share', 'heliolisk' ); ?></span>

	<?php foreach ( $heliolisk_networks as $heliolisk_icon_name => $heliolisk_network ) : ?>
		<a class="share-btn" href="<?php echo esc_url( $heliolisk_network[1] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $heliolisk_network[0] ); ?>">
			<?php heliolisk_icon( $heliolisk_icon_name ); ?>
		</a>
	<?php endforeach; ?>

	<button type="button" class="share-btn" data-copy-link="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php esc_attr_e( 'Copy link', 'heliolisk' ); ?>">
		<?php heliolisk_icon( 'link' ); ?>
	</button>
</div>
