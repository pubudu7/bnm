<?php
/**
 * Header Template
 */
?>

<header id="masthead" class="site-header hide-header-search">

    <?php do_action( 'bnm_header_top' ); ?>

    <div class="bnm-header-inner-wrapper">

        <?php 
            /**
             * Before header inner action
             */
            do_action( 'bnm_before_header_inner' );
        ?>

        <div class="bnm-header-inner bnm-container">

            <?php do_action( 'bnm_before_header_main' ); ?>

            <?php do_action( 'bnm_header_main' ); ?>

            <?php do_action( 'bnm_after_header_main' ); ?>
        
        </div><!-- .bnm-header-inner -->

        <?php 
            /**
             * After header inner action
             */
            do_action( 'bnm_after_header_inner' );
        ?>

    </div><!-- .bnm-header-inner-wrapper -->

    <?php do_action( 'bnm_header_bottom' ); ?>

</header><!-- #masthead -->