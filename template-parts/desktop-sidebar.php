<?php if ( true == get_theme_mod( 'bnm_show_slideout_sb', false ) ) : ?>
	<aside id="bnm-slideout-sidebar" class="bnm-slideout-sidebar">
		<div class="bnm-slideout-top">
			<button class="bnm-slideout-toggle">
				<?php echo bnm_the_icon_svg( 'close' ); ?>
			</button>
		</div>

		<?php if ( true === get_theme_mod( 'bnm_show_pmenu_onslideout', false ) ) : ?>
			<div class="bnm-mobile-menu-main bnm-mobile-menu">
				<?php bnm_primary_nav(); ?>
			</div>
		<?php endif; ?>

		<?php dynamic_sidebar( 'header-1' ); ?>		
	</aside><!-- .bnm-slideout-sidebar -->
<?php endif; ?>