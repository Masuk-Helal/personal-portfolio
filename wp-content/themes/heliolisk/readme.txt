=== Heliolisk ===
Contributors: heliolisk
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.0
Version: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: heliolisk
Tags: portfolio, one-column, left-sidebar, right-sidebar, full-width-template, custom-logo, custom-menu, editor-style, featured-images, threaded-comments, translation-ready, blog

A modern one-page portfolio theme for analysts, operators and creators, built with Elementor.

== Description ==

Heliolisk is a portfolio theme. The home page is built with Elementor using the
13 Heliolisk widgets from the companion plugin; the theme itself supplies the
header, footer, blog, archives, search, single posts, pages and 404.

* Dark and Light color schemes (Theme Options → General)
* Header and Footer builder (Elementor), site-wide or per page
* Projects post type with categories and tags
* Blog with left, right, both or no sidebar, overridable per page and post
* Theme Options panel and Customizer support
* Demo import package (content, Customizer and widgets)
* Translation ready (heliolisk.pot)

== Installation ==

1. Appearance → Themes → Add New → Upload Theme, choose heliolisk.zip, Activate.
2. Open Appearance → Install Plugins and install and activate every listed plugin.
3. Import the demo content (see the documentation folder) or build your own home
   page with Elementor and the Heliolisk widgets.

== Copyright ==

Heliolisk WordPress Theme, Copyright (c) 2026 Heliolisk.
Heliolisk is distributed under the terms of the GNU General Public License v2 or later:
https://www.gnu.org/licenses/gpl-2.0.html

Unless stated otherwise below, every file in this theme is original work released
under the GPL v2 or later.

== Resources ==

Third-party resources bundled with this theme, with their licenses:

* Bootstrap 5.3.3 - Copyright 2011-2024 The Bootstrap Authors - MIT License
  https://getbootstrap.com/ (assets/vendor/bootstrap/)
* GSAP and ScrollTrigger 3.13.0 - Copyright 2025 GreenSock / Webflow - GSAP Standard License
  (free, including commercial use) https://gsap.com/standard-license (assets/vendor/gsap/)
* jQuery Nice Select 1.0 - Copyright Hernan Sartorio - MIT License
  https://github.com/hernansartorio/jquery-nice-select (assets/vendor/nice-select/)
* TGM Plugin Activation 2.6.1 - Copyright 2011 Thomas Griffin - GPL-2.0+
  http://tgmpluginactivation.com/ (inc/class-tgm-plugin-activation.php)
* Codestar Framework 2.3.1 - Copyright 2015-2022 Codestar - GPL-2.0
  http://codestarframework.com/ (plugins/codestar-framework.zip, installed through TGMPA)
* Feather icon paths (some of the inline SVG icons) - Copyright Cole Bemis - MIT License
  https://feathericons.com/ (inc/icons.php)
* Fonts from Google Fonts, loaded from fonts.googleapis.com:
  Space Grotesk, Inter and Barlow Condensed - SIL Open Font License 1.1
  https://fonts.google.com/
* The animated dots, arrow and glow in the page banner are drawn with CSS and an
  original SVG (assets/images/blog/arrow-dark.svg).

The theme ships no photographs. Images shown in the demo are not part of the
theme; see licensing/licensing.txt in the download package.

== Plugins ==

plugins/heliolisk.zip           Heliolisk companion plugin (GPL v2 or later).
plugins/codestar-framework.zip  Codestar Framework (GPL v2).

Both are installed from Appearance → Install Plugins (TGM Plugin Activation).
Elementor, CMB2, Classic Editor and Classic Widgets are installed from wordpress.org.

== Structure ==

functions.php               Constants + loads everything in inc/.

inc/
  helpers.php               heliolisk_get_option(), asset versions, kses.
  icons.php                 heliolisk_icon() inline SVG set.
  setup.php                 Theme supports, menus, image sizes.
  enqueue.php               Styles and scripts.
  widgets.php               "Left Sidebar" and "Right Sidebar" widget areas and the built-in sidebar.
                            The blog widgets (Categories, Top Stories, Tags, Banner) come from the Heliolisk plugin.
  menus.php                 Primary menu fallback, one-page anchor links.
  layout.php                Sidebar layout: left / right / both / none.
  builder.php               Elementor Header / Footer templates.
  breadcrumb.php            Page banner title + breadcrumb trail.
  template-tags.php         Output helpers (meta, tags, pagination, socials).
  template-hooks.php        Filters on core output (body class, excerpts…).
  comments.php              Comment callback and form fields.
  metaboxes.php             Page / Post Settings (Pure Metafields plugin).
  cmb2-metaboxes.php        Per page Header / Footer choice (CMB2 plugin).
  plugins.php               Required / recommended plugins (TGMPA).
  class-tgm-plugin-activation.php  TGM Plugin Activation 2.6.1 (GPL-2.0+).
  theme-options.php         Appearance → Theme Options (Codestar Framework).
  customizer/               Defaults, sanitizers, controls, inline CSS.

plugins/                    Zip files installed by TGMPA (see Plugins above).
languages/heliolisk.pot     Translation template (text domain: heliolisk).

assets/
  css/style.css             Theme tokens, header, footer, home page sections.
  css/blog.css              Blog, archives, single posts, sidebar, comments.
  css/content.css           WordPress core classes: alignment, captions, gallery, calendar, blocks.
  css/scheme-light.css      Overrides for the Light color scheme.
  css/editor-style.css      Block editor styles.
  js/                       Theme scripts.
  vendor/                   Third-party libraries (see Resources).

template-parts/
  header/                   Site header, search overlay.
  footer/                   Site footer.
  layout/                   Page banner, posts loop, Elementor canvas.
  content/                  Post card, search row, single, page, none.
  post/                     Media, meta, share, author, navigation, related.

page-templates/             Right / Left / Both sidebars, Full width.

== Sidebar layouts ==

Appearance → Customize → Heliolisk Options → Blog & Layout sets the layout for
the blog + archives + search, single posts and pages. A page or post can
override it in its Page / Post Settings box, and a page template overrides both.
Widgets go in Appearance → Widgets → Left Sidebar / Right Sidebar; a side with
no widgets is hidden (or filled from the other area) automatically.

== Changelog ==

= 1.2.0 - 11 October 2026 =
* Marketplace release.
* Bundled plugins now install from the theme's plugins/ folder (previously a path outside the theme).
* Replaced the legacy utility stylesheet with an original content.css.
* Removed unused images; replaced the banner arrow and glow with original assets.
* Updated GSAP and ScrollTrigger to 3.13.0.
* Widget defaults use neutral placeholder content.
* Added licensing and credits documentation.

= 1.1.1 - 07 October 2026 =
* Fixed duplicate control registration in the What I Do widget.
* Added a per-page Footer choice (CMB2).
* Added Codestar Framework, Classic Editor, Classic Widgets and CMB2 to the plugin installer.
* Fixed sidebar widget text color in the Dark scheme.

= 1.1.0 =
* Initial release.
