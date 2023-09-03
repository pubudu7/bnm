<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package BNM
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses bnm_header_style()
 */
function bnm_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'bnm_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '222222',
				'width'              => 2000,
				'height'             => 550,
				'flex-height'        => true,
				'flex-width'		 => true,
				'wp-head-callback'   => 'bnm_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'bnm_custom_header_setup' );

if ( ! function_exists( 'bnm_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see bnm_custom_header_setup().
	 */
	function bnm_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}

		</style>
		<?php
	}
endif;
