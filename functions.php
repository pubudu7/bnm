<?php
/**
 * BNM functions and definitions
 *
 * @package BNM
 */

if ( ! defined( 'BNM_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'BNM_VERSION', '1.0.8' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bnm_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on BNM, use a find and replace
		* to change 'bnm' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'bnm', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	
	// Enqueue editor styles.
	add_editor_style( 'css/editor-style.css' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'bnm-featured-image', 1200, 9999 );
	add_image_size( 'bnm-archive-image', 800, 450, true );
	add_image_size( 'bnm-archive-image-large', 1200, 675, true );
	add_image_size( 'bnm-thumbnail', 250, 170, true );

	if ( ! get_theme_mod( 'bnm_archive_image_crop', true ) ) {
		add_image_size( 'bnm-archive-image', 800, 9999, false );
		add_image_size( 'bnm-archive-image-large', 1200, 9999, false );
	}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'bnm' ),
			'secondary' => esc_html__( 'Secondary Menu', 'bnm' ),
			'social' => esc_html__( 'Social Menu', 'bnm' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bam_custom_background_args', array(
		'default-color' => '#ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'flex-height'	=> true,
			'flex-width' 	=> true,
		)
	);
}
add_action( 'after_setup_theme', 'bnm_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bnm_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bnm_content_width', 840 );
}
add_action( 'after_setup_theme', 'bnm_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bnm_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bnm' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bnm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Magazine', 'bnm' ),
			'description'   => esc_html__( 'Add BNM: Magazine Posts blocks here.', 'bnm' ),
			'id'            => 'bnm-magazine-1',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Slide-out Sidebar', 'bnm' ),
			'id'            => 'header-1',
			'description'   => esc_html__( 'Add widgets here to appear in an off-screen sidebar when it is enabled under the Customizer Header Settings.', 'bnm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Above Header', 'bnm' ),
			'id'            => 'header-4',
			'description'   => esc_html__( 'Add widgets here to appear before the Header', 'bnm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Sidebar', 'bnm' ),
			'id'            => 'header-2',
			'description'   => esc_html__( 'Add widgets here to appear on the Header', 'bnm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Below Header', 'bnm' ),
			'id'            => 'header-3',
			'description'   => esc_html__( 'Add widgets here to appear before the Header', 'bnm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'bnm' ),
			'id'            => 'footer-1',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'bnm' ),
			'id'            => 'footer-2',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'bnm' ),
			'id'            => 'footer-3',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 4', 'bnm' ),
			'id'            => 'footer-4',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'bnm_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bnm_scripts() {
	wp_enqueue_style( 'bnm-style', get_stylesheet_uri(), array(), BNM_VERSION );
	wp_style_add_data( 'bnm-style', 'rtl', 'replace' );

	wp_enqueue_script( 'bnm-main', get_template_directory_uri() . '/js/main.js', array(), BNM_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bnm_scripts' );

/**
 * Handle SVG icons.
 */ 
require get_template_directory() . '/inc/class-bnm-svg-icons.php';

/**
 * Custom Nav Walker
 */
require get_template_directory() . '/inc/class-bnm-nav-walker.php';

/**
 * Meta boxes
 */
require get_template_directory() . '/inc/class-bnm-meta-boxes.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Add custom header background support.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Widget Files.
 */
require get_template_directory() . '/inc/widgets/widget-functions.php';

if ( ! defined( 'BNM_PRO_VERSION' ) ) {
	require get_template_directory() . '/inc/widgets/bnm-posts-widget-1.php';
	require get_template_directory() . '/inc/widgets/bnm-posts-widget-2.php';
	require get_template_directory() . '/inc/widgets/bnm-posts-widget-3.php';
	require get_template_directory() . '/inc/widgets/bnm-sidebar-posts-widget.php';
}

require get_template_directory() . '/inc/widgets/bnm-tabbed-widget.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/custom-controls/fonts/fonts.php';
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/typography.php';
require get_template_directory() . '/inc/wptt-webfont-loader.php';

if ( ! function_exists( 'bnm_get_fonts_array' ) ) :
	/**
	 * Gets the user chosen fonts from customizer as an array.
	 */
	function bnm_get_fonts_array() {
		$fonts_arr = array();
		$body_font = get_theme_mod( 'bnm_font_family_1', '' );
		$headings_font = get_theme_mod( 'bnm_font_family_2', '' );
	
		if ( $body_font ) {
			$fonts_arr[] = $body_font;
		}
	
		if ( $headings_font ) {
			$fonts_arr[] = $headings_font;
		}
	
		if ( empty( $fonts_arr ) ) {
			return;
		}

		return $fonts_arr;
	}

endif;

if ( ! function_exists( 'bnm_get_fonts_url' ) ) :
	/**
	 * Gets the font url.
	 */
	function bnm_get_fonts_url() {
		$fonts_arr = bnm_get_fonts_array();

		if ( empty( $fonts_arr ) ) {
			return;
		}
	
		$font_url = bnm_get_google_font_uri( $fonts_arr );

		return $font_url;
	}

endif;

/**
* Enqueue Google fonts.
*/
function bnm_load_fonts() {

	$font_url = bnm_get_fonts_url();

	if ( empty( $font_url ) ) {
		return;
	}

	if ( ! is_admin() && ! is_customize_preview() ) {
		$font_url = wptt_get_webfont_url( esc_url_raw( $font_url ) );
	}

	// Load Google Fonts
	wp_enqueue_style( 'bnm-fonts', $font_url, array(), null, 'screen' );
}
add_action( 'wp_enqueue_scripts', 'bnm_load_fonts' );

/**
 * Display custom color CSS in customizer and on frontend.
 */
function bnm_custom_css_wrap() {
	require_once get_parent_theme_file_path( 'inc/css-output.php' );
	?>

	<style type="text/css" id="bnm-custom-css">
		<?php echo wp_strip_all_tags( bnm_custom_css() ); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'bnm_custom_css_wrap' );

/**
 * Display custom font CSS in customizer and on frontend.
 */
function bnm_custom_typography_wrap() {
	if ( is_admin() ) {
		return;
	}
	?>

	<style type="text/css" id="bnm-fonts-css">
		<?php echo wp_strip_all_tags( bnm_custom_typography_css() ); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'bnm_custom_typography_wrap' );

/**
 * Enqueue theme customizations and fonts for the block editor.
 */
function bnm_theme_customizer_styles() {

	wp_enqueue_style( 'bnm-editor-customizer-styles', get_theme_file_uri( '/css/style-editor-customizer.css' ), false, BNM_VERSION, 'all' );

	$fonts_arr = bnm_get_fonts_array();
	if ( ! empty( $fonts_arr ) ) {
		wp_enqueue_style( 'bnm-font-import', bnm_get_google_font_uri( $fonts_arr ), array(), null );
	}

	$theme_customizations = "";

	$typography_css = bnm_custom_typography_css();
	if ( $typography_css ) {
		$theme_customizations .= $typography_css;
	}

	require_once get_parent_theme_file_path( 'inc/css-output.php' );

	$theme_customizations .= bnm_custom_css();

	if ( $theme_customizations ) {
		wp_add_inline_style( 'bnm-editor-customizer-styles', $theme_customizations );
	}

}
add_action( 'enqueue_block_editor_assets', 'bnm_theme_customizer_styles' );

/**
 * Enqueue CSS styles for the editor that use the <body> tag.
 */
function bnm_enqueue_editor_styles() {
	wp_enqueue_style( 'bnm-editor-overrides', get_theme_file_uri( '/css/style-editor-overrides.css' ), false, BNM_VERSION, 'all' );
}
add_action( 'enqueue_block_editor_assets', 'bnm_enqueue_editor_styles' );

/**
 * Theme Info Page.
 */
require get_template_directory() . '/inc/dashboard/theme-info.php';