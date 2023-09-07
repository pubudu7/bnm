<?php

function bnm_enqueue_admin_scripts( $hook ) {
    if ( 'appearance_page_about-bnm-theme' != $hook ) {
        return;
    }
    wp_register_style( 'bnm-admin-css', get_template_directory_uri() . '/inc/dashboard/css/admin.css', false, '1.0.0' );
    wp_enqueue_style( 'bnm-admin-css' );
}
add_action( 'admin_enqueue_scripts', 'bnm_enqueue_admin_scripts' );

/**
 * Add admin notice when active theme
 */
function bnm_admin_notice() {
    ?>
    <div class="updated notice notice-info is-dismissible">
        <p><?php esc_html_e( 'Welcome to BNM! To get started with BNM please visit the theme Welcome page.', 'bnm' ); ?></p>
        <p><a class="button" href="<?php echo esc_url( admin_url( 'themes.php?page=about-bnm-theme' ) ); ?>"><?php _e( 'Get Started with BNM', 'bnm' ) ?></a></p>
    </div>
    <?php
}


function bnm_activation_admin_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
        add_action( 'admin_notices', 'bnm_admin_notice' );
    }
}
add_action( 'load-themes.php',  'bnm_activation_admin_notice'  );


function bnm_add_themeinfo_page() {

    // Menu title can be displayed with recommended actions count.
    $menu_title = esc_html__( 'BNM Theme', 'bnm' );

    add_theme_page( esc_html__( 'BNM Theme', 'bnm' ), $menu_title , 'edit_theme_options', 'about-bnm-theme', 'bnm_themeinfo_page_render' );

}
add_action( 'admin_menu', 'bnm_add_themeinfo_page' );

function bnm_themeinfo_page_render() { ?>

    <div class="wrap about-wrap">

        <?php $theme_info = wp_get_theme(); ?>

        <h1><?php esc_html_e( 'Welcome to BNM', 'bnm' ); ?></h1>

        <p><?php echo esc_html( $theme_info->get( 'Description' ) ); ?></p>
    
        <h2 class="nav-tab-wrapper">
            <a class="nav-tab <?php if ( $_GET['page'] == 'about-bnm-theme' && ! isset( $_GET['tab'] ) ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'about-bnm-theme' ), 'themes.php' ) ) ); ?>">
                <?php esc_html_e( 'BNM', 'bnm' ); ?>
            </a>
            <a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'magazine_homepage' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'about-bnm-theme', 'tab' => 'magazine_homepage' ), 'themes.php' ) ) ); ?>">
                <?php esc_html_e( 'Magazine Homepage', 'bnm' ); ?>
            </a>
        </h2>

        <?php

        $current_tab = ! empty( $_GET['tab'] ) ? sanitize_title( $_GET['tab'] ) : '';

        if ( $current_tab == 'magazine_homepage' ) {
            bnm_magazine_make_guide();
        } else {
            bnm_admin_welcome_page();
        }

        ?>

    </div><!-- .wrap .about-wrap -->

    <?php

}

function bnm_admin_welcome_page() {
    ?>
    <div class="th-theme-info-page">
        <div class="th-theme-info-page-inner">
            <div class="th-theme-page-infobox">
                <div class="th-theme-infobox-content">
                <h3><?php esc_html_e( 'Theme Customizer', 'bnm' ); ?></h3>
                <p><?php esc_html_e( 'All the BNM theme settings are located at the customizer. Start customizing your website with customizer.', 'bnm' ) ?></p>
                <a class="button" target="_blank" href="<?php echo esc_url( admin_url( '/customize.php' ) ); ?>"><?php esc_html_e( 'Go to customizer','bnm' ); ?></a>
                </div>
            </div>

            <div class="th-theme-page-infobox">
            <div class="th-theme-infobox-content">
                <h3><?php esc_html_e( 'Theme Documentation', 'bnm' ); ?></h3>
                <p><?php esc_html_e( 'Need to learn all about BNM? Read the theme documentation carefully.', 'bnm' ) ?></p>
                <a class="button" target="_blank" href="<?php echo esc_url( 'https://themezhut.com/bnm-wordpress-theme-documentation/' ); ?>"><?php esc_html_e( 'Read the documentation.','bnm' ); ?></a>
            </div>
            </div>

            <div class="th-theme-page-infobox">
            <div class="th-theme-infobox-content">
                <h3><?php esc_html_e( 'Theme Info', 'bnm' ); ?></h3>
                <p><?php esc_html_e( 'Know all the details about BNM theme.', 'bnm' ) ?></p>
                <a class="button" target="_blank" href="<?php echo esc_url( 'https://themezhut.com/themes/bnm/' ); ?>"><?php esc_html_e( 'Theme Details.','bnm' ); ?></a>
            </div>
            </div>

            <div class="th-theme-page-infobox">
            <div class="th-theme-infobox-content">
                <h3><?php esc_html_e( 'Theme Demo', 'bnm' ); ?></h3>
                <p><?php esc_html_e( 'See the theme preview of free version.', 'bnm' ) ?></p>
                <a class="button" target="_blank" href="<?php echo esc_url( 'https://themezhut.com/demo/bnm/' ); ?>"><?php esc_html_e( 'Theme Preview','bnm' ); ?></a>    
            </div>
            </div>
        </div>
    </div>

    <?php
}

function bnm_magazine_make_guide() {
?>
    <div class="th-theme-info-page">
        <div class="th-theme-info-page-content">
            <h3><?php esc_html_e( 'Creating a Magazine Homepage', 'bnm' ); ?></h3>
            <p><?php esc_html_e( 'Creating a magazine homepage is really easy. All you have to do is add the "BNM: Magazine Posts" widgets to the "Magazine" widget area.', 'bnm' ) ?></p>
            <p><?php esc_html_e( 'If you need to create a seperate page for magazine create a page using the page template "Magazine Template".', 'bnm' ) ?></p>
            <p><?php esc_html_e( 'Learn more from the theme documentation.', 'bnm' ) ?></p>
        </div>
    </div>
<?php
}
