<?php
/**
 * Elementor "Law Skills" widget — fully self-contained, no theme dependency.
 *
 * Skills & strengths card grid for a lawyer or legal practice, adapted from
 * the index-6 law portfolio layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Law_Skills_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-law-skills';
	}

	public function get_title() {
		return __( 'Law Skills', 'heliolisk' );
	}

	public function get_icon() {
		return 'hlw-law-skills-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'law', 'lawyer', 'advocate', 'skills', 'strengths', 'capabilities', 'legal' );
	}

	public function get_style_depends() {
		return array( 'heliolisk-law-fonts', Heliolisk_Elementor::style_handle( 'law-skills' ) );
	}

	protected function register_controls() {
		$this->register_content_heading_controls();
		$this->register_content_skills_controls();

		$this->register_style_section_controls();
		$this->register_style_eyebrow_controls();
		$this->register_style_heading_controls();
		$this->register_style_intro_controls();
		$this->register_style_grid_controls();
		$this->register_style_card_controls();
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
				'default'     => 'skills',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#skills" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'     => __( 'Eyebrow', 'heliolisk' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( '06 / Skills & Strengths', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'The habits behind the', 'heliolisk' ),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __( 'Heading — Accent', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'work.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'intro',
			array(
				'label'     => __( 'Section Introduction', 'heliolisk' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Strengths developed through legal practice, advocacy and research in Bangladesh. No percentage scores — just the capabilities I bring to a case and the evidence behind them.', 'heliolisk' ),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_skills_controls() {
		$this->start_controls_section(
			'section_content_skills',
			array(
				'label' => __( 'Skill Cards', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'num',
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
				'default' => __( 'Legal Research', 'heliolisk' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Locating, reading and synthesising primary and secondary sources, including Bangladesh Supreme Court judgments and statutes.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'skill_items',
			array(
				'label'       => __( 'Skills', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'num'         => __( '01', 'heliolisk' ),
						'title'       => __( 'Legal Research', 'heliolisk' ),
						'description' => __( 'Locating, reading and synthesising primary and secondary sources, including Bangladesh Supreme Court judgments and statutes.', 'heliolisk' ),
					),
					array(
						'num'         => __( '02', 'heliolisk' ),
						'title'       => __( 'Critical Thinking', 'heliolisk' ),
						'description' => __( 'Testing arguments, identifying assumptions and following reasoning to its limits.', 'heliolisk' ),
					),
					array(
						'num'         => __( '03', 'heliolisk' ),
						'title'       => __( 'Analytical Writing', 'heliolisk' ),
						'description' => __( 'Turning complex doctrine into clear, structured and persuasive prose.', 'heliolisk' ),
					),
					array(
						'num'         => __( '04', 'heliolisk' ),
						'title'       => __( 'Bangla & English Advocacy', 'heliolisk' ),
						'description' => __( 'Presenting arguments clearly in Bangla and English, with composure and respect for opposing views.', 'heliolisk' ),
					),
					array(
						'num'         => __( '05', 'heliolisk' ),
						'title'       => __( 'Case Analysis', 'heliolisk' ),
						'description' => __( 'Distilling facts, issues and holdings from judgments and applying them responsibly.', 'heliolisk' ),
					),
					array(
						'num'         => __( '06', 'heliolisk' ),
						'title'       => __( 'Legal Drafting', 'heliolisk' ),
						'description' => __( 'Drafting structured submissions, case notes and research memos with accurate citation.', 'heliolisk' ),
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
				'default'   => '#101A2B',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills' => '--hlw-law-skills-charcoal: {{VALUE}}; background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-skills' => '--hlw-law-skills-gold: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-skills' => '--hlw-law-skills-ivory: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-skills' => '--hlw-law-skills-muted: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-skills' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .hlw-law-skills__eyebrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'eyebrow_typography',
				'selector' => '{{WRAPPER}} .hlw-law-skills__eyebrow',
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
					'{{WRAPPER}} .hlw-law-skills__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __( 'Accent Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C6A568',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__title em' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-law-skills__title',
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
					'{{WRAPPER}} .hlw-law-skills__title' => 'max-width: {{SIZE}}{{UNIT}};',
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
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__intro' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-law-skills__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'intro_typography',
				'selector' => '{{WRAPPER}} .hlw-law-skills__intro',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_grid_controls() {
		$this->start_controls_section(
			'section_style_grid',
			array(
				'label' => __( 'Grid', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'grid_columns',
			array(
				'label'     => __( 'Columns', 'heliolisk' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				),
			)
		);

		$this->add_control(
			'grid_border_color',
			array(
				'label'     => __( 'Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(198,165,104,0.18)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills' => '--hlw-law-skills-border: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_card_controls() {
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => __( 'Card', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_hover_bg_color',
			array(
				'label'     => __( 'Hover Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(198,165,104,0.045)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__card:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => __( 'Padding', 'heliolisk' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-law-skills__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_heading',
			array(
				'label'     => __( 'Card Content', 'heliolisk' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'num_color',
			array(
				'label'     => __( 'Number Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__num' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'num_typography',
				'selector' => '{{WRAPPER}} .hlw-law-skills__num',
			)
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => __( 'Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F1E8',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .hlw-law-skills__card-title',
			)
		);

		$this->add_control(
			'card_text_color',
			array(
				'label'     => __( 'Description Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#AAB3C2',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-law-skills__card-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_text_typography',
				'selector' => '{{WRAPPER}} .hlw-law-skills__card-text',
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-law-skills"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-law-skills__inner">
				<header class="hlw-law-skills__head">
					<div>
						<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
							<p class="hlw-law-skills__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['heading_accent'] ) ) : ?>
							<h2 class="hlw-law-skills__title">
								<?php echo esc_html( $settings['heading'] ); ?>
								<?php if ( ! empty( $settings['heading_accent'] ) ) : ?>
									<em><?php echo esc_html( $settings['heading_accent'] ); ?></em>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $settings['intro'] ) ) : ?>
						<p class="hlw-law-skills__intro"><?php echo esc_html( $settings['intro'] ); ?></p>
					<?php endif; ?>
				</header>

				<?php if ( ! empty( $settings['skill_items'] ) ) : ?>
					<div class="hlw-law-skills__grid">
						<?php foreach ( $settings['skill_items'] as $item ) : ?>
							<article class="hlw-law-skills__card">
								<?php if ( ! empty( $item['num'] ) ) : ?>
									<span class="hlw-law-skills__num"><?php echo esc_html( $item['num'] ); ?></span>
								<?php endif; ?>

								<div>
									<?php if ( ! empty( $item['title'] ) ) : ?>
										<h3 class="hlw-law-skills__card-title"><?php echo esc_html( $item['title'] ); ?></h3>
									<?php endif; ?>

									<?php if ( ! empty( $item['description'] ) ) : ?>
										<p class="hlw-law-skills__card-text"><?php echo esc_html( $item['description'] ); ?></p>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
