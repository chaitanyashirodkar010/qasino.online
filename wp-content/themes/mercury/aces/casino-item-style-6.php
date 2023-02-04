			<?php
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

				if ($casino_external_link) {
					$external_link_url = $casino_external_link;
				} else {
					$external_link_url = get_the_permalink();
				}

				if ($casino_button_title) {
					$button_title = $casino_button_title;
				} else {
					if ( get_option( 'casinos_play_now_title') ) {
						$button_title = esc_html( get_option( 'casinos_play_now_title') );
					} else {
						$button_title = esc_html__( 'Play Now', 'mercury' );
					}
				}

				if ($casino_permalink_button_title) {
					$permalink_button_title = $casino_permalink_button_title;
				} else {
					if ( get_option( 'casinos_read_review_title') ) {
						$permalink_button_title = esc_html( get_option( 'casinos_read_review_title') );
					} else {
						$permalink_button_title = esc_html__( 'Read Review', 'mercury' );
					}
				}

				if ( get_option( 'aces_rating_stars_number' ) ) {
					$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
				} else {
					$casino_rating_stars_number_value = '5';
				}

				$terms = get_the_terms( $post->ID, 'casino-category' );
			?>

				<div class="space-organizations-6-archive-item box-25 relative">
					<div class="space-organizations-6-archive-item-ins relative">
						<div class="space-organizations-6-archive-item-img-wrap box-100 relative">
							<?php
							$post_title_attr = the_title_attribute( 'echo=0' );
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
							<?php } ?>
							<div class="space-organizations-6-archive-item-overlay space-overlay absolute">

								<?php if( function_exists('aces_star_rating') ){ ?>

									<div class="space-organizations-6-archive-item-rating absolute">
										<span><i class="fas fa-star"></i></span><strong><?php echo esc_html( number_format( (float)$overall_rating, 1, '.', ',') ); ?></strong>/<?php echo esc_html( $casino_rating_stars_number_value ); ?>
									</div>

								<?php } ?>

								<div class="space-organizations-6-archive-item-central text-center relative">

									<?php if ($terms) { ?>
									<div class="space-organizations-6-archive-item-category relative">
										<?php foreach ( $terms as $term ) { ?>
									        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
									    <?php } ?>
									</div>
									<?php } ?>

									<div class="space-organizations-6-archive-item-title relative">
										<?php the_title(); ?>
									</div>

									<?php if ($casino_external_link) { ?>

									<div class="space-organizations-6-archive-item-button1 relative">
										<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($casino_external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
									</div>

									<?php } ?>

									<div class="space-organizations-6-archive-item-button2 relative">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
									</div>
								</div>

								<?php if ($casino_button_notice) { ?>

								<div class="space-organizations-6-archive-item-tac absolute">
									
									<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>

								</div>

								<?php } ?>

							</div>
						</div>
					</div>
				</div>