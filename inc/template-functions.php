<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Drowan
 */

if (!function_exists('drowan_default_menu')) :
	/**
	 * Display default page as navigation if no custom menu was set
	 */
	function drowan_default_menu()
	{
		echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">' . wp_list_pages('title_li=&echo=0') . '</ul>';
	}
endif;


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function drowan_body_classes($classes)
{

	// Get theme options from database.
	$theme_options = drowan_theme_options();

	// Set Theme Layout.
	if ('boxed' === $theme_options['theme_layout']) {
		$classes[] = 'boxed-theme-layout';
	} elseif ('centered' === $theme_options['theme_layout']) {
		$classes[] = 'centered-theme-layout';
	}

	// Check if sidebar widget area is empty or switch sidebar layout to left.
	if (!is_active_sidebar('sidebar-1') || is_page_template('templates/template-no-sidebar.php')) {
		$classes[] = 'no-sidebar';
	} elseif ('left-sidebar' == $theme_options['sidebar_position']) {
		$classes[] = 'sidebar-left';
	}

	// Set Blog Layout.
	if ('list' === $theme_options['blog_layout']) {
		$classes[] = 'blog-list-layout';
	} elseif ('grid' === $theme_options['blog_layout']) {
		$classes[] = 'blog-grid-layout';
	}

	// Hide Date?
	if (false === $theme_options['meta_date']) {
		$classes[] = 'date-hidden';
	}

	// Hide Author?
	if (false === $theme_options['meta_author']) {
		$classes[] = 'author-hidden';
	}

	// Hide Category?
	if (false === $theme_options['meta_category']) {
		$classes[] = 'categories-hidden';
	}

	// Hide Tags?
	if (false === $theme_options['meta_tags']) {
		$classes[] = 'tags-hidden';
	}

	// Featured Images?
	if (false === $theme_options['post_image_archives']) {
		$classes[] = 'post-thumbnails-hidden';
	}

	// Single Featured Image?
	if (false === $theme_options['post_image_single'] && is_single()) {
		$classes[] = 'post-thumbnail-hidden';
	}

	// Check for AMP pages.
	if (drowan_is_amp()) {
		$classes[] = 'is-amp-page';
	}

	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter('body_class', 'drowan_body_classes');


/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function drowan_post_classes($classes)
{

	// Add comments-off class.
	if (!(comments_open() || get_comments_number())) {
		$classes[] = 'comments-off';
	}

	return $classes;
}
add_filter('post_class', 'drowan_post_classes');


/**
 * Hide Elements with CSS.
 *
 * @return void
 */
function drowan_hide_elements()
{

	// Get theme options from database.
	$theme_options = drowan_theme_options();

	$elements = array();

	// Hide Site Title?
	if (false === $theme_options['site_title']) {
		$elements[] = '.site-title';
	}

	// Hide Site Description?
	if (false === $theme_options['site_description']) {
		$elements[] = '.site-description';
	}

	// Hide Post Navigation?
	if (false === $theme_options['post_navigation']) {
		$elements[] = '.single-post .site-main .post-navigation';
	}

	// Allow plugins to add own elements.
	$elements = apply_filters('drowan_hide_elements', $elements);

	// Return early if no elements are hidden.
	if (empty($elements)) {
		return;
	}

	// Create CSS.
	$classes = implode(', ', $elements);
	$custom_css = $classes . ' { position: absolute; clip: rect(1px, 1px, 1px, 1px); width: 1px; height: 1px; overflow: hidden; }';

	// Add Custom CSS.
	wp_add_inline_style('drowan-stylesheet', $custom_css);
}
add_filter('wp_enqueue_scripts', 'drowan_hide_elements', 11);


/**
 * Add custom CSS to scale down logo image for retina displays.
 *
 * @return void
 */
function drowan_retina_logo()
{
	// Return early if there is no logo image or option for retina logo is disabled.
	if (!has_custom_logo() or false === drowan_get_option('retina_logo')) {
		return;
	}

	// Get Logo Image.
	$logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');

	// Create CSS.
	$css = '.site-branding .custom-logo { width: ' . absint(floor($logo[1] / 2)) . 'px; }';

	// Add Custom CSS.
	wp_add_inline_style('drowan-stylesheet', $css);
}
add_filter('wp_enqueue_scripts', 'drowan_retina_logo', 11);


/**
 * Change excerpt length for default posts
 *
 * @param int $length Length of excerpt in number of words.
 * @return int
 */
function drowan_excerpt_length($length)
{

	if (is_admin()) {
		return $length;
	}

	// Get excerpt length from database.
	$excerpt_length = drowan_get_option('excerpt_length');

	// Return excerpt text.
	if ($excerpt_length >= 0) :
		return absint($excerpt_length);
	else :
		return 35; // Number of words.
	endif;
}
add_filter('excerpt_length', 'drowan_excerpt_length');


/**
 * Change excerpt more text for posts
 *
 * @param String $more_text Excerpt More Text.
 * @return string
 */
function drowan_excerpt_more($more_text)
{

	if (is_admin()) {
		return $more_text;
	}

	return '';
}
add_filter('excerpt_more', 'drowan_excerpt_more');
