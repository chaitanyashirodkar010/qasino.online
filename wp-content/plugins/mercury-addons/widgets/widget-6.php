<?php

class mercury_widget_6 extends WP_Widget {

/*  Widget #6 Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#6 Homepage Block [Mercury]', 'spacethemes' ), array(
			'description' => esc_html__('#6 Widget for HOMEPAGE', 'spacethemes' )
		));
	}

/*  Display Widget #6  */

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';

		$category_link = get_category_link( $categories );
		$r1 = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => 1,
			'cat'      => $categories,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );
		$r2 = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => 5,
			'cat'      => $categories,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'offset'	=> 1,
			'ignore_sticky_posts' => true
		) ) );
		$r3 = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => 1,
			'cat'      => $categories,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'offset'	=> 6,
			'ignore_sticky_posts' => true
		) ) );
		if ($r1->have_posts()) :
		?>

	<div class="space-news-6-items homepage-block box-100 relative">
		<div class="space-news-6-items-ins space-page-wrapper relative">
			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>
			<div class="space-news-6-items-ins-wrap box-100 relative">
				<?php while ( $r1->have_posts() ) : $r1->the_post();
					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'category' );
				?>
				<?php
				$post_title_attr = the_title_attribute( 'echo=0' );
				if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
				<div class="space-news-6-item first-news box-50 relative">
					<div class="space-news-6-item-ins case-15 relative">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="space-news-6-item-link-wrap relative">

								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-430', "", array( "alt" => $post_title_attr, "class" => "space-desktop-view-1" ) ); ?>
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-737-556', "", array( "alt" => $post_title_attr, "class" => "space-mobile-view-1" ) ); ?>
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
								<div class="space-news-6-item-top absolute">
									<div class="space-news-6-item-top-category relative"><?php foreach( $terms as $term ){ ?><span><?php echo esc_html($term->name); ?></span> <?php } ?></div>
									<div class="space-news-6-item-top-title relative"><?php get_the_title() ? the_title() : the_ID(); ?></div>
									<div class="space-news-6-item-top-excerpt relative">
										<?php echo esc_html(wp_trim_words( get_the_excerpt(), 25, ' ...' )); ?>
									</div>
								</div>
								<div class="space-news-6-item-bottom absolute">
									<div class="space-news-6-item-bottom-ins box-100 relative">
										<div class="space-news-6-item-bottom-left absolute">
											
											<?php if( !get_theme_mod('mercury_date_display') ) { ?>
												<span class="date"><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
											<?php } ?>

										</div>
										<div class="space-news-6-item-bottom-right text-right absolute">
											
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
				<?php } ?>
				<?php
					endwhile;
					wp_reset_postdata();
				?>
				<div class="space-news-6-item second-news box-25 relative">
					<div class="space-news-6-item-ins case-15 relative">
						<ul>
							<?php while ( $r2->have_posts() ) : $r2->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
								<div>
									
									<?php if( !get_theme_mod('mercury_date_display') ) { ?>
										<span><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
									<?php } ?>

									<?php if ( comments_open() ) { ?>
										<span><i class="far fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></span>
									<?php } ?>

									<?php if(function_exists('spacethemes_set_post_views')) { ?>
										<span><i class="fas fa-eye"></i> <?php echo esc_html(spacethemes_get_post_views(get_the_ID())); ?></span>
									<?php } ?>

								</div>
							</li>
							<?php endwhile;
								wp_reset_postdata();
							?>
						</ul>
					</div>
				</div>
				<?php while ( $r3->have_posts() ) : $r3->the_post();
					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'category' );
				?>
				<?php
				$post_title_attr = the_title_attribute( 'echo=0' );
				if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
				<div class="space-news-6-item third-news box-25 relative">
					<div class="space-news-6-item-ins case-15 relative">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="space-news-6-item-link-wrap relative">

								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-270-430', "", array( "alt" => $post_title_attr, "class" => "space-desktop-view-2" ) ); ?>
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-737-556', "", array( "alt" => $post_title_attr, "class" => "space-mobile-view-2" ) ); ?>
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
								<div class="space-news-6-item-top absolute">
									<div class="space-news-6-item-top-category relative"><?php foreach( $terms as $term ){ ?><span><?php echo esc_html($term->name); ?></span> <?php } ?></div>
									<div class="space-news-6-item-top-title relative"><?php get_the_title() ? the_title() : the_ID(); ?></div>
								</div>
								<div class="space-news-6-item-bottom absolute">
									<div class="space-news-6-item-bottom-ins box-100 relative">
										<div class="space-news-6-item-bottom-left absolute">
											
											<?php if( !get_theme_mod('mercury_date_display') ) { ?>
												<span class="date"><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'mercury' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
											<?php } ?>

										</div>
										<div class="space-news-6-item-bottom-right text-right absolute">
											
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
				<?php } ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>

		<?php
		wp_reset_postdata();
		endif;
	}

/*  Update Widget #6  */

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['cats_id'] = (int) $new_instance['cats_id'];
		return $instance;
	}

/*  Widget #6 Settings Form  */

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$cats = get_categories();
		$categories = isset( $instance['cats_id'] ) ? $instance['cats_id'] : '';
?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'spacethemes' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

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

add_action( 'widgets_init', 'mercury_widget_6_register' );

function mercury_widget_6_register() {
	register_widget( 'mercury_widget_6' );
}