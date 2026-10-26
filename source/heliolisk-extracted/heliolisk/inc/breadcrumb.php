<?php
/**
 * Page banner: the title strip + breadcrumb trail above blog, archive,
 * search and page content.
 *
 * The banner is printed by each template (not from header.php), so
 * Elementor-built pages — including the one-page front page — never get one.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the banner should show on the current view.
 *
 * A page's own "Page Banner" setting wins over the Customizer switch.
 *
 * @return bool
 */
function heliolisk_show_page_banner() {
	$page_value = heliolisk_get_context_meta( 'heliolisk_page_banner' );

	if ( 'show' === $page_value ) {
		return true;
	}

	if ( 'hide' === $page_value ) {
		return false;
	}

	return heliolisk_is_enabled( 'page_banner_enable' );
}

/**
 * Banner heading for the current view.
 *
 * @return string Unescaped text; archive titles may contain inline markup.
 */
function heliolisk_get_banner_title() {
	if ( is_home() ) {
		$posts_page = (int) get_option( 'page_for_posts' );

		return $posts_page ? get_the_title( $posts_page ) : heliolisk_get_option( 'blog_title' );
	}

	if ( is_search() ) {
		/* translators: %s: search query. */
		return sprintf( __( 'Search results for “%s”', 'heliolisk' ), get_search_query() );
	}

	if ( is_404() ) {
		return __( 'Page not found', 'heliolisk' );
	}

	if ( is_archive() ) {
		return get_the_archive_title();
	}

	return get_the_title( get_queried_object_id() );
}

/**
 * Small label shown above the banner heading.
 *
 * @return string
 */
function heliolisk_get_banner_kicker() {
	if ( is_search() ) {
		global $wp_query;

		/* translators: %s: number of results. */
		return sprintf( _n( '%s result', '%s results', (int) $wp_query->found_posts, 'heliolisk' ), number_format_i18n( (int) $wp_query->found_posts ) );
	}

	if ( is_category() ) {
		return __( 'Category', 'heliolisk' );
	}

	if ( is_tag() ) {
		return __( 'Tag', 'heliolisk' );
	}

	if ( is_author() ) {
		return __( 'Author', 'heliolisk' );
	}

	if ( is_date() ) {
		return __( 'Archive', 'heliolisk' );
	}

	// Single posts: the first category, the kicker the article header used to carry.
	if ( is_singular( 'post' ) ) {
		$categories = get_the_category( get_queried_object_id() );

		return $categories ? $categories[0]->name : '';
	}

	return '';
}

// Drop "Category:", "Tag:" … from archive titles; the banner shows that as its kicker instead.
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Breadcrumb trail for the current view.
 *
 * @return array<int, array{label: string, url: string}> The last item is the
 *                                                        current page (no url).
 */
function heliolisk_get_breadcrumb_items() {
	$items = array(
		array(
			'label' => __( 'Home', 'heliolisk' ),
			'url'   => home_url( '/' ),
		),
	);

	$posts_page = (int) get_option( 'page_for_posts' );
	$blog_item  = $posts_page ? array(
		'label' => get_the_title( $posts_page ),
		'url'   => get_permalink( $posts_page ),
	) : null;

	if ( is_home() ) {
		$items[] = array(
			'label' => wp_strip_all_tags( heliolisk_get_banner_title() ),
			'url'   => '',
		);
	} elseif ( is_singular( 'post' ) ) {
		if ( $blog_item ) {
			$items[] = $blog_item;
		}

		$categories = get_the_category( get_queried_object_id() );

		if ( $categories ) {
			$items[] = array(
				'label' => $categories[0]->name,
				'url'   => get_category_link( $categories[0] ),
			);
		}

		$items[] = array(
			'label' => get_the_title( get_queried_object_id() ),
			'url'   => '',
		);
	} elseif ( is_singular( 'hl_project' ) ) {
		$project_terms = get_the_terms( get_queried_object_id(), 'project_category' );

		if ( $project_terms && ! is_wp_error( $project_terms ) ) {
			$term_link = get_term_link( $project_terms[0] );

			$items[] = array(
				'label' => $project_terms[0]->name,
				'url'   => is_wp_error( $term_link ) ? '' : $term_link,
			);
		}

		$items[] = array(
			'label' => get_the_title( get_queried_object_id() ),
			'url'   => '',
		);
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_queried_object_id() ) ) as $ancestor ) {
			$items[] = array(
				'label' => get_the_title( $ancestor ),
				'url'   => get_permalink( $ancestor ),
			);
		}

		$items[] = array(
			'label' => get_the_title( get_queried_object_id() ),
			'url'   => '',
		);
	} else {
		if ( $blog_item && ( is_category() || is_tag() || is_date() || is_author() ) ) {
			$items[] = $blog_item;
		}

		$items[] = array(
			'label' => wp_strip_all_tags( heliolisk_get_banner_title() ),
			'url'   => '',
		);
	}

	return apply_filters( 'heliolisk_breadcrumb_items', $items );
}

/**
 * Prints the breadcrumb trail.
 */
function heliolisk_breadcrumb() {
	$items = heliolisk_get_breadcrumb_items();
	$last  = count( $items ) - 1;
	?>
	<nav class="heliolisk-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'heliolisk' ); ?>">
		<ol>
			<?php foreach ( $items as $index => $item ) : ?>
				<li>
					<?php if ( $index !== $last && $item['url'] ) : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php else : ?>
						<span aria-current="page"><?php echo esc_html( $item['label'] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
	<?php
}
