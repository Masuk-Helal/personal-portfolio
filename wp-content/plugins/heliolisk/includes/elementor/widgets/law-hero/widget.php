<?php
/**
 * Elementor "Law Hero" widget — fully self-contained, no theme dependency.
 *
 * Editorial hero for a lawyer or legal practice, adapted from the
 * index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Hero_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-hero';
	}

	public function get_title() {
		return __( 'Law Hero', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-law-hero-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'hero', 'banner', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-hero' ) );
	}

	protected function register_controls() {
		$this->register_content_text_controls();
		$this->register_content_button_controls();
		$this->register_content_facts_controls();
		$this->register_content_portrait_controls();
		$this->register_content_decor_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_description_controls();
		$this->register_style_button_controls();
		$this->register_style_facts_controls();
		$this->register_style_portrait_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_text_controls() {
		$this->start_controls_section(
			'section_content_text',
			array(
				'label' => __( 'Text', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_id',
			array(
				'label'       => __( 'Section ID', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'top',
				'description' => __( 'Sets this section\'s HTML id, e.g. for a "#top" nav link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow_left',
			array(
				'label'     => __( 'Eyebrow — Left', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Advocate', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'eyebrow_right',
			array(
				'label'   => __( 'Eyebrow — Right', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Dhaka, Bangladesh', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow_separator',
			array(
				'label'        => __( 'Show Eyebrow Separator', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'heading_line_1',
			array(
				'label'     => __( 'Heading — Line 1', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Pursuing Justice', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading_line_2',
			array(
				'label'   => __( 'Heading — Line 2', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Through', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_line_2_accent',
			array(
				'label'   => __( 'Heading — Line 2 Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Knowledge,', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_line_3',
			array(
				'label'   => __( 'Heading — Line 3', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Research &', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_line_3_accent',
			array(
				'label'   => __( 'Heading — Line 3 Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Advocacy.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'     => __( 'Description', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'I am an advocate practising in Dhaka, Bangladesh, with a focus on constitutional law, human rights and civil litigation. My work brings together rigorous legal research, clear advocacy and a commitment to making institutions answer fairly.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_button_controls() {
		$this->start_controls_section(
			'section_content_buttons',
			array(
				'label' => __( 'Buttons', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'primary_button_text',
			array(
				'label'   => __( 'Primary Button Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Explore My Profile', 'heliolisk' ),
			)
		);

		$this->add_control(
			'primary_button_link',
			array(
				'label'         => __( 'Primary Button Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '#about' ),
				'show_external' => false,
			)
		);

		$this->add_control(
			'primary_button_icon',
			array(
				'label'        => __( 'Show Arrow Icon', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'secondary_button_text',
			array(
				'label'     => __( 'Secondary Button Text', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Get in Touch', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'secondary_button_link',
			array(
				'label'         => __( 'Secondary Button Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '#contact' ),
				'show_external' => false,
			)
		);

		$this->add_control(
			'secondary_button_icon',
			array(
				'label'        => __( 'Show Arrow Icon', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_facts_controls() {
		$this->start_controls_section(
			'section_content_facts',
			array(
				'label' => __( 'Facts', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Bar', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'value',
			array(
				'label'   => __( 'Value', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Dhaka District Bar Association', 'heliolisk' ),
			)
		);

		$this->add_control(
			'facts',
			array(
				'label'       => __( 'Fact Blocks', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'label' => __( 'Bar', 'heliolisk' ),
						'value' => __( 'Dhaka District Bar Association', 'heliolisk' ),
					),
					array(
						'label' => __( 'Enrolment', 'heliolisk' ),
						'value' => __( 'Advocate · Bangladesh Bar Council', 'heliolisk' ),
					),
					array(
						'label' => __( 'Focus', 'heliolisk' ),
						'value' => __( 'Constitutional, Civil & Human Rights Law', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ label }}}: {{{ value }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_portrait_controls() {
		$this->start_controls_section(
			'section_content_portrait',
			array(
				'label' => __( 'Portrait', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => __( 'Portrait Image', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-hero/assets/images/portrait.jpg',
				),
			)
		);

		$this->add_control(
			'image_alt',
			array(
				'label'       => __( 'Image Alt Text', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Portrait of an advocate in Dhaka, Bangladesh', 'heliolisk' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'show_seal',
			array(
				'label'        => __( 'Show Seal', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'seal_line_1',
			array(
				'label'     => __( 'Seal — Line 1', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Advocate', 'heliolisk' ),
				'condition' => array( 'show_seal' => 'yes' ),
			)
		);

		$this->add_control(
			'seal_line_2',
			array(
				'label'     => __( 'Seal — Line 2', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Dhaka', 'heliolisk' ),
				'condition' => array( 'show_seal' => 'yes' ),
			)
		);

		$this->add_control(
			'caption_label',
			array(
				'label'     => __( 'Caption Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Current focus', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'caption_text',
			array(
				'label'   => __( 'Caption Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Constitutional law, human rights & civil litigation in Bangladesh', 'heliolisk' ),
			)
		);

		$this->add_control(
			'show_scroll',
			array(
				'label'        => __( 'Show Scroll Link', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'scroll_text',
			array(
				'label'     => __( 'Scroll Link Text', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Scroll to explore', 'heliolisk' ),
				'condition' => array( 'show_scroll' => 'yes' ),
			)
		);

		$this->add_control(
			'scroll_link',
			array(
				'label'         => __( 'Scroll Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '#about' ),
				'show_external' => false,
				'condition'     => array( 'show_scroll' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_decor_controls() {
		$this->start_controls_section(
			'section_content_decor',
			array(
				'label' => __( 'Decoration', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_grid_lines',
			array(
				'label'        => __( 'Show Grid Lines', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_glyph',
			array(
				'label'        => __( 'Show Section Glyph', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_scales',
			array(
				'label'        => __( 'Show Scales Illustration', 'heliolisk' ),
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
					'{{WRAPPER}} .hlw-law-hero' => '--hlw-law-navy: {{VALUE}}; background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-hero' => '--hlw-law-gold: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-hero' => '--hlw-law-ivory: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-hero' => '--hlw-law-muted: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_min_height',
			array(
				'label'      => __( 'Min Height', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array( 'min' => 300, 'max' => 1400 ),
					'vh' => array( 'min' => 40, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => 'vh',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-hero' => 'min-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-hero__eyebrow' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hlw-law-hero__eyebrow::before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-hero__eyebrow',
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
					'{{WRAPPER}} .hlw-law-hero__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-hero__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-hero__title',
			)
		);

		$this->add_responsive_control(
			'heading_max_width',
			array(
				'label'      => __( 'Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 320, 'max' => 1000 ),
					'%'  => array( 'min' => 30, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-hero__title' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_description_controls() {
		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => __( 'Description', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__lead' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'description_max_width',
			array(
				'label'      => __( 'Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 240, 'max' => 900 ),
					'%'  => array( 'min' => 20, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-hero__lead' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .hlw-law-hero__lead',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_button_controls() {
		$this->start_controls_section(
			'section_style_buttons',
			array(
				'label' => __( 'Buttons', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_primary_button',
			array(
				'label' => __( 'Primary Button', 'heliolisk' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'primary_button_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__btn--primary' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'primary_button_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__btn--primary' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => __( 'Hover Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#D9BE8B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__btn--primary:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_secondary_button',
			array(
				'label'     => __( 'Secondary Button', 'heliolisk' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'secondary_button_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__btn--ghost' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'secondary_button_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(245,241,232,0.26)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__btn--ghost' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'secondary_button_hover_color',
			array(
				'label'     => __( 'Hover Text / Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__btn--ghost:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-hero__btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'buttons_typography',
				'selector' => '{{WRAPPER}} .hlw-law-hero__btn',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_facts_controls() {
		$this->start_controls_section(
			'section_style_facts',
			array(
				'label' => __( 'Facts', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'fact_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__facts dt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fact_label_typography',
				'selector' => '{{WRAPPER}} .hlw-law-hero__facts dt',
			)
		);

		$this->add_control(
			'fact_value_color',
			array(
				'label'     => __( 'Value Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__facts dd' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fact_value_typography',
				'selector' => '{{WRAPPER}} .hlw-law-hero__facts dd',
			)
		);

		$this->add_responsive_control(
			'facts_gap',
			array(
				'label'      => __( 'Gap Between Facts', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-hero__facts' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_portrait_controls() {
		$this->start_controls_section(
			'section_style_portrait',
			array(
				'label' => __( 'Portrait', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'portrait_frame_color',
			array(
				'label'     => __( 'Frame Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(198,165,104,0.32)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__frame' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'portrait_width',
			array(
				'label'      => __( 'Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 220, 'max' => 700 ),
					'%'  => array( 'min' => 30, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 430,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-hero__visual' => 'width: min(100%, {{SIZE}}{{UNIT}});',
				),
			)
		);

		$this->add_control(
			'caption_bg_color',
			array(
				'label'     => __( 'Caption Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(11,19,32,0.93)',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__caption' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'caption_text_color',
			array(
				'label'     => __( 'Caption Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__caption strong' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'seal_bg_color',
			array(
				'label'     => __( 'Seal Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__seal' => 'background-color: {{VALUE}}; box-shadow: 0 0 0 6px {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'seal_text_color',
			array(
				'label'     => __( 'Seal Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-hero__seal' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$image_url = ! empty( $settings['image']['url'] ) ? $settings['image']['url'] : '';

		$arrows = array(
			'down' => '<svg class="hlw-law-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4v16m-6-6 6 6 6-6"/></svg>',
			'up'   => '<svg class="hlw-law-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg>',
		);
		?>
		<section class="hlw-law-hero"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<?php if ( 'yes' === $settings['show_grid_lines'] ) : ?>
				<div class="hlw-law-hero__grid-lines" aria-hidden="true"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_glyph'] ) : ?>
				<span class="hlw-law-hero__glyph" aria-hidden="true">&sect;</span>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_scales'] ) : ?>
				<svg class="hlw-law-hero__scales" viewBox="0 0 200 200" aria-hidden="true">
					<g fill="none" stroke="currentColor" stroke-width="0.9" stroke-linecap="round" stroke-linejoin="round">
						<path d="M100 28v140M70 168h60M36 76h128M36 76 12 128a30 30 0 0 0 48 0L36 76Zm128 0-24 52a30 30 0 0 0 48 0l-24-52Z"/>
						<circle cx="100" cy="28" r="5"/>
					</g>
				</svg>
			<?php endif; ?>

			<div class="hlw-law-hero__inner">
				<div class="hlw-law-hero__grid">
					<div class="hlw-law-hero__copy">
						<?php if ( ! empty( $settings['eyebrow_left'] ) || ! empty( $settings['eyebrow_right'] ) ) : ?>
							<p class="hlw-law-hero__eyebrow hlw-law-hero__reveal" style="--d: 0.12s">
								<?php if ( ! empty( $settings['eyebrow_left'] ) ) : ?>
									<span><?php echo esc_html( $settings['eyebrow_left'] ); ?></span>
								<?php endif; ?>
								<?php if ( 'yes' === $settings['eyebrow_separator'] && ! empty( $settings['eyebrow_left'] ) && ! empty( $settings['eyebrow_right'] ) ) : ?>
									<span class="hlw-law-hero__eyebrow-sep" aria-hidden="true">|</span>
								<?php endif; ?>
								<?php if ( ! empty( $settings['eyebrow_right'] ) ) : ?>
									<span><?php echo esc_html( $settings['eyebrow_right'] ); ?></span>
								<?php endif; ?>
							</p>
						<?php endif; ?>

						<?php
						$has_heading = ! empty( $settings['heading_line_1'] )
							|| ! empty( $settings['heading_line_2'] )
							|| ! empty( $settings['heading_line_2_accent'] )
							|| ! empty( $settings['heading_line_3'] )
							|| ! empty( $settings['heading_line_3_accent'] );
						?>
						<?php if ( $has_heading ) : ?>
							<h1 class="hlw-law-hero__title">
								<?php if ( ! empty( $settings['heading_line_1'] ) ) : ?>
									<span class="hlw-law-hero__title-line"><span style="--d: 0.22s"><?php echo esc_html( $settings['heading_line_1'] ); ?></span></span>
								<?php endif; ?>

								<?php if ( ! empty( $settings['heading_line_2'] ) || ! empty( $settings['heading_line_2_accent'] ) ) : ?>
									<span class="hlw-law-hero__title-line">
										<span style="--d: 0.33s">
											<?php echo esc_html( $settings['heading_line_2'] ); ?>
											<?php if ( ! empty( $settings['heading_line_2_accent'] ) ) : ?>
												<em><?php echo esc_html( $settings['heading_line_2_accent'] ); ?></em>
											<?php endif; ?>
										</span>
									</span>
								<?php endif; ?>

								<?php if ( ! empty( $settings['heading_line_3'] ) || ! empty( $settings['heading_line_3_accent'] ) ) : ?>
									<span class="hlw-law-hero__title-line">
										<span style="--d: 0.44s">
											<?php echo esc_html( $settings['heading_line_3'] ); ?>
											<?php if ( ! empty( $settings['heading_line_3_accent'] ) ) : ?>
												<em><?php echo esc_html( $settings['heading_line_3_accent'] ); ?></em>
											<?php endif; ?>
										</span>
									</span>
								<?php endif; ?>
							</h1>
						<?php endif; ?>

						<?php if ( ! empty( $settings['description'] ) ) : ?>
							<p class="hlw-law-hero__lead hlw-law-hero__reveal" style="--d: 0.58s"><?php echo esc_html( $settings['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['primary_button_text'] ) || ! empty( $settings['secondary_button_text'] ) ) : ?>
							<div class="hlw-law-hero__actions hlw-law-hero__reveal" style="--d: 0.72s">
								<?php if ( ! empty( $settings['primary_button_text'] ) ) :
									$primary_url = ! empty( $settings['primary_button_link']['url'] ) ? $settings['primary_button_link']['url'] : '#';
									?>
									<a href="<?php echo esc_url( $primary_url ); ?>" class="hlw-law-hero__btn hlw-law-hero__btn--primary">
										<?php echo esc_html( $settings['primary_button_text'] ); ?>
										<?php if ( 'yes' === $settings['primary_button_icon'] ) {
											echo $arrows['down']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										} ?>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $settings['secondary_button_text'] ) ) :
									$secondary_url = ! empty( $settings['secondary_button_link']['url'] ) ? $settings['secondary_button_link']['url'] : '#';
									?>
									<a href="<?php echo esc_url( $secondary_url ); ?>" class="hlw-law-hero__btn hlw-law-hero__btn--ghost">
										<?php echo esc_html( $settings['secondary_button_text'] ); ?>
										<?php if ( 'yes' === $settings['secondary_button_icon'] ) {
											echo $arrows['up']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										} ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['facts'] ) ) : ?>
							<dl class="hlw-law-hero__facts hlw-law-hero__reveal" style="--d: 0.84s">
								<?php foreach ( $settings['facts'] as $fact ) : ?>
									<div>
										<dt><?php echo esc_html( $fact['label'] ); ?></dt>
										<dd><?php echo esc_html( $fact['value'] ); ?></dd>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>
					</div>

					<?php if ( $image_url || 'yes' === $settings['show_seal'] || ! empty( $settings['caption_text'] ) ) : ?>
						<div class="hlw-law-hero__visual">
							<div class="hlw-law-hero__frame">
								<?php if ( $image_url ) : ?>
									<div class="hlw-law-hero__image">
										<img src="<?php echo esc_url( $image_url ); ?>"
											alt="<?php echo esc_attr( $settings['image_alt'] ); ?>"
											width="1000" height="1500" fetchpriority="high" decoding="async">
									</div>
								<?php endif; ?>

								<?php if ( 'yes' === $settings['show_seal'] && ( ! empty( $settings['seal_line_1'] ) || ! empty( $settings['seal_line_2'] ) ) ) : ?>
									<div class="hlw-law-hero__seal" aria-hidden="true">
										<?php echo esc_html( $settings['seal_line_1'] ); ?><br><?php echo esc_html( $settings['seal_line_2'] ); ?>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $settings['caption_label'] ) || ! empty( $settings['caption_text'] ) ) : ?>
									<div class="hlw-law-hero__caption">
										<?php if ( ! empty( $settings['caption_label'] ) ) : ?>
											<small><?php echo esc_html( $settings['caption_label'] ); ?></small>
										<?php endif; ?>
										<?php if ( ! empty( $settings['caption_text'] ) ) : ?>
											<strong><?php echo esc_html( $settings['caption_text'] ); ?></strong>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( 'yes' === $settings['show_scroll'] && ! empty( $settings['scroll_text'] ) ) :
				$scroll_url = ! empty( $settings['scroll_link']['url'] ) ? $settings['scroll_link']['url'] : '#about';
				?>
				<a class="hlw-law-hero__scroll" href="<?php echo esc_url( $scroll_url ); ?>"><?php echo esc_html( $settings['scroll_text'] ); ?></a>
			<?php endif; ?>
		</section>
		<?php
	}
}
