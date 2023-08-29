<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BNM
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

		// Before content hook
		do_action( 'bnm_before_content' );

		if ( 'before-header' === bnm_archive_thumbnail_position() || 'beside-article' === bnm_archive_thumbnail_position() ) {
			bnm_post_thumbnail( 'bnm-archive-image' );
		}
	?>

	<div class="bnm-article-inner">

		<?php 
			// Before entry header hook.
			do_action( 'bnm_before_entry_header' );

			bnm_categories(); 
		?>
		
		<header class="entry-header">

			<?php 
			// Before entry title hook.
			do_action( 'bnm_before_entry_title' );
			
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
			
			// After entry title hook.
			do_action( 'bnm_after_entry_title' );
			
			if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php bnm_entry_meta(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php

			// After entry header hook.
			do_action( 'bnm_after_entry_header' );

			if ( 'after-header' === bnm_archive_thumbnail_position() ) {
				bnm_post_thumbnail( 'bnm-archive-image' );
			}
		?>

		<div class="entry-content-wrapper">
			<?php
				if ( 'beside-content' === bnm_archive_thumbnail_position() ) {
					bnm_post_thumbnail( 'bnm-archive-image' );
				}
			?>
			<div class="entry-content">
				<?php 
					the_excerpt(); 

					// After entry content hook.
					do_action( 'bnm_after_entry_content' );

					bnm_read_more_button();
				?>
			</div><!-- .entry-content -->

		</div><!-- .entry-content-wrapper -->

	</div><!-- .bnm-article-inner -->

	<?php 
		// After content hook
		do_action( 'bnm_after_content' ); 
	?>
	
</article><!-- #post-<?php the_ID(); ?> -->