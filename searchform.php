<?php

/**
 * Custom Markup for Search form
 *
 * @package Drowan
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'drowan'); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'drowan'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label', 'drowan'); ?>" />
	</label>
	<button type="submit" class="search-submit">
		<?php echo drowan_get_svg('search'); ?>
		<span class="screen-reader-text"><?php echo esc_html_x('Search', 'submit button', 'drowan'); ?></span>
	</button>
</form>