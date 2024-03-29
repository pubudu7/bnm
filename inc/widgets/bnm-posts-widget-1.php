<?php

/**
 * Displays latest, category wised posts.
 *
 */

class BNM_Posts_Widget_1 extends WP_Widget {

	/* Register Widget with WordPress*/
	function __construct() {
		parent::__construct(
			'bnm_posts_widget_1', // Base ID
			esc_html__( 'BNM: Magazine Posts (Style 1)', 'bnm' ), // Name
			array( 'description' => esc_html__( 'Displays latest posts or posts from a choosen category.', 'bnm' ), ) // Args
		);
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'			=>	esc_html__( 'Latest Posts', 'bnm' ),
			'category'		=>	'all',
			'viewall_text'	=> esc_html__( 'View All', 'bnm' )
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'bnm' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
	</p>
	<p>
		<label><?php esc_html_e( 'Select a post category', 'bnm' ); ?></label>
		<?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $instance['category'], 'show_option_all' => 'Show all posts' ) ); ?>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'viewall_text' ); ?>"><?php esc_html_e( 'View All Text:', 'bnm' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'viewall_text' ); ?>" name="<?php echo $this->get_field_name( 'viewall_text' ); ?>" value="<?php echo esc_attr( $instance['viewall_text'] ); ?>"/>
	</p>	

	<?php

	}



	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );		
		$instance[ 'category' ]	= absint( $new_instance[ 'category' ] );
		$instance[ 'viewall_text' ] = sanitize_text_field( $new_instance[ 'viewall_text' ] );
		return $instance;
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	
	public function widget( $args, $instance ) {
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';	
		$title = apply_filters( 'widget_title', $title , $instance, $this->id_base );
		$category = ( isset( $instance['category'] ) ) ? absint( $instance['category'] ) : '';
		$viewall_text = ( ! empty( $instance['viewall_text'] ) ) ? $instance['viewall_text'] : '';	
		// Latest Posts
		$latest_posts = new WP_Query( 
			array(
				'cat'				=>	$category,
				'posts_per_page'	=>	5,
				'post_status'		=>	'publish',
				'ignore_sticky_posts'=>	'true'
			)
		);	

		echo $before_widget;
		
		if ( $title ) : ?>
			<div class="bnm-widget-header">
				<?php
					echo $before_title . $title . $after_title;
					bnm_viewall_link( $category, $viewall_text );
				?>
			</div>
		<?php endif; ?>

		<div class="bnm-pws-1">
			<?php $bnmp_count = 1 ?>
			<?php 
				if ( $latest_posts -> have_posts() ) :
				
				while ( $latest_posts -> have_posts() ) : $latest_posts -> the_post();

					if ( $bnmp_count == 1 ) { ?>
					
					<div class="bnm-pws1-top clearfix">
						<article class="bnm-pws1-lg">

							<?php
								if ( has_post_thumbnail() ) {
									$thumb_id           = get_post_thumbnail_id();
									$thumb_url_array    = wp_get_attachment_image_src( $thumb_id, 'bnm-archive-image', true );
									$featured_image_url = $thumb_url_array[0]; 
								} else {
									$featured_image_url = get_template_directory_uri() . '/assets/images/slide.png';
								}
							?>

								<div class="bnm-pws1-lgp-left">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<div class="bnm-pws1-image-holder" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);"></div>
									</a>
								</div>

								<div class="bnm-pws1-lgp-right">
									<div class="pws1-lgp-inner">
										<div class="pws1-lgp-blur-bg" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);"></div>
										<div class="pws1-lgp-content">
											<div class="pws1-lgp-details">
												<?php the_title( '<h3 class="bnmpws1 entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>							

												<div class="entry-meta">
												<div class="entry-meta"><?php echo bnm_posted_on(); ?></div>
												</div><!-- .entry-meta -->
											</div>
										</div>
									</div>
								</div>

						</article>
					</div><!-- .bnm-pws1-top -->

					<div class="bnm-pws1-bottom">

				<?php } else { ?>

					<article class="bnm-pw1-smp">
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="bnm-pw1-smp-thumb">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'bnm-archive-image' ); ?></a>
							</div>
						<?php } ?>
						<div class="bnm-pw1-smp-details">
							<?php the_title( sprintf( '<h3 class="bnmpws-sm entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
							<div class="entry-meta"><?php echo bnm_posted_on(); ?></div>
						</div>
					</article>

				<?php } 
				
				$bnmp_count++; 
			endwhile;
			wp_reset_postdata(); ?>

			    </div><!-- .bnm-pws1-bottom -->
			
			<?php endif; ?>
		
		</div><!-- .bnm-pws-1 -->

	<?php
		echo $after_widget;
	}

}

// Register single category posts widget
function bnm_register_posts_widget_1() {
    register_widget( 'BNM_Posts_Widget_1' );
}
add_action( 'widgets_init', 'bnm_register_posts_widget_1' );