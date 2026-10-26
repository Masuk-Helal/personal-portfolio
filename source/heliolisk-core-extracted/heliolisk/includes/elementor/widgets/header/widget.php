<?php
/**
 * Elementor "Header" widget — fully self-contained, no theme dependency.
 *
 * Logo, menu links and social icons in one bar, with a collapsing mobile
 * menu. Meant for a Heliolisk Header template (Heliolisk → Header).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

class Heliolisk_Header_Widget extends Widget_Base {

	public function get_name() {
		return 'hlw-header';
	}

	public function get_title() {
		return __( 'Header', 'heliolisk' );
	}

	public function get_icon() {
		// Not a real icon font class — it renders blank on its own. The
		// panel icon is drawn on top of it via CSS (see
		// Heliolisk_Elementor::enqueue_editor_panel_icon_css()).
		return 'hlw-header-panel-icon';
	}

	public function get_categories() {
		return array( 'heliolisk' );
	}

	public function get_keywords() {
		return array( 'header', 'menu', 'navigation', 'logo', 'social links' );
	}

	public function get_style_depends() {
		return array( Heliolisk_Elementor::style_handle( 'header' ) );
	}

	public function get_script_depends() {
		return array( Heliolisk_Elementor::script_handle( 'header' ) );
	}

	/**
	 * Social icons the widget can draw: key => array( label, inline SVG shapes ).
	 * Stroke icons on a 24px grid, so they inherit the link color.
	 *
	 * @return array<string, array{0: string, 1: string}>
	 */
	private static function social_icons() {
		return array(
			'linkedin'  => array( 'LinkedIn', '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/>' ),
			'github'    => array( 'GitHub', '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/>' ),
			'email'     => array( 'Email', '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>' ),
			'twitter'   => array( 'X / Twitter', '<path d="M4 4l11.733 16h4.267l-11.733-16z"/><path d="M4 20l6.768-6.768m2.46-2.46l6.772-6.772"/>' ),
			'facebook'  => array( 'Facebook', '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>' ),
			'instagram' => array( 'Instagram', '<rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>' ),
			'youtube'   => array( 'YouTube', '<path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/>' ),
			'link'      => array( 'Link', '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>' ),
		);
	}

	protected function register_controls() {
		$this->register_content_logo_controls();
		$this->register_content_menu_controls();
		$this->register_content_social_controls();
		$this->register_content_settings_controls();

		$this->register_style_bar_controls();
		$this->register_style_logo_controls();
		$this->register_style_menu_controls();
		$this->register_style_social_controls();
		$this->register_style_toggle_controls();
	}

	/* ==================== CONTENT TAB ==================== */

	private function register_content_logo_controls() {
		$this->start_controls_section(
			'section_content_logo',
			array(
				'label' => __( 'Logo', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'logo_image',
			array(
				'label'   => __( 'Logo Image', 'heliolisk' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => '' ),
			)
		);

		$this->add_control(
			'logo_text',
			array(
				'label'   => __( 'Logo Text', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Your Name', 'heliolisk' ),
			)
		);

		$this->add_control(
			'logo_link',
			array(
				'label'         => __( 'Logo Link', 'heliolisk' ),
				'type'          => Controls_Manager::URL,
				'default'       => array( 'url' => '#home' ),
				'show_external' => false,
			)
		);

		$this->end_controls_section();
	}

	private function register_content_menu_controls() {
		$this->start_controls_section(
			'section_content_menu',
			array(
				'label' => __( 'Menu', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$menus   = wp_get_nav_menus();
		$options = array(
			'' => __( 'Primary Menu location', 'heliolisk' ),
		);

		foreach ( $menus as $menu ) {
			$options[ (string) $menu->term_id ] = $menu->name;
		}

		$this->add_control(
			'menu_id',
			array(
				'label'       => __( 'WordPress Menu', 'heliolisk' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $options,
				'default'     => '',
				'description' => sprintf(
					/* translators: %s: link to Appearance → Menus. */
					__( 'Build the menu under %s. Add custom links such as #about for one-page sections.', 'heliolisk' ),
					'<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank" rel="noopener">' . esc_html__( 'Appearance → Menus', 'heliolisk' ) . '</a>'
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_social_controls() {
		$this->start_controls_section(
			'section_content_social',
			array(
				'label' => __( 'Social Icons', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$icon_options = array();
		foreach ( self::social_icons() as $key => $icon ) {
			$icon_options[ $key ] = $icon[0];
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'heliolisk' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $icon_options,
				'default' => 'linkedin',
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
			'social_items',
			array(
				'label'       => __( 'Items', 'heliolisk' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'icon' => 'linkedin',
						'link' => array( 'url' => 'https://www.linkedin.com/in/yourname', 'is_external' => true ),
					),
					array(
						'icon' => 'github',
						'link' => array( 'url' => 'https://github.com/yourname', 'is_external' => true ),
					),
					array(
						'icon' => 'email',
						'link' => array( 'url' => 'mailto:hello@example.com' ),
					),
				),
				'title_field' => '{{{ icon }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_content_settings_controls() {
		$this->start_controls_section(
			'section_content_settings',
			array(
				'label' => __( 'Settings', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sticky',
			array(
				'label'        => __( 'Sticky Header', 'heliolisk' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'heliolisk' ),
				'label_off'    => __( 'No', 'heliolisk' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => __( 'Keeps the header at the top of the screen while scrolling.', 'heliolisk' ),
			)
		);

		$this->add_control(
			'menu_label',
			array(
				'label'   => __( 'Mobile Menu Button Label', 'heliolisk' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Toggle menu', 'heliolisk' ),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== STYLE TAB ==================== */

	private function register_style_bar_controls() {
		$this->start_controls_section(
			'section_style_bar',
			array(
				'label' => __( 'Header Bar', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'bar_bg_color',
			array(
				'label'     => __( 'Background Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#080808',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bar_border_color',
			array(
				'label'     => __( 'Bottom Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#242438',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header' => 'border-bottom-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bar_height',
			array(
				'label'      => __( 'Bar Height', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 48, 'max' => 160 ) ),
				'default'    => array( 'size' => 78, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__inner' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bar_max_width',
			array(
				'label'      => __( 'Content Max Width', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 600, 'max' => 1920 ) ),
				'default'    => array( 'size' => 1280, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bar_padding',
			array(
				'label'      => __( 'Side Padding', 'heliolisk' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_logo_controls() {
		$this->start_controls_section(
			'section_style_logo',
			array(
				'label' => __( 'Logo', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'logo_text_color',
			array(
				'label'     => __( 'Text Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__logo-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'logo_typography',
				'selector' => '{{WRAPPER}} .hlw-header__logo-text',
			)
		);

		$this->add_responsive_control(
			'logo_image_size',
			array(
				'label'      => __( 'Image Size', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 20, 'max' => 120 ) ),
				'default'    => array( 'size' => 36, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__logo-mark' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'logo_image_border_color',
			array(
				'label'     => __( 'Image Border Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__logo-mark' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'logo_image_radius',
			array(
				'label'      => __( 'Image Radius', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array( 'min' => 0, 'max' => 50 ),
					'px' => array( 'min' => 0, 'max' => 60 ),
				),
				'default'    => array( 'size' => 50, 'unit' => '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__logo-mark' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_menu_controls() {
		$this->start_controls_section(
			'section_style_menu',
			array(
				'label' => __( 'Menu', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'menu_color',
			array(
				'label'     => __( 'Link Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__nav a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_hover_color',
			array(
				'label'     => __( 'Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__nav a:hover, {{WRAPPER}} .hlw-header__nav a:focus-visible, {{WRAPPER}} .hlw-header__nav .current-menu-item > a, {{WRAPPER}} .hlw-header__nav .current_page_item > a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'menu_typography',
				'selector' => '{{WRAPPER}} .hlw-header__nav a',
			)
		);

		$this->add_responsive_control(
			'menu_gap',
			array(
				'label'      => __( 'Space Between Links', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array( 'size' => 6, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__nav-list' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mobile_panel_bg',
			array(
				'label'     => __( 'Mobile Panel Background', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0c0c10',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__nav' => '--hlw-header-panel-bg: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_social_controls() {
		$this->start_controls_section(
			'section_style_social',
			array(
				'label' => __( 'Social Icons', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'social_color',
			array(
				'label'     => __( 'Icon Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8A8A8A',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__social a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'social_hover_color',
			array(
				'label'     => __( 'Hover Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a78bfa',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__social a:hover, {{WRAPPER}} .hlw-header__social a:focus-visible' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'social_size',
			array(
				'label'      => __( 'Icon Size', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 12, 'max' => 40 ) ),
				'default'    => array( 'size' => 18, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__social svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'social_gap',
			array(
				'label'      => __( 'Space Between Icons', 'heliolisk' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
				'default'    => array( 'size' => 14, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .hlw-header__social' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_toggle_controls() {
		$this->start_controls_section(
			'section_style_toggle',
			array(
				'label' => __( 'Mobile Menu Button', 'heliolisk' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'toggle_color',
			array(
				'label'     => __( 'Color', 'heliolisk' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f4f5fb',
				'selectors' => array(
					'{{WRAPPER}} .hlw-header__toggle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/* ==================== RENDER ==================== */

	protected function render() {
		$settings = $this->get_settings_for_display();
		$icons    = self::social_icons();
		$sticky   = ( 'yes' === $settings['sticky'] );
		$menu_id  = ! empty( $settings['menu_id'] ) ? (int) $settings['menu_id'] : 0;
		$menu_args = array(
			'container'   => false,
			'menu_class'  => 'hlw-header__nav-list',
			'depth'       => 1,
			'fallback_cb' => false,
			'echo'        => false,
		);
		if ( $menu_id ) {
			$menu_args['menu'] = $menu_id;
		} else {
			$menu_args['theme_location'] = 'primary';
		}
		$menu_html = wp_nav_menu( $menu_args );
		$has_menu  = ! empty( $menu_html );
		$logo_url = ! empty( $settings['logo_image']['url'] ) ? $settings['logo_image']['url'] : '';
		$home_url = ! empty( $settings['logo_link']['url'] ) ? $settings['logo_link']['url'] : home_url( '/' );
		$uid      = 'hlw-header-nav-' . $this->get_id();
		?>
		<header class="hlw-header<?php echo $sticky ? ' hlw-header--sticky' : ''; ?>"<?php echo $sticky ? ' data-hlw-sticky="1"' : ''; ?>>
			<div class="hlw-header__inner">

				<a class="hlw-header__logo" href="<?php echo esc_url( $home_url ); ?>">
					<?php if ( $logo_url ) : ?>
						<span class="hlw-header__logo-mark">
							<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $settings['logo_text'] ); ?>">
						</span>
					<?php endif; ?>
					<?php if ( ! empty( $settings['logo_text'] ) ) : ?>
						<span class="hlw-header__logo-text"><?php echo esc_html( $settings['logo_text'] ); ?></span>
					<?php endif; ?>
				</a>

				<?php if ( $has_menu ) : ?>
					<nav class="hlw-header__nav" id="<?php echo esc_attr( $uid ); ?>" aria-label="<?php esc_attr_e( 'Primary', 'heliolisk' ); ?>">
						<?php echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- markup built by wp_nav_menu(). ?>
					</nav>
				<?php endif; ?>

				<?php if ( ! $has_menu && \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<p class="hlw-header__empty"><?php esc_html_e( 'No menu found. Create one under Appearance → Menus and pick it in the Menu section of this widget.', 'heliolisk' ); ?></p>
				<?php endif; ?>

				<div class="hlw-header__right">
					<?php if ( ! empty( $settings['social_items'] ) ) : ?>
						<div class="hlw-header__social">
							<?php foreach ( $settings['social_items'] as $item ) :
								$key      = isset( $icons[ $item['icon'] ] ) ? $item['icon'] : 'link';
								$link_url = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
								$external = ! empty( $item['link']['is_external'] );
								$nofollow = ! empty( $item['link']['nofollow'] );
								?>
								<a
									href="<?php echo esc_url( $link_url ); ?>"
									aria-label="<?php echo esc_attr( $icons[ $key ][0] ); ?>"
									<?php echo $external ? ' target="_blank"' : ''; ?>
									<?php echo ( $external || $nofollow ) ? ' rel="noopener' . ( $nofollow ? ' nofollow' : '' ) . '"' : ''; ?>
								>
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $icons[ $key ][1]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed, trusted SVG shapes. ?></svg>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_menu ) : ?>
						<button type="button" class="hlw-header__toggle" aria-label="<?php echo esc_attr( $settings['menu_label'] ); ?>" aria-controls="<?php echo esc_attr( $uid ); ?>" aria-expanded="false">
							<span></span><span></span><span></span>
						</button>
					<?php endif; ?>
				</div>

			</div>
		</header>
		<?php
	}
}
