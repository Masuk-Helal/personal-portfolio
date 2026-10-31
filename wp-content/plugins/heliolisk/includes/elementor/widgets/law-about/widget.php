<?php
/**
 * Elementor "Law About" widget — fully self-contained, no theme dependency.
 *
 * Editorial about section for a lawyer or legal practice, adapted from the
 * index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_About_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-about';
	}

	public function get_title() {
		return __( 'Law About', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-law-about-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'about', 'bio', 'profile', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-about' ) );
	}

	protected function register_controls() {
		$this->register_content_text_controls();
		$this->register_content_media_controls();
		$this->register_content_body_controls();
		$this->register_content_facts_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_media_controls();
		$this->register_style_body_controls();
		$this->register_style_quote_controls();
		$this->register_style_facts_controls();
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
				'default'     => 'about',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#about" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '01 / About', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Law as a discipline of', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'attention.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'A short introduction to my practice, professional background and the questions that shape my work as an advocate.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_media_controls() {
		$this->start_controls_section(
			'section_content_media',
			array(
				'label' => __( 'Media', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => __( 'Image', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/law-about/assets/images/bookshelf.webp',
				),
			)
		);

		$this->add_control(
			'image_alt',
			array(
				'label'       => __( 'Image Alt Text', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Shelves of antique legal volumes in a law library', 'heliolisk' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'image_position',
			array(
				'label'   => __( 'Image Position', 'heliolisk' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => __( 'Left', 'heliolisk' ),
					'right' => __( 'Right', 'heliolisk' ),
				),
			)
		);

		$this->add_control(
			'caption_left',
			array(
				'label'     => __( 'Caption — Left', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Legal reading room', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'caption_right',
			array(
				'label'   => __( 'Caption — Right', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Fig. 01', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_body_controls() {
		$this->start_controls_section(
			'section_content_body',
			array(
				'label' => __( 'Body', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lead',
			array(
				'label'   => __( 'Lead Paragraph', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'I am Rahmat Ullah, an advocate practising in Dhaka, Bangladesh. I work across constitutional law, human rights and civil litigation, with a particular interest in how legal doctrine shapes the lives of ordinary people — especially access to justice.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'paragraph',
			array(
				'label'   => __( 'Paragraph', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'My practice is research-led. I read primary sources closely, from the Constitution of Bangladesh and statutes to Appellate Division judgments, testing an argument against its strongest objection and turning complex material into clear, persuasive writing. I also contribute to legal research, moot court mentoring and public legal education.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'quote',
			array(
				'label'     => __( 'Quote', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Law is not only a set of rules to be applied; it is a way of asking who bears the burden of a decision — and whether our institutions answer fairly.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'closing',
			array(
				'label'   => __( 'Closing Paragraph', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'My practice focuses on public-interest litigation, legal research and human rights advocacy in Bangladesh. I am particularly interested in how well-reasoned legal argument can make institutions more accountable — and more humane.', 'heliolisk' ),
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
				'default' => __( 'Currently', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'value',
			array(
				'label'   => __( 'Value', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Advocate, Dhaka District Bar Association', 'heliolisk' ),
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
						'label' => __( 'Currently', 'heliolisk' ),
						'value' => __( 'Advocate, Dhaka District Bar Association', 'heliolisk' ),
					),
					array(
						'label' => __( 'Education', 'heliolisk' ),
						'value' => __( 'LL.B. (Honours), Dhaka International University', 'heliolisk' ),
					),
					array(
						'label' => __( 'Practice areas', 'heliolisk' ),
						'value' => __( 'Constitutional law, human rights, civil litigation', 'heliolisk' ),
					),
					array(
						'label' => __( 'Commitment', 'heliolisk' ),
						'value' => __( 'Public-interest law, research and advocacy in Bangladesh', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ label }}}: {{{ value }}}',
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
				'default'   => '#F5F2EB',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about' => '--hlw-law-about-paper: {{VALUE}}; background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about' => '--hlw-law-about-ink: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about' => '--hlw-law-about-gold: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_muted_color',
			array(
				'label'     => __( 'Muted Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about' => '--hlw-law-about-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-about' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__eyebrow',
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
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__title',
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
					'{{WRAPPER}} .hlw-law-about__title' => 'max-width: {{SIZE}}{{UNIT}};',
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
				'default'   => '#596474',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__intro' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-about__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__intro',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_media_controls() {
		$this->start_controls_section(
			'section_style_media',
			array(
				'label' => __( 'Media', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'media_frame_color',
			array(
				'label'     => __( 'Frame Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(16,26,43,0.14)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__media-frame' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'media_inner_border_color',
			array(
				'label'     => __( 'Inner Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(198,165,104,0.35)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__media-frame::before' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'media_aspect_ratio',
			array(
				'label'     => __( 'Image Aspect Ratio', 'heliolisk' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4 / 5',
				'options'   => array(
					'4 / 5' => __( '4:5 (Portrait)', 'heliolisk' ),
					'1 / 1' => __( '1:1 (Square)', 'heliolisk' ),
					'4 / 3' => __( '4:3 (Landscape)', 'heliolisk' ),
					'3 / 2' => __( '3:2 (Wide)', 'heliolisk' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__media img' => 'aspect-ratio: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'media_saturation',
			array(
				'label'     => __( 'Image Saturation (%)', 'heliolisk' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 150 ) ),
				'default'   => array( 'size' => 82 ),
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__media img' => 'filter: saturate({{SIZE}}%);',
				),
			)
		);

		$this->add_control(
			'caption_color',
			array(
				'label'     => __( 'Caption Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__caption' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__caption',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_body_controls() {
		$this->start_controls_section(
			'section_style_body',
			array(
				'label' => __( 'Body', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lead_color',
			array(
				'label'     => __( 'Lead Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__lead' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'lead_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__lead',
			)
		);

		$this->add_control(
			'body_text_color',
			array(
				'label'     => __( 'Paragraph Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'body_text_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__text',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_quote_controls() {
		$this->start_controls_section(
			'section_style_quote',
			array(
				'label' => __( 'Quote', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'quote_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__quote' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quote_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__quote' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'quote_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__quote',
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
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__facts dt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fact_label_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__facts dt',
			)
		);

		$this->add_control(
			'fact_value_color',
			array(
				'label'     => __( 'Value Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-about__facts dd' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fact_value_typography',
				'selector' => '{{WRAPPER}} .hlw-law-about__facts dd',
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
					'{{WRAPPER}} .hlw-law-about__facts' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$image_url  = ! empty( $settings['image']['url'] ) ? $settings['image']['url'] : '';
		$media_right = 'right' === $settings['image_position'];

		$root_class = 'hlw-law-about' . ( $media_right ? ' hlw-law-about--media-right' : '' );
		?>
		<section class="<?php echo esc_attr( $root_class ); ?>"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-about__inner">
				<header class="hlw-law-about__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-about__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-about__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $settings['intro'] ) ) : ?>
						<p class="hlw-law-about__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
					<?php endif; ?>
				</header>

				<div class="hlw-law-about__grid">
					<figure class="hlw-law-about__media">
						<div class="hlw-law-about__media-frame">
							<?php if ( $image_url ) : ?>
								<img src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $settings['image_alt'] ); ?>"
									width="1200" height="800" loading="lazy" decoding="async">
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $settings['caption_left'] ) || ! empty( $settings['caption_right'] ) ) : ?>
							<figcaption class="hlw-law-about__caption">
								<span><?php echo esc_html( $settings['caption_left'] ); ?></span>
								<span><?php echo esc_html( $settings['caption_right'] ); ?></span>
							</figcaption>
						<?php endif; ?>
					</figure>

					<div class="hlw-law-about__body">
						<?php if ( ! empty( $settings['lead'] ) ) : ?>
							<p class="hlw-law-about__lead"><?php echo esc_html( $settings['lead'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['paragraph'] ) ) : ?>
							<p class="hlw-law-about__text"><?php echo nl2br( esc_html( $settings['paragraph'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['quote'] ) ) : ?>
							<blockquote class="hlw-law-about__quote"><?php echo esc_html( $settings['quote'] ); ?></blockquote>
						<?php endif; ?>

						<?php if ( ! empty( $settings['closing'] ) ) : ?>
							<p class="hlw-law-about__text"><?php echo nl2br( esc_html( $settings['closing'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['facts'] ) ) : ?>
							<dl class="hlw-law-about__facts">
								<?php foreach ( $settings['facts'] as $fact ) : ?>
									<div>
										<dt><?php echo esc_html( $fact['label'] ); ?></dt>
										<dd><?php echo esc_html( $fact['value'] ); ?></dd>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
