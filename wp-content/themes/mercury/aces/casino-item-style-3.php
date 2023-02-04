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

							$casino_short_desc = wp_kses( get_post_meta( get_the_ID(), 'casino_short_desc', true ), $casino_allowed_html );
							$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

							if ( get_option( 'aces_rating_stars_number' ) ) {
								$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
							} else {
								$casino_rating_stars_number_value = '5';
							}

							$terms = get_the_terms( $post->ID, 'casino-category' );

						?>

						<div class="space-companies-2-archive-item box-25 relative">
							<div class="space-companies-2-archive-item-ins relative">
								<div class="space-companies-2-archive-item-img left relative">
									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-100-100', "", array( "alt" => $post_title_attr ) ); ?>
									</a>
									<?php } ?>
								</div>
								<div class="space-companies-2-archive-item-title-box left relative">
									<div class="space-companies-2-archive-item-title-box-ins relative">
										<div class="space-companies-2-archive-item-title relative">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
										</div>

										<?php if( function_exists('aces_star_rating') ){ ?>
											<div class="space-companies-2-archive-item-rating relative">
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
										<div class="space-companies-2-archive-item-desc relative">
											<?php echo wp_kses( $casino_short_desc, $casino_allowed_html ); ?>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>