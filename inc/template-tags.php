<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package BNM
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

endif;

if ( ! function_exists( 'bnm_primary_nav' ) ) : 
	/**
	 * Displays primary navigation.
	 * 
	 */
	function bnm_primary_nav() {
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'show_toggles'   => true
			) );
		} else {
			wp_page_menu( array(
				'title_li'      => '',
				'show_toggles'  => true,
				'walker'        => new BNM_Walker_Page()
			) );
		}
	}

endif;

if ( ! function_exists( 'bnm_secondary_nav' ) ) : 
	/**
	 * Displays secondary navigation.
	 */
	function bnm_secondary_nav() {
		wp_nav_menu( array(
			'theme_location' => 'secondary',
			'menu_id'        => 'secondary-menu',
			'show_toggles'   => true
		) );
	}

endif;

if ( ! function_exists( 'bnm_social_nav' ) ) : 
	/**
	 * Displays social navigation.
	 */
	function bnm_social_nav() {
		if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="bnm-social-menu" aria-label="<?php esc_attr_e( 'Expanded Social links', 'bnm' ); ?>">
				<ul class="bnm-social-menu bnm-social-icons">
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'social',
							'container'       => '',
							'container_class' => '',
							'items_wrap'      => '%3$s',
							'menu_id'         => '',
							'menu_class'      => '',
							'depth'           => 1,
							'link_before'     => '<span class="screen-reader-text">',
							'link_after'      => '</span>',
							'fallback_cb'     => '',
						)
					);
				?>
				</ul>
			</nav><!-- .bnm-social-menu -->
		<?php
		endif; 
	}
endif;

if ( ! function_exists( 'bnm_slide_out_menu_toggle' ) ) : 

	function bnm_slide_out_menu_toggle( $location = 'primary-menu' ) {
		if ( $location === get_theme_mod( 'bnm_slideout_btn_loc', 'primary-menu' ) && true === get_theme_mod( 'bnm_show_slideout_sb', false ) ) : ?>
			<button class="bnm-slideout-toggle">
				<div class="bnmst-bars">
					<span class="bnmst1"></span>
					<span class="bnmst2"></span>
					<span class="bnmst3"></span>
				</div>
			</button>
		<?php endif; 
	}
	
endif;

