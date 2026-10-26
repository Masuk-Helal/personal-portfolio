<?php
/**
 * Elementor "Experience" widget — fully self-contained, no theme dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Experience_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-experience';
	}

	public function get_title() {
		return __( 'Experience', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-experience-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'experience', 'timeline', 'work', 'career', 'resume', 'cv' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'experience' ) );
	}

	protected function register_controls() {
		$this->register_content_timeline_controls();
		$this->register_content_columns_controls();
		$this->register_content_advanced_controls();

		$this->register_style_timeline_controls();
		$this->register_style_columns_controls();
		$this->register_style_section_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_timeline_controls() {
		$this->start_controls_section(
			'section_content_timeline',
			array(
				'label' => __( 'Timeline', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'timeline_heading',
			array(
				'label'   => __( 'Timeline Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Work Experience', 'heliolisk' ),
			)
		);

		$position = new Repeater();

		$position->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Role Title', 'heliolisk' ),
			)
		);

		$position->add_control(
			'date',
			array(
				'label'   => __( 'Date Range', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Jan 2024 — Present', 'heliolisk' ),
			)
		);

		$position->add_control(
			'meta',
			array(
				'label'   => __( 'Meta Line', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Full-time · Location', 'heliolisk' ),
			)
		);

		$position->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'heliolisk' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
			)
		);

		$position->add_control(
			'quote',
			array(
				'label'   => __( 'Quote', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$tag = new Repeater();

		$tag->add_control(
			'tag_text',
			array(
				'label'   => __( 'Tag', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tag', 'heliolisk' ),
			)
		);

		$item = new Repeater();

		$item->add_control(
			'org_name',
			array(
				'label'   => __( 'Organization', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Organization Name', 'heliolisk' ),
			)
		);

		$item->add_control(
			'org_date',
			array(
				'label'   => __( 'Date Range', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Jan 2024 — Present', 'heliolisk' ),
			)
		);

		$item->add_control(
			'org_meta',
			array(
				'label'       => __( 'Single-Role Meta Line', 'heliolisk' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Used only when this entry has no positions below — e.g. "Company · Internship".', 'heliolisk' ),
				'default'     => '',
			)
		);

		$item->add_control(
			'org_description',
			array(
				'label'       => __( 'Single-Role Description', 'heliolisk' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Used only when this entry has no positions below.', 'heliolisk' ),
				'default'     => '',
			)
		);

		$item->add_control(
			'positions',
			array(
				'label'       => __( 'Positions', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $position->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);

		$item->add_control(
			'tags',
			array(
				'label'       => __( 'Tags', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tag->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ tag_text }}}',
			)
		);

		$this->add_control(
			'timeline_items',
			array(
				'label'       => __( 'Timeline Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $item->get_controls(),
				'default'     => array(
					array(
						'org_name' => __( 'Company One', 'heliolisk' ),
						'org_date' => __( 'Jan 2023 — Present', 'heliolisk' ),
						'positions' => array(
							array(
								'title'       => __( 'Senior Role Title', 'heliolisk' ),
								'date'        => __( 'Jan 2025 — Present', 'heliolisk' ),
								'meta'        => __( 'Full-time · City', 'heliolisk' ),
								'description' => __( 'Describe your responsibilities, the team you work with and the results you deliver in this role.', 'heliolisk' ),
								'quote'       => __( 'A short line that sums up how you work.', 'heliolisk' ),
							),
							array(
								'title'       => __( 'Role Title', 'heliolisk' ),
								'date'        => __( 'Jan 2023 — Dec 2024', 'heliolisk' ),
								'meta'        => __( 'Contract · City', 'heliolisk' ),
								'description' => __( 'A short summary of what you worked on and what you achieved.', 'heliolisk' ),
							),
						),
						'tags' => array(
							array( 'tag_text' => __( 'Skill One', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Skill Two', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Skill Three', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Skill Four', 'heliolisk' ) ),
						),
					),
					array(
						'org_name' => __( 'Company Two', 'heliolisk' ),
						'org_date' => __( 'Mar 2021 — Dec 2022', 'heliolisk' ),
						'positions' => array(
							array(
								'title'       => __( 'Role Title', 'heliolisk' ),
								'date'        => __( 'Jun 2021 — Dec 2022', 'heliolisk' ),
								'meta'        => __( 'Part-time · Remote', 'heliolisk' ),
								'description' => __( 'Leading a workstream and reporting on its results.', 'heliolisk' ),
							),
							array(
								'title'       => __( 'Junior Role Title', 'heliolisk' ),
								'date'        => __( 'Mar 2021 — May 2021', 'heliolisk' ),
								'meta'        => __( 'Seasonal · City', 'heliolisk' ),
								'description' => __( 'Contributed to projects and learned the team\'s tools and processes.', 'heliolisk' ),
							),
						),
					),
					array(
						'org_name'        => __( 'Single Role Title', 'heliolisk' ),
						'org_date'        => __( 'Apr 2020 — Nov 2020', 'heliolisk' ),
						'org_meta'        => __( 'Company Three · Internship', 'heliolisk' ),
						'org_description' => __( 'Research, writing, editing and meeting deadlines.', 'heliolisk' ),
					),
				),
				'title_field' => '{{{ org_name }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_columns_controls() {
		$this->start_controls_section(
			'section_content_columns',
			array(
				'label' => __( 'Extra Columns', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$sub_position = new Repeater();

		$sub_position->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Position', 'heliolisk' ),
			)
		);

		$sub_position->add_control(
			'date',
			array(
				'label'   => __( 'Date Range', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Jan 2024 — Present', 'heliolisk' ),
			)
		);

		$col_item = new Repeater();

		$col_item->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Item Title', 'heliolisk' ),
			)
		);

		$col_item->add_control(
			'date',
			array(
				'label'   => __( 'Date', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$col_item->add_control(
			'org',
			array(
				'label'   => __( 'Organization / Subtitle', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$col_item->add_control(
			'positions',
			array(
				'label'       => __( 'Sub-Positions', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $sub_position->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);

		$column = new Repeater();

		$column->add_control(
			'heading',
			array(
				'label'   => __( 'Column Heading', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Column', 'heliolisk' ),
			)
		);

		$column->add_control(
			'items',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $col_item->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'       => __( 'Columns', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $column->get_controls(),
				'default'     => array(
					array(
						'heading' => __( 'Leadership & Activities', 'heliolisk' ),
						'items'   => array(
							array(
								'title' => __( 'Club or Organization', 'heliolisk' ),
								'date'  => __( 'Jun 2022 — Present', 'heliolisk' ),
								'positions' => array(
									array( 'title' => __( 'Lead Role', 'heliolisk' ), 'date' => __( 'Feb 2023 — Present', 'heliolisk' ) ),
									array( 'title' => __( 'Member', 'heliolisk' ), 'date' => __( 'Jun 2022 — Present', 'heliolisk' ) ),
								),
							),
							array(
								'title' => __( 'Committee Role', 'heliolisk' ),
								'date'  => __( 'Nov 2020 — Sep 2021', 'heliolisk' ),
								'org'   => __( 'Another Organization', 'heliolisk' ),
							),
						),
					),
					array(
						'heading' => __( 'Education', 'heliolisk' ),
						'items'   => array(
							array(
								'title' => __( 'Degree, Field of Study', 'heliolisk' ),
								'date'  => __( '2018 — 2022', 'heliolisk' ),
								'org'   => __( 'University Name', 'heliolisk' ),
							),
							array(
								'title' => __( 'Higher Secondary', 'heliolisk' ),
								'date'  => __( '2016', 'heliolisk' ),
								'org'   => __( 'College Name', 'heliolisk' ),
							),
						),
					),
					array(
						'heading' => __( 'Certificates & Achievements', 'heliolisk' ),
						'items'   => array(
							array(
								'title' => __( 'Certificate Title', 'heliolisk' ),
								'date'  => __( 'Jul 2022', 'heliolisk' ),
								'org'   => __( 'Issuing Organization', 'heliolisk' ),
							),
							array(
								'title' => __( 'Award or Event', 'heliolisk' ),
								'date'  => __( 'Dec 2021', 'heliolisk' ),
								'org'   => __( 'Organizer', 'heliolisk' ),
							),
						),
					),
				),
				'title_field' => '{{{ heading }}}',
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
				'default'     => 'experience',
				'description' => __( 'Sets this section\'s HTML id, e.g. for the "#experience" nav menu link to scroll here. Leave blank for no id.', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

	private function register_style_timeline_controls() {
		$this->start_controls_section(
			'section_style_timeline',
			array(
				'label' => __( 'Timeline', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'timeline_dot_color',
			array(
				'label'     => __( 'Dot / Line Accent', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-experience__tl-item::before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hlw-experience__tl-org'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .hlw-experience__tp-meta'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .hlw-experience__tp-quote'        => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'timeline_role_color',
			array(
				'label'     => __( 'Role / Title Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-experience__tl-role' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_columns_controls() {
		$this->start_controls_section(
			'section_style_columns',
			array(
				'label' => __( 'Extra Columns', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'columns_heading_color',
			array(
				'label'     => __( 'Column Heading Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-experience__col-heading' => 'color: {{VALUE}};',
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
				'default'   => '#0a0d1c',
				'selectors' => array(
					'{{WRAPPER}} .hlw-experience' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .hlw-experience' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hlw-experience"<?php echo ! empty( $settings['section_id'] ) ? ' id="' . esc_attr( $settings['section_id'] ) . '"' : ''; ?>>
			<div class="hlw-experience__inner">

				<?php if ( ! empty( $settings['timeline_items'] ) ) : ?>

					<?php if ( ! empty( $settings['timeline_heading'] ) ) : ?>
						<h3 class="hlw-experience__tl-heading"><?php echo esc_html( $settings['timeline_heading'] ); ?></h3>
					<?php endif; ?>

					<div class="hlw-experience__timeline">
						<?php foreach ( $settings['timeline_items'] as $tl_item ) : ?>
							<div class="hlw-experience__tl-item">
								<div class="hlw-experience__tl-top">
									<h4 class="hlw-experience__tl-role"><?php echo esc_html( $tl_item['org_name'] ); ?></h4>
									<span class="hlw-experience__tl-date"><?php echo esc_html( $tl_item['org_date'] ); ?></span>
								</div>

								<?php if ( ! empty( $tl_item['positions'] ) ) : ?>
									<div class="hlw-experience__tl-positions">
										<?php foreach ( $tl_item['positions'] as $position ) : ?>
											<div class="hlw-experience__tl-position">
												<div class="hlw-experience__tp-top">
													<span class="hlw-experience__tp-title"><?php echo esc_html( $position['title'] ); ?></span>
													<span class="hlw-experience__tp-date"><?php echo esc_html( $position['date'] ); ?></span>
												</div>
												<?php if ( ! empty( $position['meta'] ) ) : ?>
													<p class="hlw-experience__tp-meta"><?php echo esc_html( $position['meta'] ); ?></p>
												<?php endif; ?>
												<?php if ( ! empty( $position['description'] ) ) : ?>
													<p class="hlw-experience__tp-desc"><?php echo esc_html( $position['description'] ); ?></p>
												<?php endif; ?>
												<?php if ( ! empty( $position['quote'] ) ) : ?>
													<p class="hlw-experience__tp-quote">&ldquo;<?php echo esc_html( $position['quote'] ); ?>&rdquo;</p>
												<?php endif; ?>
											</div>
										<?php endforeach; ?>
									</div>
								<?php else : ?>
									<?php if ( ! empty( $tl_item['org_meta'] ) ) : ?>
										<p class="hlw-experience__tl-org"><?php echo esc_html( $tl_item['org_meta'] ); ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $tl_item['org_description'] ) ) : ?>
										<p class="hlw-experience__tl-desc"><?php echo esc_html( $tl_item['org_description'] ); ?></p>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ( ! empty( $tl_item['tags'] ) ) : ?>
									<div class="hlw-experience__tl-tags">
										<?php foreach ( $tl_item['tags'] as $tag ) : ?>
											<span class="hlw-experience__tag"><?php echo esc_html( $tag['tag_text'] ); ?></span>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['columns'] ) ) : ?>
					<div class="hlw-experience__columns">
						<?php foreach ( $settings['columns'] as $column ) : ?>
							<div class="hlw-experience__col">
								<?php if ( ! empty( $column['heading'] ) ) : ?>
									<h3 class="hlw-experience__col-heading"><?php echo esc_html( $column['heading'] ); ?></h3>
								<?php endif; ?>

								<?php if ( ! empty( $column['items'] ) ) : ?>
									<div class="hlw-experience__col-items">
										<?php foreach ( $column['items'] as $col_item ) : ?>
											<div class="hlw-experience__ci">
												<div class="hlw-experience__ci-top">
													<span class="hlw-experience__ci-title"><?php echo esc_html( $col_item['title'] ); ?></span>
													<?php if ( ! empty( $col_item['date'] ) ) : ?>
														<span class="hlw-experience__ci-date"><?php echo esc_html( $col_item['date'] ); ?></span>
													<?php endif; ?>
												</div>

												<?php if ( ! empty( $col_item['positions'] ) ) : ?>
													<div class="hlw-experience__ci-positions">
														<?php foreach ( $col_item['positions'] as $sub ) : ?>
															<div class="hlw-experience__ci-position">
																<span class="hlw-experience__cip-title"><?php echo esc_html( $sub['title'] ); ?></span>
																<span class="hlw-experience__cip-date"><?php echo esc_html( $sub['date'] ); ?></span>
															</div>
														<?php endforeach; ?>
													</div>
												<?php elseif ( ! empty( $col_item['org'] ) ) : ?>
													<p class="hlw-experience__ci-org"><?php echo esc_html( $col_item['org'] ); ?></p>
												<?php endif; ?>
											</div>
										<?php endforeach; ?>
									</div>
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
