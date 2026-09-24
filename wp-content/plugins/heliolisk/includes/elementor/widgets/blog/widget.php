<?php
/**
 * Elementor "Blog" widget — pulls in this site's real WordPress posts
 * (the only theme-dependent widget in this plugin, since it needs WP's own
 * post query; the layout/CSS itself is still fully self-contained).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Heliolisk_Blog_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-blog';
	}

	public function get_title() {
		return __( 'Blog', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-blog-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'blog', 'posts', 'articles', 'news' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'blog' ) );
	}

	protected function register_controls() {
		$this->register_content_header_controls();
		$this->register_content_query_controls();

		$this->register_style_eyebrow_controls();
		$this->register_style_grid_controls();
		$this->register_style_card_controls();
		$this->register_style_section_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_header_controls() {
		$this->start_controls_section(
			'section_content_header',
			array(
				'label' => __( 'Header', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_eyebrow',
			array(
				'label'        => __( 'Show Eyebrow', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'eyebrow_number',
			array(
				'label'     => __( 'Number', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '09', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'eyebrow_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Blog', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_query_controls() {
		$this->start_controls_section(
			'section_content_query',
			array(
				'label' => __( 'Posts', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'posts_count',
			array(
				'label'   => __( 'Number of Posts', 'heliolisk' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 12,
				'default' => 3,
			)
		);

		$this->add_control(
			'posts_order',
			array(
				'label'   => __( 'Order', 'heliolisk' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'newest',
				'options' => array(
					'newest' => __( 'Newest First', 'heliolisk' ),
					'oldest' => __( 'Oldest First', 'heliolisk' ),
				),
			)
		);

		$categories = get_categories( array( 'hide_empty' => false ) );
		$cat_options = array();
		foreach ( $categories as $cat ) {
			$cat_options[ $cat->term_id ] = $cat->name;
		}

		$this->add_control(
			'posts_categories',
			array(
				'label'       => __( 'Filter by Category', 'heliolisk' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $cat_options,
				'default'     => array(),
				'label_block' => true,
				'description' => __( 'Leave empty to show posts from every category.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'show_excerpt',
			array(
				'label'        => __( 'Show Excerpt', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'label'     => __( 'Excerpt Length (words)', 'heliolisk' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 60,
				'default'   => 14,
				'condition' => array( 'show_excerpt' => 'yes' ),
			)
		);

		$this->add_control(
			'fallback_image',
			array(
				'label'       => __( 'Fallback Image', 'heliolisk' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => __( 'Used for posts that have no featured image.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

	private function register_style_eyebrow_controls() {
		$this->start_controls_section(
			'section_style_eyebrow',
			array(
				'label' => __( 'Eyebrow', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'eyebrow_number_color',
			array(
				'label'     => __( 'Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__eyebrow-num' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'eyebrow_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__eyebrow-lbl' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_grid_controls() {
		$this->start_controls_section(
			'section_style_grid',
			array(
				'label' => __( 'Grid', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'grid_columns',
			array(
				'label'   => __( 'Columns', 'heliolisk' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_card_controls() {
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => __( 'Card', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_title_hover_color',
			array(
				'label'     => __( 'Title Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__card:hover .hlw-blog__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_excerpt_color',
			array(
				'label'     => __( 'Excerpt Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog__card-excerpt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_section_controls() {
		$this->start_controls_section(
			'section_style_section',
			array(
				'label' => __( 'Section', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'section_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-blog' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => __( 'Padding', 'heliolisk' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-blog' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => ! empty( $settings['posts_count'] ) ? (int) $settings['posts_count'] : 3,
			'orderby'        => 'date',
			'order'          => 'oldest' === $settings['posts_order'] ? 'ASC' : 'DESC',
			'ignore_sticky_posts' => true,
		);

		if ( ! empty( $settings['posts_categories'] ) ) {
			$query_args['category__in'] = array_map( 'intval', $settings['posts_categories'] );
		}

		$posts_query = new \WP_Query( $query_args );

		$fallback_image = ! empty( $settings['fallback_image']['url'] ) ? $settings['fallback_image']['url'] : '';
		?>
		<section class="hlw-blog">
			<div class="hlw-blog__inner">

				<?php if ( 'yes' === $settings['show_eyebrow'] && ! empty( $settings['eyebrow_label'] ) ) : ?>
					<div class="hlw-blog__eyebrow">
						<?php if ( ! empty( $settings['eyebrow_number'] ) ) : ?>
							<span class="hlw-blog__eyebrow-num"><?php echo esc_html( $settings['eyebrow_number'] ); ?></span>
						<?php endif; ?>
						<span class="hlw-blog__eyebrow-lbl"><?php echo esc_html( $settings['eyebrow_label'] ); ?></span>
						<span class="hlw-blog__eyebrow-line"></span>
					</div>
				<?php endif; ?>

				<?php if ( $posts_query->have_posts() ) : ?>
					<div class="hlw-blog__grid">
						<?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
							<a href="<?php the_permalink(); ?>" class="hlw-blog__card">
								<div class="hlw-blog__card-img">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large' ); ?>
									<?php elseif ( $fallback_image ) : ?>
										<img src="<?php echo esc_url( $fallback_image ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php endif; ?>
								</div>
								<div class="hlw-blog__card-text">
									<h3 class="hlw-blog__card-title"><?php the_title(); ?></h3>
									<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
										<p class="hlw-blog__card-excerpt">
											<?php
											$excerpt_length = ! empty( $settings['excerpt_length'] ) ? (int) $settings['excerpt_length'] : 14;
											echo esc_html( wp_trim_words( get_the_excerpt(), $excerpt_length ) );
											?>
										</p>
									<?php endif; ?>
								</div>
							</a>
						<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p class="hlw-blog__empty"><?php esc_html_e( 'No posts found yet.', 'heliolisk' ); ?></p>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}