if ( ! function_exists( 'bnm_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function bnm_posted_on() {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published sm-hu" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		add_filter( 'get_the_modified_date', 'bnm_convert_modified_to_time_ago', 10, 3 );

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		remove_filter( 'get_the_modified_date', 'bnm_convert_modified_to_time_ago', 10, 3 );

		$posted_on = sprintf(
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'bnm_author_avatar' ) ) :

	function bnm_author_avatar() {

		$author_email	= get_the_author_meta( 'user_email' );
		$avatar_url 	= get_avatar_url( $author_email );
		
		echo '<span class="bnm-author-avatar"><img class="author-photo" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" /></span>';

	}

endif;

if ( ! function_exists( 'bnm_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function bnm_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'bnm' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'bnm_categories' ) ) :
	/**
	 * Prints the category list
	 */
	function bnm_categories() {
		if ( 'post' === get_post_type() ) {

			if ( is_single() ) {
				$show_category_list = get_theme_mod( 'bnm_show_cat_links_s', true );
			} else {
				$show_category_list = get_theme_mod( 'bnm_show_cat_links', true );
			}

			if ( ! $show_category_list ) {
				return;
			}

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'bnm' ) );
			if ( $categories_list ) {
				/* translators: 1: posted in label 2: list of categories. */
				printf( 
					'<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>', 
					esc_html__( 'Posted in', 'bnm' ),
					apply_filters( 'bnm_theme_categories', $categories_list )
				); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

endif;

if ( ! function_exists( 'bnm_tags_list' ) ) :
	/**
	 * Prints the tags list
	 */
	function bnm_tags_list() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'bnm' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'bnm' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

endif;

if ( ! function_exists( 'bnm_comments_link' ) ) :
	/**
	 * Prints comments link
	 */
	function bnm_comments_link() {

		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="bnm-comments-icon">' . bnm_get_icon_svg( 'comment' ) . '</span>';
			echo '<span class="comments-link">';
				comments_popup_link( '0', '1', '%' );
			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'bnm_entry_meta' ) ) :
	/**
	 * Entry Meta
	 */
	function bnm_entry_meta() {
	
		if ( is_single() ) {
			$show_date = get_theme_mod( 'bnm_show_date_s', true );
			$show_avatar = get_theme_mod( 'bnm_show_author_avatar_s', true );
			$show_author = get_theme_mod( 'bnm_show_author_s', true );
			$show_comments = get_theme_mod( 'bnm_show_comments_link_s', true );
		} else {
			$show_date = get_theme_mod( 'bnm_show_date', true );
			$show_avatar = get_theme_mod( 'bnm_show_author_avatar', false );
			$show_author = get_theme_mod( 'bnm_show_author', true );
			$show_comments = get_theme_mod( 'bnm_show_comments_link', true );
		}

		if ( $show_avatar ) {
			bnm_author_avatar();
		}
	
		if ( $show_author ) {
			bnm_posted_by();
		}
	
		if ( $show_date ) {
			bnm_posted_on();
		}
		
		if ( $show_comments ) {
			bnm_comments_link();
		}
		
	}
endif;

if ( ! function_exists( 'bnm_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bnm_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list();
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( 
					'<div class="bnm-tag-list"><span class="bnm-tagged">%1$s</span><span class="tags-links bnm-tags-links">%2$s</span></div>', 
					esc_html__( 'Tagged', 'bnm' ), 
					$tags_list 
				); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bnm' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'bnm' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'bnm_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function bnm_post_thumbnail( $size = 'bnm-featured-image' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( $size ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
						the_post_thumbnail(
							$size,
							array(
								'alt' => the_title_attribute(
									array(
										'echo' => false,
									)
								),
							)
						);
					?>
				</a>
			</div><!-- .post-thumbnail -->

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'bnm_post_previous_next' ) ) :
	/**
	 * Prints previous and next links for single posts.
	 */
	function bnm_post_previous_next() {
		if ( true === get_theme_mod( 'bnm_post_previous_next', true ) && is_singular( 'post' ) ) {
			the_post_navigation(
				array(
					'next_text' => '<span class="posts-nav-text" aria-hidden="true">' . esc_html__( 'Next Article', 'bnm' ) . '</span> ' .
						'<span class="screen-reader-text">' . esc_html__( 'Next article:', 'bnm' ) . '</span> <br/>' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="posts-nav-text" aria-hidden="true">' . esc_html__( 'Previous Article', 'bnm' ) . '</span> ' .
						'<span class="screen-reader-text">' . esc_html__( 'Previous article:', 'bnm' ) . '</span> <br/>' .
						'<span class="post-title">%title</span>',
				)
			);
		}
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'bnm_search_box' ) ) :
/**
 * Displays the search 
 */
function bnm_search_box() {
	?>
		<div class="bnm-search-container desktop-only">
			<button id="bnm-search-toggle">
				<span class="bnm-search-icon"><?php bnm_the_icon_svg( 'search' ) ?></span>
				<span class="bnm-close-icon"><?php bnm_the_icon_svg( 'close' ) ?></span>
			</button>
			<div id="bnm-search-box">
				<?php get_search_form(); ?>
			</div><!-- bnm-search-box -->
		</div><!-- bnm-search-container -->
	<?php
}
endif;


if ( ! function_exists( 'bnm_posts_pagination' ) ) {
	/**
	 * Posts pagination.
	 */
	function bnm_posts_pagination() {

		$pagination_type = get_theme_mod( 'bnm_pagination_type', 'page-numbers' );

		if ( $pagination_type == 'page-numbers' ) {
			the_posts_pagination();
		} else {
			the_posts_navigation(
				array(
					'prev_text' => __( '&larr; Older Posts', 'bnm' ),
					'next_text' => __( 'Newer Posts &rarr;', 'bnm' ),
				)
			);
		}

	}

}

if ( ! function_exists( 'bnm_read_more_button' ) ) {
	/**
	 * Read More Button Markup
	 */
	function bnm_read_more_button() {
		if ( 'button' === get_theme_mod( 'bnm_read_more_type', 'link' ) ) : ?>
			<div class="entry-readmore">
				<a href="<?php the_permalink(); ?>" class="bnm-readmore-btn">
					<?php the_title( '<span class="screen-reader-text">', '</span>' ); ?>
					<?php echo esc_html_e( 'Read More', 'bnm' ); ?>
				</a>
			</div>
		<?php endif; 
	}
}