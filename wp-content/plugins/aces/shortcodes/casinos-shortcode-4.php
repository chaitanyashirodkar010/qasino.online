<?php

function aces_casinos_shortcode_4($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 4,
	    'external_link' => '',
	    'category' => '',
	    'items_id' => '',
	    'exclude_id' => '',
	    'game_id' => '',
	    'order' => '',
	    'orderby' => '',
	    'title' => '',
	    'show_title' => ''
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

	<div class="space-shortcode-wrap space-shortcode-4 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-organizations-3-archive-items box-100 relative">

				<?php
					$count = 0;
					while ( $casino_query->have_posts() ) : $casino_query->the_post();
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

					$casino_terms_desc = wp_kses( get_post_meta( get_the_ID(), 'casino_terms_desc', true ), $casino_allowed_html );
					$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
					$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
					$casino_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_permalink_button_title', true ) );
					$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
					$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

					$organization_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'casino_detailed_tc', true ), $casino_allowed_html );
					$organization_popup_hide = esc_attr( get_post_meta( get_the_ID(), 'aces_organization_popup_hide', true ) );
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

					if ($casino_permalink_button_title) {
						$permalink_button_title = $casino_permalink_button_title;
					} else {
						if ( get_option( 'casinos_read_review_title') ) {
							$permalink_button_title = esc_html( get_option( 'casinos_read_review_title') );
						} else {
							$permalink_button_title = esc_html__( 'Read Review', 'aces' );
						}
					}

					$terms = get_the_terms( $post->ID, 'casino-category' );

					$games_count = '';

					/*  

					$games = get_posts(
						array(
							'post_type'=>'game',
							'posts_per_page'=>-1,
							'meta_query' => array(
							    array(
							        'key' => 'parent_casino',
							        'value' => $post->ID,
							        'compare' => 'LIKE'
							    )
							)
						)
					);
					$games_count = count($games);

					*/

					$count++;
				?>

				<div class="space-organizations-3-archive-item box-100 relative">
					<div class="space-organizations-3-archive-item-ins relative">
						<div class="space-organizations-3-archive-item-logo box-25 relative">
							<div class="space-organizations-3-archive-item-logo-ins box-100 text-center relative">

								<?php
								$post_title_attr = the_title_attribute( 'echo=0' );
								if ($show_title == true) {
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
										<div class="space-organizations-3-logo-title-box box-100 text-left relative">
											<div class="space-organizations-3-logo-box relative">
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
													<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-50-50', "", array( "alt" => $post_title_attr ) ); ?>
												</a>
												<div class="space-organizations-3-archive-item-count-2 absolute">
													<span><?php echo esc_html( $count ); ?></span>
												</div>
											</div>
											<div class="space-organizations-3-title-box relative">
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
											</div>
										</div>
									<?php }
								} else {
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-9999-80', "", array( "alt" => $post_title_attr ) ); ?>
										</a>
									<?php }
								} ?>
							</div>
							<?php if ($show_title != true) { ?>
								<div class="space-organizations-3-archive-item-count absolute">
									<span><?php echo esc_html( $count ); ?></span>
								</div>
							<?php } ?>
						</div>
						<div class="space-organizations-3-archive-item-terms box-25 relative">
							<div class="space-organizations-3-archive-item-terms-ins box-100 text-center relative">
							<?php if ($casino_terms_desc) {
								echo wp_kses( $casino_terms_desc, $casino_allowed_html );
							} ?>
							</div>
						</div>
						<div class="space-organizations-3-archive-item-rating box-25 relative">
							<div class="space-organizations-3-archive-item-rating-ins box-100 text-center relative">

								<?php if ($games_count) { ?>
								<div class="space-organizations-3-archive-item-units relative">
									<i class="fas fa-dice"></i> <span><?php echo esc_html( $games_count ); ?></span> <?php if ($games_count == 1) { echo esc_html__( 'game', 'aces' ); } else { echo esc_html__( 'games', 'aces' ); } ?>
								</div>
								<?php } ?>

								<?php if( function_exists('aces_star_rating') ){ ?>
									<div class="space-organizations-3-archive-item-rating-box relative">
										<?php aces_star_rating(
											array(
												'rating' => $casino_overall_rating,
												'type' => 'rating',
												'stars_number' => $casino_rating_stars_number_value
											)
										); ?>
										<span><?php echo esc_html( number_format( round( $casino_overall_rating, 1 ), 1, '.', ',') ); ?></span>
									</div>
								<?php } ?>

								<?php if ($organization_popup_hide == true ) { ?>
									<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
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
						<div class="space-organizations-3-archive-item-button box-25 relative">
							<div class="space-organizations-3-archive-item-button-ins box-100 text-center relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><i class="fas fa-check-circle"></i> <?php echo esc_html( $button_title ); ?></a>

								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><i class="fas fa-arrow-alt-circle-right"></i> <?php echo esc_html( $permalink_button_title ); ?></a>
							</div>
						</div>
						<?php
						if ($organization_popup_hide == true ) {

						} else {
							if ($organization_detailed_tc) { ?>
							<div class="space-organizations-archive-item-detailed-tc box-100 relative">
								<div class="space-organizations-archive-item-detailed-tc-ins relative">
									<?php echo wp_kses( $organization_detailed_tc, $casino_allowed_html ); ?>
								</div>
							</div>
						<?php
							}
						}
						?>
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
 
add_shortcode('aces-casinos-4', 'aces_casinos_shortcode_4');