<?php
/**
 * Template part for displaying posts in archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BNM
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		if ( 'before-header' === bnm_archive_thumbnail_position() || 'beside-article' === bnm_archive_thumbnail_position() ) {
			bnm_post_thumbnail( 'bnm-archive-image' );
		}
	?>

	<div class="bnm-article-inner">
	
		<?php bnm_categories(); ?>
		
		<header class="entry-header">
			<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php bnm_entry_meta(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php
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
					if ( 'excerpt' === get_theme_mod( 'bnm_content_type', 'excerpt' ) ) {
						the_excerpt();
					} else {
						the_content();
					}
				?>
			</div><!-- .entry-content -->
		</div><!-- .entry-content-wrapper -->

	</div><!-- .bnm-article-inner -->

</article><!-- #post-<?php the_ID(); ?> -->
