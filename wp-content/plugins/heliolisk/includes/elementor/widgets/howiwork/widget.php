<?php
/**
 * Elementor "How I Work" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Howiwork_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-howiwork';
	}

	public function get_title() {
		return __( 'How I Work', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-howiwork-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'how i work', 'principles', 'process', 'methodology' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'howiwork' ) );
	}

	protected function register_controls() {
		$this->register_content_header_controls();
		$this->register_content_principles_controls();

		$this->register_style_eyebrow_controls();
		$this->register_style_statement_controls();
		$this->register_style_principles_controls();
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
				'default'   => __( '08', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'eyebrow_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'How I Work', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'statement',
			array(
				'label'   => __( 'Statement', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'I like turning messy problems into simple systems.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_principles_controls() {
		$this->start_controls_section(
			'section_content_principles',
			array(
				'label' => __( 'Principles', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'number',
			array(
				'label'   => __( 'Number', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '01', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Title', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Description', 'heliolisk' ),
			)
		);

		$this->add_control(
			'principles',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'number'      => '01',
						'title'       => __( 'Simplify', 'heliolisk' ),
						'description' => __( 'Reduce unnecessary complexity.', 'heliolisk' ),
					),
					array(
						'number'      => '02',
						'title'       => __( 'Measure', 'heliolisk' ),
						'description' => __( 'Use data to understand what is actually happening.', 'heliolisk' ),
					),
					array(
						'number'      => '03',
						'title'       => __( 'Improve', 'heliolisk' ),
						'description' => __( 'Build systems that continuously get better.', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ number }}} — {{{ title }}}',
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
					'{{WRAPPER}} .hlw-howiwork__eyebrow-num' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-howiwork__eyebrow-lbl' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_statement_controls() {
		$this->start_controls_section(
			'section_style_statement',
			array(
				'label' => __( 'Statement', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'statement_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-howiwork__statement' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'statement_typography',
				'selector' => '{{WRAPPER}} .hlw-howiwork__statement',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_principles_controls() {
		$this->start_controls_section(
			'section_style_principles',
			array(
				'label' => __( 'Principles', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'principle_number_color',
			array(
				'label'     => __( 'Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-howiwork__p-num' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'principle_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-howiwork__principle h3' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'principle_desc_color',
			array(
				'label'     => __( 'Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-howiwork__principle p' => 'color: {{VALUE}};',
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
				'default'   => '#101010',
				'selectors' => array(
					'{{WRAPPER}} .hlw-howiwork' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-howiwork' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-howiwork">
			<div class="hlw-howiwork__inner">

				<?php if ( 'yes' === $settings['show_eyebrow'] && ! empty( $settings['eyebrow_label'] ) ) : ?>
					<div class="hlw-howiwork__eyebrow">
						<?php if ( ! empty( $settings['eyebrow_number'] ) ) : ?>
							<span class="hlw-howiwork__eyebrow-num"><?php echo esc_html( $settings['eyebrow_number'] ); ?></span>
						<?php endif; ?>
						<span class="hlw-howiwork__eyebrow-lbl"><?php echo esc_html( $settings['eyebrow_label'] ); ?></span>
						<span class="hlw-howiwork__eyebrow-line"></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['statement'] ) ) : ?>
					<h2 class="hlw-howiwork__statement"><?php echo esc_html( $settings['statement'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['principles'] ) ) : ?>
					<div class="hlw-howiwork__principles">
						<?php foreach ( $settings['principles'] as $principle ) : ?>
							<div class="hlw-howiwork__principle">
								<?php if ( ! empty( $principle['number'] ) ) : ?>
									<div class="hlw-howiwork__p-num"><?php echo esc_html( $principle['number'] ); ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $principle['title'] ) ) : ?>
									<h3><?php echo esc_html( $principle['title'] ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $principle['description'] ) ) : ?>
									<p><?php echo esc_html( $principle['description'] ); ?></p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}
