<?php
/**
 * Elementor "Law Research" widget — fully self-contained, no theme dependency.
 *
 * Research & publications list for a lawyer or legal practice, adapted from
 * the index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Research_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-research';
	}

	public function get_title() {
		return __( 'Law Research', 'heliolisk' );
	}

	public function get_icon() {
		return 'hlw-law-research-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'research', 'publications', 'writing', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-research' ) );
	}

	protected function register_controls() {
		$this->register_content_heading_controls();
		$this->register_content_research_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_list_controls();
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
				'default'     => 'research',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#research" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '05 / Research & Publications', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Writing with', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'evidence.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Selected writing on constitutional law, human rights and legal method in Bangladesh.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'sample_note',
			array(
				'label'   => __( 'Sample Note', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Legal writing · Dhaka, Bangladesh', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_research_controls() {
		$this->start_controls_section(
			'section_content_research',
			array(
				'label' => __( 'Research Items', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'meta_category',
			array(
				'label'   => __( 'Meta Category', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Constitutional Law', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'meta_year',
			array(
				'label'   => __( 'Meta Year', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '2025', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'The Limits of Executive Power', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'A research essay examining how the Constitution, institutional practice and judicial review constrain executive authority in Bangladesh.', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'status',
			array(
				'label'   => __( 'Status / Type', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Research paper', 'heliolisk' ),
			)
		);

		$this->add_control(
			'research_items',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'meta_category' => __( 'Constitutional Law', 'heliolisk' ),
						'meta_year'     => __( '2025', 'heliolisk' ),
						'title'         => __( 'The Limits of Executive Power: A Constitutional Reading of Bangladesh', 'heliolisk' ),
						'description'   => __( 'A research essay examining how the Constitution, institutional practice and judicial review constrain executive authority in Bangladesh.', 'heliolisk' ),
						'status'        => __( 'Research paper', 'heliolisk' ),
					),
					array(
						'meta_category' => __( 'Human Rights', 'heliolisk' ),
						'meta_year'     => __( '2025', 'heliolisk' ),
						'title'         => __( 'Dignity, Equality and Administrative Decision-Making', 'heliolisk' ),
						'description'   => __( 'A short commentary on how human-rights reasoning can inform administrative decision-making and access to justice in Bangladesh.', 'heliolisk' ),
						'status'        => __( 'Commentary', 'heliolisk' ),
					),
					array(
						'meta_category' => __( 'Case Analysis', 'heliolisk' ),
						'meta_year'     => __( '2024', 'heliolisk' ),
						'title'         => __( 'Reading Appellate Division Judgments Beyond the Holding', 'heliolisk' ),
						'description'   => __( 'A case-note on method: separating facts, issues, reasoning and obiter from the final order.', 'heliolisk' ),
						'status'        => __( 'Case note', 'heliolisk' ),
					),
					array(
						'meta_category' => __( 'Practice Note', 'heliolisk' ),
						'meta_year'     => __( '2024', 'heliolisk' ),
						'title'         => __( 'Research Methods for Bangladeshi Public Law: A Practitioner\'s Notes', 'heliolisk' ),
						'description'   => __( 'A reflective piece on building a transparent research trail, from question design to citation practice using Bangla and English sources.', 'heliolisk' ),
						'status'        => __( 'Research note', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ title }}}',
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
					'{{WRAPPER}} .hlw-law-research' => '--hlw-law-research-paper: {{VALUE}}; background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-research' => '--hlw-law-research-ink: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-research' => '--hlw-law-research-gold: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-research' => '--hlw-law-research-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-research' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-research__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__eyebrow',
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
					'{{WRAPPER}} .hlw-law-research__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-research__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__title',
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
					'{{WRAPPER}} .hlw-law-research__title' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-research__intro' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-research__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__intro',
			)
		);

		$this->add_control(
			'sample_note_color',
			array(
				'label'     => __( 'Sample Note Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-research__sample-note' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sample_note_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__sample-note',
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
			'meta_color',
			array(
				'label'     => __( 'Meta Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-research__meta' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__meta',
			)
		);

		$this->add_control(
			'item_title_color',
			array(
				'label'     => __( 'Item Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101A2B',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-research__item-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__item-title',
			)
		);

		$this->add_control(
			'item_desc_color',
			array(
				'label'     => __( 'Item Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#596474',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-research__item-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_desc_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__item-desc',
			)
		);

		$this->add_control(
			'status_color',
			array(
				'label'     => __( 'Status Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#856536',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-research__status' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_typography',
				'selector' => '{{WRAPPER}} .hlw-law-research__status',
			)
		);

		$this->add_responsive_control(
			'items_gap',
			array(
				'label'      => __( 'Gap Between Items', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-research__list' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-law-research"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-research__inner">
				<header class="hlw-law-research__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-research__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-research__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<div>
						<?php if ( ! empty( $settings['intro'] ) ) : ?>
							<p class="hlw-law-research__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['sample_note'] ) ) : ?>
							<p class="hlw-law-research__sample-note"><?php echo esc_html( $settings['sample_note'] ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<?php if ( ! empty( $settings['research_items'] ) ) : ?>
					<div class="hlw-law-research__list">
						<?php foreach ( $settings['research_items'] as $item ) : ?>
							<article class="hlw-law-research__item">
								<div class="hlw-law-research__meta">
									<?php if ( ! empty( $item['meta_category'] ) ) : ?>
										<span class="hlw-law-research__meta-category"><?php echo esc_html( $item['meta_category'] ); ?></span>
									<?php endif; ?>
									<?php if ( ! empty( $item['meta_year'] ) ) : ?>
										<span class="hlw-law-research__meta-year"><?php echo esc_html( $item['meta_year'] ); ?></span>
									<?php endif; ?>
								</div>

								<?php if ( ! empty( $item['title'] ) ) : ?>
									<h3 class="hlw-law-research__item-title"><?php echo esc_html( $item['title'] ); ?></h3>
								<?php endif; ?>

								<?php if ( ! empty( $item['description'] ) ) : ?>
									<p class="hlw-law-research__item-desc"><?php echo esc_html( $item['description'] ); ?></p>
								<?php endif; ?>

								<?php if ( ! empty( $item['status'] ) ) : ?>
									<span class="hlw-law-research__status"><?php echo esc_html( $item['status'] ); ?></span>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
