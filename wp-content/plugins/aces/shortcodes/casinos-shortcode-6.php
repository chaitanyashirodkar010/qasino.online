<?php

function aces_casinos_shortcode_6($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'external_link' => '',
	    'category' => '',
	    'items_id' => '',
	    'exclude_id' => '',
	    'game_id' => '',
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
		
		$first_args = array(
			'posts_per_page' => 1,
			'post_type'      => 'casino',
			'post__in'       => $casino_ids,
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'meta_key'       => 'casino_overall_rating',
			'orderby'        => 'meta_value_num',
			'order'          => $order
		);

		$second_args = array(
			'posts_per_page' => 4,
			'offset'	     => 1,
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

			$first_args = array(
				'posts_per_page' => 1,
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

			$second_args = array(
				'posts_per_page' => 4,
				'post_type'      => 'casino',
				'post__not_in'   => $exclude_id_array,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'offset'	     => 1,
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

			$first_args = array(
				'posts_per_page' => 1,
				'post_type'      => 'casino',
				'post__in'       => $items_id_array,
				'orderby'        => 'post__in',
				'no_found_rows'  => true,
				'post_status'    => 'publish'
			);

			$second_args = array(
				'posts_per_page' => 4,
				'post_type'      => 'casino',
				'post__in'       => $items_id_array,
				'orderby'        => 'post__in',
				'no_found_rows'  => true,
				'offset'	     => 1,
				'post_status'    => 'publish'
			);

		} else {

			$first_args = array(
				'posts_per_page' => 1,
				'post_type'      => 'casino',
				'post__not_in'   => $exclude_id_array,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'meta_key' => 'casino_overall_rating',
				'orderby'  => $orderby,
				'order'    => $order
			);

			$second_args = array(
				'posts_per_page' => 4,
				'post_type'      => 'casino',
				'post__not_in'   => $exclude_id_array,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'offset'	     => 1,
				'meta_key' => 'casino_overall_rating',
				'orderby'  => $orderby,
				'order'    => $order
			);

		}

	}

	$first_query = new WP_Query( $first_args );

	if ( $first_query->have_posts() ) {

		if ( get_option( 'aces_rating_stars_number' ) ) {
			$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
		} else {
			$casino_rating_stars_number_value = '5';
		}

		?>

		<div class="space-shortcode-wrap space-shortcode-9 relative">
			<div class="space-shortcode-wrap-ins relative">

				<?php if ( $title ) { ?>
				<div class="space-block-title relative">
					<span><?php echo esc_html($title); ?></span>
				</div>
				<?php } ?>

				<div class="space-organizations-5-archive-columns box-100 relative">
					<div class="space-organizations-5-archive-column box-50 relative first">
						<?php while ( $first_query->have_posts() ) : $first_query->the_post();
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

							$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
							$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
							$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
							$casino_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_permalink_button_title', true ) );
							$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
							$overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

							if ($external_link) {
								if ($casino_external_link) {
									$external_link_url = $casino_external_link;
								} else {
									$external_link_url = get_the_permalink();
								}
							} else {
								$external_link_url = get_the_permalink();
							}

							if ($casino_button_title) {
								$button_title = $casino_button_title;
							} else {
								if ( get_option( 'casinos_play_now_title') ) {
									$button_title = esc_html( get_option( 'casinos_play_now_title') );
								} else {
									$button_title = esc_html__( 'Play Now', 'aces' );
								}
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
						?>

						<div class="space-organizations-5-archive-item box-100 relative">
							<div class="space-organizations-5-archive-item-ins relative">
								<div class="space-organizations-5-archive-item-img-wrap box-100 relative">
									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
									<?php } ?>
									<div class="space-organizations-5-archive-item-overlay space-overlay absolute">

										<?php if( function_exists('aces_star_rating') ){ ?>

											<div class="space-organizations-5-archive-item-rating absolute">
												<div class="space-rating-star-wrap relative">
													<div class="space-rating-star-background absolute"></div>
													<div class="space-rating-star-icon absolute">
														<i class="fas fa-star"></i>
													</div>
												</div>
												<strong><?php echo esc_html( number_format( round( $overall_rating, 1 ), 1, '.', ',') ); ?></strong>/<?php echo esc_html( $casino_rating_stars_number_value ); ?>
											</div>

										<?php } ?>

										<div class="space-organizations-5-archive-item-central text-center relative">

											<?php if ($terms) { ?>
											<div class="space-organizations-5-archive-item-category relative">
												<?php foreach ( $terms as $term ) { ?>
											        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
											    <?php } ?>
											</div>
											<?php } ?>

											<div class="space-organizations-5-archive-item-title relative">
												<?php the_title(); ?>
											</div>

											<?php if ($external_link) { ?>

											<div class="space-organizations-5-archive-item-button1 relative">
												<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
											</div>

											<?php } ?>

											<div class="space-organizations-5-archive-item-button2 relative">
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
											</div>
										</div>

										<?php if ($casino_button_notice) { ?>

										<div class="space-organizations-5-archive-item-tac absolute">
											
											<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>

										</div>

										<?php } ?>

									</div>
								</div>
							</div>
						</div>

						<?php
							endwhile;
							wp_reset_postdata();
						?>

					</div>
					<div class="space-organizations-5-archive-column box-50 relative second">
						<div class="space-organizations-5-archive-items box-100 relative">
						<?php
							$second_query = new WP_Query( $second_args );
							while ( $second_query->have_posts() ) : $second_query->the_post();
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

							$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
							$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
							$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );
							$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
							$casino_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_permalink_button_title', true ) );
							$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
							$overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

							if ($external_link) {
								if ($casino_external_link) {
									$external_link_url = $casino_external_link;
								} else {
									$external_link_url = get_the_permalink();
								}
							} else {
								$external_link_url = get_the_permalink();
							}

							if ($casino_button_title) {
								$button_title = $casino_button_title;
							} else {
								if ( get_option( 'casinos_play_now_title') ) {
									$button_title = esc_html( get_option( 'casinos_play_now_title') );
								} else {
									$button_title = esc_html__( 'Play Now', 'aces' );
								}
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
						?>

						<div class="space-organizations-5-archive-item box-50 relative">
							<div class="space-organizations-5-archive-item-ins relative">
								<div class="space-organizations-5-archive-item-img-wrap box-100 relative">
									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
									<?php } ?>
									<div class="space-organizations-5-archive-item-overlay space-overlay absolute">

										<?php if( function_exists('aces_star_rating') ){ ?>

											<div class="space-organizations-5-archive-item-rating absolute">
												<div class="space-rating-star-wrap relative">
													<div class="space-rating-star-background absolute"></div>
													<div class="space-rating-star-icon absolute">
														<i class="fas fa-star"></i>
													</div>
												</div>
												<strong><?php echo esc_html( number_format( round( $overall_rating, 1 ), 1, '.', ',') ); ?></strong>/<?php echo esc_html( $casino_rating_stars_number_value ); ?>
											</div>

										<?php } ?>

										<div class="space-organizations-5-archive-item-central text-center relative">

											<?php if ($terms) { ?>
											<div class="space-organizations-5-archive-item-category relative">
												<?php foreach ( $terms as $term ) { ?>
											        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
											    <?php } ?>
											</div>
											<?php } ?>

											<div class="space-organizations-5-archive-item-title relative">
												<?php the_title(); ?>
											</div>

											<?php if ($external_link) { ?>

											<div class="space-organizations-5-archive-item-button1 relative">
												<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
											</div>

											<?php } ?>

											<div class="space-organizations-5-archive-item-button2 relative">
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
											</div>
										</div>

										<?php if ($casino_button_notice) { ?>

										<div class="space-organizations-5-archive-item-tac absolute">
											
											<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>

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
			
			</div>
		</div>

	<?php
	wp_reset_postdata();
	$casino_items = ob_get_clean();
	return $casino_items;
	}

}
 
add_shortcode('aces-casinos-6', 'aces_casinos_shortcode_6');