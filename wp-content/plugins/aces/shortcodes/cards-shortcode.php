<?php

function aces_cards_shortcode_1($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
		'spades' => '',
	    'diamonds' => '',
	    'hearts' => '',
	    'clubs' => ''
	), $atts ) );

	if ( !empty($spades) ) { ?>
		<span class="aces-card spades"><?php echo esc_html($spades); ?></span>
	<?php } elseif ( !empty($diamonds) ) { ?>
		<span class="aces-card diamonds"><?php echo esc_html($diamonds); ?></span>
	<?php } elseif ( !empty($hearts) ) { ?>
		<span class="aces-card hearts"><?php echo esc_html($hearts); ?></span>
	<?php } elseif ( !empty($clubs) ) { ?>
		<span class="aces-card clubs"><?php echo esc_html($clubs); ?></span>
	<?php }

	$card_item = ob_get_clean();
	return $card_item;

}
 
add_shortcode('aces-card', 'aces_cards_shortcode_1');