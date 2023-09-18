<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package BNM
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bnm_body_classes( $classes ) {
	
	$site_layout = get_theme_mod( 'bnm_site_layout', 'wide' );
	$logo_alignment = get_theme_mod( 'bnm_logo_align', 'left' );
	$header_layout = get_theme_mod( 'bnm_header_layout', 'default' );
	$sidebar_layout = bnm_get_layout();

	if ( 'boxed' === $site_layout ) {
		$classes[] = 'bnm-boxed';
	}

	if ( bnm_show_updated_date() ) {
		$classes[] = 'bnm-show-updated';
	}

	if ( isset( $sidebar_layout ) ) {
		$classes[] = 'bnm-' . esc_attr( $sidebar_layout );
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( 'seperate-containers' === get_theme_mod( 'bnm_content_layout', 'no-containers' ) ) {
		$classes[] = 'seperate-containers';
	}

	if ( 'single-line' === $header_layout ) {

		$classes[] = 'bnm-line-header';

	} elseif ( 'default' === $header_layout ) {
		
		$classes[] = 'bnm-default-header';

		if ( 'left' === $logo_alignment ) {
			$classes[] = 'logo-aligned-left';
		} elseif ( 'right' === $logo_alignment ) {
			$classes[] = 'logo-aligned-right';
		} elseif ( 'center' === $logo_alignment ) {
			$classes[] = 'logo-aligned-center';
		}

		$menu_alignment = get_theme_mod( 'bnm_menu_align', 'left' );
		if ( 'left' === $menu_alignment ) {
			$classes[] = 'menu-align-left';
		} elseif ( 'right' === $menu_alignment ) {
			$classes[] = 'menu-align-right';
		} elseif ( 'center' === $menu_alignment ) {
			$classes[] = 'menu-align-center';
		}

		$menu_width = get_theme_mod( 'bnm_menu_width', 'contained' );
		if ( 'full' === $menu_width ) {
			$classes[] = 'bnm-wide-pmenu';
		}

	}

	$header_width = get_theme_mod( 'bnm_header_width', 'contained' );
	if ( 'full' === $header_width ) {
		$classes[] = 'bnm-wide-header';
	}

	$topbar_width = get_theme_mod( 'bnm_topbar_width', 'contained' );
	if ( 'full' === $topbar_width ) {
		$classes[] = 'bnm-wide-topbar';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'bnm-no-sidebar';
	}

	if ( is_active_sidebar( 'header-2' ) ) {
		$classes[] = 'has-header-sb';
	}

	if ( is_home() || is_archive() || is_search() ) {

		$entries_layout = get_theme_mod( 'bnm_entries_layout', 'grid' );
		if ( 'grid' === $entries_layout ) {
			$classes[] = 'bnm-post-grid';
			$number_of_cols = get_theme_mod( 'bnm_entries_grid_columns', '2' );
			$classes[] = 'bnm-grid-' . esc_attr( $number_of_cols );
		} else {
			$classes[] = 'bnm-post-list';
		}

		$archive_thumbnail_position = bnm_archive_thumbnail_position();
		$archive_thumbnail_align = get_theme_mod( 'bnm_archive_thumbnail_align', 'left' );
		if ( 'beside-article' ===  $archive_thumbnail_position ) {
			$classes[] = 'bnm-arc-img-ba';
			$classes[] = 'bnmaif-' . esc_attr( $archive_thumbnail_align );
		} elseif ( 'beside-content' === $archive_thumbnail_position ) {
			$classes[] = 'bnm-arc-img-bc';
			$classes[] = 'bnmaif-' . esc_attr( $archive_thumbnail_align );
		}

	}

	// if ( get_theme_mod( 'bnm_images_rounded_borders', false ) ) {
	// 	$classes[] = 'bnm-img-rb';
	// }
	$footer_sidebar_count = get_theme_mod( 'bnm_footer_sidebar_count', '3' );
	if ( $footer_sidebar_count ) {
		$classes[] = 'bnm-footer-cols-' . esc_attr( $footer_sidebar_count );
	}

	if ( 'full' === get_theme_mod( 'bnm_footer_widget_area_width', 'contained') ) {
		$classes[] = 'bnm-wide-footer';
	}

	return $classes;
}
add_filter( 'body_class', 'bnm_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bnm_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'bnm_pingback_header' );


if ( ! function_exists( 'bnm_get_layout' ) ) {
	/**
	 * Get the layout for the current page.
	 *
	 * @return string The sidebar layout location.
	 */
	function bnm_get_layout() {

		global $post;

		$layout = 'right-sidebar';

		if ( is_home() || is_archive() || is_search() || is_tax() ) {
			$layout = get_theme_mod( 'bnm_archive_layout', 'right-sidebar'  );
		}

		if ( is_single() ) {
			$post_specific_layout = get_post_meta( $post->ID, '_bnm_layout_meta', true );
			if ( empty( $post_specific_layout ) || $post_specific_layout === 'default-layout' ) {
				$layout = get_theme_mod( 'bnm_post_layout', 'right-sidebar' );
			} else {
				$layout = $post_specific_layout;
			}
		}

		if ( is_page() ) {
			$page_specific_layout = get_post_meta( $post->ID, '_bnm_layout_meta', true );
			if ( empty( $page_specific_layout ) || $page_specific_layout === 'default-layout' ) {
				$layout = get_theme_mod( 'bnm_page_layout', 'right-sidebar' );
			} else {
				$layout = $page_specific_layout;
			}	
		}

		return apply_filters( 'bnm_sidebar_layout', $layout );
	}
}

/**
 * Adds a Sub Nav Toggle to the Mobile Menu.
 *
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param WP_Post  $item  Menu item data object.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return stdClass An object of wp_nav_menu() arguments.
 * @since BNM 1.0.0
 */
function bnm_add_dropdown_toggle_to_menu( $title, $item, $args, $depth ) {

	// Add sub menu toggles to the menu.
	if ( isset( $args->show_toggles ) && $args->show_toggles ) {

		$args->link_after = '';

		// Add a toggle to items with children.
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

			// Note: Implement mobile menu dropdown toggles later. 
			$toggle_target_string = '.bnm-mobile-menu .menu-item-' . $item->ID . ' > .sub-menu';

			$svg_icon = bnm_get_icon_svg( 'chevron-down' );

			// Add the sub menu toggle.
			$args->link_after = '<span class="bnm-menu-icon bnm-dropdown-toggle" data-toggle-target="' . $toggle_target_string . '" aria-expanded="false">'. $svg_icon .'<span class="screen-reader-text">' . esc_html__( 'Show sub menu', 'bnm' ) . '</span></span>';

		}

	} 

	return $title;

}

add_filter( 'nav_menu_item_title', 'bnm_add_dropdown_toggle_to_menu', 10, 4 );

/**
 * Displays SVG icons in social links menu.
 * 
 * @since BNM 1.0.0
 * 
 * @param string	$item_output 	The menu item's starting HTML output.
 * @param WP_Post 	$item 			Menu item data object.
 * @param int 		$depth 			Depth of the menu. Used for padding.
 * @param stdClass 	$args 			An object of wp_nav_menu() arguments.
 * @return string The menu item output with social icon.
 */
function bnm_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		$svg = BNM_SVG_Icons::get_social_link_svg( $item->url );
		if ( empty( $svg ) ) {
			$svg = bnm_get_icon_svg( 'link' );
		}
		$item_output = str_replace( $args->link_after, '</span>' . $svg, $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'bnm_nav_menu_social_icons', 10, 4 );

/**
 * Adds custom class to the array of posts classes.
 */
function bnm_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'bnm-entry';
	return $classes;
}
add_filter( 'post_class', 'bnm_post_classes', 10, 3 );

