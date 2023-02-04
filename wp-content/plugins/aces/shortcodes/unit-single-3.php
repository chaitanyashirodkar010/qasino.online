<?php

function aces_unit_single_shortcode_3( $atts ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'item_id' => '',
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

	$unit_short_desc = wp_kses( get_post_meta( $item_id, 'game_short_desc', true ), $allowed_html );
	$unit_external_link = esc_url( get_post_meta( $item_id, 'game_external_link', true ) );
	$unit_button_title = esc_html( get_post_meta( $item_id, 'game_button_title', true ) );
	$unit_button_notice = wp_kses( get_post_meta( $item_id, 'game_button_notice', true ), $allowed_html );
	$unit_rating = esc_html( get_post_meta( $item_id, 'game_rating_one', true ) );
	$unit_detailed_tc = wp_kses( get_post_meta( $item_id, 'unit_detailed_tc', true ), $allowed_html );
	$unit_popup_hide = esc_attr( get_post_meta( $item_id, 'aces_unit_popup_hide', true ) );
	$unit_popup_title = esc_html( get_post_meta( $item_id, 'aces_unit_popup_title', true ) );

	$unit_logo_id = get_post_thumbnail_id( $item_id );

	if ($unit_button_title) {
		$button_title = $unit_button_title;
	} else {
		if ( get_option( 'games_play_now_title') ) {
			$button_title = esc_html( get_option( 'games_play_now_title') );
		} else {
			$button_title = esc_html__( 'Play Now', 'aces' );
		}
	}

	if ($unit_popup_title) {
		$custom_popup_title = $unit_popup_title;
	} else {
		$custom_popup_title = esc_html__( 'T&Cs Apply', 'aces' );
	}

	if ( get_option( 'aces_game_rating_stars_number' ) ) {
		$aces_rating_stars_number = get_option( 'aces_game_rating_stars_number' );
	} else {
		$aces_rating_stars_number = '5';
	}

	?>

	<div class="space-organization-single-3 box-100 relative unit-page-style-3 <?php if ( $dark_background ) { ?>dark-background<?php } ?>">

		<div class="space-style-3-organization-header-elements box-100 relative">
			<div class="space-style-3-organization-header-left text-center box-25 relative">
				<div class="space-style-3-organization-header-left-ins relative">
					<div class="space-style-3-organization-header-logo-box relative">
						<?php
						$post_title_attr = the_title_attribute( 'echo=0' );
						if ( wp_get_attachment_image($unit_logo_id) ) {
							echo wp_get_attachment_image( $unit_logo_id, 'mercury-270-270', "", array( "alt" => $post_title_attr ) );
						} ?>
					</div>
				</div>
			</div>
			<div class="space-style-3-organization-header-right box-75 relative">
				<?php if ($unit_rating) { ?>
					<div class="space-style-3-organization-header-rating absolute">
						<div class="space-rating-star-wrap relative">
							<div class="space-rating-star-background absolute"></div>
							<div class="space-rating-star-icon absolute">
								<i class="fas fa-star"></i>
							</div>
						</div>
						<strong><?php echo esc_html( number_format( (float)$unit_rating, 1, '.', ',') ); ?></strong>/<?php echo esc_html( $aces_rating_stars_number ); ?>
					</div>
				<?php } ?>
				<div class="space-style-3-organization-header-right-ins box-100 relative">
					<div class="space-style-3-organization-header-title relative">
						<div class="space-style-3-organization-header-title-box relative">
							<div class="space-organization-header-title-box-ins box-100 relative">

								<!-- Title Start -->

								<span class="organization-title-3"><?php echo esc_html( get_the_title( $item_id ) ); ?></span>

								<!-- Title End -->

								<?php if ($unit_short_desc) { ?>

								<!-- Short Description of the Unit Start -->

								<div class="space-style-3-organization-header-short-desc relative">
									<?php echo wp_kses( $unit_short_desc, $allowed_html ); ?>
								</div>

								<!-- Short Description of the Unit End -->

								<?php } ?>

								<?php
								if ($unit_popup_hide == true ) {

								} else {
									if ($unit_detailed_tc) { ?>

										<div class="space-organizations-archive-item-detailed-tc box-100 relative">
											<div class="space-organizations-archive-item-detailed-tc-ins relative">
												<?php echo wp_kses( $unit_detailed_tc, $allowed_html ); ?>
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

								<?php if ($unit_external_link) { ?>

								<!-- Button Start -->

								<a href="<?php echo esc_url( $unit_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" class="space-style-3-button" rel="nofollow" target="_blank"><?php echo esc_html( $button_title ); ?></a>

								<!-- Button End -->

								<?php } ?>

								<?php if ($unit_popup_hide == true ) { ?>
									<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
										<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
										<div class="tc-desc">
											<?php
												if ($unit_detailed_tc) {
													echo wp_kses( $unit_detailed_tc, $allowed_html );
												}
											?>
										</div>
									</div>
								<?php } ?>

								<?php if ($unit_button_notice) { ?>

								<!-- The notice below of the button Start -->

								<div class="space-style-3-organization-header-button-notice relative">
									<?php echo wp_kses( $unit_button_notice, $allowed_html ); ?>
								</div>

								<!-- The notice below of the button End -->

								<?php } ?>

							</div>

						</div>
					</div>
				</div>

				<!-- Vendor Start -->

				<?php
				$vendors = get_the_terms( $item_id, 'vendor' );
				if ($vendors) { ?>
					<div class="space-vendors absolute">
						<div class="space-vendors-items box-100 relative">
							<span>
								<?php echo esc_html__( 'by', 'aces' ); ?>
							</span>
							<?php foreach ( $vendors as $vendor ) { ?>
								<?php
								$vendor_logo = get_term_meta($vendor->term_id, 'taxonomy-image-id', true);
								if ($vendor_logo) { ?>
									<a href="<?php echo esc_url (get_term_link( (int)$vendor->term_id, $vendor->taxonomy )); ?>" title="<?php echo esc_attr($vendor->name); ?>" class="space-vendors-item">
										<?php echo wp_get_attachment_image( $vendor_logo, 'mercury-9999-32', "", array( "class" => "space-vendor-logo" ) );  ?>
									</a>
								<?php } else {  ?>
									<a href="<?php echo esc_url (get_term_link( (int)$vendor->term_id, $vendor->taxonomy )); ?>" title="<?php echo esc_attr($vendor->name); ?>" class="space-vendors-item name">
										<?php echo esc_html($vendor->name); ?>
									</a>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<!-- Vendor End -->

			</div>
		</div>
		
	</div>

	<?php
	wp_reset_postdata();
	$unit_item = ob_get_clean();
	return $unit_item;

}
 
add_shortcode('aces-unit-3', 'aces_unit_single_shortcode_3');