<?php
/**
 * Elementor "About" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_About_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-about';
	}

	public function get_title() {
		return __( 'About', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-about-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'about', 'bio', 'profile', 'who am i' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'about' ) );
	}

	protected function register_controls() {
		$this->register_content_text_controls();
		$this->register_content_photo_controls();
		$this->register_content_info_controls();
		$this->register_content_button_controls();
		$this->register_content_advanced_controls();

		$this->register_style_photo_controls();
		$this->register_style_kicker_controls();
		$this->register_style_heading_controls();
		$this->register_style_description_controls();
		$this->register_style_info_controls();
		$this->register_style_button_controls();
		$this->register_style_section_controls();
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
				'default' => __( 'Who Am I?', 'heliolisk' ),
			)
		);

		$this->add_control(
			'kicker_bar',
			array(
				'label'        => __( 'Show Kicker Bar', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( "I'm S.M. Refat Arefin, a Business Analytics student and Operations professional.", 'heliolisk' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'My work sits at the intersection of operations, analytics, technology, digital content and process improvement. I enjoy turning messy operational problems into structured systems, dashboards, workflows and measurable processes.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_photo_controls() {
		$this->start_controls_section(
			'section_content_photo',
			array(
				'label' => __( 'Photo', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'photo',
			array(
				'label'   => __( 'Photo', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => '' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_info_controls() {
		$this->start_controls_section(
			'section_content_info',
			array(
				'label' => __( 'Info Grid', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Label', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'value',
			array(
				'label'   => __( 'Value', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Value', 'heliolisk' ),
			)
		);

		$this->add_control(
			'info_items',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'label' => __( 'Name', 'heliolisk' ),
						'value' => __( 'S.M. Refat Arefin', 'heliolisk' ),
					),
					array(
						'label' => __( 'From', 'heliolisk' ),
						'value' => __( 'Dhaka, Bangladesh', 'heliolisk' ),
					),
					array(
						'label' => __( 'Study', 'heliolisk' ),
						'value' => __( 'Business Analytics (BBA)', 'heliolisk' ),
					),
					array(
						'label' => __( 'Email', 'heliolisk' ),
						'value' => __( 'refatshanto94@gmail.com', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ label }}}: {{{ value }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_button_controls() {
		$this->start_controls_section(
			'section_content_button',
			array(
				'label' => __( 'Button', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => __( 'Button Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'More About Me', 'heliolisk' ),
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'         => __( 'Button Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '#' ),
				'show_external' => false,
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'        => __( 'Show Arrow Icon', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
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
				'default'     => 'about',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#about" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

	private function register_style_photo_controls() {
		$this->start_controls_section(
			'section_style_photo',
			array(
				'label' => __( 'Photo', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'photo_border_radius',
			array(
				'label'      => __( 'Border Radius', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 200 ),
					'%'  => array( 'min' => 0, 'max' => 50 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 8,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-about__photo img' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'photo_grayscale',
			array(
				'label'        => __( 'Grayscale', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'selectors_dictionary' => array(
					'yes' => 'grayscale(1)',
					''    => 'none',
				),
				'selectors'    => array(
					'{{WRAPPER}} .hlw-about__photo img' => 'filter: {{VALUE}};',
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
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__kicker' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'kicker_bar_color',
			array(
				'label'     => __( 'Bar Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__kicker-bar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'kicker_typography',
				'selector' => '{{WRAPPER}} .hlw-about__kicker',
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
					'{{WRAPPER}} .hlw-about__heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-about__heading',
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
					'{{WRAPPER}} .hlw-about__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .hlw-about__desc',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_info_controls() {
		$this->start_controls_section(
			'section_style_info',
			array(
				'label' => __( 'Info Grid', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'info_label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__info-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'info_label_typography',
				'selector' => '{{WRAPPER}} .hlw-about__info-label',
			)
		);

		$this->add_control(
			'info_value_color',
			array(
				'label'     => __( 'Value Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__info-value' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'info_value_typography',
				'selector' => '{{WRAPPER}} .hlw-about__info-value',
			)
		);

		$this->add_responsive_control(
			'info_gap',
			array(
				'label'     => __( 'Gap', 'heliolisk' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__info-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_button_controls() {
		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => __( 'Button', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => __( 'Hover Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__btn:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'     => __( 'Border Radius', 'heliolisk' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-about__btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .hlw-about__btn',
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
					'{{WRAPPER}} .hlw-about' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-about' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'photo_column_width',
			array(
				'label'      => __( 'Photo Column Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array( '%' => array( 'min' => 20, 'max' => 60 ) ),
				'default'    => array(
					'unit' => '%',
					'size' => 40,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-about__photo' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .hlw-about__text'  => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$photo_url  = ! empty( $settings['photo']['url'] ) ? $settings['photo']['url'] : '';
		$arrow_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hlw-about__btn-icon"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
		?>
		<section class="hlw-about"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-about__inner">
				<?php if ( $photo_url ) : ?>
					<div class="hlw-about__photo">
						<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $settings['heading'] ); ?>">
					</div>
				<?php endif; ?>

				<div class="hlw-about__text">
					<?php if ( ! empty( $settings['kicker_text'] ) ) : ?>
						<p class="hlw-about__kicker">
							<?php if ( 'yes' === $settings['kicker_bar'] ) : ?>
								<span class="hlw-about__kicker-bar"></span>
							<?php endif; ?>
							<?php echo esc_html( $settings['kicker_text'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $settings['heading'] ) ) : ?>
						<h2 class="hlw-about__heading"><?php echo esc_html( $settings['heading'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $settings['description'] ) ) : ?>
						<p class="hlw-about__desc"><?php echo esc_html( $settings['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $settings['info_items'] ) ) : ?>
						<div class="hlw-about__info-grid">
							<?php foreach ( $settings['info_items'] as $item ) : ?>
								<div class="hlw-about__info-item">
									<span class="hlw-about__info-label"><?php echo esc_html( $item['label'] ); ?></span>
									<span class="hlw-about__info-value"><?php echo esc_html( $item['value'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['button_text'] ) ) :
						$button_url = ! empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '#';
						?>
						<a href="<?php echo esc_url( $button_url ); ?>" class="hlw-about__btn">
							<?php echo esc_html( $settings['button_text'] ); ?>
							<?php if ( 'yes' === $settings['button_icon'] ) {
								echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							} ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
