<?php

/**
 * View all link for posts widgets 
 */
function bnm_viewall_link( $category_id, $viewall_text ) {

	if ( ! empty( $viewall_text ) ) :

		if ( ! empty( $category_id ) ) {
			$viewall_link = get_category_link( $category_id );
		} else {
			$posts_page_id = get_option( 'page_for_posts' );

			if ( $posts_page_id ) {
				$viewall_link = get_page_link( $posts_page_id );
			} else {
				$viewall_link = "";
			}
		}

		if ( $viewall_link ) { ?>
			<a class="bnm-viewall" href="<?php echo esc_url( $viewall_link ); ?>"><span><?php echo esc_html( $viewall_text ); ?></span></a>
		<?php }

	endif;  

}