<?php
/**
 * BNM Theme Customizer
 *
 * @package BNM
 */

 /**
  * Set up customizer helpers early.
  */
function bnm_get_customizer_helpers() {
	require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-helpers.php';
}
add_action( 'customize_register', 'bnm_get_customizer_helpers', 1 );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bnm_customize_register( $wp_customize ) {

	// Custom Controls.
	$wp_customize->register_control_type( 'BNM_Responsive_Number_Control' );
	$wp_customize->register_control_type( 'BNM_Slider_Control' );

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_control( 'blogname' )->priority         = 1;
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_control( 'blogdescription' )->priority  = 3;
	$wp_customize->get_control( 'background_color' )->priority  = 2;
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/*
	// Un-comment when the custom-header feature is ready.
	$wp_customize->get_control( 'header_textcolor' )->priority 		= 1;
	$wp_customize->get_section( 'header_image' )->panel 		= 'bnm_panel_header';
	$wp_customize->get_section( 'header_image' )->priority 		= 50;
	// Hide the checkbox "Display site title and tagline"
	$wp_customize->remove_control( 'display_header_text' );
	*/

	// uri for the customizer images folder
	$images_uri = get_template_directory_uri() . '/inc/customizer/assets/images/'; 

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'bnm_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'bnm_customize_partial_blogdescription',
			)
		);
	}

	// Hide site title
	$wp_customize->add_setting(
		'bnm_hide_site_title',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_hide_site_title',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Hide site title', 'bnm' ),
			'priority'	  => 2,
			'section'     => 'title_tagline',
		)
	);

	// Hide site title
	$wp_customize->add_setting(
		'bnm_hide_site_tagline',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_hide_site_tagline',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Hide site tagline', 'bnm' ),
			'priority'	  => 4,
			'section'     => 'title_tagline',
		)
	);

	// Logo Max Width
	$wp_customize->add_setting(
		'bnm_logo_max_width_desktop',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	// Logo Max Width - Tab.
	$wp_customize->add_setting(
		'bnm_logo_max_width_tablet',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	// Logo Max Width - Mobile.
	$wp_customize->add_setting(
		'bnm_logo_max_width_mobile',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	$wp_customize->add_control( 
		new BNM_Responsive_Number_Control( $wp_customize, 'bnm_logo_max_width',
		array(
			'label'         => esc_html__( 'Logo Max Width (px)', 'bnm' ),
			'section'       => 'title_tagline',
			'settings'      => array(
				'desktop'   => 'bnm_logo_max_width_desktop',
				'tablet'    => 'bnm_logo_max_width_tablet',
				'mobile'    => 'bnm_logo_max_width_mobile'
			),
			'active_callback'	=> 'bnm_has_custom_logo'
		)
	) );

	// Logo Max Height
	$wp_customize->add_setting(
		'bnm_logo_max_height_desktop',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		)
	);
	// Logo Max Height - Tab.
	$wp_customize->add_setting(
		'bnm_logo_max_height_tablet',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		)
	);
	// Logo Max Height - Mobile.
	$wp_customize->add_setting(
		'bnm_logo_max_height_mobile',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		)
	);
	$wp_customize->add_control( 
		new BNM_Responsive_Number_Control( $wp_customize, 'bnm_logo_max_height',
		array(
			'label'         => esc_html__( 'Logo Max Height (px)', 'bnm' ),
			'section'       => 'title_tagline',
			'settings'      => array(
				'desktop'   => 'bnm_logo_max_height_desktop',
				'tablet'    => 'bnm_logo_max_height_tablet',
				'mobile'    => 'bnm_logo_max_height_mobile'
			),
			'active_callback'	=> 'bnm_has_custom_logo'
		)
	) );

	// Color Section
	// Primary Color.
	$wp_customize->add_setting(
		'bnm_primary_color',
		array(
			'default'			=> '#f87c7c',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
			$wp_customize,
			'bnm_primary_color',
			array(
				'section'		    => 'colors',
				'priority'			=> 1,
				'label'			    => esc_html__( 'Theme Primary Color', 'bnm' ),
			)
		)
	);

	// Boxed Inner Background Color.
	$wp_customize->add_setting(
		'bnm_boxed_inner_bg_color',
		array(
			'default'			=> '#ffffff',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
			$wp_customize,
			'bnm_boxed_inner_bg_color',
			array(
				'section'		    => 'colors',
				'label'			    => esc_html__( 'Inner Background Color', 'bnm' ),
				'active_callback'	=> 'bnm_is_boxed_layout_active'
			)
		)
	);

	// Text Color.
	$wp_customize->add_setting(
		'bnm_text_color',
		array(
			'default'			=> '#222222',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
			$wp_customize,
			'bnm_text_color',
			array(
				'section'		    => 'colors',
				'label'			    => esc_html__( 'Text Color', 'bnm' ),
			)
		)
	);

	// Link Color.
	$wp_customize->add_setting(
		'bnm_links_color',
		array(
			'default'			=> '#000000',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
			$wp_customize,
			'bnm_links_color',
			array(
				'section'		    => 'colors',
				'label'			    => esc_html__( 'Links Color', 'bnm' ),
			)
		)
	);

	// Typography Options Section
	$wp_customize->add_section(
		'bnm_typography_section',
		array(
			'title' 		=> esc_html__( 'Typography', 'bnm' ),
			'description' 	=> esc_html__( 'If the "Inherit" option is selected the theme will use the "System Fonts Stack". If you select a "Google" font it will be automatically downloaded and served locally from your server.', 'bnm' ),
			'priority' 		=> 50
		)
	);

	$wp_customize->add_setting( 
		'bnm_font_family_1',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control( 
		new BNM_Fonts_Control( $wp_customize, 'bnm_font_family_1',
		array(
			'label'         => esc_html__( 'Body Font', 'bnm' ),
			'section'       => 'bnm_typography_section',
			'settings'      => 'bnm_font_family_1'
		)
	) );

	$wp_customize->add_setting( 
		'bnm_font_family_2',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control( 
		new BNM_Fonts_Control( $wp_customize, 'bnm_font_family_2',
		array(
			'label'         => esc_html__( 'Headings Font', 'bnm' ),
			'section'       => 'bnm_typography_section',
			'settings'      => 'bnm_font_family_2'
		)
	) );

	$wp_customize->add_setting(
		'bnm_headings_font_weight',
		array(
			'default'			=> '',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_headings_font_weight',
		array(
			'settings'		=> 'bnm_headings_font_weight',
			'section'		=> 'bnm_typography_section',
			'type'			=> 'select',
			'label'			=> esc_html__( 'Headings Font Weight', 'bnm' ),
			'description'	=> esc_html__( 'Only the font supported font weights will be applied.', 'bnm' ),
			'choices'		=> array(
				''          => esc_html__( 'Default', 'bnm' ),
				'100'       => esc_html__( 'Thin: 100', 'bnm' ),
				'200'       => esc_html__( 'Extra Light: 200', 'bnm' ),
				'300'       => esc_html__( 'Light: 300', 'bnm' ),
				'400'       => esc_html__( 'Normal: 400', 'bnm' ),
				'500'       => esc_html__( 'Medium: 500', 'bnm' ),
				'600'       => esc_html__( 'Semi Bold: 600', 'bnm' ),
				'700'       => esc_html__( 'Bold: 700', 'bnm' ),
				'800'       => esc_html__( 'Extra Bold: 800', 'bnm' ),
				'900'       => esc_html__( 'Black: 900', 'bnm' )
			)
		)
	);

	// Site Title Font Size - Desktop.
	$wp_customize->add_setting(
		'bnm_site_title_desktop_font_size',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	// Site Title Font Size - Tab.
	$wp_customize->add_setting(
		'bnm_site_title_tablet_font_size',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	// Site Title Font Size - Mobile.
	$wp_customize->add_setting(
		'bnm_site_title_mobile_font_size',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 
		new BNM_Responsive_Number_Control( $wp_customize, 'bnm_site_title_font_size',
		array(
			'label'         => esc_html__( 'Site Title Font Size', 'bnm' ),
			'description' 	=> esc_html__( 'You can add: px-em-rem', 'bnm' ),
			'section'       => 'bnm_typography_section',
			'settings'      => array(
				'desktop'   => 'bnm_site_title_desktop_font_size',
				'tablet'    => 'bnm_site_title_tablet_font_size',
				'mobile'    => 'bnm_site_title_mobile_font_size'
			)
		)
	) );

	// Article Font Size - Desktop.
	$wp_customize->add_setting(
		'bnm_post_desktop_font_size',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	// Article Font Size - Tab.
	$wp_customize->add_setting(
		'bnm_post_tablet_font_size',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	// Article Font Size - Mobile.
	$wp_customize->add_setting(
		'bnm_post_mobile_font_size',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 
		new BNM_Responsive_Number_Control( $wp_customize, 'bnm_post_font_size',
		array(
			'label'         => esc_html__( 'Single Post Content Font Size', 'bnm' ),
			'description' 	=> esc_html__( 'You can add: px-em-rem', 'bnm' ),
			'section'       => 'bnm_typography_section',
			'settings'      => array(
				'desktop'   => 'bnm_post_desktop_font_size',
				'tablet'    => 'bnm_post_tablet_font_size',
				'mobile'    => 'bnm_post_mobile_font_size'
			)
		)
	) );

	// General Settings Panel
	$wp_customize->add_panel(
		'bnm_panel_general_settings',
		array(
			'priority' 			=> 190,
			'capability' 		=> 'edit_theme_options',
			'title' 			=> esc_html__( 'General Settings', 'bnm' )
		)
	);

	// General Settings Section
	$wp_customize->add_section(
		'bnm_site_layout_section',
		array(
			'title' => esc_html__( 'Site Layout', 'bnm' ),
			'panel' => 'bnm_panel_general_settings'
		)
	);

	// General - Site Layout
	$wp_customize->add_setting(
		'bnm_site_layout',
		array(
			'default' => 'wide',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_site_layout',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Site Layout', 'bnm' ),
			'section' => 'bnm_site_layout_section',
			'choices' => array(
				'wide' => esc_html__( 'Wide', 'bnm' ),
				'boxed' => esc_html__( 'Boxed', 'bnm' )
			)
		)
	);

	// General - Site container width
	$wp_customize->add_setting( 
		'bnm_container_width',
		array(
			'default'           => 1200,
			'sanitize_callback' => 'bnm_sanitize_slider_number_input',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control( 
		new BNM_Slider_Control( $wp_customize, 'bnm_container_width',
		array(
			'label'         => esc_html__( 'Container Width (px)', 'bnm' ),
			'section'       => 'bnm_site_layout_section',
			'choices'       => array(
				'min'   => 300,
				'max'   => 2000,
				'step'  => 1,
			),
			'active_callback' => 'bnm_is_wide_layout_active'
		)
	) );

	// General - Boxed Layout width
	$wp_customize->add_setting( 
		'bnm_boxed_width',
		array(
			'default'           => 30,
			'sanitize_callback' => 'bnm_sanitize_slider_number_input',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control( 
		new BNM_Slider_Control( $wp_customize, 'bnm_boxed_width',
		array(
			'label'         => esc_html__( 'Boxed Layout Width (px)', 'bnm' ),
			'description'	=> esc_html__( 'This value applies only when the sidebar is active.', 'bnm' ),
			'section'       => 'bnm_site_layout_section',
			'choices'       => array(
				'min'   => 300,
				'max'   => 2000,
				'step'  => 1,
			),
			'active_callback' => 'bnm_is_boxed_layout_active'
		)
	) );

	$wp_customize->add_setting( 
		'bnm_boxed_width',
		array(
			'default'           => 1280,
			'sanitize_callback' => 'bnm_sanitize_slider_number_input',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control( 
		new BNM_Slider_Control( $wp_customize, 'bnm_boxed_width',
		array(
			'label'         => esc_html__( 'Boxed Layout Width (px)', 'bnm' ),
			'section'       => 'bnm_site_layout_section',
			'choices'       => array(
				'min'   => 300,
				'max'   => 2000,
				'step'  => 1,
			),
			'active_callback' => 'bnm_is_boxed_layout_active'
		)
	) );

	// General - Sidebar width
	$wp_customize->add_setting( 
		'bnm_sidebar_width',
		array(
			'default'           => 30,
			'sanitize_callback' => 'bnm_sanitize_slider_number_input',
			//'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control( 
		new BNM_Slider_Control( $wp_customize, 'bnm_sidebar_width',
		array(
			'label'         => esc_html__( 'Sidebar Width (%)', 'bnm' ),
			'description'	=> esc_html__( 'This value applies only when the sidebar is active.', 'bnm' ),
			'section'       => 'bnm_site_layout_section',
			'choices'       => array(
				'min'   => 15,
				'max'   => 50,
				'step'  => 1,
			)
		)
	) );

	// Breadcrumb Settings Section
	$wp_customize->add_section(
		'bnm_breadcrumb_section',
		array(
			'title' => esc_html__( 'Breadcrumb', 'bnm' ),
			'panel' => 'bnm_panel_general_settings'
		)
	);

	$wp_customize->add_setting(
		'bnm_breadcrumb_source',
		array(
			'default' => 'none',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_breadcrumb_source',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Breadcrumb Source', 'bnm' ),
			'section' => 'bnm_breadcrumb_section',
			'choices' => array(
				'none' 			=> esc_html__( 'None', 'bnm' ),
				'yoast' 		=> esc_html__( 'Yoast SEO Breadcrumbs', 'bnm' ),
				'navxt' 		=> esc_html__( 'Breadcrumb NavXT', 'bnm' ),
				'rankmath' 		=> esc_html__( 'RankMath Breadcrumbs', 'bnm' ),
			)
		)
	);

	$wp_customize->add_setting(
		'bnm_breadcrumb_location',
		array(
			'default' => 'bnm_before_entry_header',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_breadcrumb_location',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Breadcrumb Location', 'bnm' ),
			'section' => 'bnm_breadcrumb_section',
			'choices' => array(
				'bnm_after_header'			=> esc_html__( 'After Site Header', 'bnm' ),
				'bnm_before_entry_header'	=> esc_html__( 'Before Article Header', 'bnm' )
			),
			'active_callback' => 'bnm_is_showing_breadcrumb'
		)
	);

	// General - Featured images rounded borders
	/*$wp_customize->add_setting(
		'bnm_images_rounded_borders',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_images_rounded_borders',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Make corners rounded on featured images', 'bnm' ),
			'section'     => 'bnm_site_layout_section',
		)
	);*/

	// Header Settings Panel
	$wp_customize->add_panel(
		'bnm_panel_header',
		array(
			'priority' 			=> 192,
			'capability' 		=> 'edit_theme_options',
			'title' 			=> esc_html__( 'Header Settings', 'bnm' )
		)
	);

	$wp_customize->add_section(
		'bnm_header_layout_section',
		array(
			'title' => esc_html__( 'Appearance', 'bnm' ),
			'priority' => 5,
			'panel'	=> 'bnm_panel_header'
		)
	);

	// Header Layout
	$wp_customize->add_setting(
		'bnm_header_layout',
		array(
			'default' => 'default',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_header_layout',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Header Layout', 'bnm' ),
			'section' => 'bnm_header_layout_section',
			'choices' => array(
				'default' => esc_html__( 'Default Layout', 'bnm' ),
				'single-line' => esc_html__( 'Single Line Layout', 'bnm' )
			)
		)
	);

	// Header Width.
	$wp_customize->add_setting(
		'bnm_header_width',
		array(
			'default' => 'contained',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_header_width',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Header Width', 'bnm' ),
			'section' => 'bnm_header_layout_section',
			'choices' => array(
				'contained' => esc_html__( 'Contained', 'bnm' ),
				'full' => esc_html__( 'Full', 'bnm' )
			)
		)
	);

	// Header - Logo Alignment
	$wp_customize->add_setting(
		'bnm_logo_align',
		array(
			'default' => 'left',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_logo_align',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Logo Alignment', 'bnm' ),
			'section' => 'bnm_header_layout_section',
			'choices' => array(
				'left'		=> esc_html__( 'Left', 'bnm' ),
				'center'	=> esc_html__( 'Center', 'bnm' ),
				'right'		=> esc_html__( 'Right', 'bnm' )
			),
			'active_callback' => 'bnm_is_default_header'
		)
	);

	// Header Padding Top - Desktop
	$wp_customize->add_setting(
		'bnm_header_padding_top_desktop',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	// Header Padding Top - Tablet
	$wp_customize->add_setting(
		'bnm_header_padding_top_tablet',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	// Header Padding Top - Mobile
	$wp_customize->add_setting(
		'bnm_header_padding_top_mobile',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	$wp_customize->add_control( 
		new BNM_Responsive_Number_Control( $wp_customize, 'bnm_header_padding_top',
		array(
			'label'         => esc_html__( 'Header Padding Top (px)', 'bnm' ),
			'section'       => 'bnm_header_layout_section',
			'settings'      => array(
				'desktop'   => 'bnm_header_padding_top_desktop',
				'tablet'    => 'bnm_header_padding_top_tablet',
				'mobile'    => 'bnm_header_padding_top_mobile'
			)
		)
	) );

	// Header Padding Bottom - Desktop
	$wp_customize->add_setting(
		'bnm_header_padding_bottom_desktop',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	// Header Padding Bottom - Tablet
	$wp_customize->add_setting(
		'bnm_header_padding_bottom_tablet',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	// Header Padding Bottom - Mobile
	$wp_customize->add_setting(
		'bnm_header_padding_bottom_mobile',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_blank'
		)
	);
	$wp_customize->add_control( 
		new BNM_Responsive_Number_Control( $wp_customize, 'bnm_header_padding_bottom',
		array(
			'label'         => esc_html__( 'Header Padding Bottom (px)', 'bnm' ),
			'section'       => 'bnm_header_layout_section',
			'settings'      => array(
				'desktop'   => 'bnm_header_padding_bottom_desktop',
				'tablet'    => 'bnm_header_padding_bottom_tablet',
				'mobile'    => 'bnm_header_padding_bottom_mobile'
			)
		)
	) );

	// Menu Section
	$wp_customize->add_section(
		'bnm_primary_menu_section',
		array(
			'title' => esc_html__( 'Primary Menu', 'bnm' ),
			'priority' => 10,
			'panel'	=> 'bnm_panel_header'
		)
	);

	// Header - Menu Width.
	$wp_customize->add_setting(
		'bnm_menu_width',
		array(
			'default' => 'contained',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_menu_width',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Menu Width', 'bnm' ),
			'section' => 'bnm_primary_menu_section',
			'choices' => array(
				'contained' => esc_html__( 'Contained', 'bnm' ),
				'full' => esc_html__( 'Full', 'bnm' )
			),
			'active_callback' => 'bnm_is_default_header'
		)
	);

	// Header - Menu Alignment
	$wp_customize->add_setting(
		'bnm_menu_align',
		array(
			'default' => 'left',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_menu_align',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Menu Alignment', 'bnm' ),
			'section' => 'bnm_primary_menu_section',
			'choices' => array(
				'left'		=> esc_html__( 'Left', 'bnm' ),
				'center'	=> esc_html__( 'Center', 'bnm' ),
				'right'		=> esc_html__( 'Right', 'bnm' )
			),
			'active_callback' => 'bnm_is_default_header'
		)
	);

	// Top Bar Section
	$wp_customize->add_section(
		'bnm_topbar_section',
		array(
			'title' => esc_html__( 'Top Bar', 'bnm' ),
			'priority' => 15,
			'panel'	=> 'bnm_panel_header'
		)
	);

	// Header Width.
	$wp_customize->add_setting(
		'bnm_topbar_width',
		array(
			'default' => 'contained',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_topbar_width',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Top Bar Inner Width', 'bnm' ),
			'section' => 'bnm_topbar_section',
			'choices' => array(
				'contained' => esc_html__( 'Contained', 'bnm' ),
				'full' => esc_html__( 'Full', 'bnm' )
			)
		)
	);

	// Slide-out Sidebar
	$wp_customize->add_section(
		'bnm_slideoutsb_section',
		array(
			'title' => esc_html__( 'Slide-out Sidebar', 'bnm' ),
			'priority' => 20,
			'panel'	=> 'bnm_panel_header'
		)
	);

	// Header - Show slideout sidebar
	$wp_customize->add_setting(
		'bnm_show_slideout_sb',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_slideout_sb',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show Slide-out sidebar', 'bnm' ),
			'description' => sprintf(
				/* translators: %s: link to Slide Out Sidebar widget panel in Customizer. */
				esc_html__( 'Show a Slide-out sidebar in the header, which you can populate by adding widgets %1$s.', 'bnm' ),
				'<a rel="goto-section" href="#sidebar-widgets-header-1">' . esc_html__( 'here', 'bnm' ) . '</a>'
			),
			'section'     => 'bnm_slideoutsb_section',
		)
	);

	// Header - show Primary Menu on slide out sidebar
	$wp_customize->add_setting(
		'bnm_show_pmenu_onslideout',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_pmenu_onslideout',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show Primary Menu on Slide-out sidebar', 'bnm' ),
			'section'     => 'bnm_slideoutsb_section',
			'active_callback'	=> 'bnm_is_slideout_active'
		)
	);

	// Header - slide out menu position
	$wp_customize->add_setting(
		'bnm_slideout_btn_loc',
		array(
			'default'           => 'primary-menu',
			'sanitize_callback' => 'bnm_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'bnm_slideout_btn_loc',
		array(
			'type'    => 'select',
			'label'   => esc_html__( 'Slide-out sidebar toggle button location', 'bnm' ),
			'choices' => array(
				'top-bar'		=> esc_html__( 'On top bar', 'bnm' ),
				'before-logo'	=> esc_html__( 'Before site title/logo', 'bnm' ),
				'primary-menu'	=> esc_html__( 'On Primary Menu', 'bnm' )
			),
			'section' => 'bnm_slideoutsb_section',
			'active_callback'	=> 'bnm_is_slideout_active'
		)
	);

	// Mobile Sidebar
	$wp_customize->add_section(
		'bnm_mobile_menu_section',
		array(
			'title' => esc_html__( 'Mobile Menu', 'bnm' ),
			'priority' => 20,
			'panel'	=> 'bnm_panel_header'
		)
	);

	// Header - show Primary Menu on mobile sidebar.
	$wp_customize->add_setting(
		'bnm_show_social_mobile_menu',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_social_mobile_menu',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show Social Menu on Mobile Menu', 'bnm' ),
			'section'     => 'bnm_mobile_menu_section'
		)
	);

	// Header - Show Secondary Menu on mobile sidebar.
	$wp_customize->add_setting(
		'bnm_show_top_nav_on_mobile_menu',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_top_nav_on_mobile_menu',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show Secondary Menu on Mobile Menu', 'bnm' ),
			'section'     => 'bnm_mobile_menu_section'
		)
	);

	// Header - Show slide out sidebar widgets in Mobile Menu Sidebar
	$wp_customize->add_setting(
		'bnm_show_slideout_widgets_on_mobile_menu',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_slideout_widgets_on_mobile_menu',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show Slide-out sidebar widgets on Mobile Menu', 'bnm' ),
			'section'     => 'bnm_mobile_menu_section',
			'active_callback'	=> 'bnm_is_slideout_active'
		)
	);

	// Blog Settings Panel
	$wp_customize->add_panel(
		'bnm_panel_blog',
		array(
			'priority' 			=> 194,
			'capability' 		=> 'edit_theme_options',
			'title' 			=> esc_html__( 'Blog Settings', 'bnm' )
		)
	);

	$wp_customize->add_section(
		'bnm_blog_layout_section',
		array(
			'title' => esc_html__( 'Layout', 'bnm' ),
			'priority' => 5,
			'panel'	=> 'bnm_panel_blog'
		)
	);

	// Archive Layout / Sidebar Alignment
	$wp_customize->add_setting(
		'bnm_archive_layout',
		array(
			'default'			=> 'right-sidebar',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		new BNM_Radio_Image_Control( 
			$wp_customize,
			'bnm_archive_layout',
			array(
				'section'		=> 'bnm_blog_layout_section',
				'label'			=> esc_html__( 'Blog Layout', 'bnm' ),
				'choices'		=> array(
					'right-sidebar'	        => $images_uri . '2cr.png',
					'left-sidebar' 	        => $images_uri . '2cl.png',
					'no-sidebar' 		    => $images_uri . '1c.png',
					'center-content' 	    => $images_uri . '1cc.png'
				)
			)
		)
	);

	// Entries Layout
	$wp_customize->add_setting(
		'bnm_entries_layout',
		array(
			'default' => 'grid',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_entries_layout',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Entries Layout', 'bnm' ),
			'section' => 'bnm_blog_layout_section',
			'choices' => array(
				'grid' => esc_html__( 'Grid', 'bnm' ),
				'list' => esc_html__( 'List', 'bnm' )
			)
		)
	);

	// Number of grid columns.
	$wp_customize->add_setting(
		'bnm_entries_grid_columns',
		array(
			'default' => '2',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_entries_grid_columns',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Number of grid columns', 'bnm' ),
			'section' => 'bnm_blog_layout_section',
			'choices' => array(
				'2' => esc_html__( '2', 'bnm' ),
				'3' => esc_html__( '3', 'bnm' ),
				'4' => esc_html__( '4', 'bnm' ),
				'5' => esc_html__( '5', 'bnm' ),
				'6' => esc_html__( '6', 'bnm' ),
			),
			'active_callback'	=> 'bnm_is_entries_grid'
		)
	);

	// Archive - Featured Image Position.
	$wp_customize->add_setting(
		'bnm_archive_thumbnail_position',
		array(
			'default' => 'before-header',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_archive_thumbnail_position',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Featured Image Position', 'bnm' ),
			'section' => 'bnm_blog_layout_section',
			'choices' => array(
				'before-header' => esc_html__( 'Before article header', 'bnm' ),
				'after-header' => esc_html__( 'After article header', 'bnm' ),
				'beside-article' => esc_html__( 'Beside article', 'bnm' ),
				'beside-content' => esc_html__( 'Beside article content', 'bnm' ),
				'hidden' => esc_html__( 'Hidden', 'bnm' ),
			)
		)
	);

	// Archive Featured Image Align
	$wp_customize->add_setting(
		'bnm_archive_thumbnail_align',
		array(
			'default' => 'left',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_archive_thumbnail_align',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Featured Image Align', 'bnm' ),
			'section' => 'bnm_blog_layout_section',
			'choices' => array(
				'left' => esc_html__( 'Left', 'bnm' ),
				'right' => esc_html__( 'Right', 'bnm' )
			),
			'active_callback'	=> 'bnm_thumbnail_align_active'
		)
	);

	// Archive - Leave featured image uncropped
	$wp_customize->add_setting(
		'bnm_archive_image_crop',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_archive_image_crop',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Crop featured image to theme defined size? (changes require regenerating thumbnails for existing featured images)', 'bnm' ),
			'section'     => 'bnm_blog_layout_section',
		)
	);

	// Archive - Pagination Style
	$wp_customize->add_setting(
		'bnm_pagination_type',
		array(
			'default' => 'page-numbers',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_pagination_type',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Blog Pagination Style', 'bnm' ),
			'section' => 'bnm_blog_layout_section',
			'choices' => array(
				'page-numbers' => esc_html__( 'Numbers', 'bnm' ),
				'next-prev' => esc_html__( 'Next/Prev', 'bnm' )
			)
		)
	);

	$wp_customize->add_section(
		'bnm_blog_meta_section',
		array(
			'title' => esc_html__( 'Post Meta', 'bnm' ),
			'priority' => 15,
			'panel'	=> 'bnm_panel_blog'
		)
	);

	// Archive - Show category list
	$wp_customize->add_setting(
		'bnm_show_cat_links',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_cat_links',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show category links', 'bnm' ),
			'section'     => 'bnm_blog_meta_section',
		)
	);

	// Archive - Show author
	$wp_customize->add_setting(
		'bnm_show_author',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_author',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show author', 'bnm' ),
			'section'     => 'bnm_blog_meta_section',
		)
	);

	// Archive - Show author avatar
	$wp_customize->add_setting(
		'bnm_show_author_avatar',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_author_avatar',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show author avatar', 'bnm' ),
			'section'     => 'bnm_blog_meta_section',
			'active_callback'	=> 'bnm_is_showing_author'
		)
	);

	// Archive - Show date
	$wp_customize->add_setting(
		'bnm_show_date',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_date',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show date', 'bnm' ),
			'section'     => 'bnm_blog_meta_section',
		)
	);

	// Archive - Show time ago format
	$wp_customize->add_setting(
		'bnm_time_ago',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_time_ago',
		array(
			'type'        		=> 'checkbox',
			'label'       		=> esc_html__( 'Use "time ago" date format', 'bnm' ),
			'section'     		=> 'bnm_blog_meta_section',
			'active_callback'	=> 'bnm_is_showing_date'
		)
	);

	// Excerpt length.
	$wp_customize->add_setting(
		'bnm_time_ago_date_count',
		array(
			'default'			=> 14,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_absint'
		)
	);
	$wp_customize->add_control(
		'bnm_time_ago_date_count',
		array(
			'section'			=> 'bnm_blog_meta_section',
			'type'				=> 'number',
			'label'				=> esc_html__( 'Cut off for "time ago" date in days.', 'bnm' ),
			'active_callback'	=> 'bnm_is_time_ago'
		)
	);

	// Archive - Show time ago format
	$wp_customize->add_setting(
		'bnm_show_updated_date',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_updated_date',
		array(
			'type'        		=> 'checkbox',
			'label'       		=> esc_html__( 'Show "last updated" date.', 'bnm' ),
			'description' 		=> esc_html__( 'When paired with the "time ago" date format, the cut off for that format will automatically be switched to one day.', 'bnm' ),
			'section'     		=> 'bnm_blog_meta_section',
			'active_callback'	=> 'bnm_is_showing_date'
		)
	);

	// Archive - Show comments link
	$wp_customize->add_setting(
		'bnm_show_comments_link',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_comments_link',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show comments link', 'bnm' ),
			'section'     => 'bnm_blog_meta_section',
		)
	);

	// Blog Section Content / Excerpt
	$wp_customize->add_section(
		'bnm_blog_content_section',
		array(
			'title' => esc_html__( 'Content / Excerpt', 'bnm' ),
			'priority' => 20,
			'panel'	=> 'bnm_panel_blog'
		)
	);

	// Archive Featured Image Align
	$wp_customize->add_setting(
		'bnm_content_type',
		array(
			'default' => 'excerpt',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_content_type',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Content Type', 'bnm' ),
			'section' => 'bnm_blog_content_section',
			'choices' => array(
				'excerpt' 	=> esc_html__( 'Excerpt', 'bnm' ),
				'content' 	=> esc_html__( 'Content', 'bnm' ),
				'none'		=> esc_html__( 'None', 'bnm' )
			)
		)
	);

	// Excerpt length.
	$wp_customize->add_setting(
		'bnm_excerpt_length',
		array(
			'default'			=> 25,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_number_absint'
		)
	);
	$wp_customize->add_control(
		'bnm_excerpt_length',
		array(
			'section'			=> 'bnm_blog_content_section',
			'type'				=> 'number',
			'label'				=> esc_html__( 'Excerpt Length', 'bnm' ),
			'active_callback'	=> 'bnm_is_excerpt_type'
		)
	);

	// Archive - Read More Link
	$wp_customize->add_setting(
		'bnm_read_more_type',
		array(
			'default' => 'link',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_read_more_type',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Read More Link Type', 'bnm' ),
			'section' => 'bnm_blog_content_section',
			'choices' => array(
				'link'		=> esc_html__( 'Link', 'bnm' ),
				'button' 	=> esc_html__( 'Button', 'bnm' ),
				'none'		=> esc_html__( 'None', 'bnm' )
			)
		)
	);

	// Post Settings Panel
	$wp_customize->add_panel(
		'bnm_panel_post',
		array(
			'priority' 			=> 196,
			'capability' 		=> 'edit_theme_options',
			'title' 			=> esc_html__( 'Post Settings', 'bnm' )
		)
	);

	$wp_customize->add_section(
		'bnm_post_layout_section',
		array(
			'title' => esc_html__( 'Layout', 'bnm' ),
			'priority' => 5,
			'panel'	=> 'bnm_panel_post'
		)
	);

	// Post Layout / Sidebar Alignment
	$wp_customize->add_setting(
		'bnm_post_layout',
		array(
			'default'			=> 'right-sidebar',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		new BNM_Radio_Image_Control( 
			$wp_customize,
			'bnm_post_layout',
			array(
				'section'		=> 'bnm_post_layout_section',
				'label'			=> esc_html__( 'Post Layout', 'bnm' ),
				'choices'		=> array(
					'right-sidebar'	        => $images_uri . '2cr.png',
					'left-sidebar' 	        => $images_uri . '2cl.png',
					'no-sidebar' 		    => $images_uri . '1c.png',
					'center-content' 	    => $images_uri . '1cc.png'
				)
			)
		)
	);

	// Post - Featured Image Position.
	$wp_customize->add_setting(
		'bnm_post_image_position',
		array(
			'default' => 'after-header',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_post_image_position',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Featured Image Position', 'bnm' ),
			'section' => 'bnm_post_layout_section',
			'choices' => array(
				'before-header' => esc_html__( 'Before article header', 'bnm' ),
				'after-header' => esc_html__( 'After article header', 'bnm' ),
				'hidden' => esc_html__( 'Hidden', 'bnm' ),
			)
		)
	);

	// Post Meta Section
	$wp_customize->add_section(
		'bnm_post_meta_section',
		array(
			'title' => esc_html__( 'Post Meta', 'bnm' ),
			'priority' => 10,
			'panel'	=> 'bnm_panel_post'
		)
	);

	// Post - Show category list
	$wp_customize->add_setting(
		'bnm_show_cat_links_s',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_cat_links_s',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show category links', 'bnm' ),
			'section'     => 'bnm_post_meta_section',
		)
	);

	// Post - Show author
	$wp_customize->add_setting(
		'bnm_show_author_s',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_author_s',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show author', 'bnm' ),
			'section'     => 'bnm_post_meta_section',
		)
	);

	// Post - Show author avatar
	$wp_customize->add_setting(
		'bnm_show_author_avatar_s',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_author_avatar_s',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show author avatar', 'bnm' ),
			'section'     => 'bnm_post_meta_section',
			'active_callback'	=> 'bnm_is_showing_author_s'
		)
	);

	// Post - Show date
	$wp_customize->add_setting(
		'bnm_show_date_s',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_date_s',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show date', 'bnm' ),
			'section'     => 'bnm_post_meta_section',
		)
	);

	// Post - Show time ago format
	$wp_customize->add_setting(
		'bnm_time_ago_s',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_time_ago_s',
		array(
			'type'        		=> 'checkbox',
			'label'       		=> esc_html__( 'Use "time ago" date format', 'bnm' ),
			'section'     		=> 'bnm_post_meta_section',
			'active_callback'	=> 'bnm_is_showing_date_s'
		)
	);

	// Post - Show time ago format
	$wp_customize->add_setting(
		'bnm_show_updated_date_s',
		array(
			'default'           => false,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_updated_date_s',
		array(
			'type'        		=> 'checkbox',
			'label'       		=> esc_html__( 'Show "last updated" date.', 'bnm' ),
			'description' 		=> esc_html__( 'When paired with the "time ago" date format, the cut off for that format will automatically be switched to one day.', 'bnm' ),
			'section'     		=> 'bnm_post_meta_section',
			'active_callback'	=> 'bnm_is_showing_date_s'
		)
	);

	// Post - Show comments
	$wp_customize->add_setting(
		'bnm_show_comments_link_s',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_comments_link_s',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Show comments link', 'bnm' ),
			'section'     => 'bnm_post_meta_section',
		)
	);

	// Post Meta Section
	$wp_customize->add_section(
		'bnm_post_content_section',
		array(
			'title' => esc_html__( 'Post Content', 'bnm' ),
			'priority' => 10,
			'panel'	=> 'bnm_panel_post'
		)
	);
	
	// Post - Show category list
	$wp_customize->add_setting(
		'bnm_post_previous_next',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_post_previous_next',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Display previous and next links at the bottom of each post.', 'bnm' ),
			'section'     => 'bnm_post_content_section',
		)
	);
	
	// Post - Show category list
	$wp_customize->add_setting(
		'bnm_show_author_bio',
		array(
			'default'           => true,
			'sanitize_callback' => 'bnm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bnm_show_author_bio',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Display author bio at the bottom of the post.', 'bnm' ),
			'section'     => 'bnm_post_content_section',
		)
	);

	// Page Settings Section
	$wp_customize->add_section(
		'bnm_page_section',
		array(
			'title' => esc_html__( 'Page Settings', 'bnm' ),
			'priority' => 198
		)
	);

	$wp_customize->add_setting(
		'bnm_page_layout',
		array(
			'default'			=> 'right-sidebar',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		new BNM_Radio_Image_Control( 
			$wp_customize,
			'bnm_page_layout',
			array(
				'section'		=> 'bnm_page_section',
				'label'			=> esc_html__( 'Page Layout', 'bnm' ),
				'choices'		=> array(
					'right-sidebar'	        => $images_uri . '2cr.png',
					'left-sidebar' 	        => $images_uri . '2cl.png',
					'no-sidebar' 		    => $images_uri . '1c.png',
					'center-content' 	    => $images_uri . '1cc.png'
				)
			)
		)
	);

	// Footer Panel
	$wp_customize->add_panel(
		'bnm_panel_footer',
		array(
			'priority' 			=> 200,
			'capability' 		=> 'edit_theme_options',
			'title' 			=> esc_html__( 'Footer Settings', 'bnm' )
		)
	);

	// Footer Widgets
	$wp_customize->add_section(
		'bnm_footer_widgets_section',
		array(
			'title' => esc_html__( 'Footer Widgets', 'bnm' ),
			'priority' => 10,
			'panel'	=> 'bnm_panel_footer'
		)
	);

	// Footer Number of sidebars
	$wp_customize->add_setting(
		'bnm_footer_sidebar_count',
		array(
			'default' => '3',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_footer_sidebar_count',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Widget Columns', 'bnm' ),
			'section' => 'bnm_footer_widgets_section',
			'choices' => array(
				'1' => esc_html__( '1', 'bnm' ),
				'2' => esc_html__( '2', 'bnm' ),
				'3' => esc_html__( '3', 'bnm' ),
				'4' => esc_html__( '4', 'bnm' )
			)
		)
	);

	$wp_customize->add_setting(
		'bnm_footer_widget_area_width',
		array(
			'default' => 'contained',
			'sanitize_callback' => 'bnm_sanitize_select'
		)
	);
	$wp_customize->add_control(
		'bnm_footer_widget_area_width',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Widget Area Width', 'bnm' ),
			'section' => 'bnm_footer_widgets_section',
			'choices' => array(
				'full' 		=> esc_html__( 'Full', 'bnm' ),
				'contained' => esc_html__( 'Contained', 'bnm' )
			)
		)
	);

	$wp_customize->add_section(
		'bnm_footer_bottom_section',
		array(
			'title' => esc_html__( 'Footer Bottom', 'bnm' ),
			'priority' => 15,
			'panel'	=> 'bnm_panel_footer'
		)
	);

	$wp_customize->add_setting(
		'bnm_footer_copyright_text',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'bnm_sanitize_html'
		)
	);
	$wp_customize->add_control(
		'bnm_footer_copyright_text',
		array(
			'section'		=> 'bnm_footer_bottom_section',
			'type'			=> 'textarea',
			'label'			=> esc_html__( 'Copyright Text', 'bnm' )
		)
	);

}
add_action( 'customize_register', 'bnm_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bnm_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bnm_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bnm_customize_preview_js() {
	wp_enqueue_script( 'bnm-customizer', get_template_directory_uri() . '/inc/customizer/assets/js/customizer.js', array( 'customize-preview' ), BNM_VERSION, true );
}
add_action( 'customize_preview_init', 'bnm_customize_preview_js' );

