<?php

function bnm_navigation_location() {
    $bnm_header_layout = get_theme_mod( 'bnm_header_layout', 'default' );
    if ( 'default' == $bnm_header_layout ) {
        add_action( 'bnm_header_bottom', 'bnm_navigation_full_width' );
    } elseif ('single-line' == $bnm_header_layout ) {
        add_action( 'bnm_after_header_main', 'bnm_navigation_short_width', 5 );
    }
}
add_action( 'wp', 'bnm_navigation_location' );

if ( ! function_exists( 'bnm_search_box' ) ) :
    /**
     * Displays the search 
     */
    function bnm_search_box() {
    
        if ( false === get_theme_mod( 'bnm_show_search_onmenu', true ) ) {
            return;
        }
    
        ?>
            <div class="bnm-search-container desktop-only">
                <button id="bnm-search-toggle">
                    <span class="bnm-search-icon"><?php bnm_the_icon_svg( 'search' ) ?></span>
                    <span class="bnm-close-icon"><?php bnm_the_icon_svg( 'close' ) ?></span>
                </button>
                <div id="bnm-search-box">
                    <?php get_search_form(); ?>
                </div><!-- bnm-search-box -->
            </div><!-- bnm-search-container -->
        <?php
    }

    add_action( 'bnm_after_primary_nav', 'bnm_search_box' );
    
endif;

if ( ! function_exists( 'bnm_navigation_full_width' ) ) :

    function bnm_navigation_full_width() {
        ?>
            <div class="bnm-main-menu desktop-only">
                <div class="bnm-container bnm-menu-wrapper">
                    
                    <?php do_action( 'bnm_before_primary_nav' ); ?>

                    <nav id="site-navigation" class="main-navigation bnm-menu">
                        <?php bnm_primary_nav(); ?>
                    </nav>

                    <?php do_action( 'bnm_after_primary_nav' ); ?>

                </div>
            </div>
        <?php
    }

endif;

if ( ! function_exists( 'bnm_navigation_short_width' ) ) :

    function bnm_navigation_short_width() {
        
        do_action( 'bnm_before_primary_nav' ); ?>

            <nav id="site-navigation" class="main-navigation bnm-menu desktop-only">
                <?php bnm_primary_nav(); ?>
            </nav>

        <?php

        do_action( 'bnm_after_primary_nav' ); 

    }

endif;

if ( ! function_exists( 'bnm_slide_out_menu_toggle' ) ) : 

    function bnm_slide_out_menu_toggle() {
       ?>
            <button class="bnm-slideout-toggle">
                <div class="bnmst-bars">
                    <span class="bnmst1"></span>
                    <span class="bnmst2"></span>
                    <span class="bnmst3"></span>
                </div>
            </button>
        <?php 
    }
	
endif;

function bnm_slideout_menu_toggle_location() {

    if ( get_theme_mod( 'bnm_show_slideout_sb', false ) ) {

        $location = get_theme_mod( 'bnm_slideout_btn_loc', 'primary-menu' );

        if ( 'before-logo' === $location ) {
            add_action( 'bnm_before_header_main', 'bnm_slide_out_menu_toggle', 4 );
        } elseif ( 'top-bar' === $location ) {
            add_action( 'bnm_before_top_bar_main', 'bnm_slide_out_menu_toggle', 5 );
        } else {
            if ( 'single-line' === get_theme_mod( 'bnm_header_layout', 'default' ) ) {
                add_action( 'bnm_after_primary_nav', 'bnm_slide_out_menu_toggle', 5 );
            } else {
                add_action( 'bnm_before_primary_nav', 'bnm_slide_out_menu_toggle', 5 );
            }
        }

    }

}
add_action( 'wp', 'bnm_slideout_menu_toggle_location' );