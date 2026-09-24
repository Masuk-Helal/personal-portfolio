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
		return array( 'personal-portfolio' );
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
						'org_name' => __( '10 Minute School', 'heliolisk' ),
						'org_date' => __( 'Nov 2023 — Present', 'heliolisk' ),
						'positions' => array(
							array(
								'title'       => __( 'Executive (Content Operations)', 'heliolisk' ),
								'date'        => __( 'Jan 2026 — Present', 'heliolisk' ),
								'meta'        => __( 'Full-time · Mohakhali, Dhaka', 'heliolisk' ),
								'description' => __( "Oversees end-to-end LIVE and recorded class operations on 10 Minute School's Class Operations & Productions (COP) team — live-streaming management, studio operations, content editing & publishing, platform management across CMS, CMS-360 and Teacher's Dashboard, cross-functional coordination and team development.", 'heliolisk' ),
								'quote'       => __( "We don't stand in the spotlight. But we make sure the spotlight never goes out.", 'heliolisk' ),
							),
							array(
								'title'       => __( 'Operations Coordinator – Content', 'heliolisk' ),
								'date'        => __( 'Nov 2023 — Dec 2025', 'heliolisk' ),
								'meta'        => __( 'Contractual · Mohakhali, Dhaka', 'heliolisk' ),
								'description' => __( 'Crafting engaging, impactful educational materials as part of the Content Operations team.', 'heliolisk' ),
							),
						),
						'tags' => array(
							array( 'tag_text' => __( 'Live Class Operations', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Recorded Content Operations', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Operational Reporting', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Studio Coordination', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Teacher Communication', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Dashboard & CMS Management', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Asset & Technical Coordination', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Cross-functional Collaboration', 'heliolisk' ) ),
							array( 'tag_text' => __( 'Process Improvement', 'heliolisk' ) ),
						),
					),
					array(
						'org_name' => __( 'National Newspaper Olympiad (NNO Global)', 'heliolisk' ),
						'org_date' => __( 'Mar 2025 — Present', 'heliolisk' ),
						'positions' => array(
							array(
								'title'       => __( 'Chief Marketing Officer', 'heliolisk' ),
								'date'        => __( 'Dec 2025 — Present', 'heliolisk' ),
								'meta'        => __( 'Part-time · Dhaka · Hybrid', 'heliolisk' ),
								'description' => __( 'Leading strategic marketing management, communications and public relations.', 'heliolisk' ),
							),
							array(
								'title'       => __( 'Communications Executive', 'heliolisk' ),
								'date'        => __( 'Mar 2025 — Dec 2025', 'heliolisk' ),
								'meta'        => __( 'Seasonal · Dhaka', 'heliolisk' ),
								'description' => __( 'Contributed to purpose-driven storytelling and creative collaboration.', 'heliolisk' ),
							),
						),
					),
					array(
						'org_name'        => __( 'Content Writer', 'heliolisk' ),
						'org_date'        => __( 'Apr 2023 — Nov 2023', 'heliolisk' ),
						'org_meta'        => __( 'Editorial News 24 · Internship', 'heliolisk' ),
						'org_description' => __( 'Research, storytelling, editing, SEO, deadline management and engaging audiences.', 'heliolisk' ),
					),
					array(
						'org_name'        => __( 'UX Research Assistant', 'heliolisk' ),
						'org_date'        => __( 'Jul 2022 · 1 mo', 'heliolisk' ),
						'org_meta'        => __( 'CMED Health · Part-time', 'heliolisk' ),
						'org_description' => __( 'Drove user-centric insights for product enhancement through diverse research methodologies and actionable recommendations.', 'heliolisk' ),
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
								'title' => __( 'UIU Finance Forum', 'heliolisk' ),
								'date'  => __( 'Jun 2022 — Present', 'heliolisk' ),
								'positions' => array(
									array( 'title' => __( 'Co-Head of Brand', 'heliolisk' ), 'date' => __( 'Feb 2023 — Present', 'heliolisk' ) ),
									array( 'title' => __( 'Member', 'heliolisk' ), 'date' => __( 'Jun 2022 — Present', 'heliolisk' ) ),
								),
							),
							array(
								'title' => __( 'Publication Secretary', 'heliolisk' ),
								'date'  => __( 'Nov 2020 — Sep 2021', 'heliolisk' ),
								'org'   => __( 'Science Club of Rouf College (SCRC)', 'heliolisk' ),
							),
						),
					),
					array(
						'heading' => __( 'Education', 'heliolisk' ),
						'items'   => array(
							array(
								'title' => __( 'BBA, Business Administration', 'heliolisk' ),
								'date'  => __( 'Jun 2022 — Present', 'heliolisk' ),
								'org'   => __( 'United International University', 'heliolisk' ),
							),
							array(
								'title' => __( 'HSC', 'heliolisk' ),
								'date'  => __( '2020', 'heliolisk' ),
								'org'   => __( 'Birshreshtha Munshi Abdur Rouf Public College · Dhaka Board', 'heliolisk' ),
							),
							array(
								'title' => __( 'SSC', 'heliolisk' ),
								'date'  => __( '2018', 'heliolisk' ),
								'org'   => __( 'Jhalakati Govt. High School · Barisal Board', 'heliolisk' ),
							),
						),
					),
					array(
						'heading' => __( 'Certificates & Achievements', 'heliolisk' ),
						'items'   => array(
							array(
								'title' => __( 'Organizer, "The Excelist 2022"', 'heliolisk' ),
								'date'  => __( 'Dec 2022', 'heliolisk' ),
								'org'   => __( 'Microsoft-authorized event, powered by VUMI', 'heliolisk' ),
							),
							array(
								'title' => __( 'SCRC 2nd National Science Festival', 'heliolisk' ),
								'date'  => __( 'Jan 2020', 'heliolisk' ),
								'org'   => __( 'Organizer · Science Club of Rouf College', 'heliolisk' ),
							),
							array(
								'title' => __( 'Certificate of UX Research Completion', 'heliolisk' ),
								'date'  => __( 'Jul 2022', 'heliolisk' ),
								'org'   => __( 'CMED Health', 'heliolisk' ),
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