/**
 * Enqueue the customizer stylesheet.
 */
function bnm_enqueue_customizer_stylesheets() {
    wp_register_style( 'bnm-customizer-css', get_template_directory_uri() . '/inc/customizer/assets/css/customizer.css', NULL, NULL, 'all' );
    wp_enqueue_style( 'bnm-customizer-css' );
}
add_action( 'customize_controls_print_styles', 'bnm_enqueue_customizer_stylesheets' );

/**
 * Enqueue Customize Control JS
 */
function bnm_enqueue_customize_control_scripts() {
	wp_enqueue_script( 'bnm-customizer-controls', get_template_directory_uri() . '/inc/customizer/assets/js/customizer-controls.js', array( 'jquery', 'customize-base' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'bnm_enqueue_customize_control_scripts' );

/**
 * Select sanitization callback.
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function bnm_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Number sanitization.
 *
 * @param int                  $number  Number to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int Sanitized number; otherwise, the setting default.
 */
function bnm_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );
	
	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

/**
 * Check if the given value is a number or blank.
 */
function bnm_sanitize_number_blank( $number, $setting ) {

	if ( '' != $number ) {
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint( $number );

		if ( $number >= 0 ) {
			return $number;
		} 
	}

	return $setting->default;

}

/**
 * Number Range sanitization.
 *
 * @param int                  $number  Number to check within the numeric range defined by the setting.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise,
 *                    the setting default.
 */
function bnm_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * HEX Color sanitization.
 *
 * @param string               $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting   Setting instance.
 * @return string The sanitized hex color if not null; otherwise, the setting default.
 */
function bnm_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Checkbox sanitization callback example.
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function bnm_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitization callback of Multiple Checkboxes Control
 */
function bnm_sanitize_multiple_checkboxes( $values ) {

	$multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

	return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	
}

/**
 * HTML sanitization callback.
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function bnm_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 * URL sanitization.
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
function bnm_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

/**
 * Email sanitization
 * @param string               $email   Email address to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The sanitized email if not null; otherwise, the setting default.
 */
function bnm_sanitize_email( $email, $setting ) {
	// Strips out all characters that are not allowable in an email address.
	$email = sanitize_email( $email );
	
	// If $email is a valid email, return it; otherwise, return the default.
	return ( ! is_null( $email ) ? $email : $setting->default );
}

function bnm_sanitize_slider_number_input( $number, $setting ) {
	
	// Ensure input is a number.
	$number = (float)$number ;
	
	// Get the input attributes associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// Get minimum number in the range.
	$min = ( isset( $choices['min'] ) ? $choices['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $choices['max'] ) ? $choices['max'] : $number );
	
	// Get step.
	$step = ( isset( $choices['step'] ) ? $choices['step'] : 1 );

	if ( $number <= $min ) {
		$number = $min;
	} elseif ( $number >= $max ) {
		$number = $max;
	}
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( is_numeric( $number / $step ) ? $number : $setting->default );
}

/**
 * Check if the grid style is active.
 */
function bnm_is_slideout_active( $control ) {
	if ( $control->manager->get_setting( 'bnm_show_slideout_sb' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the default header layout is active.
 */
function bnm_is_default_header( $control ) {
	if ( $control->manager->get_setting( 'bnm_header_layout' )->value() === 'default' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the line header layout is active.
 */
function bnm_is_line_header( $control ) {
	if ( $control->manager->get_setting( 'bnm_header_layout' )->value() === 'single-line' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the wide layout is active.
 */
function bnm_is_wide_layout_active( $control ) {
	if ( $control->manager->get_setting( 'bnm_site_layout' )->value() === 'wide' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the boxed layout is active.
 */
function bnm_is_boxed_layout_active( $control ) {
	if ( $control->manager->get_setting( 'bnm_site_layout' )->value() === 'boxed' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the grid layout is active.
 */
function bnm_is_entries_grid( $control ) {
	if ( $control->manager->get_setting( 'bnm_entries_layout' )->value() === 'grid' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the list layout is active.
 */
function bnm_is_entries_list( $control ) {
	if ( $control->manager->get_setting( 'bnm_entries_layout' )->value() === 'list' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the list layout is active.
 */
function bnm_is_excerpt_type( $control ) {
	if ( $control->manager->get_setting( 'bnm_content_type' )->value() === 'excerpt' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks featured image alignment should be active or not
 */
function bnm_thumbnail_align_active( $control ) {
	$thumbnail_position = $control->manager->get_setting( 'bnm_archive_thumbnail_position' )->value();
	if ( 'beside-article' === $thumbnail_position || 'beside-content' === $thumbnail_position ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if bnm is showing author.
 */
function bnm_is_showing_author( $control ) {
	if ( $control->manager->get_setting( 'bnm_show_author' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if bnm is showing author in single post.
 */
function bnm_is_showing_author_s( $control ) {
	if ( $control->manager->get_setting( 'bnm_show_author_s' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if bnm is showing date
 */
function bnm_is_showing_date( $control ) {
	if ( $control->manager->get_setting( 'bnm_show_date' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if bnm is showing date in single posts
 */
function bnm_is_showing_date_s( $control ) {
	if ( $control->manager->get_setting( 'bnm_show_date_s' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if bnm is showing time ago
 */
function bnm_is_time_ago( $control ) {
	if ( $control->manager->get_setting( 'bnm_time_ago' )->value() === true ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the custom logo has been set.
 */
function bnm_has_custom_logo() {
	if ( has_custom_logo() ) {
		return true;
	} else {
		return false;
	}
}


function bnm_is_showing_breadcrumb( $control ) {
	if ( $control->manager->get_setting( 'bnm_breadcrumb_source' )->value() !== 'none' ) {
		return true;
	} else {
		return false;
	}
}