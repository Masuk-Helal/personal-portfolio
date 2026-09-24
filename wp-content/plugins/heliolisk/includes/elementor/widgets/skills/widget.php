<?php
/**
 * Elementor "Skills" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Skills_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-skills';
	}

	public function get_title() {
		return __( 'Skills', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-skills-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'skills', 'tools', 'technologies', 'tags', 'languages' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'skills' ) );
	}

	protected function register_controls() {
		$this->register_content_header_controls();
		$this->register_content_categories_controls();
		$this->register_content_languages_controls();
		$this->register_content_advanced_controls();

		$this->register_style_eyebrow_controls();
		$this->register_style_category_controls();
		$this->register_style_tag_controls();
		$this->register_style_languages_controls();
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
				'default'   => __( '07', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'eyebrow_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Skills', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_categories_controls() {
		$this->start_controls_section(
			'section_content_categories',
			array(
				'label' => __( 'Categories', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$tag = new Repeater();

		$tag->add_control(
			'tag_text',
			array(
				'label'   => __( 'Tag', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tag', 'heliolisk' ),
			)
		);

		$category = new Repeater();

		$category->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'heliolisk' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-chart-line',
					'library' => 'fa-solid',
				),
			)
		);

		$category->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Category', 'heliolisk' ),
			)
		);

		$category->add_control(
			'tags',
			array(
				'label'       => __( 'Tags', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tag->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ tag_text }}}',
			)
		);

		$this->add_control(
			'categories',
			array(
				'label'       => __( 'Categories', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $category->get_controls(),
				'default'     => array(
					array(
						'icon'  => array( 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ),
						'title' => __( 'Data & Analytics', 'heliolisk' ),
						'tags'  => array(
							array( 'tag_text' => __( 'Excel', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Google Sheets', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Tableau', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Microsoft Power BI', 'heliolisk' ) ),
							array( 'tag_text' => __( 'SQL', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Data Visualization', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Business Analytics', 'heliolisk' ) ),
						),
					),
					array(
						'icon'  => array( 'value' => 'fas fa-layer-group', 'library' => 'fa-solid' ),
						'title' => __( 'Operations', 'heliolisk' ),
						'tags'  => array(
							array( 'tag_text' => __( 'Workflow Management', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Reporting', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Process Management', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Project Coordination', 'heliolisk' ) ),
							array( 'tag_text' => __( 'CMS', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Operational Dashboards', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Team Management', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Team Leadership', 'heliolisk' ) ),
						),
					),
					array(
						'icon'  => array( 'value' => 'fas fa-search', 'library' => 'fa-solid' ),
						'title' => __( 'Content & Marketing', 'heliolisk' ),
						'tags'  => array(
							array( 'tag_text' => __( 'SEO', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Content Strategy', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Digital Marketing', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Content Operations', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Content Writing', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Video Editing', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Strategic Marketing', 'heliolisk' ) ),
						),
					),
					array(
						'icon'  => array( 'value' => 'fas fa-bolt', 'library' => 'fa-solid' ),
						'title' => __( 'Technology', 'heliolisk' ),
						'tags'  => array(
							array( 'tag_text' => __( 'AI Tools', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Automation', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Vibe Code', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Digital Platforms', 'heliolisk' ) ),
						),
					),
					array(
						'icon'  => array( 'value' => 'fas fa-user-friends', 'library' => 'fa-solid' ),
						'title' => __( 'Core Strengths', 'heliolisk' ),
						'tags'  => array(
							array( 'tag_text' => __( 'Teamwork', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Negotiation', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Good Communicator', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Research Skills', 'heliolisk' ) ),
						),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_languages_controls() {
		$this->start_controls_section(
			'section_content_languages',
			array(
				'label' => __( 'Languages', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_languages',
			array(
				'label'        => __( 'Show Languages', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'languages_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Languages', 'heliolisk' ),
				'condition' => array( 'show_languages' => 'yes' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			array(
				'label'   => __( 'Language', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Language', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'level',
			array(
				'label'   => __( 'Proficiency', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Native', 'heliolisk' ),
			)
		);

		$this->add_control(
			'languages',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'name' => __( 'Bangla', 'heliolisk' ), 'level' => __( 'Native', 'heliolisk' ) ),
					array( 'name' => __( 'English', 'heliolisk' ), 'level' => __( 'Professional Working Proficiency', 'heliolisk' ) ),
				),
				'title_field' => '{{{ name }}} — {{{ level }}}',
				'condition'   => array( 'show_languages' => 'yes' ),
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
				'default'     => 'skills',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#skills" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
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
					'{{WRAPPER}} .hlw-skills__eyebrow-num' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-skills__eyebrow-lbl' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_category_controls() {
		$this->start_controls_section(
			'section_style_category',
			array(
				'label' => __( 'Categories', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'category_icon_color',
			array(
				'label'     => __( 'Icon Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__cat-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hlw-skills__cat-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'category_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__cat-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'category_title_typography',
				'selector' => '{{WRAPPER}} .hlw-skills__cat-title',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_tag_controls() {
		$this->start_controls_section(
			'section_style_tag',
			array(
				'label' => __( 'Tags', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tag_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__tag' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tag_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__tag' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tag_hover_color',
			array(
				'label'     => __( 'Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__tag:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_languages_controls() {
		$this->start_controls_section(
			'section_style_languages',
			array(
				'label' => __( 'Languages', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'languages_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__lang-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'languages_name_color',
			array(
				'label'     => __( 'Language Name Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__lang-item b' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'languages_level_color',
			array(
				'label'     => __( 'Proficiency Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-skills__lang-item' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-skills' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-skills' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-skills"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-skills__inner">

				<?php if ( 'yes' === $settings['show_eyebrow'] && ! empty( $settings['eyebrow_label'] ) ) : ?>
					<div class="hlw-skills__eyebrow">
						<?php if ( ! empty( $settings['eyebrow_number'] ) ) : ?>
							<span class="hlw-skills__eyebrow-num"><?php echo esc_html( $settings['eyebrow_number'] ); ?></span>
						<?php endif; ?>
						<span class="hlw-skills__eyebrow-lbl"><?php echo esc_html( $settings['eyebrow_label'] ); ?></span>
						<span class="hlw-skills__eyebrow-line"></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['categories'] ) ) : ?>
					<div class="hlw-skills__categories">
						<?php foreach ( $settings['categories'] as $category ) : ?>
							<div class="hlw-skills__category">
								<div class="hlw-skills__cat-top">
									<?php if ( ! empty( $category['icon']['value'] ) ) : ?>
										<span class="hlw-skills__cat-icon">
											<?php \Elementor\Icons_Manager::render_icon( $category['icon'], array( 'aria-hidden' => 'true' ) ); ?>
										</span>
									<?php endif; ?>
									<?php if ( ! empty( $category['title'] ) ) : ?>
										<h3 class="hlw-skills__cat-title"><?php echo esc_html( $category['title'] ); ?></h3>
									<?php endif; ?>
								</div>

								<?php if ( ! empty( $category['tags'] ) ) : ?>
									<div class="hlw-skills__tags">
										<?php foreach ( $category['tags'] as $tag ) : ?>
											<span class="hlw-skills__tag"><?php echo esc_html( $tag['tag_text'] ); ?></span>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_languages'] && ! empty( $settings['languages'] ) ) : ?>
					<div class="hlw-skills__lang-line">
						<?php if ( ! empty( $settings['languages_label'] ) ) : ?>
							<span class="hlw-skills__lang-label"><?php echo esc_html( $settings['languages_label'] ); ?></span>
						<?php endif; ?>
						<?php foreach ( $settings['languages'] as $lang ) : ?>
							<span class="hlw-skills__lang-item"><b><?php echo esc_html( $lang['name'] ); ?></b> — <?php echo esc_html( $lang['level'] ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}
