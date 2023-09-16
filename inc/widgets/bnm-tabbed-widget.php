<?php

/**
 * Displays popular posts, comments and tags in a tabbed pane.
 */
class BNM_Tabbed_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bnm_tabbed_widget', // Base ID
			esc_html__( 'BNM: Popular, Recent, Tags, Comments', 'bnm' ), // Name
			array( 'description' => esc_html__( 'Displays popular posts, recent posts comments, tags in a tabbed pane.', 'bnm' ), ) // Args
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
		$nop = ! empty( $instance['nop'] ) ? absint( $instance['nop'] ) : 5;
		$date_range = ! empty( $instance['date_range'] ) ? absint( $instance['date_range'] ) : '';
		$noc = ! empty( $instance['noc'] ) ? absint( $instance['noc'] ) : 5; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'nop' ); ?>"><?php esc_html_e( 'Number of popular posts:', 'bnm' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'nop' ); ?>" name="<?php echo $this->get_field_name( 'nop' ); ?>" type="text" value="<?php echo esc_attr( $nop ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'date_range' ); ?>"><?php esc_html_e( 'Enter the number of days to display popular posts:', 'bnm' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'date_range' ); ?>" name="<?php echo $this->get_field_name( 'date_range' ); ?>" type="text" value="<?php echo esc_attr( $date_range ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'noc' ); ?>"><?php esc_html_e( 'Number of comments:', 'bnm' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'noc' ); ?>" name="<?php echo $this->get_field_name( 'noc' ); ?>" type="text" value="<?php echo esc_attr( $noc ); ?>">
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
		$instance = array();
		$instance['nop'] = ( ! empty( $new_instance['nop'] ) ) ? (int)( $new_instance['nop'] ) : '';
		$instance['date_range'] = ( ! empty( $new_instance['date_range'] ) ) ? (int)( $new_instance['date_range'] ) : '';
		$instance['noc'] = ( ! empty( $new_instance['noc'] ) ) ? (int)( $new_instance['noc'] ) : '';

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
		$nop = ( ! empty( $instance['nop'] ) ) ? absint( $instance['nop'] ) : 5;
		$date_range = ( ! empty( $instance['date_range'] ) ) ? absint( $instance['date_range'] ) : '';
		$noc = ( ! empty( $instance['noc'] ) ) ? absint( $instance['noc'] ) : 5;

		echo $before_widget; ?>

		<div class="bnm-tabs-wdt">

		<ul class="bnm-tab-nav">
			<li class="bnm-tab"><a class="bnm-tab-anchor" aria-label="popular-posts" href="#bnm-popular"><?php bnm_the_icon_svg( 'fire' ); ?></a></li>
			<li class="bnm-tab"><a class="bnm-tab-anchor" aria-label="recent-posts" href="#bnm-recent"><?php bnm_the_icon_svg( 'clock' ); ?></a></li>
			<li class="bnm-tab"><a class="bnm-tab-anchor" aria-label="comments" href="#bnm-comments"><?php bnm_the_icon_svg( 'comments' ); ?></a></li>
			<li class="bnm-tab"><a class="bnm-tab-anchor" aria-label="post-tags" href="#bnm-tags"><?php bnm_the_icon_svg( 'tags' ); ?></a></li>
		</ul>

		<div class="tab-content clearfix">
			<div id="bnm-popular">
				<?php 
					$args = array( 
						'ignore_sticky_posts' => 1, 
						'posts_per_page' => $nop, 
						'post_status' => 'publish', 
						'no_found_rows' => true, 
						'orderby' => 'comment_count', 
						'order' => 'desc' 
					);

					if( isset( $date_range ) && ! empty( $date_range ) ) {
						$args[ 'date_query' ] = array(
							array(
								'after' => $date_range . ' days ago'
							)
						);
					}

					$popular = new WP_Query( $args );

					if ( $popular->have_posts() ) :

					while( $popular-> have_posts() ) : $popular->the_post(); ?>
						<article class="bnm-pw-smp">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="bnm-pw-smp-thumb">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'bnm-small' ); ?></a>
								</div>
							<?php } ?>
							<div class="bnm-pw-smp-details">
								<?php the_title( sprintf( '<h3 class="bnmpws-sm entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
								<div class="entry-meta"><?php bnm_posted_on(); ?></div>
							</div>
                        </article>
					<?php
					endwhile;
					endif;	
				?>
			</div><!-- .tab-pane #bnm-popular -->

			<div id="bnm-recent">
				<?php 
					$args = array( 'ignore_sticky_posts' => 1, 'posts_per_page' => $nop, 'no_found_rows' => true, 'post_status' => 'publish' );
					$recent_posts = new WP_Query( $args );

					if ( $recent_posts->have_posts() ) :

					while( $recent_posts-> have_posts() ) : $recent_posts->the_post(); ?>
						<article class="bnm-pw-smp">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="bnm-pw-smp-thumb">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'bnm-small' ); ?></a>
								</div>
							<?php } ?>
							<div class="bnm-pw-smp-details">
								<?php the_title( sprintf( '<h3 class="bnmpws-sm entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
								<div class="entry-meta"><?php bnm_posted_on(); ?></div>
							</div>
                        </article>
					<?php
					endwhile;
					endif;	
				?>
			</div><!-- .tab-pane #bnm-recent -->

			<div id="bnm-comments">
				<?php

					$avatar_size = 50;
					$args = array(
						'number'    => $noc,
						'status'	=> 'approve'
					);
					$comments_query = new WP_Comment_Query;
					$comments = $comments_query->query( $args );	
				
					if ( $comments ) {
						foreach ( $comments as $comment ) { ?>
							<div class="bnmw-comment">
								<figure class="bnmw_avatar">
									<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
										<?php echo get_avatar( $comment->comment_author_email, $avatar_size ); ?>     
									</a>                               
								</figure> 
								<div class="bnmw-comm-content">
									<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
										<span class="bnmw-comment-author"><?php echo esc_html( get_comment_author( $comment->comment_ID ) ); ?> </span> - <span class="bnm_comment_post"><?php echo esc_html( get_the_title($comment->comment_post_ID) ); ?></span>
									</a>
									<p class="bnmw-comment">
										<?php comment_excerpt( $comment->comment_ID ); ?>
									</p>
								</div>
							</div>
						<?php }
					} else {
						esc_html_e( 'No comments found.', 'bnm' );
					}
				?>
			</div><!-- .tab-pane #bnm-comments -->

			<div id="bnm-tags">
				<?php        
					$tags = wp_tag_cloud();             
					if( $tags ) {               
						echo $tags;       
					} else {          
						esc_html_e( 'No tags created.', 'bnm');           
					}            
				?>
			</div><!-- .tab-pane #bnm-tags-->

		</div><!-- .tab-content -->		

		</div><!-- #tabs -->


		<?php echo $after_widget; ?>

		<?php
			wp_enqueue_script( 'bnm-tab-widget', get_template_directory_uri() . '/js/tab-widget.js', array(), '', true );
		?>

<?php

	}

}

//Registster bnm tabbed widget.
function bnm_register_tabbed_widget() {
    register_widget( 'BNM_Tabbed_Widget' );
}
add_action( 'widgets_init', 'bnm_register_tabbed_widget' ); 