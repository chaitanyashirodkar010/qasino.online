<?php

function mercury_posts_shortcode_2($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'category' => '',
	    'title' => '',
	    'items_id' => ''
	), $atts ) );


	if ( !empty( $category ) ) {

		$first_args = array(
			'posts_per_page'      => 1,
			'cat'                 => $category,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

		$second_args = array(
			'posts_per_page'      => 4,
			'offset'	          => 1,
			'cat'                 => $category,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

	} else if ( !empty( $items_id ) ) {

		$items_id_array = explode( ',', $items_id );

		$first_args = array(
			'posts_per_page'      => 1,
			'post__in'            => $items_id_array,
			'orderby'             => 'post__in',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

		$second_args = array(
			'posts_per_page'      => 4,
			'offset'	          => 1,
			'post__in'            => $items_id_array,
			'orderby'             => 'post__in',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

	} else {

		$first_args = array(
			'posts_per_page'      => 1,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

		$second_args = array(
			'posts_per_page'      => 4,
			'offset'	          => 1,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

	}

	$post_query_first = new WP_Query( $first_args );

	if ( $post_query_first->have_posts() ) {

	?>

	<div class="space-shortcode-wrap space-posts-shortcode-2 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-news-2-items box-100 relative">
				<div class="space-news-2-items-left box-50 left relative">
					<?php while ( $post_query_first->have_posts() ) : $post_query_first->the_post();
						$post_id = get_the_ID();
						$terms = get_the_terms( $post_id, 'category' );
					?>
					<?php
					$post_title_attr = the_title_attribute( 'echo=0' );
					if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
					<div class="space-news-2-item-big relative">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="space-news-2-item-big-ins relative">
								
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-737-983', "", array( "alt" => $post_title_attr, "class" => "space-desktop-view" ) ); ?>
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-600', "", array( "alt" => $post_title_attr, "class" => "space-mobile-view" ) ); ?>
								<div class="space-news-2-item-big-box absolute">
									<div class="space-news-2-item-big-box-category relative">
										<?php foreach( $terms as $term ){ ?><span><?php echo esc_html($term->name); ?></span> <?php } ?>
									</div>
									<div class="space-news-2-item-big-box-title relative">
										<?php get_the_title() ? the_title() : the_ID(); ?>
									</div>
									<div class="space-news-2-item-big-box-excerpt relative">
										<?php echo esc_html(wp_trim_words( get_the_excerpt(), 30, ' ...' )); ?>
									</div>
									<div class="space-news-2-item-top relative">
										<div class="space-news-2-item-top-ins box-100 relative">
											<div class="space-news-2-item-top-left absolute">

												<?php if( !get_theme_mod('mercury_date_display') ) { ?>
													<span><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'spacethemes' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
												<?php } ?>

											</div>
											<div class="space-news-2-item-top-right text-right absolute">
												
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
					<?php } ?>
					<?php
						endwhile;
						wp_reset_postdata();
					?>
				</div>
				<div class="space-news-2-items-right box-50 left relative">
					<div class="space-news-2-small-items box-100 relative">
						<?php 
							$post_query_second = new WP_Query( $second_args );
							while ( $post_query_second->have_posts() ) : $post_query_second->the_post();
						?>
						<div class="space-news-2-small-item box-50 left relative">
							<div class="space-news-2-small-item-ins case-15 relative">
								<div class="space-news-2-small-item-img relative">
									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<div class="space-news-2-small-item-img-ins">
											<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-450', "", array( "alt" => $post_title_attr ) ); ?>
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
									<div class="space-news-2-small-item-img-category <?php if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>absolute<?php } ?>"><?php the_category(' '); ?></div>
								</div>
								<div class="space-news-2-small-item-title-box relative">
									<div class="space-news-2-small-item-title relative">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
									</div>
									<div class="space-news-2-small-item-meta relative">
										<div class="space-news-2-small-item-meta-left absolute">
											
											<?php if( !get_theme_mod('mercury_date_display') ) { ?>
												<span><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'spacethemes' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
											<?php } ?>

										</div>
										<div class="space-news-2-small-item-meta-right text-right absolute">
											
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
			
		</div>
	</div>

	<?php
	wp_reset_postdata();
	$posts_items = ob_get_clean();
	return $posts_items;
	}

}
 
add_shortcode('mercury-posts-2', 'mercury_posts_shortcode_2');