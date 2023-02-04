<?php

function aces_rating_shortcode_1( $atts ) {

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

	$organization_rating_trust = esc_html( get_post_meta( $item_id, 'casino_rating_trust', true ) );
	$organization_rating_games = esc_html( get_post_meta( $item_id, 'casino_rating_games', true ) );
	$organization_rating_bonus = esc_html( get_post_meta( $item_id, 'casino_rating_bonus', true ) );
	$organization_rating_customer = esc_html( get_post_meta( $item_id, 'casino_rating_customer', true ) );
	$organization_overall_rating = esc_html( get_post_meta( $item_id, 'casino_overall_rating', true ) );

	if ( get_option( 'aces_rating_stars_number' ) ) {
		$organization_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
	} else {
		$organization_rating_stars_number_value = '5';
	}

	?>

	<div class="space-organization-content-rating-wrap relative">
		<div class="space-organization-content-rating-logo relative">
			<div class="space-organization-content-rating-logo-ins absolute">
				<?php
				$post_title_attr = the_title_attribute( 'echo=0' );
				if ( wp_get_attachment_image(get_post_thumbnail_id( $item_id )) ) {
					echo wp_get_attachment_image( get_post_thumbnail_id( $item_id ), 'mercury-100-100', "", array( "alt" => $post_title_attr ) );
				} ?>
			</div>
		</div>
		<div class="space-organization-content-rating relative">
			<div class="space-organization-content-rating-ins text-center relative">
				<div class="space-organization-content-rating-overall relative">
					<label>
						<?php
						$rating_overall_title = get_option( 'rating_overall' );
						if ( $rating_overall_title ) {
							echo esc_html($rating_overall_title);
						} else {
							esc_html_e( 'Overall Rating', 'aces' );
						} ?>
					</label>
					<?php if( function_exists('aces_star_rating') ){
						aces_star_rating(
							array(
								'rating' => $organization_overall_rating,
								'type' => 'rating',
								'stars_number' => $organization_rating_stars_number_value
							)
						);
					} ?>
				</div>

				<?php if ( empty($hide_ratings) ) { ?>

					<div class="space-organization-content-rating-items box-100 relative">

						<?php if ($organization_rating_trust) { ?>
						<div class="space-organization-content-rating-item box-50 relative">
							<label>
								<?php
								$rating_1_title = get_option( 'rating_1' );
								if ( $rating_1_title ) {
									echo esc_html($rating_1_title);
								} else {
									esc_html_e( 'Trust & Fairness', 'aces' );
								} ?>
							</label>
							<div class="space-organization-content-rating-stars relative">
								<?php if( function_exists('aces_star_rating') ){
									aces_star_rating(
										array(
											'rating' => $organization_rating_trust,
											'type' => 'rating',
											'stars_number' => $organization_rating_stars_number_value
										)
									);
								} ?>
							</div>
						</div>
						<?php } ?>

						<?php if ($organization_rating_games) { ?>
						<div class="space-organization-content-rating-item box-50 relative">
							<label>
								<?php
								$rating_2_title = get_option( 'rating_2' );
								if ( $rating_2_title ) {
									echo esc_html($rating_2_title);
								} else {
									esc_html_e( 'Games & Software', 'aces' );
								} ?>
							</label>
							<div class="space-organization-content-rating-stars relative">
								<?php if( function_exists('aces_star_rating') ){
									aces_star_rating(
										array(
											'rating' => $organization_rating_games,
											'type' => 'rating',
											'stars_number' => $organization_rating_stars_number_value
										)
									);
								} ?>
							</div>
						</div>
						<?php } ?>

						<?php if ($organization_rating_bonus) { ?>
						<div class="space-organization-content-rating-item box-50 relative">
							<label>
								<?php
								$rating_3_title = get_option( 'rating_3' );
								if ( $rating_3_title ) {
									echo esc_html($rating_3_title);
								} else {
									esc_html_e( 'Bonuses & Promotions', 'aces' );
								} ?>
							</label>
							<div class="space-organization-content-rating-stars relative">
								<?php if( function_exists('aces_star_rating') ){
									aces_star_rating(
										array(
											'rating' => $organization_rating_bonus,
											'type' => 'rating',
											'stars_number' => $organization_rating_stars_number_value
										)
									);
								} ?>
							</div>
						</div>
						<?php } ?>

						<?php if ($organization_rating_customer) { ?>
						<div class="space-organization-content-rating-item box-50 relative">
							<label>
								<?php
								$rating_4_title = get_option( 'rating_4' );
								if ( $rating_4_title ) {
									echo esc_html($rating_4_title);
								} else {
									esc_html_e( 'Customer Support', 'aces' );
								} ?>
							</label>
							<div class="space-organization-content-rating-stars relative">
								<?php if( function_exists('aces_star_rating') ){
									aces_star_rating(
										array(
											'rating' => $organization_rating_customer,
											'type' => 'rating',
											'stars_number' => $organization_rating_stars_number_value
										)
									);
								} ?>
							</div>
						</div>
						<?php } ?>

					</div>

				<?php } ?>

			</div>
		</div>
	</div>

	<?php

	wp_reset_postdata();
	$aces_organization_rating = ob_get_clean();
	return $aces_organization_rating;

}
 
add_shortcode('aces-rating-1', 'aces_rating_shortcode_1');