<?php

/**
 * Elementor "What I Do" widget — fully self-contained, no theme dependency.
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Whatido_Widget extends Widget_Base
{

	public function get_name()
	{
		return 'hlw-whatido';
	}

	public function get_title()
	{
		return __('What I Do', 'heliolisk');
	}

	public function get_icon()
	{
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-whatido-panel-icon';
	}

	public function get_categories()
	{
		return array('personal-portfolio');
	}

	public function get_keywords()
	{
		return array('what i do', 'capabilities', 'services', 'cards');
	}

	public function get_style_depends()
	{
		return array(Heliolisk_Elementor::style_handle('whatido'));
	}

	protected function register_controls()
	{
		$this->register_content_text_controls();
		$this->register_content_cards_controls();
		$this->register_content_cards_controls();

		$this->register_style_kicker_controls();
		$this->register_style_heading_controls();
		$this->register_style_sub_controls();
		$this->register_style_card_controls();
		$this->register_content_advanced_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_text_controls()
	{
		$this->start_controls_section(
			'section_content_text',
			array(
				'label' => __('Text', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'kicker_text',
			array(
				'label'   => __('Kicker', 'heliolisk'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('What I Do', 'heliolisk'),
			)
		);

		$this->add_control(
			'kicker_bar',
			array(
				'label'        => __('Show Kicker Bar', 'heliolisk'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'heading_text',
			array(
				'label'   => __('Heading', 'heliolisk'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('What', 'heliolisk'),
			)
		);

		$this->add_control(
			'heading_accent',
			array(
				'label'   => __('Heading — Accent Word', 'heliolisk'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('I Do', 'heliolisk'),
			)
		);

		$this->add_control(
			'sub_text',
			array(
				'label'   => __('Sub Description', 'heliolisk'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __('I design, build and run operational systems and content workflows that are fast, reliable and outcome-focused.', 'heliolisk'),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_cards_controls()
	{
		$this->start_controls_section(
			'section_content_cards',
			array(
				'label' => __('Cards', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => __('Icon', 'heliolisk'),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-layer-group',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => __('Title', 'heliolisk'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Title', 'heliolisk'),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => __('Description', 'heliolisk'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __('Description', 'heliolisk'),
			)
		);

		$repeater->add_control(
			'number',
			array(
				'label'   => __('Number Badge', 'heliolisk'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('01', 'heliolisk'),
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => __('Cards', 'heliolisk'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'icon'        => array('value' => 'fas fa-layer-group', 'library' => 'fa-solid'),
						'title'       => __('Operations', 'heliolisk'),
						'description' => __('Live class operations, process management and workflow design across cross-functional teams.', 'heliolisk'),
						'number'      => '01',
					),
					array(
						'icon'        => array('value' => 'fas fa-chart-line', 'library' => 'fa-solid'),
						'title'       => __('Data & Analytics', 'heliolisk'),
						'description' => __('Data analysis, reporting and dashboard development that turn numbers into decisions.', 'heliolisk'),
						'number'      => '02',
					),
					array(
						'icon'        => array('value' => 'fas fa-file-alt', 'library' => 'fa-solid'),
						'title'       => __('Content Operations', 'heliolisk'),
						'description' => __('Content workflow, digital operations and quality monitoring for consistent output.', 'heliolisk'),
						'number'      => '03',
					),
					array(
						'icon'        => array('value' => 'fas fa-bolt', 'library' => 'fa-solid'),
						'title'       => __('Technology & Automation', 'heliolisk'),
						'description' => __('AI tools, automation and no-code/low-code systems that remove manual work.', 'heliolisk'),
						'number'      => '04',
					),
					array(
						'icon'        => array('value' => 'fas fa-bullhorn', 'library' => 'fa-solid'),
						'title'       => __('Marketing', 'heliolisk'),
						'description' => __('Content marketing, SEO and strategic marketing that drive reach and engagement.', 'heliolisk'),
						'number'      => '05',
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);


		$this->end_controls_section();
	}

	private function register_content_advanced_controls()
	{
		$this->start_controls_section(
			'section_content_advanced',
			array(
				'label' => __('Advanced', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_id',
			array(
				'label'       => __('Section ID', 'heliolisk'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'about',
				'description' => __('Sets this section\'s HTML id, e.g. for the "#about" nav menu link to scroll here. Leave blank for no id.', 'heliolisk'),
			)
		);

		$this->end_controls_section();
	}



	/* ==================== STYLE TAB ==================== */

	private function register_style_kicker_controls()
	{
		$this->start_controls_section(
			'section_style_kicker',
			array(
				'label' => __('Kicker', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'kicker_color',
			array(
				'label'     => __('Text Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__kicker' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'kicker_bar_color',
			array(
				'label'     => __('Bar Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__kicker-bar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'kicker_typography',
				'selector' => '{{WRAPPER}} .hlw-whatido__kicker',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_heading_controls()
	{
		$this->start_controls_section(
			'section_style_heading',
			array(
				'label' => __('Heading', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => __('Text Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_accent_color',
			array(
				'label'     => __('Accent Word Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__accent' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .hlw-whatido__heading',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_sub_controls()
	{
		$this->start_controls_section(
			'section_style_sub',
			array(
				'label' => __('Sub Description', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'sub_color',
			array(
				'label'     => __('Text Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__sub' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_typography',
				'selector' => '{{WRAPPER}} .hlw-whatido__sub',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_card_controls()
	{
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => __('Cards', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => __('Background Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_border_radius',
			array(
				'label'     => __('Border Radius', 'heliolisk'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array('px' => array('min' => 0, 'max' => 40)),
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__card' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_icon_color',
			array(
				'label'     => __('Icon Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__card-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => __('Title Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_desc_color',
			array(
				'label'     => __('Description Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a9a9b8',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__card-desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_number_color',
			array(
				'label'     => __('Number Badge Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(244, 245, 251, 0.15)',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__card-num' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_gap',
			array(
				'label'     => __('Gap Between Cards', 'heliolisk'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array('px' => array('min' => 0, 'max' => 80)),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido__cards' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_section_controls()
	{
		$this->start_controls_section(
			'section_style_section',
			array(
				'label' => __('Section', 'heliolisk'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'section_bg_color',
			array(
				'label'     => __('Background Color', 'heliolisk'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-whatido' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => __('Padding', 'heliolisk'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-whatido' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render()
	{
		$settings = $this->get_settings_for_display();
?>
		<section class="hlw-whatido" <?php echo ! empty($settings['section_id']) ? ' id="' . esc_attr($settings['section_id']) . '"' : ''; ?>>
			<div class="hlw-whatido__inner">
				<div class="hlw-whatido__intro">
					<?php if (! empty($settings['kicker_text'])) : ?>
						<p class="hlw-whatido__kicker">
							<?php if ('yes' === $settings['kicker_bar']) : ?>
								<span class="hlw-whatido__kicker-bar"></span>
							<?php endif; ?>
							<?php echo esc_html($settings['kicker_text']); ?>
						</p>
					<?php endif; ?>

					<?php if (! empty($settings['heading_text']) || ! empty($settings['heading_accent'])) : ?>
						<h2 class="hlw-whatido__heading">
							<?php echo esc_html($settings['heading_text']); ?>
							<?php if (! empty($settings['heading_accent'])) : ?>
								<span class="hlw-whatido__accent"><?php echo esc_html($settings['heading_accent']); ?></span>
							<?php endif; ?>
						</h2>
					<?php endif; ?>

					<?php if (! empty($settings['sub_text'])) : ?>
						<p class="hlw-whatido__sub"><?php echo esc_html($settings['sub_text']); ?></p>
					<?php endif; ?>
				</div>

				<?php if (! empty($settings['cards'])) : ?>
					<div class="hlw-whatido__cards">
						<?php foreach ($settings['cards'] as $card) : ?>
							<div class="hlw-whatido__card">
								<?php if (! empty($card['icon']['value'])) : ?>
									<div class="hlw-whatido__card-icon">
										<?php \Elementor\Icons_Manager::render_icon($card['icon'], array('aria-hidden' => 'true')); ?>
									</div>
								<?php endif; ?>
								<?php if (! empty($card['title'])) : ?>
									<h3 class="hlw-whatido__card-title"><?php echo esc_html($card['title']); ?></h3>
								<?php endif; ?>
								<?php if (! empty($card['description'])) : ?>
									<p class="hlw-whatido__card-desc"><?php echo esc_html($card['description']); ?></p>
								<?php endif; ?>
								<?php if (! empty($card['number'])) : ?>
									<span class="hlw-whatido__card-num"><?php echo esc_html($card['number']); ?></span>
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
