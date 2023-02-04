<?php

function aces_casinos_shortcode_1($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 4,
	    'external_link' => '',
	    'category' => '',
	    'big_thumbnail' => '',
	    'items_id' => '',
	    'exclude_id' => '',
	    'game_id' => '',
	    'columns' => 4,
	    'order' => '',
	    'orderby' => '',
	    'title' => ''
	), $atts ) );

	if ( $orderby == 'rating') {
		$orderby = 'meta_value_num';
	}

	$exclude_id_array = '';

	if ($exclude_id) {
		$exclude_id_array = explode( ',', $exclude_id );
	}

	if ($game_id) {
		
		$casino_ids = get_post_meta( $game_id, 'parent_casino', true );
		
		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'casino',
			'post__in'       => $casino_ids,
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'meta_key'       => 'casino_overall_rating',
			'orderby'        => 'meta_value_num',
			'order'          => $order
		);

	} else {

		if ( !empty( $category ) ) {

			$categories_id_array = explode( ',', $category );

			$args = array(
				'posts_per_page' => $items_number,
				'post_type'      => 'casino',
				'post__not_in'   => $exclude_id_array,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'casino-category',
						'field'    => 'id',
						'terms'    => $categories_id_array
					)
				),
				'meta_key' => 'casino_overall_rating',
				'orderby'  => $orderby,
				'order'    => $order
			);

		} else if ( !empty( $items_id ) ) {

			$items_id_array = explode( ',', $items_id );

			$args = array(
				'posts_per_page' => $items_number,
				'post_type'      => 'casino',
				'post__in'       => $items_id_array,
				'orderby'        => 'post__in',
				'no_found_rows'  => true,
				'post_status'    => 'publish'
			);

		} else {

			$args = array(
				'posts_per_page' => $items_number,
				'post_type'      => 'casino',
				'post__not_in'   => $exclude_id_array,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'meta_key' => 'casino_overall_rating',
				'orderby'  => $orderby,
				'order'    => $order
			);

		}

	}

	$casino_query = new WP_Query( $args );

	if ( $casino_query->have_posts() ) {

		if ( get_option( 'aces_rating_stars_number' ) ) {
			$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
		} else {
			$casino_rating_stars_number_value = '5';
		}
		
	?>

	<div class="space-shortcode-wrap space-shortcode-1 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-companies-archive-items box-100 relative">

				<?php while ( $casino_query->have_posts() ) : $casino_query->the_post();
					global $post;
					$casino_allowed_html = array(
						'a' => array(
							'href' => true,
							'title' => true,
							'target' => true,
							'rel' => true
						),
						'br' => array(),
						'em' => array(),
						'strong' => array(),
						'span' => array(
							'class' => true
						),
						'div' => array(
							'class' => true
						),
						'p' => array()
					);

					$casino_short_desc = wp_kses( get_post_meta( get_the_ID(), 'casino_short_desc', true ), $casino_allowed_html );
					$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
					$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
					$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
					$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

					$organization_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'casino_detailed_tc', true ), $casino_allowed_html );
					$organization_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_organization_popup_title', true ) );

					if ($casino_button_title) {
						$button_title = $casino_button_title;
					} else {
						if ( get_option( 'casinos_play_now_title') ) {
							$button_title = esc_html( get_option( 'casinos_play_now_title') );
						} else {
							$button_title = esc_html__( 'Play Now', 'aces' );
						}
					}

					if ($external_link) {
						if ($casino_external_link) {
							$external_link_url = $casino_external_link;
						} else {
							$external_link_url = get_the_permalink();
						}
					} else {
						$external_link_url = get_the_permalink();
					}

					if ($organization_popup_title) {
						$custom_popup_title = $organization_popup_title;
					} else {
						$custom_popup_title = esc_html__( 'T&Cs Apply', 'aces' );
					}

					$terms = get_the_terms( $post->ID, 'casino-category' );
					$post_title_attr = the_title_attribute( 'echo=0' );
				?>

				<div class="space-companies-archive-item <?php if ($columns == 1) { ?>box-100<?php } else if ($columns == 2) { ?>box-50<?php } else if ($columns == 3) { ?>box-33<?php } else { ?>box-25<?php } ?> relative">
					<div class="space-companies-archive-item-ins relative">
						<?php if ($big_thumbnail) {
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
							<div class="space-companies-archive-item-big-img text-center relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-317', "", array( "alt" => $post_title_attr ) ); ?>
								</a>
							</div>
							<?php }
						} ?>

						<div class="space-companies-archive-item-wrap text-center relative<?php if ($big_thumbnail) { ?> big<?php } ?>">
							<?php
							if (!$big_thumbnail) {
								if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<div class="space-companies-archive-item-img relative">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-120-120', "", array( "alt" => $post_title_attr ) ); ?>
									</a>
								</div>
								<?php }
							} ?>

							<div class="space-companies-archive-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>

							</div>
							<?php if( function_exists('aces_star_rating') ){ ?>
								<div class="space-companies-archive-item-rating relative">
									<?php aces_star_rating(
										array(
											'rating' => $casino_overall_rating,
											'type' => 'rating',
											'stars_number' => $casino_rating_stars_number_value
										)
									); ?>
								</div>
							<?php } ?>

							<?php if ($casino_short_desc) { ?>
							<div class="space-companies-archive-item-short-desc relative">
								<?php echo wp_kses( $casino_short_desc, $casino_allowed_html ); ?>
							</div>
							<?php } ?>

							<div class="space-companies-archive-item-button relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
							</div>

							<?php if ($organization_detailed_tc) { ?>
								<div class="space-organizations-archive-item-button-notice relative" style="margin-top: 5px;">
									<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
									<div class="tc-desc">
										<?php
											if ($organization_detailed_tc) {
												echo wp_kses( $organization_detailed_tc, $casino_allowed_html );
											}
										?>
									</div>
								</div>
							<?php } ?>

							<?php if ($casino_button_notice) { ?>

							<div class="space-organizations-archive-item-button-notice relative" style="margin-top: 5px;">
								<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>
							</div>

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
	$casino_items = ob_get_clean();
	return $casino_items;
	}

}
 
add_shortcode('aces-casinos-1', 'aces_casinos_shortcode_1');