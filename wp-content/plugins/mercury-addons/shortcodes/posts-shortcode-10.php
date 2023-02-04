<?php

function mercury_posts_shortcode_10($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 2,
	    'category' => '',
	    'columns' => 2,
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

	<div class="space-shortcode-wrap space-posts-shortcode-10 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-news-10-items box-100 relative">

				<?php while ( $post_query->have_posts() ) : $post_query->the_post();
					$post_id = get_the_ID();
					$terms = get_the_terms( $post_id, 'category' );
				?>

					<div class="space-news-10-item <?php if ($columns == 1) { ?>box-100<?php } else { ?>box-50<?php } ?> relative">
						<div class="space-news-10-item-ins case-15 relative">
							<div class="space-news-10-item-image-wrap box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<div class="space-news-10-item-image box-100 relative">
										<?php
										$post_title_attr = the_title_attribute( 'echo=0' );
										if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
											<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-270', "", array( "alt" => $post_title_attr ) ); ?>
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
							<div class="space-news-10-item-category text-center box-100 relative">
								<?php the_category(' '); ?>
							</div>
							<div class="space-news-10-item-title text-center box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>
							<div class="space-news-10-item-info text-center box-100 relative">
								
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
 
add_shortcode('mercury-posts-10', 'mercury_posts_shortcode_10');