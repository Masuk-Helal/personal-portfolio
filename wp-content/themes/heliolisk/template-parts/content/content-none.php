<?php
/**
 * Shown when a listing has no posts.
 *
 * @package Heliolisk
 */

?>
<div class="no-results reveal">
	<p class="page-banner-kicker"><span class="bar" aria-hidden="true"></span><?php esc_html_e( 'Nothing here', 'heliolisk' ); ?></p>

	<?php if ( is_search() ) : ?>
		<h2 class="no-results-title"><?php esc_html_e( 'No matches found', 'heliolisk' ); ?></h2>
		<p><?php esc_html_e( 'Nothing matched your search. Try different or fewer keywords.', 'heliolisk' ); ?></p>
	<?php elseif ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<h2 class="no-results-title"><?php esc_html_e( 'No posts yet', 'heliolisk' ); ?></h2>
		<p>
			<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Publish your first post', 'heliolisk' ); ?></a>
		</p>
	<?php else : ?>
		<h2 class="no-results-title"><?php esc_html_e( 'Nothing to show yet', 'heliolisk' ); ?></h2>
		<p><?php esc_html_e( 'It seems we can’t find what you’re looking for. Searching may help.', 'heliolisk' ); ?></p>
	<?php endif; ?>

	<?php get_search_form(); ?>
</div>
