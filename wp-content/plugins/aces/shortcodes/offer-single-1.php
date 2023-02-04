<?php

function aces_offer_single_shortcode_1( $atts ) {

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

	$offer_short_desc = wp_kses( get_post_meta( $item_id, 'bonus_short_desc', true ), $allowed_html );
	$offer_external_link = esc_url( get_post_meta( $item_id, 'bonus_external_link', true ) );
	$offer_button_title = esc_html( get_post_meta( $item_id, 'bonus_button_title', true ) );
	$offer_button_notice = wp_kses( get_post_meta( $item_id, 'bonus_button_notice', true ), $allowed_html );
	$offer_code = esc_html( get_post_meta( $item_id, 'bonus_code', true ) );
	$offer_valid_date = esc_html( get_post_meta( $item_id, 'bonus_valid_date', true ) );
	$offer_popup_hide = esc_attr( get_post_meta( $item_id, 'aces_offer_popup_hide', true ) );
	$offer_popup_title = esc_html( get_post_meta( $item_id, 'aces_offer_popup_title', true ) );
	$offer_detailed_tc = wp_kses( get_post_meta( $item_id, 'offer_detailed_tc', true ), $allowed_html );

	if ($offer_button_title) {
		$button_title = $offer_button_title;
	} else {
		if ( get_option( 'bonuses_get_bonus_title') ) {
			$button_title = esc_html( get_option( 'bonuses_get_bonus_title') );
		} else {
			$button_title = esc_html__( 'Get Bonus', 'aces' );
		}
	}

	if ($offer_popup_title) {
		$custom_popup_title = $offer_popup_title;
	} else {
		$custom_popup_title = esc_html__( 'T&Cs Apply', 'aces' );
	}

	?>

	<div class="space-offer-single-1 box-100 relative space-single-offer <?php if ($dark_background) { ?>space-dark-style<?php } ?>">

		<div class="space-aces-single-offer-box box-100 text-center relative">
			<div class="space-aces-single-offer-info box-100 relative">
				<div class="space-aces-single-offer-info-ins relative">
					<div class="space-aces-single-offer-info-ins-wrap relative">
						<div class="space-aces-single-offer-info-cat relative">

							<?php $terms = get_the_terms( $item_id, 'bonus-category' );

								if ($terms) {
					            foreach ( $terms as $term ) { ?>
					                <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
					        <?php }

					    	} ?>

						</div>
						<div class="space-aces-single-offer-info-title relative">
							<span class="offer-title-1"><?php echo esc_html( get_the_title( $item_id ) ); ?></span>
						</div>

						<?php if ($offer_short_desc) { ?>
						<div class="space-aces-single-offer-info-short-desc relative">
							<?php echo wp_kses( $offer_short_desc, $allowed_html ); ?>
						</div>
						<?php } ?>

						<div class="space-aces-single-offer-info-code-button box-100 relative"<?php if (! $offer_short_desc) { ?> style="padding-top: 85px;"<?php } ?>>

							<?php if ($offer_code) { ?>

							<div class="space-aces-single-offer-info-code box-60 left relative">
								<div class="space-aces-single-offer-info-code-ins relative">
									<fieldset class="space-aces-single-offer-info-code-value relative">
										<legend><?php esc_html_e( 'Bonus Code', 'aces' ); ?></legend>
										<span>
											<?php echo esc_html( $offer_code ); ?>
										</span>
									</fieldset>
									<?php if ($offer_valid_date) { ?>
									<div class="space-aces-single-offer-info-code-date relative">
										<?php esc_html_e( 'Valid Until:', 'aces' ); ?> <span><?php echo esc_html( date_i18n('M d, Y',strtotime($offer_valid_date))); ?></span>
									</div>
									<?php } ?>

								</div>
							</div>

							<?php } ?>

							<div class="space-aces-single-offer-info-button <?php if ($offer_code) { ?>box-40 right<?php } else { ?>box-100<?php } ?> relative">
								<div class="space-aces-single-offer-info-button-ins text-center relative">
									<a href="<?php echo esc_url( $offer_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" target="_blank" rel="nofollow"><?php echo esc_html( $button_title ); ?> <i class="fas fa-arrow-alt-circle-right"></i></a>
								</div>

								<?php if ($offer_button_notice) { ?>

								<!-- The notice below of the button Start -->

								<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
									<?php echo wp_kses( $offer_button_notice, $allowed_html ); ?>
								</div>

								<!-- The notice below of the button End -->

								<?php } ?>

								<?php
								if ($offer_popup_hide == true ) {
								?>
									<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
										<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
										<div class="tc-desc">
											<?php
												if ($offer_detailed_tc) {
													echo wp_kses( $offer_detailed_tc, $allowed_html );
												}
											?>
										</div>
									</div>
								<?php } ?>

							</div>
						</div>

						<?php
						if ($offer_popup_hide == true ) {

						} else {
							if ($offer_detailed_tc) { ?>

								<div class="space-organizations-archive-item-detailed-tc box-100 relative">
									<div class="space-organizations-archive-item-detailed-tc-ins relative">
										<?php echo wp_kses( $offer_detailed_tc, $allowed_html ); ?>
									</div>
								</div>
								
							<?php
							}
						}
						?>

					</div>
				</div>
			</div>
		</div>

	</div>

	<?php
	wp_reset_postdata();
	$offer_item = ob_get_clean();
	return $offer_item;

}
 
add_shortcode('aces-offer-1', 'aces_offer_single_shortcode_1');