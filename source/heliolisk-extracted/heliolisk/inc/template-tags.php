<?php
/**
 * Template tags: small output helpers called from templates.
 *
 * Each is wrapped in function_exists() so a child theme can replace it.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'heliolisk_get_social_links' ) ) {
	/**
	 * Social profiles set in Customizer → Header, in display order.
	 *
	 * The icon set is fixed; the Customizer only supplies each URL / email.
	 * An empty value hides that icon.
	 *
	 * @return array<int, array{url: string, label: string, icon: string, external: bool}>
	 */
	function heliolisk_get_social_links() {
		$fields = array(
			'social_linkedin_url'  => array( __( 'LinkedIn', 'heliolisk' ), 'linkedin' ),
			'social_github_url'    => array( __( 'GitHub', 'heliolisk' ), 'github' ),
			'social_twitter_url'   => array( __( 'Twitter / X', 'heliolisk' ), 'twitter' ),
			'social_facebook_url'  => array( __( 'Facebook', 'heliolisk' ), 'facebook' ),
			'social_instagram_url' => array( __( 'Instagram', 'heliolisk' ), 'instagram' ),
			'social_youtube_url'   => array( __( 'YouTube', 'heliolisk' ), 'youtube' ),
			'social_email'         => array( __( 'Email', 'heliolisk' ), 'email' ),
		);

		$links = array();

		foreach ( $fields as $key => $field ) {
			$value = heliolisk_get_option( $key );

			if ( ! $value ) {
				continue;
			}

			$is_email = 'social_email' === $key;
			$links[]  = array(
				'url'      => $is_email ? 'mailto:' . $value : $value,
				'label'    => $field[0],
				'icon'     => $field[1],
				'external' => ! $is_email,
			);
		}

		return $links;
	}
}

if ( ! function_exists( 'heliolisk_social_links' ) ) {
	/**
	 * Prints the social icon links.
	 *
	 * @param string $class Wrapper classes.
	 */
	function heliolisk_social_links( $class = 'socials d-flex gap-3' ) {
		$links = heliolisk_get_social_links();

		if ( ! $links ) {
			return;
		}

		echo '<div class="' . esc_attr( $class ) . '">';

		foreach ( $links as $link ) {
			printf(
				'<a href="%1$s"%2$s aria-label="%3$s">%4$s</a>',
				esc_url( $link['url'] ),
				$link['external'] ? ' target="_blank" rel="noopener"' : '',
				esc_attr( $link['label'] ),
				heliolisk_get_icon( $link['icon'] ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed, trusted inline SVG markup.
			);
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'heliolisk_reading_time' ) ) {
	/**
	 * Estimated reading time of a post, in minutes (200 words per minute).
	 *
	 * @param int $post_id Post ID; defaults to the current post.
	 * @return int At least 1.
	 */
	function heliolisk_reading_time( $post_id = 0 ) {
		$content = get_post_field( 'post_content', $post_id ? $post_id : get_the_ID() );
		$words   = str_word_count( wp_strip_all_tags( strip_shortcodes( (string) $content ) ) );

		return max( 1, (int) ceil( $words / 200 ) );
	}
}

if ( ! function_exists( 'heliolisk_get_quote_markup' ) ) {
	/**
	 * The quote of a "quote" format post, as a <blockquote>.
	 *
	 * Quote posts normally hold a blockquote already, so that one is reused and
	 * the card matches the single post. Plain text content is wrapped in one.
	 *
	 * @param int $post_id Post ID; defaults to the current post.
	 * @return string Blockquote markup, or '' when the post has no content.
	 */
	function heliolisk_get_quote_markup( $post_id = 0 ) {
		$content = get_post_field( 'post_content', $post_id ? $post_id : get_the_ID() );
		$content = apply_filters( 'the_content', (string) $content );

		if ( preg_match( '#<blockquote\b[^>]*>.*?</blockquote>#is', $content, $match ) ) {
			return $match[0];
		}

		$text = trim( wp_strip_all_tags( $content ) );

		return $text ? '<blockquote><p>' . esc_html( $text ) . '</p></blockquote>' : '';
	}
}

if ( ! function_exists( 'heliolisk_primary_category' ) ) {
	/**
	 * Prints the post's first category as a kicker link.
	 *
	 * @param string $class Link classes.
	 */
	function heliolisk_primary_category( $class = 'post-kicker' ) {
		$categories = get_the_category();

		if ( ! $categories ) {
			return;
		}

		printf(
			'<a class="%1$s" href="%2$s"><span class="bar" aria-hidden="true"></span>%3$s</a>',
			esc_attr( $class ),
			esc_url( get_category_link( $categories[0] ) ),
			esc_html( $categories[0]->name )
		);
	}
}

if ( ! function_exists( 'heliolisk_posted_on' ) ) {
	/**
	 * Prints the publish date as a <time> element.
	 */
	function heliolisk_posted_on() {
		printf(
			'<time class="entry-date" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
	}
}

if ( ! function_exists( 'heliolisk_post_tags' ) ) {
	/**
	 * Prints the post's tags as linked .tag pills.
	 */
	function heliolisk_post_tags() {
		$tags = get_the_tags();

		if ( ! $tags ) {
			return;
		}

		echo '<div class="entry-tags d-flex flex-wrap align-items-center gap-2">';
		echo '<span class="entry-tags-label">' . esc_html__( 'Tags', 'heliolisk' ) . '</span>';

		foreach ( $tags as $tag ) {
			printf( '<a class="tag" href="%1$s" rel="tag">%2$s</a>', esc_url( get_tag_link( $tag ) ), esc_html( $tag->name ) );
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'heliolisk_pagination' ) ) {
	/**
	 * Numbered pagination for the main query.
	 *
	 * Not the_posts_pagination(): core wraps it in .nav-links, the class the
	 * header's mobile drawer uses.
	 */
	function heliolisk_pagination() {
		$links = paginate_links(
			array(
				'type'      => 'array',
				'mid_size'  => 1,
				'prev_text' => heliolisk_get_icon( 'arrow-left' ) . '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'heliolisk' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'heliolisk' ) . '</span>' . heliolisk_get_icon( 'arrow-right' ),
			)
		);

		if ( ! $links ) {
			return;
		}

		echo '<nav class="heliolisk-pagination" aria-label="' . esc_attr__( 'Posts pagination', 'heliolisk' ) . '"><ul>';

		foreach ( $links as $link ) {
			echo '<li>' . $link . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links() output.
		}

		echo '</ul></nav>';
	}
}
