<?php

function aces_cons_shortcode_1( $atts, $content = null ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'title' => '',
			),
			$atts
		)
	);

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

	?>

	<div class="space-cons box-100 relative">
		<div class="space-cons-ins relative">
			<div class="space-cons-title box-100 relative">
				<?php echo esc_html( $title ); ?>
			</div>
			<div class="space-cons-description box-100 relative">
				<?php echo wp_kses( $content, $allowed_html ); ?>
			</div>
		</div>
	</div>

	<?php

	$aces_taxonomy_items = ob_get_clean();
	return $aces_taxonomy_items;

}
 
add_shortcode('aces-cons-1', 'aces_cons_shortcode_1');