<?php

class mercury_widget_3 extends WP_Widget {

/*  Widget #3 Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#3 Homepage Block [Mercury]', 'spacethemes' ), array(
			'description' => esc_html__('#3 Widget for HOMEPAGE', 'spacethemes' )
		));
	}

/*  Display Widget #3  */

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 4;
		if ( ! $number ) {
			$number = 4;
		}

		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';
		$category_link = get_category_link( $categories );

		$r1 = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'cat'      => $categories,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r1->have_posts()) :
	?>

	<div class="space-news-3 homepage-block box-100 relative">
		<div class="space-news-3-ins space-page-wrapper relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-news-3-items box-100 relative">

				<?php while ( $r1->have_posts() ) : $r1->the_post(); ?>

				<div class="space-news-3-item box-25 left relative">
					<div class="space-news-3-item-ins case-15 relative">
						<div class="space-news-3-item-img relative">
							<?php
							$post_title_attr = the_title_attribute( 'echo=0' );
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<div class="space-news-3-item-img-ins">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-338', "", array( "alt" => $post_title_attr ) ); ?>
									<div class="space-overlay absolute"></div>

									<?php if ( has_post_format( 'video' )) { ?>
										<div class="space-post-format absolute"><i class="fas fa-play"></i></div>
									<?php } ?>
									<?php if ( has_post_format( 'image' )) { ?>
										<div class="space-post-format absolute"><i class="fas fa-camera"></i></div>
									<?php } ?>
									<?php if ( has_post_format( 'gallery' )) { ?>
										<div class="space-post-format absolute"><i class="fas fa-camera"></i></div>
									<?php } ?>
								</div>
							</a>
							<?php } ?>
							<div class="space-news-3-item-img-category <?php if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>absolute<?php } ?>"><?php the_category(' '); ?></div>
						</div>
						<div class="space-news-3-item-title-box relative">
							<div class="space-news-3-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>
							<div class="space-news-3-item-excerpt relative">
								<?php echo esc_html(wp_trim_words( get_the_excerpt(), 17, ' ...' )); ?>
							</div>
							<div class="space-news-3-item-meta relative">
								<div class="space-news-3-item-meta-left absolute">
									
									<?php if( !get_theme_mod('mercury_date_display') ) { ?>
										<span class="date"><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
									<?php } ?>

								</div>
								<div class="space-news-3-item-meta-right text-right absolute">
									
									<?php if ( comments_open() ) { ?>
										<span><i class="far fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></span>
									<?php } ?>

									<?php if(function_exists('spacethemes_set_post_views')) { ?>
										<span><i class="fas fa-eye"></i> <?php echo esc_html(spacethemes_get_post_views(get_the_ID())); ?></span>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php endwhile; ?>

			</div>
		</div>
	</div>

	<?php
		wp_reset_postdata();
		endif;
	}

/*  Update Widget #3  */

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['cats_id'] = (int) $new_instance['cats_id'];
		return $instance;
	}

/*  Widget #3 Settings Form  */

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$cats = get_categories();
		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';
?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'spacethemes' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

 		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of post to show:', 'spacethemes' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="2" /></p>

		<hr>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'cats_id' )); ?>"><?php esc_html_e('Select Category:' , 'spacethemes' );?></label>
		<select id="<?php echo esc_attr($this->get_field_id( 'cats_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cats_id' )); ?>">
 		<option value=""><?php esc_html_e('All' , 'spacethemes' );?></option>
			<?php foreach ( $cats as $cat ) {?>
				<option value="<?php echo esc_attr($cat->term_id); ?>"<?php echo selected( $categories, $cat->term_id, false ) ?>> <?php echo esc_attr( $cat->name ) ?></option>
			<?php }?>
 		</select></p>

<?php

	}
}

add_action( 'widgets_init', 'mercury_widget_3_register' );

function mercury_widget_3_register() {
	register_widget( 'mercury_widget_3' );
}