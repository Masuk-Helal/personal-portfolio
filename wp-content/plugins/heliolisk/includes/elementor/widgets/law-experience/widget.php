<?php
/**
 * Elementor "Law Experience" widget — fully self-contained, no theme dependency.
 *
 * Experience & activities card grid for a lawyer or legal practice, adapted
 * from the index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Experience_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-experience';
	}

	public function get_title() {
		return __( 'Law Experience', 'heliolisk' );
	}

	public function get_icon() {
		return 'hlw-law-experience-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'experience', 'activities', 'practice', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-experience' ) );
	}

	protected function register_controls() {
		$this->register_content_heading_controls();
		$this->register_content_experience_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_grid_controls();
		$this->register_style_card_controls();
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
				'default'     => 'experience',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#experience" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '04 / Experience & Practice', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Advocacy beyond the', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'courtroom.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Court appearances, legal aid, research and public speaking form the practical side of my legal practice in Dhaka.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'sample_note',
			array(
				'label'   => __( 'Sample Note', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Professional experience · Dhaka, Bangladesh', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_experience_controls() {
		$this->start_controls_section(
			'section_content_experience',
			array(
				'label' => __( 'Experience Cards', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => __( 'Media Image', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/courthouse.webp',
				),
			)
		);

		$repeater->add_control(
			'image_alt',
			array(
				'label'       => __( 'Image Alt Text', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Facade of a neoclassical courthouse with tall columns', 'heliolisk' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'meta_tag',
			array(
				'label'   => __( 'Meta Tag', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Litigation', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'meta_date',
			array(
				'label'   => __( 'Meta Date', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '2024 — Present', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Court Appearances & Pleadings', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'org',
			array(
				'label'   => __( 'Organization', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Dhaka District Bar Association', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Drafting plaints, written statements and submissions, and appearing in civil and constitutional matters under senior counsel.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'experience_items',
			array(
				'label'       => __( 'Cards', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'image'      => array( 'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/courthouse.webp' ),
						'image_alt'  => __( 'Facade of a neoclassical courthouse with tall columns', 'heliolisk' ),
						'meta_tag'   => __( 'Litigation', 'heliolisk' ),
						'meta_date'  => __( '2024 — Present', 'heliolisk' ),
						'title'      => __( 'Court Appearances & Pleadings', 'heliolisk' ),
						'org'        => __( 'Dhaka District Bar Association', 'heliolisk' ),
						'description'=> __( 'Drafting plaints, written statements and submissions, and appearing in civil and constitutional matters under senior counsel.', 'heliolisk' ),
					),
					array(
						'image'      => array( 'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/campus.webp' ),
						'image_alt'  => __( 'Legal campus building framed by lawns and trees', 'heliolisk' ),
						'meta_tag'   => __( 'Advocacy', 'heliolisk' ),
						'meta_date'  => __( '2024', 'heliolisk' ),
						'title'      => __( 'Public Speaking & Advocacy', 'heliolisk' ),
						'org'        => __( 'Dhaka Bar Association', 'heliolisk' ),
						'description'=> __( 'Took part in structured debates and policy discussions, building confidence in argument, rebuttal and persuasive public speaking.', 'heliolisk' ),
					),
					array(
						'image'      => array( 'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/reading-room.webp' ),
						'image_alt'  => __( 'Historic library reading room lined with busts and law books', 'heliolisk' ),
						'meta_tag'   => __( 'Pro bono', 'heliolisk' ),
						'meta_date'  => __( '2025', 'heliolisk' ),
						'title'      => __( 'Pro Bono Legal Aid', 'heliolisk' ),
						'org'        => __( 'Community legal aid clinic · Dhaka', 'heliolisk' ),
						'description'=> __( 'Providing intake support, legal research and plain-language advice to clients who cannot afford representation.', 'heliolisk' ),
					),
					array(
						'image'      => array( 'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/aisle.webp' ),
						'image_alt'  => __( 'Rows of bookshelves in a warmly lit law library', 'heliolisk' ),
						'meta_tag'   => __( 'Research', 'heliolisk' ),
						'meta_date'  => __( '2025', 'heliolisk' ),
						'title'      => __( 'Legal Research & Drafting', 'heliolisk' ),
						'org'        => __( 'Chambers of Rahmat Ullah · Dhaka', 'heliolisk' ),
						'description'=> __( 'Preparing research memos, case notes and written submissions on public law topics in Bangladesh.', 'heliolisk' ),
					),
					array(
						'image'      => array( 'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/graduation.webp' ),
						'image_alt'  => __( 'Colleagues at a legal community event on campus', 'heliolisk' ),
						'meta_tag'   => __( 'Community', 'heliolisk' ),
						'meta_date'  => __( '2024 — Present', 'heliolisk' ),
						'title'      => __( 'Bar Association & Community', 'heliolisk' ),
						'org'        => __( 'Dhaka District Bar Association', 'heliolisk' ),
						'description'=> __( 'Participating in bar events, peer discussions and professional development, including law-day programmes and career sessions.', 'heliolisk' ),
					),
					array(
						'image'      => array( 'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-experience/assets/images/workshop.webp' ),
						'image_alt'  => __( 'Lawyers collaborating around a table during a workshop', 'heliolisk' ),
						'meta_tag'   => __( 'Workshops', 'heliolisk' ),
						'meta_date'  => __( '2025', 'heliolisk' ),
						'title'      => __( 'Continuing Legal Education', 'heliolisk' ),
						'org'        => __( 'Professional seminar series · Dhaka', 'heliolisk' ),
						'description'=> __( 'Attending sessions on advocacy, legal research and emerging areas of Bangladeshi law, including constitutional and human-rights topics.', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ title }}}',
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
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience' => '--hlw-law-experience-navy: {{VALUE}}; background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience' => '--hlw-law-experience-gold: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience' => '--hlw-law-experience-ivory: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_muted_color',
			array(
				'label'     => __( 'Muted Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience' => '--hlw-law-experience-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-experience' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__eyebrow',
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
				'default'   => '#F5F1E8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__title',
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
					'{{WRAPPER}} .hlw-law-experience__title' => 'max-width: {{SIZE}}{{UNIT}};',
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
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__intro' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-experience__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__intro',
			)
		);

		$this->add_control(
			'sample_note_color',
			array(
				'label'     => __( 'Sample Note Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__sample-note' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sample_note_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__sample-note',
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
				'label'     => __( 'Columns', 'heliolisk' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				),
			)
		);

		$this->add_control(
			'grid_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(198,165,104,0.18)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience' => '--hlw-law-experience-border: {{VALUE}};',
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
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_hover_bg_color',
			array(
				'label'     => __( 'Hover Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(198,165,104,0.045)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__card:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => __( 'Padding', 'heliolisk' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-experience__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_heading',
			array(
				'label'     => __( 'Card Content', 'heliolisk' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => __( 'Meta Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__meta' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__meta',
			)
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__title',
			)
		);

		$this->add_control(
			'org_color',
			array(
				'label'     => __( 'Organization Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__org' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'org_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__org',
			)
		);

		$this->add_control(
			'card_text_color',
			array(
				'label'     => __( 'Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_text_typography',
				'selector' => '{{WRAPPER}} .hlw-law-experience__desc',
			)
		);

		$this->add_control(
			'media_frame_color',
			array(
				'label'     => __( 'Frame Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(16,26,43,0.14)',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-experience__media-frame' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-law-experience"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-experience__inner">
				<header class="hlw-law-experience__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-experience__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-experience__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<div>
						<?php if ( ! empty( $settings['intro'] ) ) : ?>
							<p class="hlw-law-experience__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['sample_note'] ) ) : ?>
							<p class="hlw-law-experience__sample-note"><?php echo esc_html( $settings['sample_note'] ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<?php if ( ! empty( $settings['experience_items'] ) ) : ?>
					<div class="hlw-law-experience__grid">
						<?php foreach ( $settings['experience_items'] as $item ) : ?>
							<article class="hlw-law-experience__card">
								<div class="hlw-law-experience__media">
									<div class="hlw-law-experience__media-frame">
										<?php if ( ! empty( $item['image']['url'] ) ) : ?>
											<img src="<?php echo esc_url( $item['image']['url'] ); ?>"
												alt="<?php echo esc_attr( $item['image_alt'] ); ?>"
												width="1200" height="800" loading="lazy" decoding="async">
										<?php endif; ?>
									</div>
								</div>

								<div class="hlw-law-experience__body">
									<div class="hlw-law-experience__meta">
										<?php if ( ! empty( $item['meta_tag'] ) ) : ?>
											<span class="hlw-law-experience__meta-tag"><?php echo esc_html( $item['meta_tag'] ); ?></span>
										<?php endif; ?>
										<?php if ( ! empty( $item['meta_date'] ) ) : ?>
											<span class="hlw-law-experience__meta-date"><?php echo esc_html( $item['meta_date'] ); ?></span>
										<?php endif; ?>
									</div>

									<?php if ( ! empty( $item['title'] ) ) : ?>
										<h3 class="hlw-law-experience__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
									<?php endif; ?>

									<?php if ( ! empty( $item['org'] ) ) : ?>
										<p class="hlw-law-experience__org"><?php echo esc_html( $item['org'] ); ?></p>
									<?php endif; ?>

									<?php if ( ! empty( $item['description'] ) ) : ?>
										<p class="hlw-law-experience__desc"><?php echo nl2br( esc_html( $item['description'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
