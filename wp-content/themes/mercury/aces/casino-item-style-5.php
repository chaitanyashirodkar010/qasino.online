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
$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
$casino_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_permalink_button_title', true ) );
$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

$organization_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'casino_detailed_tc', true ), $casino_allowed_html );
$organization_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_organization_popup_title', true ) );

if ($casino_external_link) {
	$external_link_url = $casino_external_link;
} else {
	$external_link_url = get_the_permalink();
}

if ($organization_popup_title) {
	$custom_popup_title = $organization_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
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

<div class="space-organizations-4-archive-item box-25 relative">
	<div class="space-organizations-4-archive-item-ins relative">
		<div class="space-organizations-4-archive-item-top box-100 relative">
			<div class="space-organizations-4-archive-item-logo relative">
				<?php
				$post_title_attr = the_title_attribute( 'echo=0' );
				if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-50-50', "", array( "alt" => $post_title_attr ) ); ?>
				</a>
				<?php } ?>
			</div>
			<div class="space-organizations-4-archive-item-title relative">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				<?php if( function_exists('aces_star_rating') ){
					aces_star_rating(
						array(
							'rating' => $casino_overall_rating,
							'type' => 'rating',
							'stars_number' => $casino_rating_stars_number_value
						)
					);
				} ?>
			</div>
		</div>
		<?php if ($casino_short_desc) { ?>
		<div class="space-organizations-4-archive-item-desc box-100 relative">
			<?php echo wp_kses( $casino_short_desc, $casino_allowed_html ); ?>
		</div>
		<?php } ?>
		<div class="space-organizations-4-archive-item-buttons box-100 relative">
			<div class="space-organizations-4-archive-item-button-one box-50 relative">
				<div class="space-organizations-4-archive-item-button-one-ins text-center relative">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
				</div>
			</div>
			<div class="space-organizations-4-archive-item-button-two box-50 relative">
				<div class="space-organizations-4-archive-item-button-two-ins text-center relative">
					<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($casino_external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
				</div>
			</div>
		</div>

		<?php if ($organization_detailed_tc) { ?>
			<div class="space-organizations-archive-item-button-notice text-center box-100 relative" style="margin-top: 5px;">
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

		<div class="space-organizations-archive-item-button-notice text-center box-100 relative" style="margin-top: 5px;">
			<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>
		</div>

		<?php } ?>

	</div>
</div>