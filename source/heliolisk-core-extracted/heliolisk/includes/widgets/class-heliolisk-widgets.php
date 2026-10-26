<?php
/**
 * Blog widgets: Categories, Top Stories, Tags and Banner.
 *
 * Widgets are plugin territory, so they live here rather than in the theme.
 * The Heliolisk theme styles them and shows three of them in its built-in
 * sidebar.
 *
 * @package Heliolisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared title / count form fields for the theme widgets.
 */
abstract class Heliolisk_Widget extends WP_Widget {

	/**
	 * Default instance values.
	 *
	 * @var array<string, mixed>
	 */
	protected $defaults = array( 'title' => '' );

	/**
	 * Instance merged over the defaults.
	 *
	 * @param array $instance Saved settings.
	 * @return array
	 */
	protected function settings( $instance ) {
		return wp_parse_args( (array) $instance, $this->defaults );
	}

	/**
	 * Prints the widget title, if any.
	 *
	 * @param array  $args  Area wrapper args.
	 * @param string $title Title.
	 */
	protected function title( $args, $title ) {
		$title = apply_filters( 'widget_title', $title, array(), $this->id_base );

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
		}
	}

	/**
	 * Text field row for the widget form.
	 *
	 * @param array  $instance Settings.
	 * @param string $key      Field key.
	 * @param string $label    Label.
	 * @param string $type     Input type.
	 */
	protected function field( $instance, $key, $label, $type = 'text' ) {
		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" id="%1$s" name="%3$s" type="%4$s" value="%5$s"></p>',
			esc_attr( $this->get_field_id( $key ) ),
			esc_html( $label ),
			esc_attr( $this->get_field_name( $key ) ),
			esc_attr( $type ),
			esc_attr( $instance[ $key ] )
		);
	}

	/**
	 * Default form: every field in $this->defaults as a text / number input.
	 *
	 * @param array $instance Settings.
	 * @return string
	 */
	public function form( $instance ) {
		$instance = $this->settings( $instance );

		foreach ( $this->defaults as $key => $value ) {
			$this->field( $instance, $key, ucfirst( str_replace( '_', ' ', $key ) ) . ':', is_int( $value ) ? 'number' : 'text' );
		}

		return '';
	}

	/**
	 * Sanitizes every field by the type of its default.
	 *
	 * @param array $new_instance New settings.
	 * @param array $old_instance Old settings.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$clean = array();

		foreach ( $this->defaults as $key => $value ) {
			$raw           = isset( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
			$clean[ $key ] = is_int( $value ) ? max( 1, absint( $raw ) ) : sanitize_text_field( $raw );
		}

		return $clean;
	}
}

/**
 * Categories with their post count in a circle on the right.
 */
class Heliolisk_Widget_Categories extends Heliolisk_Widget {

	/**
	 * Default instance values.
	 *
	 * @var array<string, mixed>
	 */
	protected $defaults = array(
		'title'  => '',
		'number' => 6,
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'heliolisk_categories', __( 'Heliolisk: Categories', 'heliolisk' ), array( 'description' => __( 'Blog categories with post counts.', 'heliolisk' ) ) );
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Area wrapper args.
	 * @param array $instance Settings.
	 */
	public function widget( $args, $instance ) {
		$instance   = $this->settings( $instance );
		$categories = get_categories(
			array(
				'orderby'    => 'count',
				'order'      => 'DESC',
				'number'     => (int) $instance['number'],
				'hide_empty' => true,
			)
		);

		if ( ! $categories ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
		$this->title( $args, $instance['title'] );
		echo '<ul class="category-list">';

		foreach ( $categories as $category ) {
			printf(
				'<li><a href="%1$s">%2$s</a><span>%3$s</span></li>',
				esc_url( get_category_link( $category ) ),
				esc_html( $category->name ),
				esc_html( str_pad( (string) $category->count, 2, '0', STR_PAD_LEFT ) )
			);
		}

		echo '</ul>';
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
	}
}

/**
 * Latest posts as thumbnail + title + date rows.
 */
class Heliolisk_Widget_Top_Stories extends Heliolisk_Widget {

