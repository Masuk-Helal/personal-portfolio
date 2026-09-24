<?php

/**
 * Bootstraps the Elementor integration: category, widget registration and
 * each widget's own isolated CSS/JS (no theme dependency).
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

final class Heliolisk_Elementor
{
	/**
	 * Registry of widgets this integration provides. Adding a widget is a
	 * single entry here plus its own self-contained folder under widgets/
	 * (widget.php + assets/) — nothing else in this file needs to change.
	 *
	 * Keys are the widget's folder name, also used as the `hlw-{slug}`
	 * widget name/icon-class suffix. `style`/`script` are paths relative to
	 * that folder, or null if the widget doesn't need one. `icon_image` is
	 * the path (relative to that folder) to a custom panel icon image, or
	 * null to use a normal Elementor icon font class instead.
	 */
	private static function widgets()
	{
		return array(
			'hero' => array(
				'class'      => 'Heliolisk_Hero_Widget',
				'style'      => 'assets/css/hero-widget.css',
				'script'     => 'assets/js/hero-widget.js',
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'about' => array(
				'class'      => 'Heliolisk_About_Widget',
				'style'      => 'assets/css/about-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'whatido' => array(
				'class'      => 'Heliolisk_Whatido_Widget',
				'style'      => 'assets/css/whatido-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'experience' => array(
				'class'      => 'Heliolisk_Experience_Widget',
				'style'      => 'assets/css/experience-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'numbers' => array(
				'class'      => 'Heliolisk_Numbers_Widget',
				'style'      => 'assets/css/numbers-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'skills' => array(
				'class'      => 'Heliolisk_Skills_Widget',
				'style'      => 'assets/css/skills-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'howiwork' => array(
				'class'      => 'Heliolisk_Howiwork_Widget',
				'style'      => 'assets/css/howiwork-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'collaborators' => array(
				'class'      => 'Heliolisk_Collaborators_Widget',
				'style'      => 'assets/css/collaborators-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'contact' => array(
				'class'      => 'Heliolisk_Contact_Widget',
				'style'      => 'assets/css/contact-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'blog' => array(
				'class'      => 'Heliolisk_Blog_Widget',
				'style'      => 'assets/css/blog-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'projects' => array(
				'class'      => 'Heliolisk_Projects_Widget',
				'style'      => 'assets/css/projects-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
			'footer' => array(
				'class'      => 'Heliolisk_Footer_Widget',
				'style'      => 'assets/css/footer-widget.css',
				'script'     => null,
				'icon_image' => 'assets/images/hero-icon.jpg',
			),
		);
	}

	/**
	 * The registered style handle for a given widget slug.
	 */
	public static function style_handle($slug)
	{
		return 'heliolisk-' . $slug . '-widget';
	}

	/**
	 * The registered script handle for a given widget slug.
	 */
	public static function script_handle($slug)
	{
		return 'heliolisk-' . $slug . '-widget';
	}

	/**
	 * Wires up the integration, but only once Elementor itself is confirmed loaded.
	 *
	 * Elementor calls `Plugin::instance()` unconditionally at the bottom of its
	 * own main file, so `elementor/loaded` fires the moment Elementor's file is
	 * required — which happens before this plugin's file loads (alphabetically
	 * "elementor" precedes "heliolisk"). Hooking `elementor/loaded` directly
	 * would therefore always miss it, so we check on `plugins_loaded` instead,
	 * by which point every plugin file (including Elementor's) has run.
	 */
	public function __construct()
	{
		add_action('plugins_loaded', array($this, 'on_elementor_loaded'));
	}

	/**
	 * Runs once every plugin has loaded; bails out if Elementor isn't active.
	 */
	public function on_elementor_loaded()
	{
		if (! did_action('elementor/loaded')) {
			return;
		}

		add_action('elementor/elements/categories_registered', array($this, 'register_category'));
		add_action('elementor/frontend/register_styles', array($this, 'register_assets'));
		add_action('elementor/frontend/register_scripts', array($this, 'register_assets'));
		add_action('elementor/widgets/register', array($this, 'register_widgets'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_assets_if_widget_present'), 20);

		// The editor's live canvas is a separate iframe (not a normal frontend
		// request), and reflects unsaved edits that `_elementor_data` doesn't
		// have yet — so the meta-based check above can't detect the widget
		// there. Elementor exposes these two hooks specifically so third-party
		// widgets can guarantee their assets load inside that preview iframe.
		add_action('elementor/preview/enqueue_styles', array($this, 'register_assets'));
		add_action('elementor/preview/enqueue_styles', array($this, 'enqueue_assets'));
		add_action('elementor/preview/enqueue_scripts', array($this, 'register_assets'));
		add_action('elementor/preview/enqueue_scripts', array($this, 'enqueue_assets'));

		// The main editor chrome (widgets panel, navigator) is yet another
		// document from the preview iframe, and only ever shows a widget's
		// *icon*, never its real markup — so it doesn't need the full widget
		// CSS, just this small icon override.
		add_action('elementor/editor/after_enqueue_styles', array($this, 'enqueue_editor_panel_icon_css'));
	}

	/**
	 * Adds a dedicated "Personal Portfolio" widget category.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_category($elements_manager)
	{
		$elements_manager->add_category(
			'personal-portfolio',
			array(
				'title' => __('Personal Portfolio', 'heliolisk'),
				'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<defs>
								<linearGradient id="bolt-gradient" x1="0" y1="0" x2="0" y2="1">
								<stop offset="0%" stop-color="#FFE28A"/>
								<stop offset="45%" stop-color="#FFC72C"/>
								<stop offset="100%" stop-color="#E8A400"/>
								</linearGradient>
							</defs>
							<path d="M13 2 4 14h6l-2 8 9-12h-6l2-8Z" fill="url(#bolt-gradient)"/>
							</svg>
							',
			)
		);
	}

	/**
	 * Registers every widget's own CSS/JS handles so Elementor can load
	 * them only when that widget is actually placed on a page — independent
	 * of whatever theme (if any) is active.
	 */
	public function register_assets()
	{
		$widgets_url = HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/';

		foreach (self::widgets() as $slug => $widget) {
			if ($widget['style']) {
				wp_register_style(
					self::style_handle($slug),
					$widgets_url . $slug . '/' . $widget['style'],
					array(),
					HELIOLISK_VERSION
				);
			}

			if ($widget['script']) {
				wp_register_script(
					self::script_handle($slug),
					$widgets_url . $slug . '/' . $widget['script'],
					array('elementor-frontend'),
					HELIOLISK_VERSION,
					true
				);
			}
		}
	}

	/**
	 * Unconditionally enqueues every widget's registered assets. Used inside
	 * the editor preview iframe, where it's cheap and safe to always load
	 * them (only admins/editors actively building a page hit this).
	 */
	public function enqueue_assets()
	{
		foreach (self::widgets() as $slug => $widget) {
			if ($widget['style']) {
				wp_enqueue_style(self::style_handle($slug));
			}

			if ($widget['script']) {
				wp_enqueue_script(self::script_handle($slug));
			}
		}
	}

	/**
	 * Draws each widget's panel icon from its own image instead of a font glyph.
	 *
	 * Elementor's widget-list markup is `<div class="icon"><i class="{{ get_icon() }}"></i></div>`
	 * — it only ever expects a font/glyph class there, so an arbitrary image
	 * can't be passed directly through `get_icon()`. Instead a widget with a
	 * custom icon returns an inert class name (`hlw-{slug}-panel-icon`) from
	 * `get_icon()`, and this CSS paints the real image onto that `<i>` as a
	 * background, scoped to that widget's row via Elementor's own
	 * `data-library-element-type` attribute.
	 */
	public function enqueue_editor_panel_icon_css()
	{
		$widgets_url = HELIOLISK_PLUGIN_URL . 'includes/elementor/widgets/';
		$css         = '';

		foreach (self::widgets() as $slug => $widget) {
			if (! $widget['icon_image']) {
				continue;
			}

			$icon_url = $widgets_url . $slug . '/' . $widget['icon_image'];

			$css .= '.elementor-element[data-library-element-type="hlw-' . $slug . '"] .icon i.hlw-' . $slug . '-panel-icon {' .
				'display: inline-block !important;' .
				'width: 36px !important;' .
				'height: 36px !important;' .
				'font-size: 36px !important;' .
				'line-height: 36px !important;' .
				'background-image: url(' . esc_url($icon_url) . ');' .
				'background-size: contain;' .
				'background-position: center;' .
				'background-repeat: no-repeat;' .
			'}';
		}

		if (! $css) {
			return;
		}

		wp_register_style('heliolisk-editor-icons', false, array(), HELIOLISK_VERSION);
		wp_enqueue_style('heliolisk-editor-icons');
		wp_add_inline_style('heliolisk-editor-icons', $css);
	}

	/**
	 * Registers every widget with Elementor.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets($widgets_manager)
	{
		$widgets_dir = __DIR__ . '/widgets/';

		foreach (self::widgets() as $slug => $widget) {
			require_once $widgets_dir . $slug . '/widget.php';

			$class = $widget['class'];
			$widgets_manager->register(new $class());
		}
	}

	/**
	 * Directly enqueues a widget's assets when its markup is present on the
	 * current page, plus whichever custom Header/Footer template the theme
	 * has picked as "active" (via `header_template_id`/`footer_template_id`
	 * theme_mods) — those render outside the normal singular-page loop, so
	 * `is_singular()` alone would miss the widgets they contain.
	 *
	 * Elementor's `get_style_depends()` / `get_script_depends()` normally
	 * enqueue a widget's assets automatically, but that mechanism can miss
	 * them when Elementor's own "element cache" (`elementor_element_cache_ttl`)
	 * defers rendering to an `[elementor-element]` shortcode — the dependency
	 * collection doesn't always run on that deferred path. This direct check
	 * guarantees the CSS/JS load whenever a widget is actually used,
	 * regardless of that caching behaviour, without touching site-wide
	 * Elementor settings.
	 */
	public function enqueue_assets_if_widget_present()
	{
		$post_ids = array();

		if (is_singular()) {
			$post_ids[] = get_queried_object_id();
		}

		if (function_exists('get_theme_mod')) {
			$header_id = (int) get_theme_mod('header_template_id', 0);
			$footer_id = (int) get_theme_mod('footer_template_id', 0);

			if ($header_id) {
				$post_ids[] = $header_id;
			}

			if ($footer_id) {
				$post_ids[] = $footer_id;
			}
		}

		$post_ids = array_unique(array_filter($post_ids));

		if (! $post_ids) {
			return;
		}

		$needed = array();

		foreach ($post_ids as $post_id) {
			$elementor_data = get_post_meta($post_id, '_elementor_data', true);

			if (empty($elementor_data)) {
				continue;
			}

			foreach (self::widgets() as $slug => $widget) {
				if (false !== strpos($elementor_data, '"widgetType":"hlw-' . $slug . '"')) {
					$needed[$slug] = $widget;
				}
			}
		}

		if (! $needed) {
			return;
		}

		$this->register_assets();

		foreach ($needed as $slug => $widget) {
			if ($widget['style']) {
				wp_enqueue_style(self::style_handle($slug));
			}

			if ($widget['script']) {
				wp_enqueue_script(self::script_handle($slug));
			}
		}
	}
}
