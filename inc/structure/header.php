<?php
/**
 * Sidebar header before.
 */
function bnm_sidebar_before_header() {
    if ( is_active_sidebar( 'header-4' ) ) :
    ?>
		<div class="bnm-sidebar-header-before">
			<div class="bnm-container">
				<?php dynamic_sidebar( 'header-4' ); ?>
			</div>
		</div>
    <?php
    endif;
}
add_action( 'bnm_before_header', 'bnm_sidebar_before_header' );

/**
 * Header Top Bar
 */
function bnm_header_top_bar() {
    if ( has_nav_menu( 'secondary' ) || has_nav_menu( 'social' ) ) : ?>
        <div class="bnm-top-bar desktop-only">
            <div class="top-bar-inner bnm-container">
                
                <?php do_action( 'bnm_before_top_bar_main' ); ?>

                <?php do_action( 'bnm_top_bar_main' ); ?>

                <?php do_action( 'bnm_after_top_bar_main' ); ?>

            </div><!-- .top-bar-inner .bnm-container -->
        </div><!-- .bnm-top-bar -->
    <?php endif; 
}
add_action( 'bnm_header_top', 'bnm_header_top_bar' );

/**
 * Header top bar menu.
 */
function bnm_header_top_menu() {
    if ( has_nav_menu( 'secondary') ) : ?>
        <nav class="secondary-menu bnm-menu" area-label="<?php esc_attr_e( 'Secondary Menu', 'bnm' ); ?>">
            <?php bnm_secondary_nav(); ?>
        </nav>
    <?php endif; 
}
add_action( 'bnm_top_bar_main', 'bnm_header_top_menu' );

/**
 * Header Image.
 */
function bnm_header_image_location() {
    $bnm_header_image_loc = get_theme_mod( 'bnm_header_image_location', 'before-header-inner' );
    if ( 'before-header-inner' === $bnm_header_image_loc ) {
        add_action( 'bnm_header_top', 'bnm_header_image', 15 );
    } elseif ( 'after-header-inner' === $bnm_header_image_loc ) {
        add_action( 'bnm_header_bottom', 'bnm_header_image', 5 );
    } elseif ( 'before-site-header' === $bnm_header_image_loc ) {
        add_action( 'bnm_before_header', 'bnm_header_image', 15 );
    } elseif ( 'after-site-header' === $bnm_header_image_loc ) {
        add_action( 'bnm_after_header', 'bnm_header_image', 5 );
    }
}
add_action( 'wp', 'bnm_header_image_location' );


/**
 * Sidebar header after.
 */
function bnm_sidebar_after_header() {
    if ( is_active_sidebar( 'header-3' ) ) :
    ?>
		<div class="bnm-sidebar-header-after">
			<div class="bnm-container">
				<?php dynamic_sidebar( 'header-3' ); ?>
			</div>
		</div>
    <?php
    endif;
}
add_action( 'bnm_after_header', 'bnm_sidebar_after_header' );

/**
 * Get Header Template Part.
 */
function bnm_header_template() {
    get_template_part( 'template-parts/header/header' );
}
add_action( 'bnm_header', 'bnm_header_template' );

/**
 * Header Sidebar
 */
function bnm_header_sidebar() {
    if ( is_active_sidebar( 'header-2' ) ) : ?>
        <div class="bnm-header-sidebar">
            <?php dynamic_sidebar( 'header-2' ); ?>
        </div>
    <?php endif;
}
add_action( 'bnm_after_header_main', 'bnm_header_sidebar', 7 );

/**
 * Mobile Menu toggle.
 */
function bnm_mobile_menu_toggle() {
    ?>
        <button class="bnm-mobile-menu-toggle">
            <span class="screen-reader-text"><?php esc_html_e( 'Main Menu', 'bnm' ); ?></span>
            <?php bnm_the_icon_svg( 'menu-bars' ); ?>
        </button>
    <?php
}
add_action( 'bnm_after_header_main', 'bnm_mobile_menu_toggle', 6 );

/**
 * Site branding.
 */
if ( ! function_exists( 'bnm_site_title' ) ) : 

	function bnm_site_title() {

		$bnm_site_title = get_bloginfo( 'title' );
		$bnm_description = get_bloginfo( 'description', 'display' );

		$hide_title = ( get_theme_mod( 'bnm_hide_site_title', false ) || '' == $bnm_site_title ) ? true : false;
		$hide_tagline = ( get_theme_mod( 'bnm_hide_site_tagline', false ) || '' == $bnm_description ) ? true : false;

		?>
		<div class="site-branding-container">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif; ?>

			<div class="site-branding">
				<?php

				if ( ! $hide_title ) :

					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;

				endif;
				
				if ( ! $hide_tagline ) :
					?>
					<p class="site-description"><?php echo $bnm_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->
		</div><!-- .site-branding-container -->
		<?php
	}
    add_action( 'bnm_before_header_main', 'bnm_site_title', 5 );

endif;