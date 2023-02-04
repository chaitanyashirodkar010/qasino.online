<?php
global $post;
$game_allowed_html = array(
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

$game_external_link = esc_url( get_post_meta( get_the_ID(), 'game_external_link', true ) );
$game_button_title = esc_html( get_post_meta( get_the_ID(), 'game_button_title', true ) );
$game_button_notice = wp_kses( get_post_meta( get_the_ID(), 'game_button_notice', true ), $game_allowed_html );
$game_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'game_permalink_button_title', true ) );
$game_rating = esc_html( get_post_meta( get_the_ID(), 'game_rating_one', true ) );
$unit_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_unit_popup_title', true ) );

$unit_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'unit_detailed_tc', true ), $game_allowed_html );

if ($game_button_title) {
	$button_title = $game_button_title;
} else {
	if ( get_option( 'games_play_now_title') ) {
		$button_title = esc_html( get_option( 'games_play_now_title') );
	} else {
		$button_title = esc_html__( 'Play Now', 'mercury' );
	}
}

if ($game_external_link) {
	$external_link_url = $game_external_link;
} else {
	$external_link_url = get_the_permalink();
}

if ($game_permalink_button_title) {
	$permalink_button_title = $game_permalink_button_title;
} else {
	if ( get_option( 'games_read_review_title') ) {
		$permalink_button_title = esc_html( get_option( 'games_read_review_title') );
	} else {
		$permalink_button_title = esc_html__( 'Read Review', 'mercury' );
	}
}

if ( get_option( 'aces_game_rating_stars_number' ) ) {
	$game_rating_stars_number_value = get_option( 'aces_game_rating_stars_number' );
} else {
	$game_rating_stars_number_value = '5';
}

if ($unit_popup_title) {
	$custom_popup_title = $unit_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
}

$terms = get_the_terms( $post->ID, 'game-category' );
?>

<div class="space-units-3-archive-item box-25 relative">
	<div class="space-units-3-archive-item-ins relative">
		<div class="space-units-3-archive-item-img-wrap box-100 relative">
			<?php
			$post_title_attr = the_title_attribute( 'echo=0' );
			if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
				<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
			<?php } ?>
			<div class="space-units-3-archive-item-overlay space-overlay absolute">

				<?php if ($game_rating) {
					if( function_exists('aces_star_rating') ){
				?>

					<div class="space-units-3-archive-item-rating absolute">
						<span><i class="fas fa-star"></i></span><strong><?php echo esc_html( number_format( (float)$game_rating, 1, '.', ',') ); ?></strong>/<?php echo esc_html( $game_rating_stars_number_value ); ?>
					</div>

				<?php
					}
				} ?>

				<div class="space-units-3-archive-item-central text-center relative">

					<?php if ($terms) { ?>
					<div class="space-units-3-archive-item-category relative">
						<?php foreach ( $terms as $term ) { ?>
					        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
					    <?php } ?>
					</div>
					<?php } ?>

					<div class="space-units-3-archive-item-title relative">
						<?php the_title(); ?>
					</div>

					<?php if ($game_external_link) { ?>

					<div class="space-units-3-archive-item-button1 relative">
						<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($game_external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
					</div>

					<?php } ?>

					<div class="space-units-3-archive-item-button2 relative">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
					</div>
				</div>

				<?php if ($unit_detailed_tc) { ?>
					<div class="space-units-3-archive-item-tac absolute" style="margin-top: 5px;">
						<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
						<div class="tc-desc">
							<?php
								if ($unit_detailed_tc) {
									echo wp_kses( $unit_detailed_tc, $game_allowed_html );
								}
							?>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</div>