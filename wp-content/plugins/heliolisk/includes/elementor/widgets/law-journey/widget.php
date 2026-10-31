<?php
/**
 * Elementor "Law Journey" widget — fully self-contained, no theme dependency.
 *
 * Career-journey timeline section for a lawyer or legal practice, adapted
 * from the index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Journey_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-journey';
	}

	public function get_title() {
		return __( 'Law Journey', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-law-journey-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'career', 'journey', 'timeline', 'education', 'milestones', 'cv', 'resume', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-journey' ) );
	}

	protected function register_controls() {
		$this->register_content_heading_controls();
		$this->register_content_timeline_controls();
		$this->register_content_aside_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_timeline_controls();
		$this->register_style_aside_controls();
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
				'default'     => 'journey',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#journey" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'   => __( 'Eyebrow', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '03 / Career Journey', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'A practice built on', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'preparation.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'A timeline of my legal education, enrolment and the professional milestones that followed at the Dhaka Bar.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'sample_note',
			array(
				'label'   => __( 'Sample Note', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Advocate · Dhaka District Bar Association', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_timeline_controls() {
		$this->start_controls_section(
			'section_content_timeline',
			array(
				'label' => __( 'Timeline', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'date',
			array(
				'label'   => __( 'Date', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '2024 — Present', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'tag',
			array(
				'label'   => __( 'Tag', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Practice', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Advocate, Dhaka District Bar Association', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'meta',
			array(
				'label'   => __( 'Meta Line', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Independent practice · Dhaka, Bangladesh', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Representing clients in civil and constitutional matters, drafting pleadings and written submissions, and appearing before the courts in Dhaka.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'timeline_items',
			array(
				'label'       => __( 'Timeline Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'date'        => __( '2024 — Present', 'heliolisk' ),
						'tag'         => __( 'Practice', 'heliolisk' ),
						'title'       => __( 'Advocate, Dhaka District Bar Association', 'heliolisk' ),
						'meta'        => __( 'Independent practice · Dhaka, Bangladesh', 'heliolisk' ),
						'description' => __( 'Representing clients in civil and constitutional matters, drafting pleadings and written submissions, and appearing before the courts in Dhaka.', 'heliolisk' ),
					),
					array(
						'date'        => __( '2024', 'heliolisk' ),
						'tag'         => __( 'Enrolment', 'heliolisk' ),
						'title'       => __( 'Enrolment as Advocate', 'heliolisk' ),
						'meta'        => __( 'Bangladesh Bar Council', 'heliolisk' ),
						'description' => __( 'Completed the enrolment process and began practice under the guidance of senior counsel at the Dhaka Bar.', 'heliolisk' ),
					),
					array(
						'date'        => __( '2023', 'heliolisk' ),
						'tag'         => __( 'Advocacy training', 'heliolisk' ),
						'title'       => __( 'Moot Court & Advocacy Training', 'heliolisk' ),
						'meta'        => __( 'DIU Moot Court Society', 'heliolisk' ),
						'description' => __( 'Prepared written submissions and delivered oral arguments on constitutional law problems; now mentors junior colleagues in advocacy and legal writing.', 'heliolisk' ),
					),
					array(
						'date'        => __( '2023', 'heliolisk' ),
						'tag'         => __( 'Research training', 'heliolisk' ),
						'title'       => __( 'Legal Research Workshop', 'heliolisk' ),
						'meta'        => __( 'Faculty workshop · Dhaka International University', 'heliolisk' ),
						'description' => __( 'Workshop on primary-source research, citation practice and building a transparent research trail using Bangla and English legal materials.', 'heliolisk' ),
					),
					array(
						'date'        => __( '2019 — 2023', 'heliolisk' ),
						'tag'         => __( 'Education', 'heliolisk' ),
						'title'       => __( 'LL.B. (Honours)', 'heliolisk' ),
						'meta'        => __( 'Dhaka International University · Department of Law', 'heliolisk' ),
						'description' => __( 'Core study in constitutional law, criminal law, legal method, the law of contract and obligations, with a developing focus on human rights and public law in Bangladesh.', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_aside_controls() {
		$this->start_controls_section(
			'section_content_aside',
			array(
				'label' => __( 'Aside Card', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'aside_heading',
			array(
				'label'   => __( 'Card Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Areas of practice', 'heliolisk' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tag_text',
			array(
				'label'   => __( 'Tag', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Constitutional Law', 'heliolisk' ),
			)
		);

		$this->add_control(
			'aside_tags',
			array(
				'label'       => __( 'Tags', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'tag_text' => __( 'Constitutional Law', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Civil Litigation', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Criminal Law', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Human Rights', 'heliolisk' ) ),
					array( 'tag_text' => __( 'Corporate & Commercial Law', 'heliolisk' ) ),
					array( 'tag_text' => __( 'International Law', 'heliolisk' ) ),
				),
				'title_field' => '{{{ tag_text }}}',
			)
		);

		$this->add_control(
			'aside_note',
			array(
				'label'     => __( 'Aside Note', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Practice areas are representative and can be tailored to your chambers or firm profile.', 'heliolisk' ),
				'separator' => 'before',
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
					'{{WRAPPER}} .hlw-law-journey' => '--hlw-law-journey-paper: {{VALUE}}; background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-journey' => '--hlw-law-journey-ink: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-journey' => '--hlw-law-journey-gold: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-journey' => '--hlw-law-journey-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-journey' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-journey__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__eyebrow',
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
					'{{WRAPPER}} .hlw-law-journey__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-journey__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__title',
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
					'{{WRAPPER}} .hlw-law-journey__title' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-journey__intro' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-journey__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__intro',
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
					'{{WRAPPER}} .hlw-law-journey__sample-note' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sample_note_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__sample-note',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_timeline_controls() {
		$this->start_controls_section(
			'section_style_timeline',
			array(
				'label' => __( 'Timeline', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'timeline_line_color',
			array(
				'label'     => __( 'Line Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(16,26,43,0.14)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__timeline::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .hlw-law-journey__tl-item'         => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_dot_color',
			array(
				'label'     => __( 'Dot Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-item::before' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_dot_hover_color',
			array(
				'label'     => __( 'Dot Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-item:hover::before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_date_color',
			array(
				'label'     => __( 'Date Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-date' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_tag_color',
			array(
				'label'     => __( 'Tag Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-tag' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'timeline_title_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__tl-title',
			)
		);

		$this->add_control(
			'timeline_meta_color',
			array(
				'label'     => __( 'Meta Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-meta' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_desc_color',
			array(
				'label'     => __( 'Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tl-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_aside_controls() {
		$this->start_controls_section(
			'section_style_aside',
			array(
				'label' => __( 'Aside Card', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_border_color',
			array(
				'label'     => __( 'Card Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(16,26,43,0.14)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__card' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => __( 'Card Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.34)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_heading_color',
			array(
				'label'     => __( 'Card Heading Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__card-title',
			)
		);

		$this->add_control(
			'tag_border_color',
			array(
				'label'     => __( 'Tag Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(16,26,43,0.14)',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tag' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tag_text_color',
			array(
				'label'     => __( 'Tag Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__tag' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tag_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__tag',
			)
		);

		$this->add_control(
			'aside_note_color',
			array(
				'label'     => __( 'Aside Note Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-journey__aside-note' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'aside_note_typography',
				'selector' => '{{WRAPPER}} .hlw-law-journey__aside-note',
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-law-journey"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-journey__inner">
				<header class="hlw-law-journey__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-journey__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-journey__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<div>
						<?php if ( ! empty( $settings['intro'] ) ) : ?>
							<p class="hlw-law-journey__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['sample_note'] ) ) : ?>
							<p class="hlw-law-journey__sample-note"><?php echo esc_html( $settings['sample_note'] ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<div class="hlw-law-journey__grid">
					<?php if ( ! empty( $settings['timeline_items'] ) ) : ?>
						<ol class="hlw-law-journey__timeline">
							<?php foreach ( $settings['timeline_items'] as $item ) : ?>
								<li class="hlw-law-journey__tl-item">
									<?php if ( ! empty( $item['date'] ) ) : ?>
										<span class="hlw-law-journey__tl-date"><?php echo esc_html( $item['date'] ); ?></span>
									<?php endif; ?>

									<div class="hlw-law-journey__tl-content">
										<?php if ( ! empty( $item['tag'] ) ) : ?>
											<span class="hlw-law-journey__tl-tag"><?php echo esc_html( $item['tag'] ); ?></span>
										<?php endif; ?>

										<?php if ( ! empty( $item['title'] ) ) : ?>
											<h3 class="hlw-law-journey__tl-title"><?php echo esc_html( $item['title'] ); ?></h3>
										<?php endif; ?>

										<?php if ( ! empty( $item['meta'] ) ) : ?>
											<p class="hlw-law-journey__tl-meta"><?php echo esc_html( $item['meta'] ); ?></p>
										<?php endif; ?>

										<?php if ( ! empty( $item['description'] ) ) : ?>
											<p class="hlw-law-journey__tl-desc"><?php echo nl2br( esc_html( $item['description'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
										<?php endif; ?>
									</div>
								</li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>

					<?php if ( ! empty( $settings['aside_heading'] ) || ! empty( $settings['aside_tags'] ) || ! empty( $settings['aside_note'] ) ) : ?>
						<aside class="hlw-law-journey__aside">
							<?php if ( ! empty( $settings['aside_heading'] ) || ! empty( $settings['aside_tags'] ) ) : ?>
								<div class="hlw-law-journey__card">
									<?php if ( ! empty( $settings['aside_heading'] ) ) : ?>
										<h3 class="hlw-law-journey__card-title"><?php echo esc_html( $settings['aside_heading'] ); ?></h3>
									<?php endif; ?>

									<?php if ( ! empty( $settings['aside_tags'] ) ) : ?>
										<ul class="hlw-law-journey__tags">
											<?php foreach ( $settings['aside_tags'] as $tag ) : ?>
												<li class="hlw-law-journey__tag"><?php echo esc_html( $tag['tag_text'] ); ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $settings['aside_note'] ) ) : ?>
								<p class="hlw-law-journey__aside-note"><?php echo esc_html( $settings['aside_note'] ); ?></p>
							<?php endif; ?>
						</aside>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
