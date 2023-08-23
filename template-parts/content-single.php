<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BNM
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		if ( 'before-header' === get_theme_mod( 'bnm_post_image_position', 'after-header' ) ) {
			bnm_post_thumbnail( 'bnm-featured-image' );
		}
	?>

	<?php bnm_categories(); ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php bnm_entry_meta(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php
		if ( 'after-header' === get_theme_mod( 'bnm_post_image_position', 'after-header' ) ) {
			bnm_post_thumbnail( 'bnm-featured-image' );
		}
	?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bnm' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bnm' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php bnm_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php 
		if ( ! is_singular( 'attachment' ) ) { 
			get_template_part( 'template-parts/author', 'bio' ); 
		}
	?>

</article><!-- #post-<?php the_ID(); ?> -->
