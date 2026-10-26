<?php
/**
 * Comment list markup and comment form fields.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'heliolisk_comment_callback' ) ) {
	/**
	 * Renders one comment for wp_list_comments(). WordPress closes the <li>.
	 *
	 * @param WP_Comment $comment Comment.
	 * @param array      $args    wp_list_comments() arguments.
	 * @param int        $depth   Nesting depth.
	 */
	function heliolisk_comment_callback( $comment, $args, $depth ) {
		if ( in_array( $comment->comment_type, array( 'pingback', 'trackback' ), true ) ) {
			?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-ping' ); ?>>
				<p><?php esc_html_e( 'Pingback:', 'heliolisk' ); ?> <?php comment_author_link( $comment ); ?></p>
			<?php
			return;
		}
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent', $comment ); ?>>
			<article class="comment-card d-flex gap-3">
				<div class="comment-avatar flex-shrink-0">
					<?php echo get_avatar( $comment, 56 ); ?>
				</div>
				<div class="comment-body-wrap flex-grow-1">
					<header class="comment-head d-flex flex-wrap align-items-baseline gap-2">
						<span class="comment-author-name"><?php comment_author_link( $comment ); ?></span>
						<time class="comment-date" datetime="<?php echo esc_attr( get_comment_date( DATE_W3C, $comment ) ); ?>">
							<?php
							/* translators: 1: comment date, 2: comment time. */
							printf( esc_html__( '%1$s at %2$s', 'heliolisk' ), esc_html( get_comment_date( '', $comment ) ), esc_html( get_comment_time() ) );
							?>
						</time>
					</header>

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<p class="comment-awaiting"><?php esc_html_e( 'Your comment is awaiting moderation.', 'heliolisk' ); ?></p>
					<?php endif; ?>

					<div class="comment-text"><?php comment_text(); ?></div>

					<div class="comment-actions d-flex gap-3">
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
								)
							)
						);
						edit_comment_link( __( 'Edit', 'heliolisk' ) );
						?>
					</div>
				</div>
			</article>
		<?php
	}
}

/**
 * Comment form fields: name and email side by side, website below.
 *
 * @param array $fields Default fields.
 * @return array
 */
function heliolisk_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$required  = get_option( 'require_name_email' ) ? ' required' : '';

	$fields['author'] = sprintf(
		'<div class="row g-3 comment-form-fields"><p class="col-md-6 comment-form-author"><label class="screen-reader-text" for="author">%1$s</label><input id="author" name="author" type="text" placeholder="%1$s" value="%2$s" autocomplete="name"%3$s></p>',
		esc_attr__( 'Your name', 'heliolisk' ),
		esc_attr( $commenter['comment_author'] ),
		$required
	);

	$fields['email'] = sprintf(
		'<p class="col-md-6 comment-form-email"><label class="screen-reader-text" for="email">%1$s</label><input id="email" name="email" type="email" placeholder="%1$s" value="%2$s" autocomplete="email"%3$s></p>',
		esc_attr__( 'Your email', 'heliolisk' ),
		esc_attr( $commenter['comment_author_email'] ),
		$required
	);

	$fields['url'] = sprintf(
		'<p class="col-12 comment-form-url"><label class="screen-reader-text" for="url">%1$s</label><input id="url" name="url" type="url" placeholder="%1$s" value="%2$s" autocomplete="url"></p></div>',
		esc_attr__( 'Your website (optional)', 'heliolisk' ),
		esc_attr( $commenter['comment_author_url'] )
	);

	return $fields;
}
add_filter( 'comment_form_default_fields', 'heliolisk_comment_form_fields' );

/**
 * Puts the message box after name / email / website, where readers expect it.
 *
 * @param array $fields All comment form fields.
 * @return array
 */
function heliolisk_comment_textarea_last( $fields ) {
	if ( isset( $fields['comment'] ) ) {
		$comment = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment;
	}

	return $fields;
}
add_filter( 'comment_form_fields', 'heliolisk_comment_textarea_last' );
