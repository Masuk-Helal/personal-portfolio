<?php
/**
 * Elementor "Law Achievements" widget — fully self-contained, no theme dependency.
 *
 * Professional milestones list with an optional figure image for a lawyer or
 * legal practice, adapted from the index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Achievements_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-achievements';
	}

	public function get_title() {
		return __( 'Law Achievements', 'heliolisk' );
	}

	public function get_icon() {
		return 'hlw-law-achievements-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'achievements', 'milestones', 'certifications', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-achievements' ) );
	}

	protected function register_controls() {
		$this->register_content_heading_controls();
		$this->register_content_achievements_controls();
		$this->register_content_figure_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_list_controls();
		$this->register_style_figure_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_heading_controls() {
		$this->start_controls_section(
			'section_content_heading',
			array(
				'label' => __( 'Heading', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_id',
			array(
				'label'       => __( 'Section ID', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'achievements',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#achievements" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '07 / Professional Milestones', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'A record built on', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'evidence.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Enrolment, advocacy training and research experience that underpin my legal practice in Dhaka.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'sample_note',
			array(
				'label'   => __( 'Sample Note', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Professional record · Dhaka, Bangladesh', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_achievements_controls() {
		$this->start_controls_section(
			'section_content_achievements',
			array(
				'label' => __( 'Achievements', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'year',
			array(
				'label'   => __( 'Year', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '2025', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Constitutional Litigation', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Research and drafting support on constitutional and fundamental-rights matters before the High Court Division.', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'status',
			array(
				'label'   => __( 'Status / Type', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Practice', 'heliolisk' ),
			)
		);

		$this->add_control(
			'achievement_items',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'year'        => __( '2025', 'heliolisk' ),
						'title'       => __( 'Constitutional Litigation', 'heliolisk' ),
						'description' => __( 'Research and drafting support on constitutional and fundamental-rights matters before the High Court Division.', 'heliolisk' ),
						'status'      => __( 'Practice', 'heliolisk' ),
					),
					array(
						'year'        => __( '2024', 'heliolisk' ),
						'title'       => __( 'Moot Court & Advocacy Training', 'heliolisk' ),
						'description' => __( 'Written submissions and oral advocacy on a constitutional law problem before a judging panel.', 'heliolisk' ),
						'status'      => __( 'Training', 'heliolisk' ),
					),
					array(
						'year'        => __( '2024', 'heliolisk' ),
						'title'       => __( 'Bar Enrolment', 'heliolisk' ),
						'description' => __( 'Enrolled as an advocate with the Bangladesh Bar Council and admitted to practice at the Dhaka Bar.', 'heliolisk' ),
						'status'      => __( 'Admission', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_figure_controls() {
		$this->start_controls_section(
			'section_content_figure',
			array(
				'label' => __( 'Figure Image', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => __( 'Image', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-achievements/assets/images/justice-statue.webp',
				),
			)
		);

		$this->add_control(
			'image_alt',
			array(
				'label'       => __( 'Image Alt Text', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Bronze statue of Lady Justice holding the scales', 'heliolisk' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'figcaption',
			array(
				'label'   => __( 'Caption', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'A standard to work toward — fairness, rigour and public accountability.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

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
				'default'   => '#F5F2EB',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements' => '--hlw-law-achievements-paper: {{VALUE}}; background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements' => '--hlw-law-achievements-ink: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements' => '--hlw-law-achievements-gold: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_muted_color',
			array(
				'label'     => __( 'Muted Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements' => '--hlw-law-achievements-muted: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => __( 'Padding', 'heliolisk' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-achievements' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_eyebrow_controls() {
		$this->start_controls_section(
			'section_style_eyebrow',
			array(
				'label' => __( 'Eyebrow', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'eyebrow_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__eyebrow',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_heading_controls() {
		$this->start_controls_section(
			'section_style_heading',
			array(
				'label' => __( 'Heading', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__title',
			)
		);

		$this->add_responsive_control(
			'heading_max_width',
			array(
				'label'      => __( 'Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 300, 'max' => 900 ),
					'%'  => array( 'min' => 30, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-achievements__title' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_intro_controls() {
		$this->start_controls_section(
			'section_style_intro',
			array(
				'label' => __( 'Introduction', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'intro_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__intro' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'intro_max_width',
			array(
				'label'      => __( 'Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 220, 'max' => 700 ),
					'%'  => array( 'min' => 20, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-achievements__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__intro',
			)
		);

		$this->add_control(
			'sample_note_color',
			array(
				'label'     => __( 'Sample Note Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__sample-note' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sample_note_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__sample-note',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_list_controls() {
		$this->start_controls_section(
			'section_style_list',
			array(
				'label' => __( 'List', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'year_color',
			array(
				'label'     => __( 'Year Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__year' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'year_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__year',
			)
		);

		$this->add_control(
			'item_title_color',
			array(
				'label'     => __( 'Item Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__item-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__item-title',
			)
		);

		$this->add_control(
			'item_desc_color',
			array(
				'label'     => __( 'Item Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__item-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_desc_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__item-desc',
			)
		);

		$this->add_control(
			'status_color',
			array(
				'label'     => __( 'Status Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__status' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__status',
			)
		);

		$this->add_responsive_control(
			'items_gap',
			array(
				'label'      => __( 'Gap Between Items', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-achievements__list' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_figure_controls() {
		$this->start_controls_section(
			'section_style_figure',
			array(
				'label' => __( 'Figure', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'figure_caption_color',
			array(
				'label'     => __( 'Caption Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-achievements__figcaption' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'figure_caption_typography',
				'selector' => '{{WRAPPER}} .hlw-law-achievements__figcaption',
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-law-achievements"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-achievements__inner">
				<header class="hlw-law-achievements__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-achievements__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-achievements__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<div>
						<?php if ( ! empty( $settings['intro'] ) ) : ?>
							<p class="hlw-law-achievements__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['sample_note'] ) ) : ?>
							<p class="hlw-law-achievements__sample-note"><?php echo esc_html( $settings['sample_note'] ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<div class="hlw-law-achievements__grid">
					<?php if ( ! empty( $settings['achievement_items'] ) ) : ?>
						<div data-reveal>
							<ul class="hlw-law-achievements__list">
								<?php foreach ( $settings['achievement_items'] as $item ) : ?>
									<li class="hlw-law-achievements__item">
										<?php if ( ! empty( $item['year'] ) ) : ?>
											<span class="hlw-law-achievements__year"><?php echo esc_html( $item['year'] ); ?></span>
										<?php endif; ?>

										<div>
											<?php if ( ! empty( $item['title'] ) ) : ?>
												<h3 class="hlw-law-achievements__item-title"><?php echo esc_html( $item['title'] ); ?></h3>
											<?php endif; ?>

											<?php if ( ! empty( $item['description'] ) ) : ?>
												<p class="hlw-law-achievements__item-desc"><?php echo esc_html( $item['description'] ); ?></p>
											<?php endif; ?>
										</div>

										<?php if ( ! empty( $item['status'] ) ) : ?>
											<span class="hlw-law-achievements__status"><?php echo esc_html( $item['status'] ); ?></span>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['image']['url'] ) || ! empty( $settings['figcaption'] ) ) : ?>
						<figure class="hlw-law-achievements__figure">
							<div class="media">
								<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
									<img src="<?php echo esc_url( $settings['image']['url'] ); ?>"
										alt="<?php echo esc_attr( $settings['image_alt'] ); ?>"
										width="1200" height="800" loading="lazy" decoding="async">
								<?php endif; ?>
							</div>
							<?php if ( ! empty( $settings['figcaption'] ) ) : ?>
								<figcaption class="hlw-law-achievements__figcaption"><?php echo esc_html( $settings['figcaption'] ); ?></figcaption>
							<?php endif; ?>
						</figure>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
