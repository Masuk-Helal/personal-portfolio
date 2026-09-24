<?php
/**
 * Elementor "Contact CTA" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Contact_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-contact';
	}

	public function get_title() {
		return __( 'Contact CTA', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-contact-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'contact', 'cta', 'call to action', 'get in touch' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'contact' ) );
	}

	protected function register_controls() {
		$this->register_content_text_controls();
		$this->register_content_button_controls();
		$this->register_content_links_controls();
		$this->register_content_advanced_controls();

		$this->register_style_heading_controls();
		$this->register_style_description_controls();
		$this->register_style_button_controls();
		$this->register_style_links_controls();
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
			'heading_text',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( "Let's build something", 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading Accent Word', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'useful.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Have a project, collaboration, opportunity or simply want to connect?', 'heliolisk' ),
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
				'default' => __( 'Start a Conversation', 'heliolisk' ),
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'         => __( 'Button Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array(
					'url'         => 'https://wa.me/qr/RJZE2HJUFJSZD1',
					'is_external' => true,
					'nofollow'    => false,
				),
				'show_external' => true,
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

	private function register_content_links_controls() {
		$this->start_controls_section(
			'section_content_links',
			array(
				'label' => __( 'Contact Links', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'   => __( 'Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'link', 'heliolisk' ),
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
						'text' => __( 'refatshanto94@gmail.com', 'heliolisk' ),
						'link' => array( 'url' => 'mailto:refatshanto94@gmail.com' ),
					),
					array(
						'text' => __( '+880 1984-617471', 'heliolisk' ),
						'link' => array( 'url' => 'tel:+8801984617471' ),
					),
					array(
						'text' => __( 'WhatsApp', 'heliolisk' ),
						'link' => array( 'url' => 'https://wa.me/qr/RJZE2HJUFJSZD1', 'is_external' => true ),
					),
					array(
						'text' => __( 'linkedin.com/in/shantoszz', 'heliolisk' ),
						'link' => array( 'url' => 'https://www.linkedin.com/in/shantoszz', 'is_external' => true ),
					),
					array(
						'text' => __( 'facebook.com/shantoszz', 'heliolisk' ),
						'link' => array( 'url' => 'https://www.facebook.com/shantoszz/', 'is_external' => true ),
					),
					array(
						'text' => __( 'github.com/Shantoszz', 'heliolisk' ),
						'link' => array( 'url' => 'https://github.com/Shantoszz', 'is_external' => true ),
					),
				),
				'title_field' => '{{{ text }}}',
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
				'default'     => 'contact',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#contact" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

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
					'{{WRAPPER}} .hlw-contact__heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e63946',
				'selectors' => array(
					'{{WRAPPER}} .hlw-contact__accent' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-contact__heading',
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
					'{{WRAPPER}} .hlw-contact__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .hlw-contact__desc',
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
				'default'   => '#e63946',
				'selectors' => array(
					'{{WRAPPER}} .hlw-contact__btn' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => __( 'Hover Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e63946',
				'selectors' => array(
					'{{WRAPPER}} .hlw-contact__btn:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_text_color',
			array(
				'label'     => __( 'Hover Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-contact__btn:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-contact__btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .hlw-contact__btn',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_links_controls() {
		$this->start_controls_section(
			'section_style_links',
			array(
				'label' => __( 'Contact Links', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'links_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-contact__links a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'links_hover_color',
			array(
				'label'     => __( 'Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff6b6b',
				'selectors' => array(
					'{{WRAPPER}} .hlw-contact__links a:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-contact' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'show_glow',
			array(
				'label'        => __( 'Show Background Glow', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'selectors_dictionary' => array(
					'yes' => 'block',
					''    => 'none',
				),
				'selectors'    => array(
					'{{WRAPPER}} .hlw-contact__glow' => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => __( 'Padding', 'heliolisk' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => 130,
					'right'    => 24,
					'bottom'   => 130,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-contact__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$arrow_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hlw-contact__btn-icon"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
		?>
		<section class="hlw-contact"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<span class="hlw-contact__glow" aria-hidden="true"></span>

			<div class="hlw-contact__inner">
				<?php if ( ! empty( $settings['heading_text'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
					<h2 class="hlw-contact__heading">
						<?php echo esc_html( $settings['heading_text'] ); ?>
						<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
							<span class="hlw-contact__accent"><?php echo esc_html( $settings['heading_accent'] ); ?></span>
						<?php endif; ?>
					</h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description'] ) ) : ?>
					<p class="hlw-contact__desc"><?php echo esc_html( $settings['description'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['button_text'] ) ) :
					$button_url    = ! empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '#';
					$is_external   = ! empty( $settings['button_link']['is_external'] );
					$is_nofollow   = ! empty( $settings['button_link']['nofollow'] );
					?>
					<a
						href="<?php echo esc_url( $button_url ); ?>"
						class="hlw-contact__btn"
						<?php echo $is_external ? ' target="_blank"' : ''; ?>
						<?php echo ( $is_external || $is_nofollow ) ? ' rel="noopener' . ( $is_nofollow ? ' nofollow' : '' ) . '"' : ''; ?>
					>
						<?php echo esc_html( $settings['button_text'] ); ?>
						<?php if ( 'yes' === $settings['button_icon'] ) {
							echo $arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['links'] ) ) : ?>
					<div class="hlw-contact__links">
						<?php foreach ( $settings['links'] as $item ) :
							$link_url  = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
							$external  = ! empty( $item['link']['is_external'] );
							$nofollow  = ! empty( $item['link']['nofollow'] );
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
		</section>
		<?php
	}
}
