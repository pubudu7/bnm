<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BNM
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
wp_body_open(); 
do_action( 'bnm_before_header' );	

// Header Settings.
$bnm_header_layout = get_theme_mod( 'bnm_header_layout', 'default' );
$bnm_header_image_loc = get_theme_mod( 'bnm_header_image_location', 'before-header-inner' );
?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bnm' ); ?></a>

	<?php if ( is_active_sidebar( 'header-4' ) ) : ?>
		<div class="bnm-sidebar-header-before">
			<div class="bnm-container">
				<?php dynamic_sidebar( 'header-4' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<header id="masthead" class="site-header hide-header-search">

		<?php if ( has_nav_menu( 'secondary' ) || has_nav_menu( 'social' ) ) : ?>
			<div class="bnm-top-bar desktop-only">
				<div class="top-bar-inner bnm-container">
					<?php bnm_slide_out_menu_toggle( 'top-bar' ); ?>

					<?php if ( has_nav_menu( 'secondary') ) : ?>
						<nav class="secondary-menu bnm-menu" area-label="<?php esc_attr_e( 'Secondary Menu', 'bnm' ); ?>">
							<?php bnm_secondary_nav() ?>
						</nav>
					<?php endif; ?>

					<?php bnm_social_nav(); ?>
				</div><!-- .top-bar-inner .bnm-container -->
			</div><!-- .bnm-top-bar -->
		<?php endif; ?>

		<div class="bnm-header-inner-wrapper">

			<?php 
				/**
				 * Before header inner action
				 */
				do_action( 'bnm_before_header_inner' );

				if ( 'before-header-inner' === $bnm_header_image_loc ) {
					bnm_header_image();
				}
			?>

			<div class="bnm-header-inner bnm-container">

				<?php bnm_slide_out_menu_toggle( 'before-logo' ); ?>

				<?php bnm_site_title(); ?>

				<?php if ( 'single-line' === $bnm_header_layout ) : ?>
					<nav id="site-navigation" class="main-navigation bnm-menu desktop-only">
						<?php bnm_primary_nav(); ?>
					</nav>
					<?php bnm_search_box(); ?>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'header-2' ) ) : ?>
					<div class="bnm-header-sidebar">
						<?php dynamic_sidebar( 'header-2' ); ?>
					</div>
				<?php endif; ?>

				<button class="bnm-mobile-menu-toggle">
					<span class="screen-reader-text"><?php esc_html_e( 'Main Menu', 'bnm' ); ?></span>
					<?php bnm_the_icon_svg( 'menu-bars' ); ?>
				</button>
			
			</div><!-- .bnm-header-inner -->

			<?php 
				/**
				 * After header inner action
				 */
				do_action( 'bnm_after_header_inner' );

				if ( 'after-header-inner' === $bnm_header_image_loc ) {
					bnm_header_image();
				}
			?>

		</div><!-- .bnm-header-inner-wrapper -->

		<?php if ( 'default' === $bnm_header_layout ) : ?>
			<div class="bnm-main-menu desktop-only">
				<div class="bnm-container bnm-menu-wrapper">
					
					<?php bnm_slide_out_menu_toggle( 'primary-menu' ); ?>

					<nav id="site-navigation" class="main-navigation bnm-menu">
						<?php bnm_primary_nav(); ?>
					</nav>

					<?php bnm_search_box(); ?>
				</div>
			</div>
		<?php endif; ?>

	</header><!-- #masthead -->

	<?php
		if ( 'after-site-header' === $bnm_header_image_loc ) {
			bnm_header_image();
		}
	?>

	<?php do_action( 'bnm_after_header' ); ?>

	<?php if ( is_active_sidebar( 'header-3' ) ) : ?>
		<div class="bnm-sidebar-header-after">
			<div class="bnm-container">
				<?php dynamic_sidebar( 'header-3' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<div id="content" class="site-content">
		<?php
			/**
			 * Inside site content action top
			 * 
			 * @since 1.0.3
			 */
			do_action( 'bnm_inside_site_content_top' );
		?>
		<div class="content-area bnm-container">

			<?php do_action( 'bnm_inside_container' ); ?>