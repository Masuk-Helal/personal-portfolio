<?php
/**
 * Elementor "By The Numbers" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Numbers_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-numbers';
	}

	public function get_title() {
		return __( 'By The Numbers', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-numbers-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'numbers', 'stats', 'statistics', 'counter', 'metrics' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'numbers' ) );
	}

	protected function register_controls() {
		$this->register_content_header_controls();
		$this->register_content_stats_controls();
		$this->register_content_focus_controls();

		$this->register_style_eyebrow_controls();
		$this->register_style_stats_controls();
		$this->register_style_focus_controls();
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
				'default'   => __( '06', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'eyebrow_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'By The Numbers', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_stats_controls() {
		$this->start_controls_section(
			'section_content_stats',
			array(
				'label' => __( 'Stat Blocks', 'heliolisk' ),
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

		$this->add_control(
			'stats',
			array(
				'label'       => __( 'Blocks', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'value' => '3.6+',
						'label' => __( 'Years Professional Experience', 'heliolisk' ),
					),
					array(
						'value' => 'BBA',
						'label' => __( 'Business Analytics', 'heliolisk' ),
					),
					array(
						'value' => '05',
						'label' => __( 'Core Capabilities', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ value }}} — {{{ label }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_focus_controls() {
		$this->start_controls_section(
			'section_content_focus',
			array(
				'label' => __( 'Focus List', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_focus_list',
			array(
				'label'        => __( 'Show Focus List Block', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'focus_heading',
			array(
				'label'     => __( 'Heading', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Core Focus', 'heliolisk' ),
				'condition' => array( 'show_focus_list' => 'yes' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'   => __( 'Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Item', 'heliolisk' ),
			)
		);

		$this->add_control(
			'focus_items',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'text' => __( 'Data', 'heliolisk' ) ),
					array( 'text' => __( 'Operations', 'heliolisk' ) ),
					array( 'text' => __( 'Content', 'heliolisk' ) ),
					array( 'text' => __( 'Technology', 'heliolisk' ) ),
					array( 'text' => __( 'Marketing', 'heliolisk' ) ),
				),
				'title_field' => '{{{ text }}}',
				'condition'   => array( 'show_focus_list' => 'yes' ),
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
					'{{WRAPPER}} .hlw-numbers__eyebrow-num' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-numbers__eyebrow-lbl' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_stats_controls() {
		$this->start_controls_section(
			'section_style_stats',
			array(
				'label' => __( 'Stat Blocks', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'stats_value_color',
			array(
				'label'     => __( 'Value Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-numbers__stat-value' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'stats_value_typography',
				'selector' => '{{WRAPPER}} .hlw-numbers__stat-value',
			)
		);

		$this->add_control(
			'stats_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-numbers__stat-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_focus_controls() {
		$this->start_controls_section(
			'section_style_focus',
			array(
				'label' => __( 'Focus List', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'focus_heading_color',
			array(
				'label'     => __( 'Heading Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-numbers__focus-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'focus_text_color',
			array(
				'label'     => __( 'Item Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-numbers__focus-item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'focus_number_color',
			array(
				'label'     => __( 'Item Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-numbers__focus-num' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-numbers' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-numbers">
			<div class="hlw-numbers__inner">

				<?php if ( 'yes' === $settings['show_eyebrow'] && ! empty( $settings['eyebrow_label'] ) ) : ?>
					<div class="hlw-numbers__eyebrow">
						<?php if ( ! empty( $settings['eyebrow_number'] ) ) : ?>
							<span class="hlw-numbers__eyebrow-num"><?php echo esc_html( $settings['eyebrow_number'] ); ?></span>
						<?php endif; ?>
						<span class="hlw-numbers__eyebrow-lbl"><?php echo esc_html( $settings['eyebrow_label'] ); ?></span>
						<span class="hlw-numbers__eyebrow-line"></span>
					</div>
				<?php endif; ?>

				<div class="hlw-numbers__grid">
					<?php if ( ! empty( $settings['stats'] ) ) : ?>
						<?php foreach ( $settings['stats'] as $stat ) : ?>
							<div class="hlw-numbers__block">
								<div class="hlw-numbers__stat-value"><?php echo esc_html( $stat['value'] ); ?></div>
								<div class="hlw-numbers__stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_focus_list'] && ! empty( $settings['focus_items'] ) ) : ?>
						<div class="hlw-numbers__block hlw-numbers__block--focus">
							<?php if ( ! empty( $settings['focus_heading'] ) ) : ?>
								<div class="hlw-numbers__focus-heading"><?php echo esc_html( $settings['focus_heading'] ); ?></div>
							<?php endif; ?>
							<ul class="hlw-numbers__focus-list">
								<?php foreach ( $settings['focus_items'] as $index => $item ) : ?>
									<li class="hlw-numbers__focus-item">
										<i class="hlw-numbers__focus-num"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></i>
										<?php echo esc_html( $item['text'] ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</section>
		<?php
	}
}
