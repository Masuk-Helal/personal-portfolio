<?php
/**
 * Elementor "Projects" widget — pulls in this site's real "Project" custom
 * post type entries (the query itself is theme-dependent on WordPress data;
 * the layout/CSS is still fully self-contained). Each card links out to that
 * project's own single page (see the theme's single-hl_project.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class Heliolisk_Projects_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-projects';
	}

	public function get_title() {
		return __( 'Projects', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-projects-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'projects', 'portfolio', 'case studies', 'work' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'projects' ) );
	}

	protected function register_controls() {
		$this->register_content_header_controls();
		$this->register_content_skills_controls();
		$this->register_content_query_controls();
		$this->register_content_advanced_controls();

		$this->register_style_eyebrow_controls();
		$this->register_style_skills_controls();
		$this->register_style_card_controls();
		$this->register_style_grid_controls();
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
				'default'   => __( '03', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'eyebrow_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Projects', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => __( 'Layout', 'heliolisk' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'featured',
				'options' => array(
					'featured' => __( 'Layout 1 — Featured Cards', 'heliolisk' ),
					'grid'     => __( 'Layout 2 — Image Grid', 'heliolisk' ),
				),
			)
		);

		$this->add_control(
			'lead_text',
			array(
				'label'   => __( 'Lead Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( "Academic & practical analytics experience. As a Business Analytics student, I've applied R, Python and SQL to real survey data — cleaning, modelling, testing and visualizing it to turn raw numbers into readable, defensible insights.", 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_skills_controls() {
		$this->start_controls_section(
			'section_content_skills',
			array(
				'label' => __( 'Skill Tags', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_skills',
			array(
				'label'        => __( 'Show Skill Tags', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tag_text',
			array(
				'label'   => __( 'Tag', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tag', 'heliolisk' ),
			)
		);

		$this->add_control(
			'skills',
			array(
				'label'       => __( 'Tags', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'tag_text' => __( 'R', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Python', 'heliolisk' ) ),
					array( 'tag_text' => __( 'SQL', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Excel', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Google Sheets', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Tableau', 'heliolisk' ) ),
				),
				'title_field' => '{{{ tag_text }}}',
				'condition'   => array( 'show_skills' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_query_controls() {
		$this->start_controls_section(
			'section_content_query',
			array(
				'label' => __( 'Projects Query', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'posts_count',
			array(
				'label'   => __( 'Number of Projects', 'heliolisk' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 20,
				'default' => 10,
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

		$categories  = get_terms( array( 'taxonomy' => 'project_category', 'hide_empty' => false ) );
		$cat_options = array();
		if ( ! is_wp_error( $categories ) ) {
			foreach ( $categories as $cat ) {
				$cat_options[ $cat->term_id ] = $cat->name;
			}
		}

		$this->add_control(
			'posts_categories',
			array(
				'label'       => __( 'Filter by Project Category', 'heliolisk' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $cat_options,
				'default'     => array(),
				'label_block' => true,
				'description' => __( 'Leave empty to show projects from every category.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'category_fallback',
			array(
				'label'     => __( 'Category Badge Fallback Text', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Project', 'heliolisk' ),
				'condition' => array( 'layout' => 'featured' ),
			)
		);

		$this->add_control(
			'featured_label',
			array(
				'label'     => __( 'Featured Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Featured Project', 'heliolisk' ),
				'condition' => array( 'layout' => 'featured' ),
			)
		);

		$this->add_control(
			'number_prefix',
			array(
				'label'     => __( 'Number Prefix', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Project', 'heliolisk' ),
				'description' => __( 'Shown above each card as "Project 01", "Project 02"...', 'heliolisk' ),
				'condition' => array( 'layout' => 'grid' ),
			)
		);

		$this->add_control(
			'fallback_image',
			array(
				'label'       => __( 'Fallback Preview Image', 'heliolisk' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => __( 'Used for projects that have no featured image.', 'heliolisk' ),
				'condition'   => array( 'layout' => 'grid' ),
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'label'   => __( 'Summary Length (words)', 'heliolisk' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 10,
				'max'     => 120,
				'default' => 50,
			)
		);

		$this->add_control(
			'view_button_text',
			array(
				'label'   => __( 'View Button Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'View Full Project', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_advanced_controls() {
		$this->start_controls_section(
			'section_content_advanced',
			array(
				'label' => __( 'Advanced', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_id',
			array(
				'label'       => __( 'Section ID', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'e.g. analytics or work', 'heliolisk' ),
				'description' => __( 'Sets this section\'s HTML id, for a nav menu link to scroll here. Left blank by default because this widget covers both the "#analytics" and "#work" nav links — set it to whichever one this instance represents (use two instances, one per Layout, if you need both).', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

	private function register_style_eyebrow_controls() {
		$this->start_controls_section(
			'section_style_eyebrow',
			array(
				'label' => __( 'Eyebrow & Lead', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'eyebrow_number_color',
			array(
				'label'     => __( 'Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e63946',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__eyebrow-num' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'eyebrow_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__eyebrow-lbl' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lead_color',
			array(
				'label'     => __( 'Lead Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__lead' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_skills_controls() {
		$this->start_controls_section(
			'section_style_skills',
			array(
				'label' => __( 'Skill Tags', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'skill_tag_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__skill' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'skill_tag_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__skill' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_card_controls() {
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => __( 'Project Card', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__card' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_tag_color',
			array(
				'label'     => __( 'Featured Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e63946',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__card-tag' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-projects__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_category_color',
			array(
				'label'     => __( 'Category Badge Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__card-cat' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_desc_color',
			array(
				'label'     => __( 'Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__card-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_link_color',
			array(
				'label'     => __( 'View Link Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__link' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_link_hover_color',
			array(
				'label'     => __( 'View Link Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff6b6b',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__link:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_grid_controls() {
		$this->start_controls_section(
			'section_style_grid',
			array(
				'label' => __( 'Grid Layout', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'grid_columns',
			array(
				'label'           => __( 'Columns', 'heliolisk' ),
				'type'            => Controls_Manager::SELECT,
				'default'         => '3',
				'tablet_default'  => '2',
				'mobile_default'  => '1',
				'options'         => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors'       => array(
					'{{WRAPPER}} .hlw-projects__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				),
			)
		);

		$this->add_control(
			'grid_num_color',
			array(
				'label'     => __( 'Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e63946',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-projects__grid-num' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-projects' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-projects' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$query_args = array(
			'post_type'           => 'hl_project',
			'post_status'         => 'publish',
			'posts_per_page'      => ! empty( $settings['posts_count'] ) ? (int) $settings['posts_count'] : 10,
			'orderby'             => 'date',
			'order'               => 'oldest' === $settings['posts_order'] ? 'ASC' : 'DESC',
			'ignore_sticky_posts' => true,
		);

		if ( ! empty( $settings['posts_categories'] ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'project_category',
					'field'    => 'term_id',
					'terms'    => array_map( 'intval', $settings['posts_categories'] ),
				),
			);
		}

		$projects_query    = new \WP_Query( $query_args );
		$excerpt_length    = ! empty( $settings['excerpt_length'] ) ? (int) $settings['excerpt_length'] : 50;
		$category_fallback = ! empty( $settings['category_fallback'] ) ? $settings['category_fallback'] : __( 'Project', 'heliolisk' );
		$number_prefix     = ! empty( $settings['number_prefix'] ) ? $settings['number_prefix'] : __( 'Project', 'heliolisk' );
		$fallback_image    = ! empty( $settings['fallback_image']['url'] ) ? $settings['fallback_image']['url'] : '';
		$is_grid           = 'grid' === $settings['layout'];
		$arrow_icon        = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hlw-projects__link-icon"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
		?>
		<section class="hlw-projects"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-projects__inner">

				<?php if ( 'yes' === $settings['show_eyebrow'] && ! empty( $settings['eyebrow_label'] ) ) : ?>
					<div class="hlw-projects__eyebrow">
						<?php if ( ! empty( $settings['eyebrow_number'] ) ) : ?>
							<span class="hlw-projects__eyebrow-num"><?php echo esc_html( $settings['eyebrow_number'] ); ?></span>
						<?php endif; ?>
						<span class="hlw-projects__eyebrow-lbl"><?php echo esc_html( $settings['eyebrow_label'] ); ?></span>
						<span class="hlw-projects__eyebrow-line"></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['lead_text'] ) ) : ?>
					<p class="hlw-projects__lead"><?php echo esc_html( $settings['lead_text'] ); ?></p>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_skills'] && ! empty( $settings['skills'] ) ) : ?>
					<div class="hlw-projects__skills">
						<?php foreach ( $settings['skills'] as $skill ) : ?>
							<span class="hlw-projects__skill"><?php echo esc_html( $skill['tag_text'] ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $projects_query->have_posts() ) : ?>
					<div class="<?php echo $is_grid ? 'hlw-projects__grid' : 'hlw-projects__list'; ?>">
						<?php
						$i = 0;
						while ( $projects_query->have_posts() ) :
							$projects_query->the_post();
							$i++;
							$cat_terms = get_the_terms( get_the_ID(), 'project_category' );
							$cat_name  = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? $cat_terms[0]->name : $category_fallback;
							$tags      = get_the_tags();

							if ( $is_grid ) :
								?>
								<div class="hlw-projects__grid-card">
									<div class="hlw-projects__grid-preview">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'large' ); ?>
										<?php elseif ( $fallback_image ) : ?>
											<img src="<?php echo esc_url( $fallback_image ); ?>" alt="<?php the_title_attribute(); ?>">
										<?php endif; ?>
									</div>
									<p class="hlw-projects__grid-num"><?php echo esc_html( $number_prefix . ' ' . sprintf( '%02d', $i ) ); ?></p>
									<h3 class="hlw-projects__card-title hlw-projects__grid-title"><?php the_title(); ?></h3>
									<p class="hlw-projects__card-desc hlw-projects__grid-desc">
										<?php echo esc_html( wp_trim_words( get_the_excerpt(), $excerpt_length ) ); ?>
									</p>
									<?php if ( $tags ) : ?>
										<div class="hlw-projects__grid-tags">
											<?php foreach ( $tags as $tag ) : ?>
												<span class="hlw-projects__card-pill hlw-projects__grid-pill"><?php echo esc_html( $tag->name ); ?></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
									<a href="<?php the_permalink(); ?>" class="hlw-projects__link hlw-projects__grid-link">
										<?php echo esc_html( $settings['view_button_text'] ); ?>
										<?php echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								</div>
								<?php
							else :
								?>
								<div class="hlw-projects__card">
									<div class="hlw-projects__card-head">
										<div>
											<?php if ( ! empty( $settings['featured_label'] ) ) : ?>
												<p class="hlw-projects__card-tag"><?php echo esc_html( $settings['featured_label'] ); ?></p>
											<?php endif; ?>
											<h3 class="hlw-projects__card-title"><?php the_title(); ?></h3>
										</div>
										<p class="hlw-projects__card-cat"><?php echo esc_html( $cat_name ); ?></p>
									</div>

									<?php if ( $tags ) : ?>
										<div class="hlw-projects__card-tags">
											<?php foreach ( $tags as $tag ) : ?>
												<span class="hlw-projects__card-pill"><?php echo esc_html( $tag->name ); ?></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>

									<p class="hlw-projects__card-desc">
										<?php echo esc_html( wp_trim_words( get_the_excerpt(), $excerpt_length ) ); ?>
									</p>

									<a href="<?php the_permalink(); ?>" class="hlw-projects__link">
										<?php echo esc_html( $settings['view_button_text'] ); ?>
										<?php echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								</div>
								<?php
							endif;
						endwhile;
						?>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p class="hlw-projects__empty"><?php esc_html_e( 'No projects published yet.', 'heliolisk' ); ?></p>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}
