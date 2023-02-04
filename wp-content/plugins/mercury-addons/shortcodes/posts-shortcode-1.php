<?php

function mercury_posts_shortcode_1($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 4,
	    'category' => '',
	    'columns' => 4,
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

	<div class="space-shortcode-wrap space-posts-shortcode-1 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-news-1-items box-100 relative">

				<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

				<div class="space-news-1-item <?php if ($columns == 1) { ?>box-100<?php } else if ($columns == 2) { ?>box-50<?php } else if ($columns == 3) { ?>box-33<?php } else { ?>box-25<?php } ?> left relative">
					<div class="space-news-1-item-ins relative">
						<div class="space-news-1-item-img left relative">
							<?php
							$post_title_attr = the_title_attribute( 'echo=0' );
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-100-100', "", array( "alt" => $post_title_attr ) ); ?>
								</a>
							<?php } ?>
						</div>
						<div class="space-news-1-item-title-box left relative">
							<div class="space-news-1-item-title-box-ins relative">
								<div class="space-news-1-item-title relative">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
								</div>

								<?php if( !get_theme_mod('mercury_date_display') ) { ?>
									<div class="space-news-1-item-meta relative">
										<span><i class="far fa-clock"></i> <?php if( get_theme_mod('mercury_time_ago_format') ){ ?><?php printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'spacethemes' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php } else { echo get_the_date(); } ?></span>
									</div>
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
 
add_shortcode('mercury-posts-1', 'mercury_posts_shortcode_1');