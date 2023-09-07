<?php
/**
 * Template Name: Magazine Template
 *
 * @package BNM
 * @since BNM 1.0.3
 */

 get_header();

 ?>

 <main id="primary" class="site-main">

    <?php
    if ( is_active_sidebar( 'bnm-magazine-1' ) ) : ?>
        <div class="bnm-magazine-beside-sb">
            <?php dynamic_sidebar( 'bnm-magazine-1' ); ?>
        </div>
    <?php endif;

    /**
     * Before Main Content Hook
     */
    do_action( 'bnm_before_magazine_content' );

    while ( have_posts() ) :

        the_post();

        the_content();

    endwhile; // End of the loop.

    /**
     * After Main Content Hook
     */
    do_action( 'bnm_after_magazine_content' );

    ?>

 </main><!-- #main -->

<?php

$bnm_page_layout = bnm_get_layout();
if ( 'right-sidebar' === $bnm_page_layout || 'left-sidebar' === $bnm_page_layout ) {
    get_sidebar();
}

get_footer();