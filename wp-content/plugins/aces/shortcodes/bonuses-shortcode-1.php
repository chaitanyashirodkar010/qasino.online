<?php

function aces_bonuses_shortcode_1($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 4,
	    'external_link' => '',
	    'category' => '',
	    'items_id' => '',
	    'parent_id' => '',
	    'exclude_id' => '',
	    'columns' => 4,
	    'order' => '',
	    'orderby' => '',
	    'title' => ''
	), $atts ) );

	$exclude_id_array = '';

	if ($exclude_id) {
		$exclude_id_array = explode( ',', $exclude_id );
	}

	if ( !empty( $category ) ) {

		$categories_id_array = explode( ',', $category );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'bonus',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'bonus-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $items_id ) ) {

		$items_id_array = explode( ',', $items_id );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'bonus',
			'post__in'       => $items_id_array,
			'orderby'        => 'post__in',
			'no_found_rows'  => true,
			'post_status'    => 'publish'
		);

	} else if ( !empty( $parent_id ) ) {

		$parent_id = '"'.$parent_id.'"';

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'bonus',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'meta_query' => array(
		        array(
		            'key' => 'bonus_parent_casino',
		            'value' => $parent_id,
		            'compare' => 'LIKE'
		        )
		    )
		);

	} else {

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'bonus',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'orderby'  => $orderby,
			'order'    => $order
		);

	}

	$bonus_query = new WP_Query( $args );

	if ( $bonus_query->have_posts() ) {
	?>

	<div class="space-shortcode-wrap space-shortcode-8 relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-offers-archive-items box-100 relative">

				<?php while ( $bonus_query->have_posts() ) : $bonus_query->the_post();
					global $post;
					$bonus_allowed_html = array(
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
					$bonus_short_desc = wp_kses( get_post_meta( get_the_ID(), 'bonus_short_desc', true ), $bonus_allowed_html );
					$bonus_external_link = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );
					$bonus_button_title = esc_html( get_post_meta( get_the_ID(), 'bonus_button_title', true ) );
					$bonus_button_notice = wp_kses( get_post_meta( get_the_ID(), 'bonus_button_notice', true ), $bonus_allowed_html );
					$bonus_code = esc_html( get_post_meta( get_the_ID(), 'bonus_code', true ) );
					$bonus_valid_date = esc_html( get_post_meta( get_the_ID(), 'bonus_valid_date', true ) );
					$bonus_dark_style = esc_attr( get_post_meta( get_the_ID(), 'bonus_dark_style', true ) );

					$offer_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'offer_detailed_tc', true ), $bonus_allowed_html );
					$offer_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_offer_popup_title', true ) );

					if ($bonus_button_title) {
						$button_title = $bonus_button_title;
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

					if ($external_link) {
						if ($bonus_external_link) {
							$external_link_url = $bonus_external_link;
						} else {
							$external_link_url = get_the_permalink();
						}
					} else {
						$external_link_url = get_the_permalink();
					}

					$terms = get_the_terms( $post->ID, 'bonus-category' );
				?>

				<div class="space-offers-archive-item <?php if ($columns == 1) { ?>box-100<?php } else if ($columns == 2) { ?>box-50<?php } else if ($columns == 3) { ?>box-33<?php } else { ?>box-25<?php } ?> relative<?php if ($bonus_dark_style == true ) { ?> space-dark-style<?php } ?>">
					<div class="space-offers-archive-item-ins relative">
						<div class="space-offers-archive-item-wrap text-center relative">

							<?php if ($terms) { ?>
							<div class="space-offers-archive-item-cat relative">

								<?php foreach ( $terms as $term ) { ?>
							        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
							    <?php } ?>
								
							</div>
							<?php } ?>

							<div class="space-offers-archive-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>

							<?php if ($bonus_code) { ?>
							<div class="space-offers-archive-item-code relative">
								<div class="space-offers-archive-item-code-value relative">
									<?php echo esc_html( $bonus_code ); ?>
								</div>
								<div class="space-offers-archive-item-code-title absolute">
									<span><?php esc_html_e( 'Bonus Code', 'aces' ); ?></span>
								</div>
							</div>

								<?php if ($bonus_valid_date) { ?>
								<div class="space-offers-archive-item-code-date relative">
									<?php esc_html_e( 'Valid Until:', 'aces' ); ?> <span><?php echo esc_html( date_i18n('M d, Y',strtotime($bonus_valid_date))); ?></span>
								</div>
								<?php } ?>
								
							<?php } ?>

							<?php if ($bonus_short_desc) { ?>
							<div class="space-offers-archive-item-short-desc relative">
								<?php echo wp_kses( $bonus_short_desc, $bonus_allowed_html ); ?>
							</div>
							<?php } ?>

							<div class="space-offers-archive-item-button relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
							</div>

							<?php if ($offer_detailed_tc) { ?>
								<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
									<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
									<div class="tc-desc">
										<?php
											if ($offer_detailed_tc) {
												echo wp_kses( $offer_detailed_tc, $bonus_allowed_html );
											}
										?>
									</div>
								</div>
							<?php } ?>

							<?php if ($bonus_button_notice) { ?>

							<div class="space-offers-archive-item-button-notice relative" style="margin-top: 5px;">
								<?php echo wp_kses( $bonus_button_notice, $bonus_allowed_html ); ?>
							</div>

							<?php } ?>

						</div>
					</div>
				</div>

				<?php endwhile; ?>

			</div>
		
		</div>
	</div>

	<?php
	wp_reset_postdata();
	$bonus_items = ob_get_clean();
	return $bonus_items;
	}

}
 
add_shortcode('aces-bonuses-1', 'aces_bonuses_shortcode_1');