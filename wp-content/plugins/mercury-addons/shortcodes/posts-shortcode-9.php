<?php

function mercury_posts_shortcode_9($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 4,
	    'category' => '',
	    'title' => '',
	    'items_id' => ''
	), $atts ) );

	if ( !empty( $category ) ) {

		$args = array(
			'posts_per_page'      => $items_number,
			'cat'                 => $category,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

	} else if ( !empty( $items_id ) ) {

		$items_id_array = explode( ',', $items_id );

		$args = array(
			'posts_per_page'      => $items_number,
			'post__in'            => $items_id_array,
			'orderby'             => 'post__in',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

	} else {

		$args = array(
			'posts_per_page'      => $items_number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		);

	}

	$post_query = new WP_Query( $args );

	if ( $post_query->have_posts() ) {
	?>

	<div class="space-shortcode-wrap space-posts-shortcode-9 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-news-9-items box-100 relative owl-carousel">

				<?php
					while ( $post_query->have_posts() ) : $post_query->the_post();
					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'category' );
				?>

					<div class="space-news-9-item box-100 relative">
						<div class="space-news-9-item-ins case-15 relative">
							<div class="space-news-9-item-background box-100 relative">
								<div class="space-news-9-item-info box-50 relative">
									<div class="space-news-9-item-info-ins relative">
										<div class="space-news-9-item-info-wrap relative">
											<div class="space-news-9-item-info-category relative">
												<?php foreach( $terms as $term ){ ?><span><?php echo esc_html($term->name); ?></span> <?php } ?>
											</div>
											<div class="space-news-9-item-title-box relative">
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
											</div>
											<div class="space-news-9-item-info-meta relative">

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
											<div class="space-news-9-item-info-excerpt relative">
												<?php echo esc_html(wp_trim_words( get_the_excerpt(), 27, ' ...' )); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="space-news-9-item-img box-50 relative">
								<?php
								$post_title_attr = the_title_attribute( 'echo=0' );
								if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-585-505', "", array( "alt" => $post_title_attr ) ); ?>
										<?php if ( has_post_format( 'video' )) { ?>
											<div class="space-post-format absolute"><i class="fas fa-play"></i></div>
										<?php } ?>
										<?php if ( has_post_format( 'image' )) { ?>
											<div class="space-post-format absolute"><i class="fas fa-camera"></i></div>
										<?php } ?>
										<?php if ( has_post_format( 'gallery' )) { ?>
											<div class="space-post-format absolute"><i class="fas fa-camera"></i></div>
										<?php } ?>
									</a>
								<?php } ?>
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
	$posts_items = ob_get_clean();
	return $posts_items;
	}

}
 
add_shortcode('mercury-posts-9', 'mercury_posts_shortcode_9');