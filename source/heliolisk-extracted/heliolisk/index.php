<?php
/**
 * Fallback template, and the blog index ("Posts page").
 *
 * The front page is an Elementor page, so this file only renders post
 * listings: banner + card grid + sidebar(s).
 *
 * @package Heliolisk
 */

get_header();

get_template_part( 'template-parts/layout/page-banner' );
get_template_part( 'template-parts/layout/posts-loop' );

get_footer();
