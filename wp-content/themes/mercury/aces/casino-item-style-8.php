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
$casino_terms_desc = wp_kses( get_post_meta( get_the_ID(), 'casino_terms_desc', true ), $casino_allowed_html );
$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
$casino_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_permalink_button_title', true ) );
$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

$organization_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'casino_detailed_tc', true ), $casino_allowed_html );
$organization_popup_hide = esc_attr( get_post_meta( get_the_ID(), 'aces_organization_popup_hide', true ) );
$organization_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_organization_popup_title', true ) );

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

if ($organization_popup_title) {
	$custom_popup_title = $organization_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
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

<div class="space-organizations-8-archive-item box-100 relative">
	<div class="space-organizations-8-archive-item-ins relative">
		<div class="space-organizations-8-archive-item-bg box-100 relative">
			<div class="space-organizations-8-archive-item-left box-33 relative">

					<div class="space-organizations-8-archive-item-brand box-100 relative">
						<div class="space-organizations-8-archive-item-brand-logo box-40 relative">
							<div class="space-organizations-8-archive-item-brand-logo-ins relative">

								<?php
								$post_title_attr = the_title_attribute( 'echo=0' );
								if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-135-135', "", array( "alt" => $post_title_attr ) ); ?>
								</a>
								<?php } ?>
							
							</div>
						</div>
						<div class="space-organizations-8-archive-item-brand-name text-center box-60 relative">
							<div class="space-organizations-8-archive-item-brand-name-link box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</div>

							<?php if( function_exists('aces_star_rating') ){ ?>
								<div class="space-organizations-8-archive-item-stars-rating relative">
									<?php aces_star_rating(
										array(
											'rating' => $casino_overall_rating,
											'type' => 'rating',
											'stars_number' => $casino_rating_stars_number_value
										)
									); ?>
								</div>
							<?php } ?>

						</div>
					</div>

			</div>
			<div class="space-organizations-8-archive-item-central box-33 relative">
				<div class="space-organizations-8-archive-item-ins-pd relative">
					<div class="space-organizations-8-archive-item-terms box-100 relative">
						<?php if ($casino_terms_desc) {
							echo wp_kses( $casino_terms_desc, $casino_allowed_html );
						} ?>
					</div>
				</div>
			</div>
			<div class="space-organizations-8-archive-item-right box-33 relative">
				
					<div class="space-organizations-8-archive-item-buttons box-100 relative">
						<div class="space-organizations-8-archive-item-buttons-left box-50 text-center relative">

							<div class="space-organizations-8-archive-item-button-one box-100 relative">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
							</div>

							<?php if ($organization_popup_hide == true ) { ?>
								<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
									<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
									<div class="tc-desc">
										<?php
											if ($organization_detailed_tc) {
												echo wp_kses( $organization_detailed_tc, $casino_allowed_html );
											}
										?>
									</div>
								</div>
							<?php } ?>

							<?php if ($casino_button_notice) { ?>
								<div class="space-organizations-8-archive-item-button-notice box-100 relative" style="margin-top: 5px;">
									<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>
								</div>
							<?php } ?>

						</div>
						<div class="space-organizations-8-archive-item-buttons-right box-50 text-center relative">
							<div class="space-organizations-8-archive-item-button-two relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
							</div>
						</div>
					</div>
			
			</div>
		</div>

		<?php
		if ($organization_popup_hide == true ) {

		} else {
			if ($organization_detailed_tc) { ?>
		<div class="space-organizations-archive-item-detailed-tc box-100 relative">
			<div class="space-organizations-archive-item-detailed-tc-ins relative" style="padding-top: 5px;">
				<?php echo wp_kses( $organization_detailed_tc, $casino_allowed_html ); ?>
			</div>
		</div>
		<?php
			}
		}
		?>
		
	</div>
</div>