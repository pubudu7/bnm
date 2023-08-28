<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BNM
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php 

	/**
	 * Before sidebar hook.
	 */
	do_action( 'bnm_before_main_sidebar' );
	
	
	dynamic_sidebar( 'sidebar-1' ); 

	/**
	 * After sidebar hook.
	 */
	do_action( 'bnm_after_main_sidebar' );
	
	?>
</aside><!-- #secondary -->
