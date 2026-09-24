<?php
/**
 * Elementor "Collaborators" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class Heliolisk_Collaborators_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-collaborators';
	}

	public function get_title() {
		return __( 'Collaborators', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-collaborators-panel-icon';
	}

	public function get_categories() {
		return array( 'personal-portfolio' );
	}

	public function get_keywords() {
		return array( 'collaborators', 'brands', 'logos', 'clients', 'partners' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'collaborators' ) );
	}

	protected function register_controls() {
		$this->register_content_header_controls();
		$this->register_content_logos_controls();
		$this->register_content_advanced_controls();

		$this->register_style_eyebrow_controls();
		$this->register_style_lead_controls();
		$this->register_style_logos_controls();
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
				'default'   => __( '10', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'eyebrow_label',
			array(
				'label'     => __( 'Label', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Collaborators', 'heliolisk' ),
				'condition' => array( 'show_eyebrow' => 'yes' ),
			)
		);

		$this->add_control(
			'lead_text',
			array(
				'label'   => __( 'Lead Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( "Organizations and Brands I've Had the Opportunity to Work With Directly.", 'heliolisk' ),
			)
		);

		$this->add_control(
			'logos_heading',
			array(
				'label'   => __( 'Logos Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Brands', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_logos_controls() {
		$this->start_controls_section(
			'section_content_logos',
			array(
				'label' => __( 'Logos', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'logo',
			array(
				'label'   => __( 'Logo', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => '' ),
			)
		);

		$repeater->add_control(
			'alt',
			array(
				'label'   => __( 'Alt Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Brand', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'         => __( 'Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '' ),
				'show_external' => false,
			)
		);

		$this->add_control(
			'logos',
			array(
				'label'       => __( 'Logo Tiles', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'alt' => __( 'bKash', 'heliolisk' ) ),
					array( 'alt' => __( 'The Daily Star', 'heliolisk' ) ),
					array( 'alt' => __( 'VUMI Group', 'heliolisk' ) ),
					array( 'alt' => __( 'CMED Health', 'heliolisk' ) ),
					array( 'alt' => __( 'United Commercial Bank (UCB)', 'heliolisk' ) ),
					array( 'alt' => __( 'Editorial News 24', 'heliolisk' ) ),
					array( 'alt' => __( '10 Minute School', 'heliolisk' ) ),
					array( 'alt' => __( 'Newspaper Olympiad', 'heliolisk' ) ),
				),
				'title_field' => '{{{ alt }}}',
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
				'default'     => 'collaborators',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#collaborators" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
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
					'{{WRAPPER}} .hlw-collaborators__eyebrow-num' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-collaborators__eyebrow-lbl' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_lead_controls() {
		$this->start_controls_section(
			'section_style_lead',
			array(
				'label' => __( 'Lead & Heading', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lead_color',
			array(
				'label'     => __( 'Lead Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-collaborators__lead' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'logos_heading_color',
			array(
				'label'     => __( 'Logos Heading Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-collaborators__logos-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_logos_controls() {
		$this->start_controls_section(
			'section_style_logos',
			array(
				'label' => __( 'Logo Tiles', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tile_bg_color',
			array(
				'label'     => __( 'Tile Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5f5f3',
				'selectors' => array(
					'{{WRAPPER}} .hlw-collaborators__tile' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tile_size',
			array(
				'label'      => __( 'Tile Size', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 60, 'max' => 220 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 132 ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-collaborators__tile' => 'width: {{SIZE}}{{UNIT}}; height: calc({{SIZE}}{{UNIT}} * 0.6);',
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
					'{{WRAPPER}} .hlw-collaborators' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-collaborators' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-collaborators"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-collaborators__inner">

				<?php if ( 'yes' === $settings['show_eyebrow'] && ! empty( $settings['eyebrow_label'] ) ) : ?>
					<div class="hlw-collaborators__eyebrow">
						<?php if ( ! empty( $settings['eyebrow_number'] ) ) : ?>
							<span class="hlw-collaborators__eyebrow-num"><?php echo esc_html( $settings['eyebrow_number'] ); ?></span>
						<?php endif; ?>
						<span class="hlw-collaborators__eyebrow-lbl"><?php echo esc_html( $settings['eyebrow_label'] ); ?></span>
						<span class="hlw-collaborators__eyebrow-line"></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['lead_text'] ) ) : ?>
					<p class="hlw-collaborators__lead"><?php echo esc_html( $settings['lead_text'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['logos_heading'] ) ) : ?>
					<h3 class="hlw-collaborators__logos-heading"><?php echo esc_html( $settings['logos_heading'] ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $settings['logos'] ) ) : ?>
					<div class="hlw-collaborators__logos">
						<?php foreach ( $settings['logos'] as $item ) :
							$logo_url = ! empty( $item['logo']['url'] ) ? $item['logo']['url'] : '';
							$link_url = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '';

							if ( ! $logo_url ) {
								continue;
							}

							if ( $link_url ) : ?>
								<a href="<?php echo esc_url( $link_url ); ?>" target="_blank" rel="noopener" class="hlw-collaborators__tile">
									<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>">
								</a>
							<?php else : ?>
								<div class="hlw-collaborators__tile">
									<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>">
								</div>
							<?php endif;
						endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}
