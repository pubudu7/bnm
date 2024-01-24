<?php
/**
 * Load necessary Customizer controls and functions.
 * 
 * @package BNM
 */

// Custom Controls.
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/custom-controls/fonts/class-fonts-control.php';
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/custom-controls/responsive-number/class-responsive-number-control.php';
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/custom-controls/slider/class-slider-control.php';
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/custom-controls/radio-image/class-radio-image-control.php';
if ( ! defined( 'BNM_PRO_VERSION' ) ) {
    require_once trailingslashit( get_template_directory() ) . 'inc/customizer/custom-controls/class-upsell-customize.php';
}