	/**
	 * Default instance values.
	 *
	 * @var array<string, mixed>
	 */
	protected $defaults = array(
		'title'  => '',
		'number' => 4,
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'heliolisk_top_stories', __( 'Heliolisk: Top Stories', 'heliolisk' ), array( 'description' => __( 'Latest posts with their thumbnails.', 'heliolisk' ) ) );
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Area wrapper args.
	 * @param array $instance Settings.
	 */
	public function widget( $args, $instance ) {
		$instance = $this->settings( $instance );
		$exclude  = is_singular( 'post' ) ? array( get_queried_object_id() ) : array();
		$posts    = get_posts(
			array(
				'numberposts'         => (int) $instance['number'],
				'post__not_in'        => $exclude,
				'ignore_sticky_posts' => true,
				'suppress_filters'    => false,
			)
		);

		if ( ! $posts ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
		$this->title( $args, $instance['title'] );
		echo '<div class="widget-post-items">';

		foreach ( $posts as $story ) {
			$has_thumb = has_post_thumbnail( $story );
			$link      = get_permalink( $story );
			?>
			<div class="widget-post-item<?php echo $has_thumb ? '' : ' widget-post-item--no-thumb'; ?>">
				<?php if ( $has_thumb ) : ?>
					<div class="widget-post-thumb">
						<a href="<?php echo esc_url( $link ); ?>" tabindex="-1" aria-hidden="true"><?php echo get_the_post_thumbnail( $story, 'heliolisk-thumb', array( 'loading' => 'lazy' ) ); ?></a>
					</div>
				<?php endif; ?>
				<div class="widget-post-content">
					<h4><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( get_the_title( $story ) ); ?></a></h4>
					<time class="widget-post-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $story ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y', $story ) ); ?></time>
				</div>
			</div>
			<?php
		}

		echo '</div>';
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
	}
}

/**
 * Post tags as pills.
 */
class Heliolisk_Widget_Tags extends Heliolisk_Widget {

	/**
	 * Default instance values.
	 *
	 * @var array<string, mixed>
	 */
	protected $defaults = array(
		'title'  => '',
		'number' => 12,
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'heliolisk_tags', __( 'Heliolisk: Tags', 'heliolisk' ), array( 'description' => __( 'Most used post tags as pills.', 'heliolisk' ) ) );
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Area wrapper args.
	 * @param array $instance Settings.
	 */
	public function widget( $args, $instance ) {
		$instance = $this->settings( $instance );
		$tags     = get_tags(
			array(
				'orderby' => 'count',
				'order'   => 'DESC',
				'number'  => (int) $instance['number'],
			)
		);

		if ( ! $tags ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
		$this->title( $args, $instance['title'] );
		echo '<ul class="widget-tags">';

		foreach ( $tags as $tag ) {
			printf( '<li><a href="%1$s" rel="tag">%2$s</a></li>', esc_url( get_tag_link( $tag ) ), esc_html( $tag->name ) );
		}

		echo '</ul>';
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
	}
}

/**
 * A linked image, e.g. a promo banner.
 */
class Heliolisk_Widget_Banner extends Heliolisk_Widget {

	/**
	 * Default instance values.
	 *
	 * @var array<string, mixed>
	 */
	protected $defaults = array(
		'image_url' => '',
		'link_url'  => '',
		'alt_text'  => '',
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'heliolisk_banner', __( 'Heliolisk: Banner', 'heliolisk' ), array( 'description' => __( 'A linked banner image.', 'heliolisk' ) ) );
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Area wrapper args.
	 * @param array $instance Settings.
	 */
	public function widget( $args, $instance ) {
		$instance = $this->settings( $instance );

		if ( ! $instance['image_url'] ) {
			return;
		}

		$image = sprintf( '<img src="%1$s" alt="%2$s" loading="lazy">', esc_url( $instance['image_url'] ), esc_attr( $instance['alt_text'] ) );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
		echo '<div class="sidebar-banner">';
		echo $instance['link_url'] ? '<a href="' . esc_url( $instance['link_url'] ) . '">' . $image . '</a>' : $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
		echo '</div>';
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- area wrapper markup.
	}

	/**
	 * Sanitizes the URLs as URLs.
	 *
	 * @param array $new_instance New settings.
	 * @param array $old_instance Old settings.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'image_url' => esc_url_raw( isset( $new_instance['image_url'] ) ? $new_instance['image_url'] : '' ),
			'link_url'  => esc_url_raw( isset( $new_instance['link_url'] ) ? $new_instance['link_url'] : '' ),
			'alt_text'  => sanitize_text_field( isset( $new_instance['alt_text'] ) ? $new_instance['alt_text'] : '' ),
		);
	}
}

/**
 * Registers the blog widgets.
 */
function heliolisk_register_widgets() {
	register_widget( 'Heliolisk_Widget_Categories' );
	register_widget( 'Heliolisk_Widget_Top_Stories' );
	register_widget( 'Heliolisk_Widget_Tags' );
	register_widget( 'Heliolisk_Widget_Banner' );
}
add_action( 'widgets_init', 'heliolisk_register_widgets' );
