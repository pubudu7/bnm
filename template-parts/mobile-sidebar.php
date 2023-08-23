<aside class="bnm-mobile-sidebar">
	<button class="bnm-mobile-menu-toggle">
		<?php bnm_the_icon_svg( 'close' ); ?>
	</button>

	<?php 
		if ( true === get_theme_mod( 'bnm_show_social_mobile_menu', true ) && has_nav_menu( 'social' ) ) {
			bnm_social_nav(); 
		}
	?>

	<div class="bnm-mobile-menu-main bnm-mobile-menu">
		<?php bnm_primary_nav(); ?>
	</div>

	<?php if ( true === get_theme_mod( 'bnm_show_top_nav_on_mobile_menu', false ) && has_nav_menu( 'secondary' ) ) : ?>
		<div class="bnm-mobile-menu-secondary bnm-mobile-menu">
			<?php bnm_secondary_nav() ?>
		</div>
	<?php endif; ?>

	<?php 
		if ( true === get_theme_mod( 'bnm_show_slideout_widgets_on_mobile_menu', false ) ) {
			dynamic_sidebar( 'header-1' );
		} 
	?>
</aside><!-- .bnm-mobile-sidebar -->