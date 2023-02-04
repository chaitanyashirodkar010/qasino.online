<?php

function aces_taxonomy_shortcode_1( $atts ) {

	ob_start();

	// Define attributes and their defaults

	extract(
		shortcode_atts(
			array (
			    'taxonomy_slug' => '',
			    'parent_id' => '',
			    'title' => '',
			    'icon_class' => '',
			    'no_links' => '',
			),
			$atts
		)
	);

	if ( empty( $parent_id ) ) {
		$parent_id = get_the_ID();
	}

	$aces_taxonomy_items = get_the_terms( $parent_id, $taxonomy_slug );

	if ($aces_taxonomy_items) {
	?>

	<div class="space-organization-details-item box-100 relative">
		<?php if ( $title ) { ?>
			<div class="space-organization-details-item-title box-33 relative">
				<?php if ( $icon_class ) { ?>
					<span><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
				<?php } ?>
				<?php echo esc_html( $title ); ?>
			</div>
		<?php } ?>
		<div class="space-organization-details-item-links <?php if ( $title ) { ?>box-66<?php } else {  ?>box-66<?php } ?> relative">
			<?php foreach ( $aces_taxonomy_items as $taxonomy_item ) {
				$taxonomy_logo = get_term_meta($taxonomy_item->term_id, 'taxonomy-image-id', true);
				if ($taxonomy_logo) { ?>
					<?php if ( $no_links ) { ?>
						<span>
							<?php echo wp_get_attachment_image( $taxonomy_logo, 'mercury-9999-32', "", array( "class" => "space-taxonomy-slug-logo" ) );  ?>
						</span>
					<?php } else { ?>
						<a href="<?php echo esc_url (get_term_link( (int)$taxonomy_item->term_id, $taxonomy_item->taxonomy )); ?>" title="<?php echo esc_attr($taxonomy_item->name); ?>" class="logo-item">
							<?php echo wp_get_attachment_image( $taxonomy_logo, 'mercury-9999-32', "", array( "class" => "space-taxonomy-slug-logo" ) );  ?>
						</a>
					<?php } ?>
				<?php } else { ?>
					<?php if ( $no_links ) { ?>
						<span><?php echo esc_html($taxonomy_item->name); ?></span>
					<?php } else { ?>
						<a href="<?php echo esc_url (get_term_link( (int)$taxonomy_item->term_id, $taxonomy_item->taxonomy )); ?>" title="<?php echo esc_attr($taxonomy_item->name); ?>"><?php echo esc_html($taxonomy_item->name); ?></a>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>

	<?php
	}

	wp_reset_postdata();
	$aces_taxonomy_items = ob_get_clean();
	return $aces_taxonomy_items;

}
 
add_shortcode('aces-taxonomy-1', 'aces_taxonomy_shortcode_1');