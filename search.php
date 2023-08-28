<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

		?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'bnm' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<div id="blog-entries">

			<?php
			
			/**
			 * Before search loop hook
			 */
			do_action( 'bnm_before_loop', 'search' );

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			/**
			 * After index loop hook
			 */
			do_action( 'bnm_after_loop', 'search' );

			?>

			</div><!-- #blog-entries -->

		<?php

			bnm_posts_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;

		/**
		 * After Main Content Hook
		 */
		do_action( 'bnm_after_main_content' );

		?>

	</main><!-- #main -->

<?php
$bnm_archive_layout = get_theme_mod( 'bnm_archive_layout', 'right-sidebar' );
if ( 'right-sidebar' === $bnm_archive_layout || 'left-sidebar' === $bnm_archive_layout ) {
	get_sidebar();
}
get_footer();
