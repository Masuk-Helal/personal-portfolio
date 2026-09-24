<?php
/**
 * Elementor "Footer" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Footer_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-footer';
	}

	public function get_title() {
		return __( 'Footer', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-footer-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'footer', 'copyright', 'social links' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'footer' ) );
	}

	protected function register_controls() {
		$this->register_content_brand_controls();
		$this->register_content_links_controls();
		$this->register_content_bottom_controls();

		$this->register_style_brand_controls();
		$this->register_style_links_controls();
		$this->register_style_bottom_controls();
		$this->register_style_section_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_brand_controls() {
		$this->start_controls_section(
			'section_content_brand',
			array(
				'label' => __( 'Brand', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'name',
			array(
				'label'   => __( 'Name', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'S.M. Refat Arefin', 'heliolisk' ),
			)
		);

		$this->add_control(
			'tagline',
			array(
				'label'   => __( 'Tagline', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Business Analytics · Operations · Technology · Marketing', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_links_controls() {
		$this->start_controls_section(
			'section_content_links',
			array(
				'label' => __( 'Social Links', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'   => __( 'Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'LinkedIn', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'         => __( 'Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '#' ),
				'show_external' => true,
			)
		);

		$this->add_control(
			'links',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'text' => __( 'LinkedIn', 'heliolisk' ),
						'link' => array( 'url' => 'https://www.linkedin.com/in/shantoszz', 'is_external' => true ),
					),
					array(
						'text' => __( 'GitHub', 'heliolisk' ),
						'link' => array( 'url' => 'https://github.com/Shantoszz', 'is_external' => true ),
					),
					array(
						'text' => __( 'Email', 'heliolisk' ),
						'link' => array( 'url' => 'mailto:refatshanto94@gmail.com' ),
					),
				),
				'title_field' => '{{{ text }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_bottom_controls() {
		$this->start_controls_section(
			'section_content_bottom',
			array(
				'label' => __( 'Bottom Bar', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'copyright_text',
			array(
				'label'   => __( 'Copyright Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '© 2026 S.M. Refat Arefin. All rights reserved.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'location_text',
			array(
				'label'   => __( 'Location Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Dhaka, Bangladesh', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

	private function register_style_brand_controls() {
		$this->start_controls_section(
			'section_style_brand',
			array(
				'label' => __( 'Brand', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => __( 'Name Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer__name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tagline_color',
			array(
				'label'     => __( 'Tagline Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer__tagline' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_links_controls() {
		$this->start_controls_section(
			'section_style_links',
			array(
				'label' => __( 'Social Links', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer__links a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'     => __( 'Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer__links a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_bottom_controls() {
		$this->start_controls_section(
			'section_style_bottom',
			array(
				'label' => __( 'Bottom Bar', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'bottom_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer__bottom' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bottom_border_color',
			array(
				'label'     => __( 'Divider Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer__bottom' => 'border-top-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-footer' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_border_color',
			array(
				'label'     => __( 'Top Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-footer' => 'border-top-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="hlw-footer">
			<div class="hlw-footer__inner">

				<?php if ( ! empty( $settings['name'] ) || ! empty( $settings['tagline'] ) || ! empty( $settings['links'] ) ) : ?>
					<div class="hlw-footer__top">
						<div>
							<?php if ( ! empty( $settings['name'] ) ) : ?>
								<div class="hlw-footer__name"><?php echo esc_html( $settings['name'] ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $settings['tagline'] ) ) : ?>
								<div class="hlw-footer__tagline"><?php echo esc_html( $settings['tagline'] ); ?></div>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $settings['links'] ) ) : ?>
							<div class="hlw-footer__links">
								<?php foreach ( $settings['links'] as $item ) :
									$link_url = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
									$external = ! empty( $item['link']['is_external'] );
									$nofollow = ! empty( $item['link']['nofollow'] );
									?>
									<a
										href="<?php echo esc_url( $link_url ); ?>"
										<?php echo $external ? ' target="_blank"' : ''; ?>
										<?php echo ( $external || $nofollow ) ? ' rel="noopener' . ( $nofollow ? ' nofollow' : '' ) . '"' : ''; ?>
									><?php echo esc_html( $item['text'] ); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['copyright_text'] ) || ! empty( $settings['location_text'] ) ) : ?>
					<div class="hlw-footer__bottom">
						<?php if ( ! empty( $settings['copyright_text'] ) ) : ?>
							<p><?php echo esc_html( $settings['copyright_text'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $settings['location_text'] ) ) : ?>
							<p><?php echo esc_html( $settings['location_text'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</footer>
		<?php
	}
}