/**
 * Gets the archive thumbnail position.
 */
function bnm_archive_thumbnail_position() {
	$position = get_theme_mod( 'bnm_archive_thumbnail_position', 'before-header' );
	return $position;
}

/**
 * Custom excerpt length.
 */
function bnm_excerpt_length( $length ) {
	if( is_admin() ) {
		return $length;
	}
	$custom_length = get_theme_mod( 'bnm_excerpt_length', 25 );
	return absint( $custom_length );
}
add_filter( 'excerpt_length', 'bnm_excerpt_length', 999 );

if ( ! function_exists( 'bnm_excerpt_more' ) ) {
	add_filter( 'excerpt_more', 'bnm_excerpt_more', 20 );
	/**
	 * Prints the read more HTML to post excerpts.
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link.
	 */
	function bnm_excerpt_more( $more ) {
		if ( 'link' === get_theme_mod( 'bnm_read_more_type', 'link' ) ) {
			return apply_filters(
				'bnm_excerpt_more_output',
				sprintf(
					' &hellip; <a title="%1$s" class="bnm-read-more" href="%2$s"><span class="screen-reader-text">%3$s</span>%4$s</a>',
					the_title_attribute( 'echo=0' ),
					esc_url( get_permalink( get_the_ID() ) ),
					esc_html( get_the_title( get_the_ID() ) ),
					__( 'Read more', 'bnm' ),
				)
			);
		} else {
			return '&hellip;';
		}
	}
}

