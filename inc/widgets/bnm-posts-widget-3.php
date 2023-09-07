<?php

/**
 * Displays latest, category wised posts.
 *
 */

class BNM_Posts_Widget_3 extends WP_Widget {

	/* Register Widget with WordPress*/
	function __construct() {
		parent::__construct(
			'bnm_posts_widget_3', // Base ID
			esc_html__( 'BNM: Magazine Posts (Style 3)', 'bnm' ), // Name
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
			'title'			=> esc_html__( 'Latest Posts', 'bnm' ),
			'category'		=> 'all',
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
		?>
		<div class="bnm-widget-header">
			<?php
				if ( $title ) {
					echo $before_title . $title . $after_title;
				}
				bnm_viewall_link( $category, $viewall_text );
			?>
		</div>

		<div class="bnm-pws-3">
			<?php $bnmp_count = 1 ?>
			<?php 
				if ( $latest_posts -> have_posts() ) :
				
				while ( $latest_posts -> have_posts() ) : $latest_posts -> the_post();

					if ( $bnmp_count == 1 ) { ?>
					
					<div class="bnm-pws3-left">
						<article class="bnm-pws3-lg">

							<?php if ( has_post_thumbnail() ) { ?>
								<div class="bnm-pw-bp-thumb">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'bnm-archive-image' ); ?></a>
								</div>
							<?php } ?>

							<?php bnm_categories(); ?>

							<?php the_title( '<h3 class="bnmpwb entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>							

							<div class="entry-meta">
								<?php bnm_entry_meta(); ?>
							</div>

							<div class="entry-summary"><?php the_excerpt(); ?></div>

						</article>
					</div><!-- .bnm-pws3-left -->

					<div class="bnm-pws3-right">

				<?php } else { ?>

					<article class="bnm-pw-smp">
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="bnm-pw-smp-thumb">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'bnm-thumbnail' ); ?></a>
							</div>
						<?php } ?>
						<div class="bnm-pw-smp-details">
							<?php the_title( sprintf( '<h3 class="bnmpws-sm entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
							<div class="entry-meta"><?php echo bnm_posted_on(); ?></div>
						</div>
					</article>

				<?php } 
				
				$bnmp_count++; 
			endwhile;
			wp_reset_postdata(); ?>

			    </div><!-- .bnm-pws3-right -->
			
			<?php endif; ?>
		
		</div><!-- .bnm-pws-3 -->

	<?php
		echo $after_widget;
	}

}

// Register single category posts widget
function bnm_register_posts_widget_3() {
    register_widget( 'BNM_Posts_Widget_3' );
}
add_action( 'widgets_init', 'bnm_register_posts_widget_3' );