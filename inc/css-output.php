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

        $theme_css .= '
            :root { ' . $css_variables . ' }
        ';

        $article_link_color = get_theme_mod( 'bnm_article_links_color', '#046bd2' );
        if ( ! empty( $article_link_color ) && '#046bd2' != $article_link_color ) {
            $theme_css .= '
                .page-content a:not(.bnm-read-more):not(.wp-block-button__link):not(.bnm-readmore-btn), 
                .entry-content a:not(.bnm-read-more):not(.wp-block-button__link):not(.bnm-readmore-btn), 
                .entry-summary a:not(.bnm-read-more):not(.wp-block-button__link):not(.bnm-readmore-btn) {
                    color: '. esc_attr( $article_link_color ) .';
                }
            ';
        }

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
        $logo_max_width = get_theme_mod( 'bnm_logo_max_width_desktop', 0 );
        if ( ! empty( $logo_max_width ) ) {
            $theme_css .= '
                .site-logo img {
                    max-width: '. esc_attr( $logo_max_width ) .'px;
                }
            ';
        }

        // Logo Max Height
        $logo_max_height = get_theme_mod( 'bnm_logo_max_height_desktop', 0 );
        if ( ! empty( $logo_max_height ) ) {
            $theme_css .= '
                .site-logo img {
                    max-height: '. esc_attr( $logo_max_height ) .'px;
                    width: auto;
                }
            ';
        }

        // Logo Max Width Tablet
        $logo_max_width = get_theme_mod( 'bnm_logo_max_width_tablet', 0 );
        if ( ! empty( $logo_max_width ) ) {
            $theme_css .= '
                @media (min-width: 480px) and (max-width: 768px) {
                    .site-logo img {
                        max-width: '. esc_attr( $logo_max_width ) .'px;
                    }
                }
            ';
        }

        // Logo Max Height Tablet
        $logo_max_height = get_theme_mod( 'bnm_logo_max_height_tablet', 0 );
        if ( ! empty( $logo_max_height ) ) {
            $theme_css .= '
                @media (min-width: 480px) and (max-width: 768px) {
                    .site-logo img {
                        max-height: '. esc_attr( $logo_max_height ) .'px;
                        width: auto;
                    }
                }
            ';
        }

        // Logo Max Width Mobile
        $logo_max_width = get_theme_mod( 'bnm_logo_max_width_mobile', 0 );
        if ( ! empty( $logo_max_width ) ) {
            $theme_css .= '
                @media (max-width: 480px) {
                    .site-logo img {
                        max-width: '. esc_attr( $logo_max_width ) .'px;
                    }
                }
            ';
        }

        // Logo Max Height Mobile
        $logo_max_height = get_theme_mod( 'bnm_logo_max_height_mobile', 0 );
        if ( ! empty( $logo_max_height ) ) {
            $theme_css .= '
                @media (max-width: 480px) {
                    .site-logo img {
                        max-height: '. esc_attr( $logo_max_height ) .'px;
                        width: auto;
                    }
                }
            ';
        }

        $default_header_padding_top = get_theme_mod( 'bnm_default_header_padding_top', 40 );
        if ( 40 != $default_header_padding_top ) {
            $theme_css .= '
                .bnm-default-header .bnm-header-inner {
                    padding-top: '. esc_attr( $default_header_padding_top ) .'px;
                }
            ';
        }

        $default_header_padding_bottom = get_theme_mod( 'bnm_default_header_padding_bottom', 40 );
        if ( 40 != $default_header_padding_bottom ) {
            $theme_css .= '
                .bnm-default-header .bnm-header-inner {
                    padding-bottom: '. esc_attr( $default_header_padding_bottom ) .'px;
                }
            ';
        }

        $line_header_padding_top = get_theme_mod( 'bnm_line_header_padding_top', 20 );
        if ( 20 != $line_header_padding_top ) {
            $theme_css .= '
                .bnm-line-header .bnm-header-inner {
                    padding-top: '. esc_attr( $line_header_padding_top ) .'px;
                }
            ';
        }

        $line_header_padding_bottom = get_theme_mod( 'bnm_line_header_padding_bottom', 20 );
        if ( 20 != $line_header_padding_bottom ) {
            $theme_css .= '
                .bnm-line-header .bnm-header-inner {
                    padding-bottom: '. esc_attr( $line_header_padding_bottom ) .'px;
                }
            ';
        }

        return $theme_css;

    }
}

