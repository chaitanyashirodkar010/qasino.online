<?php

function aces_organization_single_shortcode_3( $atts ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'hide_schema' => '',
			    'item_id' => '',
			    'float_bar' => '',
			    'dark_background' => ''
			),
			$atts
		)
	);

	if ( empty( $item_id ) ) {
		$item_id = get_the_ID();
	}

	$allowed_html = array(
		'a' => array(
			'href' => true,
			'title' => true,
			'target' => true,
			'rel' => true
		),
		'img' => array(
			'src' => true,
			'alt' => true
		),
		'br' => array(),
		'em' => array(),
		'strong' => array(),
		'span' => array(
			'class' => true,
			'style' => true
		),
		'div' => array(
			'class' => true,
			'style' => true
		),
		'p' => array(),
		'ul' => array(),
		'ol' => array(),
		'li' => array(),
	);

	$organization_short_desc = wp_kses( get_post_meta( $item_id, 'casino_short_desc', true ), $allowed_html );
	$organization_external_link = esc_url( get_post_meta( $item_id, 'casino_external_link', true ) );
	$organization_button_title = esc_html( get_post_meta( $item_id, 'casino_button_title', true ) );
	$organization_button_notice = wp_kses( get_post_meta( $item_id, 'casino_button_notice', true ), $allowed_html );
	$organization_overall_rating = esc_html( get_post_meta( $item_id, 'casino_overall_rating', true ) );
	$organization_detailed_tc = wp_kses( get_post_meta( $item_id, 'casino_detailed_tc', true ), $allowed_html );
	$organization_popup_hide = esc_attr( get_post_meta( $item_id, 'aces_organization_popup_hide', true ) );
	$organization_popup_title = esc_html( get_post_meta( $item_id, 'aces_organization_popup_title', true ) );

	$organization_logo_id = get_post_thumbnail_id( $item_id );

	if ($organization_button_title) {
		$button_title = $organization_button_title;
	} else {
		if ( get_option( 'casinos_play_now_title') ) {
			$button_title = esc_html( get_option( 'casinos_play_now_title') );
		} else {
			$button_title = esc_html__( 'Play Now', 'aces' );
		}
	}

	if ($organization_popup_title) {
		$custom_popup_title = $organization_popup_title;
	} else {
		$custom_popup_title = esc_html__( 'T&Cs Apply', 'aces' );
	}

	if ( get_option( 'aces_rating_stars_number' ) ) {
		$aces_rating_stars_number = get_option( 'aces_rating_stars_number' );
	} else {
		$aces_rating_stars_number = '5';
	}

	?>

	<?php if ( empty($hide_schema) ) {

		if (get_the_author_meta( 'url' )) {
			$author_schema_url = esc_url( get_the_author_meta( 'url' ));
		} else {
			$author_schema_url = esc_url( home_url( '/' ));
		}

		?>

		<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "Review",
				"itemReviewed": {
				    "@type": "Organization",
				    "name": "<?php echo esc_html( get_the_title( $item_id ) ); ?>",
				    "image": "<?php $src_schema = wp_get_attachment_image_src($organization_logo_id, 'full'); echo esc_url($src_schema[0]); ?>"
				},
				"author": {
				    "@type": "Person",
				    "name": "<?php echo esc_attr( get_the_author() ); ?>",
				    "url": "<?php echo esc_url( $author_schema_url ); ?>"
				},
				"reviewRating": {
				    "@type": "Rating",
				    "ratingValue": "<?php echo esc_attr($organization_overall_rating); ?>",
				    "bestRating": "<?php echo esc_attr($aces_rating_stars_number); ?>",
				    "worstRating": "1"
				},
				"datePublished": "<?php echo get_the_date( '', $item_id ); ?>",
				"reviewBody": "<?php echo esc_html( get_the_excerpt( $item_id ) ); ?>"
			}
		</script>

	<?php } ?>

	<div class="space-organization-single-3 box-100 relative <?php if ( $dark_background ) { ?>dark-background<?php } ?>">

		<div class="space-style-3-organization-header-elements box-100 relative">
			<div class="space-style-3-organization-header-left text-center box-25 relative">
				<div class="space-style-3-organization-header-left-ins relative">
					<div class="space-style-3-organization-header-logo-box relative">
						<?php
						$post_title_attr = the_title_attribute( 'echo=0' );
						if ( wp_get_attachment_image($organization_logo_id) ) {
							echo wp_get_attachment_image( $organization_logo_id, 'mercury-270-270', "", array( "alt" => $post_title_attr ) );
						} ?>
					</div>
				</div>
			</div>
			<div class="space-style-3-organization-header-right box-75 relative">
				<?php if ($organization_overall_rating) { ?>
					<div class="space-style-3-organization-header-rating absolute">
						<div class="space-rating-star-wrap relative">
							<div class="space-rating-star-background absolute"></div>
							<div class="space-rating-star-icon absolute">
								<i class="fas fa-star"></i>
							</div>
						</div>
						<strong><?php echo esc_html( number_format( (float)$organization_overall_rating, 1, '.', ',') ); ?></strong>/<?php echo esc_html( $aces_rating_stars_number ); ?>
					</div>
				<?php } ?>
				<div class="space-style-3-organization-header-right-ins box-100 relative">
					<div class="space-style-3-organization-header-title relative">
						<div class="space-style-3-organization-header-title-box relative">
							<div class="space-organization-header-title-box-ins box-100 relative">

								<!-- Title Start -->

								<span class="organization-title-3"><?php echo esc_html( get_the_title( $item_id ) ); ?></span>

								<!-- Title End -->

								<?php if ($organization_short_desc) { ?>

								<!-- Short Description of the Organization Start -->

								<div class="space-style-3-organization-header-short-desc relative">
									<?php echo wp_kses( $organization_short_desc, $allowed_html ); ?>
								</div>

								<!-- Short Description of the Organization End -->

								<?php } ?>

								<?php
								if( function_exists( 'aces_geolocation' ) ) {
									if ( get_option( 'aces_geolocation_enable') ) { ?>

									<!-- Accepted users info Start -->

									<div class="space-header-accepted-info relative">
										<?php aces_geolocation( get_the_ID() ); ?>
									</div>
									
									<!-- Accepted users info End -->

									<?php }
								} ?>

								<?php
								if ($organization_popup_hide == true ) {

								} else {
									if ($organization_detailed_tc) { ?>

										<div class="space-organizations-archive-item-detailed-tc box-100 relative">
											<div class="space-organizations-archive-item-detailed-tc-ins relative">
												<?php echo wp_kses( $organization_detailed_tc, $allowed_html ); ?>
											</div>
										</div>
										
									<?php
									}
								}
								?>

							</div>
						</div>
						<div class="space-style-3-organization-header-button relative">
							<div class="space-style-3-organization-header-button-ins text-center relative">

								<?php if ($organization_external_link) { ?>

								<!-- Button Start -->

								<a href="<?php echo esc_url( $organization_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" class="space-style-3-button" rel="nofollow" target="_blank"><?php echo esc_html( $button_title ); ?></a>

								<!-- Button End -->

								<?php } ?>

								<?php if ($organization_popup_hide == true ) { ?>
									<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
										<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
										<div class="tc-desc">
											<?php
												if ($organization_detailed_tc) {
													echo wp_kses( $organization_detailed_tc, $allowed_html );
												}
											?>
										</div>
									</div>
								<?php } ?>

								<?php if ($organization_button_notice) { ?>

								<!-- The notice below of the button Start -->

								<div class="space-style-3-organization-header-button-notice relative">
									<?php echo wp_kses( $organization_button_notice, $allowed_html ); ?>
								</div>

								<!-- The notice below of the button End -->

								<?php } ?>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>

	<?php if ( !empty($float_bar) ) { ?>

		<!-- Organization Float Bar Start -->

		<script type="text/javascript">
		jQuery(document).ready(function($) {
			'use strict';

				var stickyOffset = $('.space-organization-float-bar-bg').offset().top;

				$(window).scroll(function(){
					'use strict';
				  var sticky = $('.space-organization-float-bar-bg'),
				      scroll = $(window).scrollTop();
				    
				  if (scroll >= 400) sticky.addClass('show');
				  else sticky.removeClass('show');
				});

		});
		</script>

		<style type="text/css">
		.space-footer {
		    padding-bottom: 110px;
		}
		@media screen and (max-width: 479px) {
			.single .space-footer,
			.page .space-footer {
			    padding-bottom: 100px;
			}
			.single #scrolltop.show,
			.page #scrolltop.show {
			    opacity: 1;
			    visibility: visible;
			    bottom: 120px;
			}
		}
		</style>

		<div class="space-organization-float-bar-bg box-100">
			<div class="space-organization-float-bar-bg-ins space-page-wrapper relative">
				<div class="space-organization-float-bar relative">
					<div class="space-organization-float-bar-data box-75 relative">
						<div class="space-organization-float-bar-data-ins relative">

							<?php if ( $organization_logo_id ) { ?>

								<div class="space-organization-float-bar-logo relative">
									<div class="space-organization-float-bar-logo-img relative">
										<?php echo wp_get_attachment_image( $organization_logo_id, 'mercury-100-100' ); ?>
									</div>
								</div>

							<?php } ?>

							<div class="space-organization-float-bar-title box-50 relative">
								<div class="space-organization-float-bar-title-wrap box-100 relative">
									<?php echo esc_html( get_the_title( $item_id ) ); ?>
								</div>
								
								<?php if ($organization_overall_rating) { ?>
									<div class="space-organization-float-bar-rating box-100 relative">
										<?php if( function_exists('aces_star_rating') ){
											mercurymaker_star_rating(
												array(
													'rating' => $organization_overall_rating,
													'type' => 'rating',
													'stars_number' => $aces_rating_stars_number
												)
											);
										} ?>
										<span><i class="fas fa-star"></i> <?php echo esc_html( number_format( (float)$organization_overall_rating, 1, '.', ',') ); ?>/<?php esc_html_e( $aces_rating_stars_number ); ?></span>
									</div>
								<?php } ?>

							</div>
						</div>
					</div>

					<?php if ( $organization_external_link ) { ?>

						<div class="space-organization-float-bar-button box-25 relative">
							<div class="space-organization-float-bar-button-all text-center relative">
								<div class="space-organization-float-bar-button-ins relative">
									<div class="space-organization-float-bar-button-wrap relative">
										<a href="<?php echo esc_url( $organization_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" target="_blank" rel="nofollow">
											<?php echo esc_html( $button_title ); ?>
										</a>
									</div>
								</div>
							</div>
						</div>

					<?php } ?>

				</div>
			</div>
		</div>

		<!-- Organization Float Bar End -->

	<?php } ?>

	<?php
	wp_reset_postdata();
	$organization_item = ob_get_clean();
	return $organization_item;

}
 
add_shortcode('aces-organization-3', 'aces_organization_single_shortcode_3');