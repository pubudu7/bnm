<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BNM
 */

?>
	</div><!-- .bnm-container -->
	</div><!-- .site-content -->
	<footer id="colophon" class="site-footer">

		<?php
			$bnm_footer_sidebar_count = get_theme_mod( 'bnm_footer_sidebar_count', '3' );
		?>

		<div class="bnm-footer-widget-area">
			<div class="bnm-container bnm-footer-widgets-inner">
				<div class="bnm-footer-column">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div><!-- .bnm-footer-column -->

				<?php if ( $bnm_footer_sidebar_count >= 2 ) : ?>
					<div class="bnm-footer-column">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div><!-- .bnm-footer-column -->
				<?php endif; ?>

				<?php if ( $bnm_footer_sidebar_count >= 3 ) : ?>
					<div class="bnm-footer-column">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div><!-- .bnm-footer-column -->
				<?php endif; ?>

				<?php if ( $bnm_footer_sidebar_count >= 4 ) : ?>
					<div class="bnm-footer-column">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div><!-- .bnm-footer-column -->
				<?php endif; ?>
			</div><!-- .bnm-footer-widgets-inner -->
		</div><!-- .bnm-footer-widget-area -->

		<div class="bnm-footer-bottom">
			<div class="bnm-container bnm-footer-site-info">
				<div class="bnm-footer-copyright">
					<?php 
						$bnm_copyright_text = get_theme_mod( 'bnm_footer_copyright_text', '' ); 

						if ( ! empty( $bnm_copyright_text ) ) {
							echo wp_kses_post( $bnm_copyright_text );
						} else {
							$bnm_site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" >' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
							/* translators: 1: Year 2: Site URL. */
							printf( esc_html__( 'Copyright &#169; %1$s %2$s.', 'bnm' ), date_i18n( 'Y' ), $bnm_site_link ); // WPCS: XSS OK.
						}		
					?>
				</div><!-- .bnm-footer-copyright -->

				<div class="bnm-designer-credit">
					<?php
						/* translators: 1: WordPress 2: Theme Author. */
						printf( esc_html__( 'Powered by %1$s and %2$s.', 'bnm' ),
							'<a href="https://wordpress.org" target="_blank">WordPress</a>',
							'<a href="https://themezhut.com/themes/bnm/" target="_blank">BNM</a>'
						); 
					?>
				</div><!-- .bnm-designer-credit" -->
			</div><!-- .bnm-container -->
		</div><!-- .bnm-footer-bottom -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php
get_template_part( 'template-parts/mobile', 'sidebar' );
get_template_part( 'template-parts/desktop', 'sidebar' );
?>

<?php wp_footer(); ?>

</body>
</html>
