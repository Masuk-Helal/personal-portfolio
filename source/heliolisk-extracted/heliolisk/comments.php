<?php
/**
 * Comments list and form. Each comment is rendered by
 * heliolisk_comment_callback() (inc/comments.php).
 *
 * @package Heliolisk
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area reveal">

	<?php if ( have_comments() ) : ?>
		<h2 class="section-subhead">
			<?php
			$heliolisk_comment_count = get_comments_number();
			/* translators: %s: number of comments. */
			printf( esc_html( _n( '%s Comment', '%s Comments', $heliolisk_comment_count, 'heliolisk' ) ), esc_html( number_format_i18n( $heliolisk_comment_count ) ) );
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
					'callback'    => 'heliolisk_comment_callback',
					'reply_text'  => __( 'Reply', 'heliolisk' ),
				)
			);
			?>
		</ol>

		<?php
		// Not the_comments_navigation(): core wraps it in .nav-links, the header drawer's class.
		$heliolisk_comment_pages = paginate_comments_links(
			array(
				'echo' => false,
				'type' => 'list',
			)
		);

		if ( $heliolisk_comment_pages ) :
			?>
			<nav class="heliolisk-pagination" aria-label="<?php esc_attr_e( 'Comments pagination', 'heliolisk' ); ?>">
				<?php echo wp_kses_post( $heliolisk_comment_pages ); ?>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="comments-closed"><?php esc_html_e( 'Comments are closed.', 'heliolisk' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'          => __( 'Leave a comment', 'heliolisk' ),
			'title_reply_before'   => '<h2 id="reply-title" class="section-subhead comment-reply-title">',
			'title_reply_after'    => '</h2>',
			'class_submit'         => 'btn btn-primary',
			'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s ' . heliolisk_get_icon( 'arrow-right' ) . '</button>',
			'comment_field'        => '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'heliolisk' ) . '</label><textarea id="comment" name="comment" rows="6" placeholder="' . esc_attr__( 'Write your comment…', 'heliolisk' ) . '" required></textarea></p>',
			'comment_notes_before' => '',
		)
	);
	?>

</section>
