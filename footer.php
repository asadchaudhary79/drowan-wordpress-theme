<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Drowan
 */

?>

</div><!-- #content -->

<?php do_action('drowan_before_footer'); ?>

<div id="footer" class="footer-wrap">

	<footer id="colophon" class="site-footer container clearfix" role="contentinfo">

		<?php do_action('drowan_footer_menu'); ?>

		<div id="footer-line" class="site-info">
			<?php do_action('drowan_footer_text'); ?>
			<?php drowan_credit_link(); ?>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->

</div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>