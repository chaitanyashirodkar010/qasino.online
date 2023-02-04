<?php

function mercury_content_shortcode_1($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'title' => '',
	    'subtitle' => '',
	    'image_url' => '',
	    'link' => ''
	), $atts ) );

	?>

	<div class="mercury-content-item-1-box box-100 relative">
		<?php if ($link) { ?>
			<a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $title ); ?>">
		<?php } ?>
			<div class="mercury-content-item-1 box-100 relative">
				<div class="mercury-content-item-1-ins relative">
					<div class="mercury-content-item-1-wrap text-center relative">

						<?php if ($image_url) { ?>
							<div class="mercury-content-item-1-img relative">
								<img height="120" alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_url( $image_url ); ?>">
							</div>
						<?php } ?>

						<?php if ($title) { ?>
							<div class="mercury-content-item-1-title relative">
								<?php echo esc_html( $title ); ?>
							</div>
						<?php } ?>

						<?php if ($subtitle) { ?>
							<div class="mercury-content-item-1-short-desc relative">
								<?php echo esc_html( $subtitle ); ?>
							</div>
						<?php } ?>
							
					</div>
				</div>
			</div>
		<?php if ($link) { ?>
			</a>
		<?php } ?>
	</div>

	<?php
	$content_item_1 = ob_get_clean();
	return $content_item_1;

}
 
add_shortcode('mercury-content-1', 'mercury_content_shortcode_1');