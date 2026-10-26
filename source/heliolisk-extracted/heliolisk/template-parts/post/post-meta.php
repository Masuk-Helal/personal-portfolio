<?php
/**
 * Post meta row.
 *
 * $args:
 *   - items (string[]) Any of 'author', 'date', 'reading', 'comments', in
 *                      display order. Default: date + reading time.
 *
 * @package Heliolisk
 */

$heliolisk_items = isset( $args['items'] ) ? (array) $args['items'] : array( 'date', 'reading' );
?>
<ul class="post-meta">
	<?php foreach ( $heliolisk_items as $heliolisk_item ) : ?>
		<?php if ( 'author' === $heliolisk_item ) : ?>
			<li>
				<?php heliolisk_icon( 'user' ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
			</li>
		<?php elseif ( 'date' === $heliolisk_item ) : ?>
			<li><?php heliolisk_icon( 'calendar' ); ?><?php heliolisk_posted_on(); ?></li>
		<?php elseif ( 'reading' === $heliolisk_item ) : ?>
			<li>
				<?php heliolisk_icon( 'clock' ); ?>
				<?php
				/* translators: %s: minutes. */
				printf( esc_html__( '%s min read', 'heliolisk' ), esc_html( number_format_i18n( heliolisk_reading_time() ) ) );
				?>
			</li>
		<?php elseif ( 'comments' === $heliolisk_item && ( comments_open() || get_comments_number() ) ) : ?>
			<li>
				<?php heliolisk_icon( 'comment' ); ?>
				<a href="<?php comments_link(); ?>">
					<?php
					/* translators: %s: number of comments. */
					printf( esc_html( _n( '%s comment', '%s comments', get_comments_number(), 'heliolisk' ) ), esc_html( number_format_i18n( get_comments_number() ) ) );
					?>
				</a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
