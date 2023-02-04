<?php

class mercury_widget_11 extends WP_Widget {

	/*  Widget #11 Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#11 Homepage Block [Mercury]', 'spacethemes' ), array(
			'description' => esc_html__('#11 Widget for HOMEPAGE', 'spacethemes' )
		));
	}

	/*  Display Widget #11  */

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';
		$category_link = get_category_link( $categories );

		$post_query = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => 3,
			'cat'                 => $categories,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($post_query->have_posts()) :
	?>


	<div class="space-news-11 homepage-block box-100 relative">
		<div class="space-news-11-ins space-page-wrapper relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-news-11-items box-100 relative">

				<?php
					$count = 0;
					while ( $post_query->have_posts() ) : $post_query->the_post();

					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'category' );
					$post_title_attr = the_title_attribute( 'echo=0' );
					$count++;
				?>

				<?php if ($count == 1) { ?>

					<div class="space-news-11-item big box-50 relative">
						<div class="space-news-11-item-ins case-15 relative">
							<div class="space-news-11-item-image-wrap box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<div class="space-news-11-item-image box-100 relative">
										<?php if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
											<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-430', "", array( "alt" => $post_title_attr ) ); ?>
											<div class="space-overlay absolute"></div>
										<?php } ?>

										<?php if ( has_post_format( 'video' )) { ?>
											<div class="space-post-format absolute"><i class="fas fa-play"></i></div>
										<?php } ?>
										<?php if ( has_post_format( 'image' )) { ?>
											<div class="space-post-format absolute"><i class="fas fa-camera"></i></div>
										<?php } ?>
										<?php if ( has_post_format( 'gallery' )) { ?>
											<div class="space-post-format absolute"><i class="fas fa-camera"></i></div>
										<?php } ?>

										<div class="space-news-11-item-title-box absolute">
											<div class="space-news-11-item-category box-100 relative">
												<?php foreach( $terms as $term ){ ?><span><?php echo esc_html($term->name); ?></span> <?php } ?>
											</div>
											<div class="space-news-11-item-title box-100 relative">
												<?php get_the_title() ? the_title() : the_ID(); ?>
											</div>
											<div class="space-news-11-item-info relative">
												<div class="space-news-11-item-info-left absolute">

													<?php if( !get_theme_mod('mercury_date_display') ) { ?>
														<span class="date"><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
													<?php } ?>

												</div>
												<div class="space-news-11-item-info-right text-right absolute">
													
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
								</a>
							</div>
						</div>
					</div>

				<?php } else { ?>

					<div class="space-news-11-item small box-25 relative">
						<div class="space-news-11-item-ins case-15 relative">
							<div class="space-news-11-item-image-wrap box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<div class="space-news-11-item-image box-100 relative">
										<?php if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
											<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-450', "", array( "alt" => $post_title_attr ) ); ?>
											<div class="space-overlay absolute"></div>
										<?php } ?>

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
							</div>
							<div class="space-news-11-item-category box-100 relative">
								<?php the_category(' '); ?>
							</div>
							<div class="space-news-11-item-title box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>
							<div class="space-news-11-item-info relative">
								<div class="space-news-11-item-info-left absolute">
										
									<?php if( !get_theme_mod('mercury_date_display') ) { ?>
										<span class="date"><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
									<?php } ?>

								</div>
								<div class="space-news-11-item-info-right text-right absolute">
									
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

				<?php } ?>

				<?php endwhile; ?>

			</div>
		</div>
	</div>

		<?php
		wp_reset_postdata();
		endif;
	}

	/*  Update Widget #11  */

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['cats_id'] = (int) $new_instance['cats_id'];
		return $instance;
	}

	/*  Widget #11 Settings Form  */

	public function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$cats       = get_categories();
		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';
?>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php esc_html_e( 'Title:', 'spacethemes' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'cats_id' )); ?>">
			<?php esc_html_e('Select Category:' , 'spacethemes' );?>
		</label>
		<select id="<?php echo esc_attr($this->get_field_id( 'cats_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cats_id' )); ?>">
	 		<option value=""><?php esc_html_e('All' , 'spacethemes' );?></option>

			<?php foreach ( $cats as $cat ) {?>
			<option value="<?php echo esc_attr($cat->term_id); ?>"<?php echo selected( $categories, $cat->term_id, false ) ?>> <?php echo esc_attr( $cat->name ) ?></option>
			<?php }?>

 		</select>
 	</p>

<?php

	}
}

add_action( 'widgets_init', 'mercury_widget_11_register' );

function mercury_widget_11_register() {
	register_widget( 'mercury_widget_11' );
}