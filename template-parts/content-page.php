<?php

/**
 * The template used for displaying page content in page.php
 *
 * @package Drowan
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php the_post_thumbnail(); ?>

	<div class="post-content">

		<header class="entry-header">

			<?php the_title('<h1 class="entry-title page-title">', '</h1>'); ?>

		</header><!-- .entry-header -->

		<div class="entry-content clearfix">

			<?php the_content(); ?>

			<?php wp_link_pages(array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'drowan'),
				'after'  => '</div>',
			)); ?>

		</div><!-- .entry-content -->

	</div><!-- .post-content -->

</article>