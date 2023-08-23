<?php

/**
 * BNM: Typography functions.
 * 
 * @package BNM
 */

function bnm_custom_typography_css() {
    $body_font = get_theme_mod( 'bnm_font_family_1', '' );
    $headings_font = get_theme_mod( 'bnm_font_family_2', '' );
    $headings_font_weight = get_theme_mod( 'bnm_headings_font_weight', '' );

    $site_title_desktop_font_size   = get_theme_mod( 'bnm_site_title_desktop_font_size', '' );
    $site_title_tablet_font_size    = get_theme_mod( 'bnm_site_title_tablet_font_size', '' );
    $site_title_mobile_font_size    = get_theme_mod( 'bnm_site_title_mobile_font_size', '' );

    $post_desktop_font_size   = get_theme_mod( 'bnm_post_desktop_font_size', '' );
    $post_tablet_font_size    = get_theme_mod( 'bnm_post_tablet_font_size', '' );
    $post_mobile_font_size    = get_theme_mod( 'bnm_post_mobile_font_size', '' );    

    $css = '';

    if ( $body_font ) {
        $css .= '
            :root {
                --bnm-font-family-body: ' . wp_kses( $body_font, null ) . ';
            }
        ';
    }

    if ( $headings_font ) {
        $css .= '
            :root {
                --bnm-font-family-headings: ' . wp_kses( $headings_font, null ) . ';
            }
        ';
    }

    if ( $headings_font_weight ) {
        $css .= '
            :root {
                --bnm-font-weight-headings: ' . esc_attr( $headings_font_weight ) . ';
            }
        ';
    }

    // Site title font size.
    if ( $site_title_desktop_font_size ) {
        $css .= '
            .site-title {
                font-size: ' . esc_attr( $site_title_desktop_font_size ) . ';
            }
        ';
    }

    if ( $site_title_tablet_font_size ) {
        $css .= '
            @media screen and (max-width: 768px) {
                .site-title {
                    font-size: ' . esc_attr( $site_title_tablet_font_size ) . ';
                }
            }
        ';
    }

    if ( $site_title_mobile_font_size ) {
        $css .= '
            @media screen and (max-width: 600px) {
                .site-title {
                    font-size: ' . esc_attr( $site_title_mobile_font_size ) . ';
                }
            }
        ';
    }

    // Post font size.
    if ( $post_desktop_font_size ) {
        $css .= '
            .single .bnm-entry {
                font-size: ' . esc_attr( $post_desktop_font_size ) . ';
            }
        ';
    }

    if ( $post_tablet_font_size ) {
        $css .= '
            @media screen and (max-width: 768px) {
                .single .bnm-entry {
                    font-size: ' . esc_attr( $post_tablet_font_size ) . ';
                }
            }
        ';
    }

    if ( $post_mobile_font_size ) {
        $css .= '
            @media screen and (max-width: 600px) {
                .single .bnm-entry {
                    font-size: ' . esc_attr( $post_mobile_font_size ) . ';
                }
            }
        ';
    }

    return $css;
}