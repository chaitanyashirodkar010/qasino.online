<?php

function aces_organization_shortcode_1( $atts ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'hide_schema' => '',
			    'item_id' => '',
			    'float_bar' => '',
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
	$organization_promo_desc = wp_kses( get_post_meta( $item_id, 'casino_terms_desc', true ), $allowed_html );
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
		$organization_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
	} else {
		$organization_rating_stars_number_value = '5';
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
				    "bestRating": "<?php echo esc_attr($organization_rating_stars_number_value); ?>",
				    "worstRating": "1"
				},
				"datePublished": "<?php echo get_the_date( '', $item_id ); ?>",
				"reviewBody": "<?php echo esc_html( get_the_excerpt( $item_id ) ); ?>"
			}
		</script>

	<?php } ?>

	<div class="space-organization-single-1 box-100 text-center relative">

		<?php if ( $organization_logo_id ) { ?>

			<!-- Organization Logo Start -->

			<div class="space-organization-content-logo relative">

				<?php echo wp_get_attachment_image( $organization_logo_id, 'mercury-9999-135' ); ?>

			</div>

			<!-- Organization Logo End -->

		<?php } ?>

		<!-- Title Start -->

		<div class="space-organization-title-style-1 relative">
			<?php echo esc_html( get_the_title( $item_id ) ); ?>
		</div>

		<!-- Title End -->

		<?php if( function_exists('aces_star_rating') ){ ?>

			<!-- Organization Rating Start -->

			<div class="space-organization-content-logo-stars relative">
				<?php aces_star_rating(
					array(
						'rating' => $organization_overall_rating,
						'type' => 'rating',
						'stars_number' => $organization_rating_stars_number_value
					)
				); ?>
			</div>

			<!-- Organization Rating End -->

		<?php } ?>

		<?php if ($organization_short_desc) { ?>

			<!-- Short Description of the Organization Start -->

			<div class="space-organization-content-short-desc relative">
				<?php echo wp_kses( $organization_short_desc, $allowed_html ); ?>
			</div>
			
			<!-- Short Description of the Organization End -->

		<?php } ?>

		<?php
		if( function_exists('aces_geolocation') ) {
			if ( get_option( 'aces_geolocation_enable') ) { ?>

			<!-- Accepted users info Start -->

			<div class="space-header-accepted-info relative">
				<?php aces_geolocation( get_the_ID() ); ?>
			</div>
			
			<!-- Accepted users info End -->

			<?php }
		} ?>

		<!-- Button & Info Block Start -->

		<div class="space-organization-content-button-block relative">

			<!-- Info -->

			<?php if ($organization_promo_desc) { ?>
				<div class="space-organization-content-info relative">
					<?php echo wp_kses( $organization_promo_desc, $allowed_html ); ?>
				</div>
			<?php } ?>

			<!-- Button -->

			<?php if ($organization_external_link) { ?>
				<div class="space-organization-content-button relative">
					<a href="<?php echo esc_url( $organization_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" rel="nofollow" target="_blank"><?php echo esc_html( $button_title ); ?> <i class="fas fa-arrow-alt-circle-right"></i></a>
				</div>
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

				<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
					<?php echo wp_kses( $organization_button_notice, $allowed_html ); ?>
				</div>

				<!-- The notice below of the button End -->

			<?php } ?>

		</div>

		<!-- Button & Info Block End -->

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
								<div class="space-organization-float-bar-rating box-100 relative">
									<?php if( function_exists('aces_star_rating') ){
										aces_star_rating(
											array(
												'rating' => $organization_overall_rating,
												'type' => 'rating',
												'stars_number' => $organization_rating_stars_number_value
											)
										);
									} ?>
									<span><i class="fas fa-star"></i> <?php echo esc_html( number_format( (float)$organization_overall_rating, 1, '.', ',') ); ?>/<?php echo esc_html( $organization_rating_stars_number_value ); ?></span>
								</div>
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
 
add_shortcode('aces-organization-1', 'aces_organization_shortcode_1');