/**
 * Change date to 'time ago' format if enabled in the Customizer.
 */
function bnm_math_to_time_ago( $post_time, $format, $post, $updated ) {
	if ( is_single() ) {
		$use_time_ago = get_theme_mod( 'bnm_time_ago_s', false );
	} else {
		$use_time_ago = get_theme_mod( 'bnm_time_ago', false );
	}
	
	// Only filter time when $use_time_ago is enabled, and it's not using a machine-readable format (for datetime).
	if ( true === $use_time_ago && 'Y-m-d\TH:i:sP' !== $format ) {
		$current_time = current_time( 'timestamp' ); // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
		$cut_off      = get_theme_mod( 'bnm_time_ago_date_count', '14' );
		$org_time     = strtotime( $post->post_date );

		if ( true === $updated ) {
			$org_time = strtotime( $post->post_modified );
		}

		// Transform cut off from days to seconds.
		$cut_off_seconds = $cut_off * 86400;

		if ( is_single() ) {
			$show_updated_date = get_theme_mod( 'bnm_show_updated_date_s', false );
		} else {
			$show_updated_date = get_theme_mod( 'bnm_show_updated_date', false );
		}

		if ( true === $show_updated_date ) {
			// Switch cut off to 24 hours.
			$cut_off_seconds = 86400;
		}

		if ( $cut_off_seconds >= ( $current_time - $org_time ) ) {
			$post_time = sprintf(
				/* translators: %s: Time ago date format */
				esc_html__( '%s ago', 'bnm' ),
				human_time_diff( $org_time, $current_time )
			);
		}
	}

	return $post_time;
}


/**
 * Apply time ago format to publish dates if enabled.
 */
function bnm_convert_to_time_ago( $post_time, $format, $post ) {
	// Don't override specifically requested formats.
	if ( empty( $format ) ) {
		$post_time = bnm_math_to_time_ago( $post_time, $format, $post, false );
	}
	return $post_time;
}
add_filter( 'get_the_date', 'bnm_convert_to_time_ago', 10, 3 );

/**
 * Apply time ago format to modified dates if enabled.
 */
function bnm_convert_modified_to_time_ago( $post_time, $format, $post ) {
	return bnm_math_to_time_ago( $post_time, $format, $post, true );
}

/**
 * Checks to see if it should display the updated date.
 */
function bnm_show_updated_date() {
	if ( is_single() ) {
		$show_updated_date = get_theme_mod( 'bnm_show_updated_date_s', false );
	} else {
		$show_updated_date = get_theme_mod( 'bnm_show_updated_date', false );
	}
	return $show_updated_date;
}

