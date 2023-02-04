<?php

function aces_unit_single_shortcode_1( $atts ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'item_id' => ''
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
	$unit_detailed_tc = wp_kses( get_post_meta( $item_id, 'unit_detailed_tc', true ), $allowed_html );
	$unit_popup_hide = esc_attr( get_post_meta( $item_id, 'aces_unit_popup_hide', true ) );
	$unit_popup_title = esc_html( get_post_meta( $item_id, 'aces_unit_popup_title', true ) );

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

	$unit_logo_id = get_post_thumbnail_id( $item_id );

	?>

	<div class="space-unit-single-1 box-100 relative">
		<div class="space-unit-single-1-ins relative">

			<?php
			$post_title_attr = the_title_attribute( 'echo=0' );
			if ( wp_get_attachment_image($unit_logo_id) ) {
			?>

			<div class="space-page-content-featured-img box-100 relative" style="margin-bottom: 15px;">
				<?php echo wp_get_attachment_image( $unit_logo_id, 'mercury-450-317', "", array( "alt" => $post_title_attr ) ); ?>
			</div>
			<?php } ?>

			<span class="unit-title-1"><?php echo esc_html( get_the_title( $item_id ) ); ?></span>

			<!-- Vendors Start -->

			<?php
			$vendors = get_the_terms( $item_id, 'vendor' );
			if ($vendors) { ?>
				<div class="space-vendors box-100 relative">
					<span>
						<?php echo esc_html__( 'by', 'aces' ); ?>
					</span>
					<div class="space-vendors-items box-100 relative">
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

			<!-- Vendors End -->

			<?php if ($unit_short_desc) { ?>
			<div class="space-unit-content-short-desc relative">
				<?php echo wp_kses( $unit_short_desc, $allowed_html ); ?>
			</div>
			<?php } ?>

			<?php if(has_excerpt( $item_id )) { ?>
			<div class="space-unit-content-excerpt relative">
				<?php echo esc_html( get_the_excerpt( $item_id ) ); ?>
			</div>
			<?php } ?>

			<?php if ($unit_external_link) { ?>
			<div class="space-unit-content-button-wrap text-center relative">
				<div class="space-unit-content-button relative">
					<a href="<?php echo esc_url( $unit_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" target="_blank" rel="nofollow"><?php echo esc_html( $button_title ); ?> <i class="fas fa-arrow-alt-circle-right"></i></a>
				</div>

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

				<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
					<?php echo wp_kses( $unit_button_notice, $allowed_html ); ?>
				</div>

				<!-- The notice below of the button End -->

				<?php } ?>

			</div>
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

	<?php
	wp_reset_postdata();
	$unit_item = ob_get_clean();
	return $unit_item;

}
 
add_shortcode('aces-unit-1', 'aces_unit_single_shortcode_1');