<?php

class mercury_widget_4 extends WP_Widget {

/*  Widget #4 Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#4 Homepage Block [Mercury]', 'spacethemes' ), array(
			'description' => esc_html__('#4 Widget for HOMEPAGE', 'spacethemes' )
		));
	}

/*  Display Widget #4  */

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$margin_bottom = ( ! empty( $instance['margin_bottom'] ) ) ? esc_attr( $instance['margin_bottom'] ) : '';
		if ( ! $margin_bottom ) {
			$margin_bottom = '';
		}

		$post_format_4 = ( ! empty( $instance['post_format_4'] ) ) ? esc_attr( $instance['post_format_4'] ) : '';
		if ( !$post_format_4 ) {
			$post_format_4 = array('post-format-image', 'post-format-gallery', 'post-format-video');
		}

		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';

		$category_link = get_category_link( $categories );
		$r1 = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => 4,
			'cat'                 => $categories,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'tax_query' => array(
		        array(                
		            'taxonomy' => 'post_format',
		            'field' => 'slug',
		            'terms' => $post_format_4
		        )
		    )
		) ) );

		if ($r1->have_posts()) :
		?>

	<div class="space-news-4 homepage-block box-100 relative"<?php if ( $margin_bottom ) { ?> style="margin-bottom: <?php echo esc_attr($margin_bottom); ?>;"<?php } ?>>
		<div class="space-news-4-ins space-page-wrapper relative">
			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>
			<div class="space-news-4-items box-100 relative">
				<?php while ( $r1->have_posts() ) : $r1->the_post();
					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'category' );
				?>
				<?php
				$post_title_attr = the_title_attribute( 'echo=0' );
				if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
				<div class="space-news-4-item small-news-block box-25 relative">
					<div class="space-news-4-item-ins case-15 relative">
						<div class="space-news-4-item-img relative">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<div class="space-news-4-item-img-ins">
									
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
									<div class="space-news-4-item-meta absolute">
										<div class="space-news-4-item-meta-left absolute">
											
											<?php if( !get_theme_mod('mercury_date_display') ) { ?>
												<span class="date"><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
											<?php } ?>

										</div>
										<div class="space-news-4-item-meta-right text-right absolute">
											
											<?php if ( comments_open() ) { ?>
												<span><i class="far fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></span>
											<?php } ?>

											<?php if(function_exists('spacethemes_set_post_views')) { ?>
												<span><i class="fas fa-eye"></i> <?php echo esc_html(spacethemes_get_post_views(get_the_ID())); ?></span>
											<?php } ?>
											
										</div>
									</div>
								</div>
							</a>
							<div class="space-news-4-item-img-category text-center absolute"><?php the_category(' '); ?></div>
						</div>
						<div class="space-news-4-item-title-box relative">
							<div class="space-news-4-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>
							<div class="space-news-4-item-excerpt relative">
								<?php echo esc_html(wp_trim_words( get_the_excerpt(), 20, ' ...' )); ?>
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

/*  Update Widget #4  */

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['margin_bottom'] = sanitize_text_field( $new_instance['margin_bottom'] );
		$instance['post_format_4'] = sanitize_text_field( $new_instance['post_format_4'] );
		$instance['cats_id'] = (int) $new_instance['cats_id'];
		return $instance;
	}

/*  Widget #4 Settings Form  */

	public function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$margin_bottom    = isset( $instance['margin_bottom'] ) ? esc_attr( $instance['margin_bottom'] ) : '';

		$post_format_4 = isset( $instance['post_format_4'] ) ? esc_attr( $instance['post_format_4'] ) : '';
		
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
			<label for="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>">
				<?php esc_html_e( 'Margin bottom for the block (in pixels):', 'spacethemes' ); ?>
			</label>
			<input class="small-text" id="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'margin_bottom' )); ?>" type="text" value="<?php echo esc_attr($margin_bottom); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_name( 'post_format_4' )); ?>">
				<?php esc_html_e('Select Post Format:' , 'spacethemes' );?>
			</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'post_format_4' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_format_4' )); ?>">
		 		<option value=""><?php esc_html_e('All' , 'spacethemes' );?></option>
		 		<option value="post-format-image" <?php selected( $post_format_4, 'post-format-image'); ?>><?php esc_html_e('Image' , 'spacethemes' );?></option>
		 		<option value="post-format-gallery" <?php selected( $post_format_4, 'post-format-gallery'); ?>><?php esc_html_e('Gallery' , 'spacethemes' );?></option>
		 		<option value="post-format-video" <?php selected( $post_format_4, 'post-format-video'); ?>><?php esc_html_e('Video' , 'spacethemes' );?></option>			
	 		</select>
	 	</p>

		<hr>

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

add_action( 'widgets_init', 'mercury_widget_4_register' );

function mercury_widget_4_register() {
	register_widget( 'mercury_widget_4' );
}