if ( ! function_exists( 'bnm_get_icon_svg' ) ) :
	/**
	 * Get SVG Icons.
	 * 
	 * @since BNM 1.0.0
	 * 
	 * @param string $icon_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 */
	function bnm_get_icon_svg( $icon_name, $group = 'ui' ) {

		// Make sure that only our allowed tags and attributes are included.
		$svg = wp_kses( BNM_SVG_Icons::get_svg( $icon_name, $group ), array(
			'svg'     => array(
				'class'       => true,
				'xmlns'       => true,
				'width'       => true,
				'height'      => true,
				'viewbox'     => true,
				'aria-hidden' => true,
				'role'        => true,
				'focusable'   => true,
			),
			'path'    => array(
				'fill'      => true,
				'fill-rule' => true,
				'd'         => true,
				'transform' => true,
			),
			'polygon' => array(
				'fill'      => true,
				'fill-rule' => true,
				'points'    => true,
				'transform' => true,
				'focusable' => true,
			),
		) );

		if ( ! $svg ) {
			return false;
		}

		return $svg;

	}

endif;


if ( ! function_exists( 'bnm_the_icon_svg' ) ) {
	/**
	 * Echo svg icon.
	 * 
	 * @since BNM 1.0.0
	 * 
	 * @param string $icon_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 */
	function bnm_the_icon_svg( $icon_name, $group = 'ui' ) {
		echo bnm_get_icon_svg( $icon_name, $group ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in bnm_get_icon_svg().
	}
}

if ( ! function_exists( 'bnm_filter_the_archive_title' ) ) {
	/**
	 * Remove "category" and "tag" text from the archive title
	 * 
	 * @param string $title The archive title. 
	 * @return string The changed archive title.
	 */
	function bnm_filter_the_archive_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		}

		return $title;
	}
	add_filter( 'get_the_archive_title', 'bnm_filter_the_archive_title' );

}

if ( ! function_exists( 'bnm_get_selected_breadcrumb' ) ) {
	/**
	 * Get the user selected breadcrumb
	 * 
	 * @since 1.0.6
	 */
	function bnm_get_selected_breadcrumb() {
		$breadcrumb_source = get_theme_mod( 'bnm_breadcrumb_source', 'none' );

		if ( 'yoast' === $breadcrumb_source ) {
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				yoast_breadcrumb( '<div id="bnm-yoast-breadcrumbs">', '</div>' );
			}
		} elseif ( 'navxt' === $breadcrumb_source ) {
			if ( function_exists( 'bcn_display' ) ) {
				bcn_display();
			}
		} elseif ( 'rankmath' === $breadcrumb_source ) {
			if ( function_exists( 'rank_math_the_breadcrumbs') ) {
				rank_math_the_breadcrumbs();
			}
		}
	}

}

if ( ! function_exists( 'bnm_breadcrumb_template' ) ) {
	/**
	 * Adds the breadcrumb to the selected location
	 * 
	 * @since 1.0.6
	 */
	function bnm_breadcrumb_template() {
		$breadcrumb_location = get_theme_mod( 'bnm_breadcrumb_location', 'bnm_before_entry_header' );

		if ( ( is_archive() || is_search() ) && 'bnm_before_entry_header' === $breadcrumb_location ) {
			add_action( 'bnm_before_main_content', 'bnm_hook_breadcrumb_location', 15 );
		} else {
			add_action( $breadcrumb_location, 'bnm_hook_breadcrumb_location', 15 );
		}
	}
	add_action( 'wp', 'bnm_breadcrumb_template' );
}

if ( ! function_exists( 'bnm_hook_breadcrumb_location' ) ) {
	/**
	 * Hook breadcrumb template to the selected location.
	 * 
	 * @since 1.0.6
	 */
	function bnm_hook_breadcrumb_location() {
		$breadcrumb_location = get_theme_mod( 'bnm_breadcrumb_location', 'bnm_before_entry_header' );

		if ( 'bnm_after_header' === $breadcrumb_location ) {
			echo '<div class="bnm-header-bar bnm-header-breadcrumb">
					<div class="bnm-container">';
		}
		
		bnm_get_selected_breadcrumb();

		if ( 'bnm_after_header' === $breadcrumb_location ) {
			echo '</div>
				</div>';
		}

	}

}