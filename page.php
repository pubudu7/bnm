<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BNM
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php

		/**
		 * Before Main Content Hook
		 */
		do_action( 'bnm_before_main_content' );

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.

		/**
		 * After Main Content Hook
		 */
		do_action( 'bnm_after_main_content' );

		?>

	</main><!-- #main -->

<?php
	$bnm_page_layout = bnm_get_layout();
	if ( 'right-sidebar' === $bnm_page_layout || 'left-sidebar' === $bnm_page_layout ) {
		get_sidebar();
	}

get_footer();