<?php
/**
 * Elementor "Law Practice" widget — fully self-contained, no theme dependency.
 *
 * Practice-area grid for a lawyer or legal practice, adapted from the
 * index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Practice_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-practice';
	}

	public function get_title() {
		return __( 'Law Practice', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-law-practice-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'practice', 'areas', 'services', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-practice' ) );
	}

	/**
	 * Line icons the widget can draw, keyed by control value. All use a
	 * 24px grid and stroke currentColor.
	 *
	 * @return array<string, string>
	 */
	private static function icons() {
		return array(
			'columns'   => '<path d="M3 21h18M5 21V9m4 12V9m6 12V9m4 12V9M3 9l9-6 9 6"/>',
			'gavel'     => '<path d="m14 4 6 6M9 9l6 6M4 20l7-7M13 3l8 8-2 2-8-8 2-2ZM3 21h8"/>',
			'heart'     => '<path d="M12 21s-8-4.8-8-10a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 11c0 5.2-8 10-8 10Z"/>',
			'building'  => '<path d="M4 21V5l8-3 8 3v16M9 21v-5h6v5M8 9h.01M12 9h.01M16 9h.01M8 12.5h.01M12 12.5h.01M16 12.5h.01"/>',
			'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"/>',
			'bulb'      => '<path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-3.5 10.9c.6.5.9 1.2.9 2.1h5.2c0-.9.3-1.6.9-2.1A6 6 0 0 0 12 3Z"/>',
			'scales'    => '<path d="M12 3v18M7 21h10M5 7h14M5 7l-3 6a4 4 0 0 0 6 0L5 7Zm14 0-3 6a4 4 0 0 0 6 0l-3-6Z"/><circle cx="12" cy="3" r="1.15"/>',
			'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="1.5"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18M10 12v2h4v-2"/>',
			'document'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8Z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
			'shield'    => '<path d="M12 3 5 6v6c0 4.5 3 7.5 7 9 4-1.5 7-4.5 7-9V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>',
			'book'      => '<path d="M4 5a2 2 0 0 1 2-2h13v16H6a2 2 0 0 0-2 2V5Z"/><path d="M6 19h13"/>',
			'users'     => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13A4 4 0 0 1 16 11"/>',
		);
	}

	protected function register_controls() {
		$this->register_content_text_controls();
		$this->register_content_practice_controls();
		$this->register_content_settings_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_grid_controls();
		$this->register_style_card_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_text_controls() {
		$this->start_controls_section(
			'section_content_text',
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
				'default'     => 'interests',
				'description' => __( 'Sets this section\'s HTML id, e.g. for an "#interests" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '02 / Practice Areas', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Areas of law that shape my', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'practice.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'These are the core areas of my practice within Bangladesh’s legal system. Each one represents a body of law I work with and continue to study in depth.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_practice_controls() {
		$this->start_controls_section(
			'section_content_practice',
			array(
				'label' => __( 'Practice Areas', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Constitutional Law', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Advising and litigating on constitutional questions — how the Constitution of Bangladesh allocates power, protects fundamental rights and adapts to changing social realities.', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'heliolisk' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'columns',
				'options' => array(
					'columns'   => __( 'Columns', 'heliolisk' ),
					'gavel'     => __( 'Gavel', 'heliolisk' ),
					'heart'     => __( 'Heart', 'heliolisk' ),
					'building'  => __( 'Building', 'heliolisk' ),
					'globe'     => __( 'Globe', 'heliolisk' ),
					'bulb'      => __( 'Bulb', 'heliolisk' ),
					'scales'    => __( 'Scales', 'heliolisk' ),
					'briefcase' => __( 'Briefcase', 'heliolisk' ),
					'document'  => __( 'Document', 'heliolisk' ),
					'shield'    => __( 'Shield', 'heliolisk' ),
					'book'      => __( 'Book', 'heliolisk' ),
					'users'     => __( 'People', 'heliolisk' ),
				),
			)
		);

		$this->add_control(
			'practice_items',
			array(
				'label'       => __( 'Areas', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'       => __( 'Constitutional Law', 'heliolisk' ),
						'description' => __( 'Advising and litigating on constitutional questions — how the Constitution of Bangladesh allocates power, protects fundamental rights and adapts to changing social realities.', 'heliolisk' ),
						'icon'        => 'columns',
					),
					array(
						'title'       => __( 'Criminal Law', 'heliolisk' ),
						'description' => __( 'Fair trial, culpability and punishment under Bangladesh’s criminal justice system, with attentive representation and respect for due process.', 'heliolisk' ),
						'icon'        => 'gavel',
					),
					array(
						'title'       => __( 'Human Rights', 'heliolisk' ),
						'description' => __( 'Domestic and international frameworks that protect dignity, equality and access to justice, including strategic litigation and advocacy.', 'heliolisk' ),
						'icon'        => 'heart',
					),
					array(
						'title'       => __( 'Corporate, Labour & Commercial Law', 'heliolisk' ),
						'description' => __( 'Advising businesses, employers and institutions on governance, compliance and responsible conduct in a growing economy.', 'heliolisk' ),
						'icon'        => 'building',
					),
					array(
						'title'       => __( 'International Law', 'heliolisk' ),
						'description' => __( 'Treaties, institutions and cross-border rules that govern Bangladesh’s relations with other states and shape domestic practice.', 'heliolisk' ),
						'icon'        => 'globe',
					),
					array(
						'title'       => __( 'Intellectual Property Law', 'heliolisk' ),
						'description' => __( 'Protecting creative and brand value while balancing incentive, public access and the ownership of ideas in Bangladesh’s creative and digital economy.', 'heliolisk' ),
						'icon'        => 'bulb',
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_settings_controls() {
		$this->start_controls_section(
			'section_content_settings',
			array(
				'label' => __( 'Settings', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_numbers',
			array(
				'label'        => __( 'Show Numbers', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_icons',
			array(
				'label'        => __( 'Show Icons', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_rules',
			array(
				'label'        => __( 'Show Card Rules', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
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
					'{{WRAPPER}} .hlw-law-practice' => '--hlw-law-practice-navy: {{VALUE}}; background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice' => '--hlw-law-practice-gold: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_text_color',
			array(
				'label'     => __( 'Heading / Card Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-practice' => '--hlw-law-practice-ivory: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice' => '--hlw-law-practice-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-practice__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-practice__eyebrow',
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
					'{{WRAPPER}} .hlw-law-practice__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-practice__title',
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
					'{{WRAPPER}} .hlw-law-practice__title' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-practice__intro' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-practice__intro',
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
					'{{WRAPPER}} .hlw-law-practice__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
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
					'{{WRAPPER}} .hlw-law-practice' => '--hlw-law-practice-border: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice__item' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice__item:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-practice__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_min_height',
			array(
				'label'      => __( 'Min Height', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array( 'min' => 160, 'max' => 600 ),
					'vh' => array( 'min' => 15, 'max' => 60 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-practice__item' => 'min-height: {{SIZE}}{{UNIT}};',
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
			'card_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-practice__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .hlw-law-practice__card-title',
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
					'{{WRAPPER}} .hlw-law-practice__card-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_text_typography',
				'selector' => '{{WRAPPER}} .hlw-law-practice__card-text',
			)
		);

		$this->add_control(
			'number_color',
			array(
				'label'     => __( 'Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-practice__num' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Icon Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-practice__icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 16, 'max' => 64 ) ),
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-practice__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'rule_color',
			array(
				'label'     => __( 'Rule Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-practice__rule' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		$icons    = self::icons();
		?>
		<section class="hlw-law-practice"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-practice__inner">
				<header class="hlw-law-practice__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-practice__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-practice__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $settings['intro'] ) ) : ?>
						<p class="hlw-law-practice__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
					<?php endif; ?>
				</header>

				<?php if ( ! empty( $settings['practice_items'] ) ) : ?>
					<div class="hlw-law-practice__grid">
						<?php foreach ( $settings['practice_items'] as $index => $item ) : ?>
							<article class="hlw-law-practice__item">
								<div class="hlw-law-practice__top">
									<?php if ( 'yes' === $settings['show_numbers'] ) : ?>
										<span class="hlw-law-practice__num"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
									<?php endif; ?>

									<?php if ( 'yes' === $settings['show_icons'] && ! empty( $item['icon'] ) && ! empty( $icons[ $item['icon'] ] ) ) : ?>
										<svg class="hlw-law-practice__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<?php echo $icons[ $item['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</svg>
									<?php endif; ?>
								</div>

								<h3 class="hlw-law-practice__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
								<p class="hlw-law-practice__card-text"><?php echo esc_html( $item['description'] ); ?></p>

								<?php if ( 'yes' === $settings['show_rules'] ) : ?>
									<span class="hlw-law-practice__rule" aria-hidden="true"></span>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
