<?php
/**
 * Elementor "Law Contact" widget — fully self-contained, no theme dependency.
 *
 * Contact section for a lawyer or legal practice, adapted from the index-6
 * law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Contact_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-contact';
	}

	public function get_title() {
		return __( 'Law Contact', 'heliolisk' );
	}

	public function get_icon() {
		return 'hlw-law-contact-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'contact', 'email', 'location', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-contact' ) );
	}

	protected function register_controls() {
		$this->register_content_heading_controls();
		$this->register_content_contact_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_lead_controls();
		$this->register_style_list_controls();
		$this->register_style_note_controls();
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
				'default'     => 'contact',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#contact" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '08 / Contact', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Let’s discuss your case, a research question, or the next idea worth pursuing.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'lead',
			array(
				'label'     => __( 'Lead Paragraph', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'I welcome enquiries about legal representation, research collaboration, public-interest work and professional opportunities in Bangladesh. The fastest way to reach me is by email.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'mail_text',
			array(
				'label'   => __( 'Mail Link Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'rahmat.ullah@example.com', 'heliolisk' ),
			)
		);

		$this->add_control(
			'mail_link',
			array(
				'label'         => __( 'Mail Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => 'mailto:rahmat.ullah@example.com' ),
				'show_external' => false,
			)
		);

		$this->end_controls_section();
	}

	private function register_content_contact_controls() {
		$this->start_controls_section(
			'section_content_contact',
			array(
				'label' => __( 'Contact List', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Email', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'value',
			array(
				'label'   => __( 'Value', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'rahmat.ullah@example.com', 'heliolisk' ),
			)
		);

		$this->add_control(
			'contact_rows',
			array(
				'label'       => __( 'Rows', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'label' => __( 'Email', 'heliolisk' ),
						'value' => __( 'rahmat.ullah@example.com', 'heliolisk' ),
					),
					array(
						'label' => __( 'LinkedIn', 'heliolisk' ),
						'value' => __( 'linkedin.com/in/rahmat-ullah-law', 'heliolisk' ),
					),
					array(
						'label' => __( 'Chambers', 'heliolisk' ),
						'value' => __( 'Dhaka District Bar Association · Dhaka', 'heliolisk' ),
					),
					array(
						'label' => __( 'Location', 'heliolisk' ),
						'value' => __( 'Dhaka, Bangladesh', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ label }}}: {{{ value }}}',
			)
		);

		$this->add_control(
			'note',
			array(
				'label'     => __( 'Note', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Based in Dhaka. For legal and professional enquiries, email is the best way to reach me.', 'heliolisk' ),
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
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-contact' => '--hlw-law-contact-navy: {{VALUE}}; background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-contact' => '--hlw-law-contact-gold: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-contact' => '--hlw-law-contact-ivory: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-contact' => '--hlw-law-contact-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-contact' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-contact__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-contact__eyebrow',
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
					'{{WRAPPER}} .hlw-law-contact__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-contact__title',
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
					'{{WRAPPER}} .hlw-law-contact__title' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_lead_controls() {
		$this->start_controls_section(
			'section_style_lead',
			array(
				'label' => __( 'Lead', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lead_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-contact__lead' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'lead_max_width',
			array(
				'label'      => __( 'Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 220, 'max' => 700 ),
					'%'  => array( 'min' => 20, 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-contact__lead' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'lead_typography',
				'selector' => '{{WRAPPER}} .hlw-law-contact__lead',
			)
		);

		$this->add_control(
			'mail_color',
			array(
				'label'     => __( 'Mail Link Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-contact__mail' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_list_controls() {
		$this->start_controls_section(
			'section_style_list',
			array(
				'label' => __( 'List', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => __( 'Label Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-contact__list dt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .hlw-law-contact__list dt',
			)
		);

		$this->add_control(
			'value_color',
			array(
				'label'     => __( 'Value Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-contact__list dd' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'value_typography',
				'selector' => '{{WRAPPER}} .hlw-law-contact__list dd',
			)
		);

		$this->add_responsive_control(
			'rows_gap',
			array(
				'label'      => __( 'Gap Between Rows', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-contact__list' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_note_controls() {
		$this->start_controls_section(
			'section_style_note',
			array(
				'label' => __( 'Note', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'note_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-contact__note' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'note_typography',
				'selector' => '{{WRAPPER}} .hlw-law-contact__note',
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$mail_url = ! empty( $settings['mail_link']['url'] ) ? $settings['mail_link']['url'] : '#';
		?>
		<section class="hlw-law-contact"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-contact__inner">
				<div class="hlw-law-contact__grid">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-contact__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) ) : ?>
							<h2 class="hlw-law-contact__title"><?php echo esc_html( $settings['heading'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $settings['lead'] ) ) : ?>
							<p class="hlw-law-contact__lead"><?php echo esc_html( $settings['lead'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['mail_text'] ) ) : ?>
							<a class="hlw-law-contact__mail" href="<?php echo esc_url( $mail_url ); ?>">
								<?php echo esc_html( $settings['mail_text'] ); ?>
								<svg class="icon" aria-hidden="true"><use href="#i-arrow-up-right"></use></svg>
							</a>
						<?php endif; ?>
					</div>

					<div>
						<?php if ( ! empty( $settings['contact_rows'] ) ) : ?>
							<dl class="hlw-law-contact__list">
								<?php foreach ( $settings['contact_rows'] as $row ) : ?>
									<div class="hlw-law-contact__row">
										<?php if ( ! empty( $row['label'] ) ) : ?>
											<dt><?php echo esc_html( $row['label'] ); ?></dt>
										<?php endif; ?>
										<?php if ( ! empty( $row['value'] ) ) : ?>
											<dd><?php echo esc_html( $row['value'] ); ?></dd>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>

						<?php if ( ! empty( $settings['note'] ) ) : ?>
							<p class="hlw-law-contact__note"><?php echo esc_html( $settings['note'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
