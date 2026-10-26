<?php
/**
 * Author box. Only shown when the author has filled in a biography
 * (Users → Profile → Biographical Info).
 *
 * @package Heliolisk
 */

$heliolisk_bio = get_the_author_meta( 'description' );

if ( ! $heliolisk_bio ) {
	return;
}
?>
<section class="author-box d-flex gap-4 reveal" aria-label="<?php esc_attr_e( 'About the author', 'heliolisk' ); ?>">
	<div class="author-box-avatar flex-shrink-0">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 88 ); ?>
	</div>
	<div>
		<p class="entry-tags-label mb-1"><?php esc_html_e( 'Written by', 'heliolisk' ); ?></p>
		<h2 class="author-box-name"><?php the_author(); ?></h2>
		<p class="author-box-bio"><?php echo wp_kses_post( $heliolisk_bio ); ?></p>
		<a class="view-case" href="<?php echo esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ); ?>">
			<?php esc_html_e( 'All posts', 'heliolisk' ); ?>
			<?php heliolisk_icon( 'arrow-right' ); ?>
		</a>
	</div>
</section>
