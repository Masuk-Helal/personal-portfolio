<?php
/**
 * Elementor "Hero" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

class Heliolisk_Hero_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-hero';
	}

	public function get_title() {
		return __( 'Hero', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()), since
		// Elementor's widget-list icon only accepts a font/glyph class,
		// not an arbitrary image.
		return 'hlw-hero-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'hero', 'header', 'banner', 'intro' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'hero' ) );
	}

	public function get_script_depends() {
		return array( Heliolisk_Elementor::script_handle( 'hero' ) );
	}

	protected function register_controls() {
		$this->register_content_text_controls();
		$this->register_content_button_controls();
		$this->register_content_background_controls();
		$this->register_content_stats_controls();
		$this->register_content_advanced_controls();

		$this->register_style_section_controls();
		$this->register_style_kicker_controls();
		$this->register_style_role_controls();
		$this->register_style_heading_controls();
		$this->register_style_description_controls();
		$this->register_style_button_controls();
		$this->register_style_stats_controls();
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
			'kicker_text',
			array(
				'label'   => __( 'Kicker', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'S.M. REFAT AREFIN', 'heliolisk' ),
			)
		);

		$this->add_control(
			'kicker_dot',
			array(
				'label'        => __( 'Show Kicker Dot', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'heliolisk' ),
				'label_off'    => __( 'Hide', 'heliolisk' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'role_text',
			array(
				'label'   => __( 'Role Line', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Business Analytics · Operations · Technology · Marketing', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_line_1',
			array(
				'label'   => __( 'Heading — Line 1', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'I TURN', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_line_2',
			array(
				'label'   => __( 'Heading — Line 2', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'COMPLEXITY', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_line_3',
			array(
				'label'   => __( 'Heading — Line 3', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'INTO', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent Word', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'SYSTEMS.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Business Analytics student and EdTech operations professional working at the intersection of data, operations, technology and digital content.', 'heliolisk' ),
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
				'default' => __( 'View My Work', 'heliolisk' ),
			)
		);

		$this->add_control(
			'primary_button_link',
			array(
				'label'       => __( 'Primary Button Link', 'heliolisk' ),
				'type'        => Controls_Manager::URL,
				'default'     => array( 'url' => '#' ),
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
				'default'   => __( 'About Me', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'secondary_button_link',
			array(
				'label'       => __( 'Secondary Button Link', 'heliolisk' ),
				'type'        => Controls_Manager::URL,
				'default'     => array( 'url' => '#' ),
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

	private function register_content_background_controls() {
		$this->start_controls_section(
			'section_content_background',
			array(
				'label' => __( 'Background', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'background_image',
			array(
				'label'   => __( 'Background Image', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => '' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_stats_controls() {
		$this->start_controls_section(
			'section_content_stats',
			array(
				'label' => __( 'Stats', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'value',
			array(
				'label'   => __( 'Value', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '3.6+', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Years Professional Experience', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'enable_count',
			array(
				'label'        => __( 'Animate Count-Up', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
			)
		);

		$repeater->add_control(
			'count_number',
			array(
				'label'     => __( 'Count To', 'heliolisk' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array( 'enable_count' => 'yes' ),
			)
		);

		$repeater->add_control(
			'count_decimals',
			array(
				'label'     => __( 'Decimal Places', 'heliolisk' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'max'       => 2,
				'condition' => array( 'enable_count' => 'yes' ),
			)
		);

		$repeater->add_control(
			'count_suffix',
			array(
				'label'     => __( 'Suffix', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array( 'enable_count' => 'yes' ),
			)
		);

		$this->add_control(
			'stats',
			array(
				'label'       => __( 'Stat Blocks', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'value'         => '3.6+',
						'label'         => __( 'Years Professional Experience', 'heliolisk' ),
						'enable_count'  => 'yes',
						'count_number'  => 3.6,
						'count_decimals'=> 1,
						'count_suffix'  => '+',
					),
					array(
						'value' => 'BBA',
						'label' => __( 'Business Analytics', 'heliolisk' ),
					),
					array(
						'value'         => '02',
						'label'         => __( 'Core Industry — EdTech and Marketing', 'heliolisk' ),
						'enable_count'  => 'yes',
						'count_number'  => 2,
						'count_decimals'=> 0,
						'count_suffix'  => '',
					),
				),
				'title_field' => '{{{ value }}} — {{{ label }}}',
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
				'default'     => 'home',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#home" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
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
			'section_min_height',
			array(
				'label'      => __( 'Min Height', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 1200 ),
					'vh' => array( 'min' => 20, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => 'vh',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-hero' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'section_overlay_color',
			array(
				'label'     => __( 'Background Overlay', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(6,6,10,0.72)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__overlay' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-hero__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_kicker_controls() {
		$this->start_controls_section(
			'section_style_kicker',
			array(
				'label' => __( 'Kicker', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'kicker_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#c9c9d6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__kicker' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'kicker_dot_color',
			array(
				'label'     => __( 'Dot Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__kicker-dot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'kicker_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__kicker',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_role_controls() {
		$this->start_controls_section(
			'section_style_role',
			array(
				'label' => __( 'Role Line', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'role_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__role' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'role_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__role',
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
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __( 'Accent Word Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__accent' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__heading',
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
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__desc' => 'color: {{VALUE}};',
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
					'px' => array( 'min' => 200, 'max' => 900 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-hero__desc' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__desc',
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
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__btn--primary' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'primary_button_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__btn--primary' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => __( 'Hover Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__btn--primary:hover' => 'background-color: {{VALUE}};',
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
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__btn--ghost' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'secondary_button_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(244,245,251,0.3)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__btn--ghost' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'secondary_button_hover_bg_color',
			array(
				'label'     => __( 'Hover Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(244,245,251,0.08)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__btn--ghost:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-hero__btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'buttons_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__btn',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_stats_controls() {
		$this->start_controls_section(
			'section_style_stats',
			array(
				'label' => __( 'Stats', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'stat_value_color',
			array(
				'label'     => __( 'Value Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__stat-value' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'stat_value_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__stat-value',
			)
		);

		$this->add_control(
			'stat_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-hero__stat-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'stat_label_typography',
				'selector' => '{{WRAPPER}} .hlw-hero__stat-label',
			)
		);

		$this->add_responsive_control(
			'stats_gap',
			array(
				'label'      => __( 'Gap Between Stats', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-hero__stats' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$bg_url = ! empty( $settings['background_image']['url'] ) ? $settings['background_image']['url'] : '';

		$arrow_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hlw-hero__btn-icon"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
		?>
		<section class="hlw-hero"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<?php if ( $bg_url ) : ?>
				<div class="hlw-hero__bg" style="background-image:url('<?php echo esc_url( $bg_url ); ?>');"></div>
			<?php endif; ?>
			<div class="hlw-hero__overlay"></div>

			<div class="hlw-hero__inner">
				<div class="hlw-hero__copy">
					<?php if ( ! empty( $settings['kicker_text'] ) ) : ?>
						<p class="hlw-hero__kicker">
							<?php if ( 'yes' === $settings['kicker_dot'] ) : ?>
								<span class="hlw-hero__kicker-dot"></span>
							<?php endif; ?>
							<?php echo esc_html( $settings['kicker_text'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $settings['role_text'] ) ) : ?>
						<p class="hlw-hero__role"><?php echo esc_html( $settings['role_text'] ); ?></p>
					<?php endif; ?>

					<h1 class="hlw-hero__heading">
						<?php if ( ! empty( $settings['heading_line_1'] ) ) : ?>
							<span><?php echo esc_html( $settings['heading_line_1'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $settings['heading_line_2'] ) ) : ?>
							<span><?php echo esc_html( $settings['heading_line_2'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $settings['heading_line_3'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<span>
								<?php echo esc_html( $settings['heading_line_3'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<span class="hlw-hero__accent"><?php echo esc_html( $settings['heading_accent'] ); ?></span>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</h1>

					<?php if ( ! empty( $settings['description'] ) ) : ?>
						<p class="hlw-hero__desc"><?php echo esc_html( $settings['description'] ); ?></p>
					<?php endif; ?>

					<div class="hlw-hero__ctas">
						<?php if ( ! empty( $settings['primary_button_text'] ) ) :
							$primary_url = ! empty( $settings['primary_button_link']['url'] ) ? $settings['primary_button_link']['url'] : '#';
							?>
							<a href="<?php echo esc_url( $primary_url ); ?>" class="hlw-hero__btn hlw-hero__btn--primary">
								<?php echo esc_html( $settings['primary_button_text'] ); ?>
								<?php if ( 'yes' === $settings['primary_button_icon'] ) {
									echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} ?>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $settings['secondary_button_text'] ) ) :
							$secondary_url = ! empty( $settings['secondary_button_link']['url'] ) ? $settings['secondary_button_link']['url'] : '#';
							?>
							<a href="<?php echo esc_url( $secondary_url ); ?>" class="hlw-hero__btn hlw-hero__btn--ghost">
								<?php echo esc_html( $settings['secondary_button_text'] ); ?>
								<?php if ( 'yes' === $settings['secondary_button_icon'] ) {
									echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} ?>
							</a>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( ! empty( $settings['stats'] ) ) : ?>
					<div class="hlw-hero__stats">
						<?php foreach ( $settings['stats'] as $stat ) : ?>
							<div class="hlw-hero__stat">
								<div
									class="hlw-hero__stat-value"
									<?php if ( 'yes' === $stat['enable_count'] ) : ?>
										data-hlw-count="<?php echo esc_attr( $stat['count_number'] ); ?>"
										data-hlw-decimals="<?php echo esc_attr( $stat['count_decimals'] ); ?>"
										data-hlw-suffix="<?php echo esc_attr( $stat['count_suffix'] ); ?>"
									<?php endif; ?>
								><?php echo esc_html( $stat['value'] ); ?></div>
								<div class="hlw-hero__stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
