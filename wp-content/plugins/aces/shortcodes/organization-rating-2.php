<?php

function aces_rating_shortcode_2( $atts ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'item_id' => '',
			    'hide_ratings' => '',
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
			'class' => true
		),
		'p' => array(),
		'ul' => array(),
		'ol' => array(),
		'li' => array(),
	);

	$organization_promo_desc = wp_kses( get_post_meta( $item_id, 'casino_terms_desc', true ), $allowed_html );
	$organization_external_link = esc_url( get_post_meta( $item_id, 'casino_external_link', true ) );
	$organization_button_title = esc_html( get_post_meta( $item_id, 'casino_button_title', true ) );
	$organization_button_notice = wp_kses( get_post_meta( $item_id, 'casino_button_notice', true ), $allowed_html );
	$organization_detailed_tc = wp_kses( get_post_meta( $item_id, 'casino_detailed_tc', true ), $allowed_html );
	$organization_popup_title = esc_html( get_post_meta( $item_id, 'aces_organization_popup_title', true ) );

	$organization_rating_trust = esc_html( get_post_meta( $item_id, 'casino_rating_trust', true ) );
	$organization_rating_games = esc_html( get_post_meta( $item_id, 'casino_rating_games', true ) );
	$organization_rating_bonus = esc_html( get_post_meta( $item_id, 'casino_rating_bonus', true ) );
	$organization_rating_customer = esc_html( get_post_meta( $item_id, 'casino_rating_customer', true ) );
	$organization_overall_rating = esc_html( get_post_meta( $item_id, 'casino_overall_rating', true ) );

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

	<div class="space-organization-style-2-calltoaction-rating relative">
		<div class="space-organization-style-2-calltoaction-rating-ins box-100 relative">
			<div class="space-organization-style-2-calltoaction-block box-100 relative">
				<div class="space-organization-style-2-calltoaction-text box-66 relative">

					<?php if ($organization_promo_desc) { ?>

					<!-- Terms Start -->

					<div class="space-organization-style-2-calltoaction-text-ins relative">
						<?php echo wp_kses( $organization_promo_desc, $allowed_html ); ?>
					</div>

					<!-- Terms End -->

					<?php } ?>

				</div>
				<div class="space-organization-style-2-calltoaction-button box-33 text-right relative">

					<?php if ($organization_external_link) { ?>

					<!-- Button Start -->

					<div class="space-organization-style-2-calltoaction-button-ins text-center relative">
						<a href="<?php echo esc_url( $organization_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" class="space-calltoaction-button" rel="nofollow" target="_blank"><?php echo esc_html( $button_title ); ?> <i class="fas fa-arrow-alt-circle-right"></i></a>

						<?php if ($organization_detailed_tc) { ?>

							<div class="space-organization-style-2-calltoaction-button-notice relative">
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

							<div class="space-organization-style-2-calltoaction-button-notice relative">
								<?php echo wp_kses( $organization_button_notice, $allowed_html ); ?>
							</div>

							<!-- The notice below of the button End -->

						<?php } ?>

					</div>

					<!-- Button End -->

					<?php } ?>

				</div>
			</div>

			<?php if ( empty($hide_ratings) ) { ?>

			<div class="space-organization-style-2-ratings-block box-100 relative">
				<div class="space-organization-style-2-ratings-all box-66 relative">
					<div class="space-organization-style-2-ratings-all-ins box-100 relative">

						<?php if ($organization_rating_trust) { ?>
						<div class="space-organization-style-2-ratings-all-item box-50 relative">
							<div class="space-organization-style-2-ratings-all-item-ins relative">
								<div class="space-organization-style-2-ratings-all-item-value relative">
									<?php echo esc_html( number_format( (float)$organization_rating_trust, 1, '.', ',') ); ?> <i class="fas fa-star"></i>
								</div>
								<?php
								$rating_1_title = get_option( 'rating_1' );
								if ( $rating_1_title ) {
									echo esc_html($rating_1_title);
								} else {
									esc_html_e( 'Trust & Fairness', 'aces' );
								} ?>
							</div>
						</div>
						<?php } ?>

						<?php if ($organization_rating_games) { ?>
						<div class="space-organization-style-2-ratings-all-item box-50 relative">
							<div class="space-organization-style-2-ratings-all-item-ins relative">
								<div class="space-organization-style-2-ratings-all-item-value relative">
									<?php echo esc_html( number_format( (float)$organization_rating_games, 1, '.', ',') ); ?> <i class="fas fa-star"></i>
								</div>
								<?php
								$rating_2_title = get_option( 'rating_2' );
								if ( $rating_2_title ) {
									echo esc_html($rating_2_title);
								} else {
									esc_html_e( 'Games & Software', 'aces' );
								} ?>
							</div>
						</div>
						<?php } ?>

						<?php if ($organization_rating_bonus) { ?>
						<div class="space-organization-style-2-ratings-all-item box-50 relative">
							<div class="space-organization-style-2-ratings-all-item-ins relative">
								<div class="space-organization-style-2-ratings-all-item-value relative">
									<?php echo esc_html( number_format( (float)$organization_rating_bonus, 1, '.', ',') ); ?> <i class="fas fa-star"></i>
								</div>
								<?php
								$rating_3_title = get_option( 'rating_3' );
								if ( $rating_3_title ) {
									echo esc_html($rating_3_title);
								} else {
									esc_html_e( 'Bonuses & Promotions', 'aces' );
								} ?>
							</div>
						</div>
						<?php } ?>

						<?php if ($organization_rating_customer) { ?>
						<div class="space-organization-style-2-ratings-all-item box-50 relative">
							<div class="space-organization-style-2-ratings-all-item-ins relative">
								<div class="space-organization-style-2-ratings-all-item-value relative">
									<?php echo esc_html( number_format( (float)$organization_rating_customer, 1, '.', ',') ); ?> <i class="fas fa-star"></i>
								</div>
								<?php
								$rating_4_title = get_option( 'rating_4' );
								if ( $rating_4_title ) {
									echo esc_html($rating_4_title);
								} else {
									esc_html_e( 'Customer Support', 'aces' );
								} ?>
							</div>
						</div>
						<?php } ?>

					</div>
				</div>
				<div class="space-organization-style-2-rating-overall box-33 relative">
					<div class="space-organization-style-2-rating-overall-ins text-center relative">
						<?php echo esc_html( number_format( (float)$organization_overall_rating, 1, '.', ',') ); ?>
						<span>
							<?php
							$rating_overall_title = get_option( 'rating_overall' );
							if ( $rating_overall_title ) {
								echo esc_html($rating_overall_title);
							} else {
								esc_html_e( 'Overall Rating', 'aces' );
							} ?>
						</span>
					</div>
				</div>
			</div>

			<?php } ?>

		</div>
	</div>

	<?php

	wp_reset_postdata();
	$aces_organization_rating = ob_get_clean();
	return $aces_organization_rating;

}
 
add_shortcode('aces-rating-2', 'aces_rating_shortcode_2');