<?php
/**
 * Output all the dynamic CSS
 * 
 * @package BNM
 */

if ( ! function_exists( 'bnm_custom_css' ) ) {

    /**
     * Generate CSS in the <head> section using the 
     */
    function bnm_custom_css() {

        $theme_css = "";

        $css_variables = "";

        $primary_color = get_theme_mod( 'bnm_primary_color', '#f87c7c' );
        $text_color = get_theme_mod( 'bnm_text_color', '#222222' );
        $links_color = get_theme_mod( 'bnm_links_color', '#000000' );
        $inner_background_color = get_theme_mod( 'bnm_boxed_inner_bg_color', '#ffffff' );

        if ( ! empty( $primary_color ) && '#f87c7c' != $primary_color ) {
            $css_variables .= '
                --bnm-color-primary: '. esc_attr( $primary_color ) .';
            ';
        }

        if ( ! empty( $text_color ) && '#222222' != $text_color ) {
            $css_variables .= '
                --bnm-color-text-main: '. esc_attr( $text_color ) .';
            ';
        }

        if ( ! empty( $links_color ) && '#000000' != $links_color ) {
            $css_variables .= '
                --bnm-color-link: '. esc_attr( $links_color ) .';
            ';
        }

        if ( ! empty( $inner_background_color ) && '#ffffff' != $inner_background_color ) {
            $css_variables .= '
                --bnm-color-body-background: '. esc_attr( $inner_background_color ) .';
            ';
        }

        $theme_css .= '
            :root { ' . $css_variables . ' }
        ';

        $site_layout = get_theme_mod( 'bnm_site_layout', 'wide' );
        if ( 'wide' === $site_layout ) {
            $container_width = get_theme_mod( 'bnm_container_width', 1200 );
            if ( 1200 != $container_width && ! empty( $container_width ) && $container_width >= 300 ) {
                $theme_css .= '
                    .bnm-container {
                        width: '. esc_attr( $container_width ) .'px;
                    }
                ';
            }
        } elseif ( 'boxed' === $site_layout ) {
            $boxed_container_width = get_theme_mod( 'bnm_boxed_width', 1280 );
            if ( 1280 != $boxed_container_width && ! empty( $boxed_container_width ) && $boxed_container_width >= 300 ) {
                $theme_css .= '
                    body.bnm-boxed #page {
                        width: '. esc_attr( $boxed_container_width ) .'px;
                    }
                ';
            }
        }

        $sidebar_width = get_theme_mod( 'bnm_sidebar_width', 30 );
        $sidebar_width = floatval( $sidebar_width );
        $content_area_width = 100 - $sidebar_width;
        if ( ! empty( $sidebar_width ) && 30 != $sidebar_width && 50 >= $sidebar_width && 15 <= $sidebar_width ) {
            $theme_css .= '
                @media only screen and (min-width: 768px) {
                    #primary {
                        width: '. esc_attr( $content_area_width ) .'%;
                    }
                    #secondary {
                        width: '. esc_attr( $sidebar_width ) .'%;
                    }
                }
            ';
        }

        // Logo Max Width
        $logo_max_width = get_theme_mod( 'bnm_logo_max_width_desktop', '' );
        if ( '' != $logo_max_width ) {
            $theme_css .= '
                .site-logo img {
                    max-width: '. esc_attr( $logo_max_width ) .'px;
                }
            ';
        }

        // Logo Max Height
        $logo_max_height = get_theme_mod( 'bnm_logo_max_height_desktop', '' );
        if ( '' != $logo_max_height ) {
            $theme_css .= '
                .site-logo img {
                    max-height: '. esc_attr( $logo_max_height ) .'px;
                    width: auto;
                }
            ';
        }

        // Logo Max Width Tablet
        $logo_max_width_t = get_theme_mod( 'bnm_logo_max_width_tablet', '' );
        if ( '' != $logo_max_width_t ) {
            $theme_css .= '
                @media (min-width: 480px) and (max-width: 768px) {
                    .site-logo img {
                        max-width: '. esc_attr( $logo_max_width_t ) .'px;
                    }
                }
            ';
        }

        // Logo Max Height Tablet
        $logo_max_height_t = get_theme_mod( 'bnm_logo_max_height_tablet', '' );
        if ( '' != $logo_max_height_t ) {
            $theme_css .= '
                @media (min-width: 480px) and (max-width: 768px) {
                    .site-logo img {
                        max-height: '. esc_attr( $logo_max_height_t ) .'px;
                        width: auto;
                    }
                }
            ';
        }

        // Logo Max Width Mobile
        $logo_max_width_m = get_theme_mod( 'bnm_logo_max_width_mobile', '' );
        if ( '' != $logo_max_width_m ) {
            $theme_css .= '
                @media (max-width: 480px) {
                    .site-logo img {
                        max-width: '. esc_attr( $logo_max_width_m ) .'px;
                    }
                }
            ';
        }

        // Logo Max Height Mobile
        $logo_max_height_m = get_theme_mod( 'bnm_logo_max_height_mobile', '' );
        if ( '' != $logo_max_height_m ) {
            $theme_css .= '
                @media (max-width: 480px) {
                    .site-logo img {
                        max-height: '. esc_attr( $logo_max_height_m ) .'px;
                        width: auto;
                    }
                }
            ';
        }

        $header_layout_class = ".bnm-default-header";
        if ( 'single-line' === get_theme_mod( 'bnm_header_layout', 'default' ) ) {
            $header_layout_class = ".bnm-line-header";
        }

        /**
         * Header Padding
         */

        // Header padding top.
        $header_padding_top = get_theme_mod( 'bnm_header_padding_top_desktop', '' );
        if ( '' != $header_padding_top ) {
            $theme_css .= '
                @media screen and (min-width: 768px) {
                    '.$header_layout_class.' .bnm-header-inner {
                        padding-top: '. esc_attr( $header_padding_top ) .'px;
                    }
                }
            ';
        }

        // Header padding bottom.
        $header_padding_bottom = get_theme_mod( 'bnm_header_padding_bottom_desktop', '' );
        if ( '' != $header_padding_bottom ) {
            $theme_css .= '
                @media screen and (min-width: 768px) {
                    '.$header_layout_class.' .bnm-header-inner {
                        padding-bottom: '. esc_attr( $header_padding_bottom ) .'px;
                    }
                }
            ';
        }

        // Header padding top Tablet
        $header_padding_top_t = get_theme_mod( 'bnm_header_padding_top_tablet', '' );
        if ( '' != $header_padding_top_t ) {
            $theme_css .= '
                @media (min-width: 480px) and (max-width: 768px) {
                    '.$header_layout_class.' .bnm-header-inner {
                        padding-top: '. esc_attr( $header_padding_top_t ) .'px;
                    }
                }
            ';
        }

        // Header padding bottom Tablet
        $header_padding_bottom_t = get_theme_mod( 'bnm_header_padding_bottom_tablet', '' );
        if ( '' != $header_padding_bottom_t ) {
            $theme_css .= '
                @media (min-width: 480px) and (max-width: 768px) {
                    '.$header_layout_class.' .bnm-header-inner {
                        padding-bottom: '. esc_attr( $header_padding_bottom_t ) .'px;
                    }
                }
            ';
        }

        // Header padding top mobile
        $header_padding_top_m = get_theme_mod( 'bnm_header_padding_top_mobile', '' );
        if ( '' != $header_padding_top_m ) {
            $theme_css .= '
                @media (max-width: 480px) {
                    '.$header_layout_class.' .bnm-header-inner {
                        padding-top: '. esc_attr( $header_padding_top_m ) .'px;
                    }
                }
            ';
        }

        // Header padding bottom mobile
        $header_padding_bottom_m = get_theme_mod( 'bnm_header_padding_bottom_mobile', '' );
        if ( '' != $header_padding_bottom_m ) {
            $theme_css .= '
                @media (max-width: 480px) {
                    '.$header_layout_class.' .bnm-header-inner {
                        padding-bottom: '. esc_attr( $header_padding_bottom_m ) .'px;
                    }
                }
            ';
        }

        // Display Header image as header background
        if ( has_header_image() ) {
            if ( 'header-background' === get_theme_mod( 'bnm_header_image_location', 'before-header-inner' ) ) {
                $header_image = get_header_image();
                $theme_css .= '
                    .bnm-header-inner-wrapper {
                        background-image:url('. esc_url( $header_image ) .');
                        background-position: center center;
                        background-size: cover;
                    }
                ';
            }
        }

        /**
         * HEADER COLORS.
         */
        $header_layout = get_theme_mod( 'bnm_header_layout', 'default' );
        $header_bg_color = get_theme_mod( 'bnm_header_bg_color', '' );
        $menu_bg_color = get_theme_mod( 'bnm_menu_bg_color', '' );
        $menu_link_color = get_theme_mod( 'bnm_menu_link_color', '' );
        $menu_link_hover_color = get_theme_mod( 'bnm_menu_link_hover_color', '' );
        $menu_link_action_hover_color = get_theme_mod( 'bnm_menu_link_action_hover_color', '' );
        $dropdown_menu_bg_color = get_theme_mod( 'bnm_dropdown_menu_bg_color', '' );
        $dropdown_menu_link_color = get_theme_mod( 'bnm_dropdown_menu_link_color', '' );
        $dropdown_menu_link_hover_color = get_theme_mod( 'bnm_dropdown_menu_link_hover_color', '' );
        $dropdown_menu_link_hover_bg_color = get_theme_mod( 'bnm_dropdown_menu_link_hover_bg_color', '' );

        if ( ! empty( $header_bg_color ) ) {
            $theme_css .= '
                .bnm-header-inner-wrapper {
                    background-color: '. esc_attr( $header_bg_color ) .';
                }
            ';
        }

        /**
         * Single Line Header Layout Menu Styles.
         */
        if ( 'single-line' === $header_layout ) {

            if ( ! empty( $menu_bg_color ) ) {
                $theme_css .= '
                    .bnm-line-header .main-navigation {
                        background-color: '. esc_attr( $menu_bg_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $menu_link_color ) ) {
                $theme_css .= '
                    .bnm-line-header .main-navigation a {
                        color: '. esc_attr( $menu_link_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $menu_link_hover_color ) ) {
                $theme_css .= '
                    .bnm-line-header .main-navigation ul li a:hover {
                        color: '. esc_attr( $menu_link_hover_color ) .';
                    }
    
                    .bnm-line-header .main-navigation .current_page_item > a, 
                    .bnm-line-header .main-navigation .current-menu-item > a, 
                    .bnm-line-header .main-navigation .current_page_ancestor > a, 
                    .bnm-line-header .main-navigation .current-menu-ancestor > a {
                        color: '. esc_attr( $menu_link_hover_color ) .';
                    }
                ';
            }
    
            // if ( ! empty( $menu_link_action_hover_color ) ) {
            //     $theme_css .= '
            //         .bnm-default-header .main-navigation ul li a:hover::after,
            //         .bnm-default-header .main-navigation .current_page_item > a::after, 
            //         .bnm-default-header .main-navigation .current-menu-item > a::after, 
            //         .bnm-default-header .main-navigation .current_page_ancestor > a::after, 
            //         .bnm-default-header .main-navigation .current-menu-ancestor > a::after {
            //             background-color: '. esc_attr( $menu_link_action_hover_color ) .';
            //         }
            //     ';
            // }
    
            if ( ! empty( $dropdown_menu_link_color ) ) {
                $theme_css .= '
                    .bnm-line-header .main-navigation ul ul li a {
                        color: '. esc_attr( $dropdown_menu_link_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $dropdown_menu_link_hover_color ) ) {
                $theme_css .= '
                    .bnm-line-header .main-navigation ul ul .current_page_item > a, 
                    .bnm-line-header .main-navigation ul ul .current-menu-item > a, 
                    .bnm-line-header .main-navigation ul ul .current_page_ancestor > a, 
                    .bnm-line-header .main-navigation ul ul .current-menu-ancestor > a,
                    .bnm-line-header .main-navigation ul ul li a:hover {
                        color: '. esc_attr( $dropdown_menu_link_hover_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $dropdown_menu_link_hover_bg_color ) ) {
                $theme_css .= '
                    .bnm-line-header .main-navigation ul ul .current_page_item > a, 
                    .bnm-line-header .main-navigation ul ul .current-menu-item > a, 
                    .bnm-line-header .main-navigation ul ul .current_page_ancestor > a, 
                    .bnm-line-header .main-navigation ul ul .current-menu-ancestor > a,
                    .bnm-line-header .main-navigation ul ul li a:hover {
                        background-color: '. esc_attr( $dropdown_menu_link_hover_bg_color ) .';
                    }
                ';
            }

        } else {
            /**
             * DEFAULT HEADER Layout Menu Style.
             */
            if ( ! empty( $menu_bg_color ) ) {
                $theme_css .= '
                    .bnm-default-header .site-header .bnm-main-menu {
                        background-color: '. esc_attr( $menu_bg_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $menu_link_color ) ) {
                $theme_css .= '
                    .bnm-default-header .main-navigation a {
                        color: '. esc_attr( $menu_link_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $menu_link_hover_color ) ) {
                $theme_css .= '
                    .bnm-default-header .main-navigation a:hover {
                        color: '. esc_attr( $menu_link_hover_color ) .';
                    }
    
                    .bnm-default-header .main-navigation .current_page_item > a, 
                    .bnm-default-header .main-navigation .current-menu-item > a, 
                    .bnm-default-header .main-navigation .current_page_ancestor > a, 
                    .bnm-default-header .main-navigation .current-menu-ancestor > a {
                        color: '. esc_attr( $menu_link_hover_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $menu_link_action_hover_color ) ) {
                $theme_css .= '
                    .bnm-default-header .main-navigation ul li a:hover::after,
                    .bnm-default-header .main-navigation .current_page_item > a::after, 
                    .bnm-default-header .main-navigation .current-menu-item > a::after, 
                    .bnm-default-header .main-navigation .current_page_ancestor > a::after, 
                    .bnm-default-header .main-navigation .current-menu-ancestor > a::after {
                        background-color: '. esc_attr( $menu_link_action_hover_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $dropdown_menu_link_color ) ) {
                $theme_css .= '
                    .bnm-default-header .main-navigation ul ul li a {
                        color: '. esc_attr( $dropdown_menu_link_color ) .';
                    }
                ';
            }
    
            if ( ! empty( $dropdown_menu_link_hover_color ) ) {
                $theme_css .= '
                    .bnm-default-header .main-navigation ul ul li a:hover,
                    .bnm-default-header .main-navigation ul ul .current_page_item > a, 
                    .bnm-default-header .main-navigation ul ul .current-menu-item > a, 
                    .bnm-default-header .main-navigation ul ul .current_page_ancestor > a, 
                    .bnm-default-header .main-navigation ul ul .current-menu-ancestor > a {
                        color: '. esc_attr( $dropdown_menu_link_hover_color ) .';
                    }
                ';
            }

            if ( ! empty( $dropdown_menu_link_hover_bg_color ) ) {
                $theme_css .= '
                    .bnm-default-header .main-navigation ul ul .current_page_item > a, 
                    .bnm-default-header .main-navigation ul ul .current-menu-item > a, 
                    .bnm-default-header .main-navigation ul ul .current_page_ancestor > a, 
                    .bnm-default-header .main-navigation ul ul .current-menu-ancestor > a,
                    .bnm-default-header .main-navigation ul ul li a:hover {
                        background-color: '. esc_attr( $dropdown_menu_link_hover_bg_color ) .';
                    }
                ';
            }

        } // END HEADER LAYOUT IF()

        /**
         * Common menu styles for both header layouts.
         */
         if ( ! empty( $dropdown_menu_bg_color ) ) {
            $theme_css .= '
                #site-navigation.bnm-menu ul ul {
                    background-color: '. esc_attr( $dropdown_menu_bg_color ) .';
                }
            ';
        }

         if ( ! empty( $menu_link_color ) ) {
            $theme_css .= '
                #bnm-search-toggle .bnm-svg-icon {
                    color: '. esc_attr( $menu_link_color ) .';
                }
            ';
        }

        /**
         * TOP BAR COLORS
         */
        $topbar_bg_color = get_theme_mod( 'bnm_topbar_bg_color', '' );
        $topbar_text_color = get_theme_mod( 'bnm_topbar_text_color', '' );
        $topbar_link_color = get_theme_mod( 'bnm_topbar_link_color', '' );
        $topbar_link_hover_color = get_theme_mod( 'bnm_topbar_link_hover_color', '' );

        if ( ! empty( $topbar_bg_color ) ) {
            $theme_css .= '
                .bnm-top-bar {
                    background-color: '. esc_attr( $topbar_bg_color ) .';
                }
            ';
        }

        if ( ! empty( $topbar_text_color ) ) {
            $theme_css .= '
                .bnm-top-bar {
                    color: '. esc_attr( $topbar_text_color ) .';
                }
            ';
        }

        if ( ! empty( $topbar_link_color ) ) {
            $theme_css .= '
                .secondary-menu a,
                .bnm-top-bar a {
                    color: '. esc_attr( $topbar_link_color ) .';
                }

                .bnm-slideout-toggle span {
                    border-color: '. esc_attr( $topbar_link_color ) .';
                }
            ';
        }

        if ( ! empty( $topbar_link_hover_color ) ) {
            $theme_css .= '
                .bnm-top-bar .bnm-social-menu a:hover,
                .bnm-top-bar a:hover {
                    color: '. esc_attr( $topbar_link_hover_color ) .';
                }
            ';
        }

        /**
         * bnm_theme_custom_css hook since BNM 1.0.9
         */
        return $theme_css = apply_filters( 'bnm_theme_custom_css', $theme_css );

    }
}

