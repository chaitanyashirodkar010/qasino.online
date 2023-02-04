<?php

/*  Mercury - 3.9.2  */

$bonus_allowed_html = array(
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
$bonus_short_desc = wp_kses( get_post_meta( get_the_ID(), 'bonus_short_desc', true ), $bonus_allowed_html );
$bonus_external_link = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );
$bonus_button_title = esc_html( get_post_meta( get_the_ID(), 'bonus_button_title', true ) );
$bonus_button_notice = wp_kses( get_post_meta( get_the_ID(), 'bonus_button_notice', true ), $bonus_allowed_html );
$bonus_code = esc_html( get_post_meta( get_the_ID(), 'bonus_code', true ) );
$bonus_valid_date = esc_html( get_post_meta( get_the_ID(), 'bonus_valid_date', true ) );
$bonus_dark_style = esc_attr( get_post_meta( get_the_ID(), 'bonus_dark_style', true ) );
$offer_popup_hide = esc_attr( get_post_meta( get_the_ID(), 'aces_offer_popup_hide', true ) );
$offer_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_offer_popup_title', true ) );
$offers_disable_more_block = esc_attr( get_post_meta( get_the_ID(), 'offers_disable_more_block', true ) );

$offer_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'offer_detailed_tc', true ), $bonus_allowed_html );

if ($bonus_button_title) {
	$button_title = $bonus_button_title;
} else {
	if ( get_option( 'bonuses_get_bonus_title') ) {
		$button_title = esc_html( get_option( 'bonuses_get_bonus_title') );
	} else {
		$button_title = esc_html__( 'Get Bonus', 'mercury' );
	}
}

if ($offer_popup_title) {
	$custom_popup_title = $offer_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
}

?>

	<div class="space-single-offer relative<?php if ($bonus_dark_style == true ) { ?> space-dark-style<?php } ?>">

		<!-- Breadcrumbs Start -->

		<?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

		<!-- Breadcrumbs End -->

		<!-- Single Offer Page Section Start -->

		<div class="space-page-section box-100 relative">
			<div class="space-page-section-ins space-page-wrapper relative">
				<div class="space-content-section box-75 left relative">

					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<?php if(function_exists('spacethemes_set_post_views')) { spacethemes_set_post_views(get_the_ID()); } ?>

					<div class="space-aces-single-offer-box box-100 text-center relative">
						<div class="space-aces-single-offer-info box-100 relative"<?php $src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'mercury-900-675'); if ($src) { ?> style="background-image: url(<?php echo esc_url($src[0]); ?>);"<?php } ?>>
							<?php if ($src) { ?><div class="space-overlay absolute"></div><?php } ?>
							<div class="space-aces-single-offer-info-ins relative">
								<div class="space-aces-single-offer-info-ins-wrap relative">
									<div class="space-aces-single-offer-info-cat relative">

										<?php $terms = get_the_terms( $post->ID , 'bonus-category' );

											if ($terms) {
								            foreach ( $terms as $term ) { ?>
								                <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
								        <?php }

								    	} ?>

									</div>
									<div class="space-aces-single-offer-info-title relative">
										<h1><?php the_title(); ?></h1>
									</div>

									<?php if ($bonus_short_desc) { ?>
									<div class="space-aces-single-offer-info-short-desc relative">
										<?php echo wp_kses( $bonus_short_desc, $bonus_allowed_html ); ?>
									</div>
									<?php } ?>

									<div class="space-aces-single-offer-info-code-button box-100 relative"<?php if (! $bonus_short_desc) { ?> style="padding-top: 85px;"<?php } ?>>

										<?php if ($bonus_code) { ?>

										<div class="space-aces-single-offer-info-code box-60 left relative">
											<div class="space-aces-single-offer-info-code-ins relative">
												<fieldset class="space-aces-single-offer-info-code-value relative">
													<legend><?php esc_html_e( 'Bonus Code', 'mercury' ); ?></legend>
													<span>
														<?php echo esc_html( $bonus_code ); ?>
													</span>
												</fieldset>
												<?php if ($bonus_valid_date) { ?>
												<div class="space-aces-single-offer-info-code-date relative">
													<?php esc_html_e( 'Valid Until:', 'mercury' ); ?> <span><?php echo esc_html( date_i18n('M d, Y',strtotime($bonus_valid_date))); ?></span>
												</div>
												<?php } ?>

											</div>
										</div>

										<?php } ?>

										<div class="space-aces-single-offer-info-button <?php if ($bonus_code) { ?>box-40 right<?php } else { ?>box-100<?php } ?> relative">
											<div class="space-aces-single-offer-info-button-ins text-center relative">
												<a href="<?php echo esc_url( $bonus_external_link ); ?>" title="<?php echo esc_attr( $button_title ); ?>" target="_blank" rel="nofollow"><?php echo esc_html( $button_title ); ?> <i class="fas fa-arrow-alt-circle-right"></i></a>
											</div>

											<?php if ($bonus_button_notice) { ?>

											<!-- The notice below of the button Start -->

											<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
												<?php echo wp_kses( $bonus_button_notice, $bonus_allowed_html ); ?>
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
																echo wp_kses( $offer_detailed_tc, $bonus_allowed_html );
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
													<?php echo wp_kses( $offer_detailed_tc, $bonus_allowed_html ); ?>
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
					<div class="space-page-content-wrap relative">
						<div class="space-page-content-box-wrap relative">

							<?php if(has_excerpt()) { ?>
							<div class="space-offer-content-excerpt relative">
								<?php the_excerpt(); ?>
							</div>
							<?php } ?>

							<div class="space-page-content box-100 relative">

								<?php
									the_content();
									wp_link_pages( array(
										'before'      => '<div class="clear"></div><nav class="navigation pagination-post">' . esc_html__( 'Pages:', 'mercury' ),
										'after'       => '</nav>',
										'link_before' => '<span class="page-number">',
										'link_after'  => '</span>',
									) );
								?>

							</div>
						</div>
						
						<!-- Author Info Start -->

						<?php
							if(!get_theme_mod('mercury_author_info_block')) {
								get_template_part('/theme-parts/author-info');
							}
						?>

						<!-- Author Info End -->

					</div>

					<?php endwhile; ?>
					<?php endif; ?>

					<?php if ($offers_disable_more_block == true ) {
						
					} else { ?>

						<!-- Related Offers Start -->

						<?php
							$bonus_category_list = get_the_terms( $post->ID, 'bonus-category' );

							if ( $bonus_category_list ) {
							
								$bonus_category_string = wp_list_pluck( $bonus_category_list, 'term_id' );

								$bonus_args = get_posts(
									array(
										'posts_per_page' => 6,
										'post_type'      => 'bonus',
										'exclude'        => $post->ID,
										'tax_query'      => array(
											array(
												'taxonomy' => 'bonus-category',
												'field'    => 'id',
												'terms'    => $bonus_category_string
											)
										)
									)
								);
								if( $bonus_args ){
							?>

							<div class="space-related-items box-100 read-more-block relative">
								<div class="space-related-items-ins space-page-wrapper relative">
									<div class="space-block-title relative">
										<span>
											<?php esc_html_e( 'More ', 'mercury' ); ?>
											<?php if ( get_option( 'bonuses_section_name') ) {
												esc_html_e( get_option( 'bonuses_section_name') );
											} else {
												esc_html_e( 'Bonuses', 'mercury' );
											} ?>
										</span>
									</div>
									<div class="space-offers-archive-items box-100 relative">

										<?php
											foreach( $bonus_args as $post ){
											setup_postdata($post);
											
											// connect the bonus loop item style
											get_template_part( '/aces/related/bonus-item-style-1' );

											}
											wp_reset_postdata();
										?>

									</div>
								</div>
							</div>

							<?php } 
						} ?>

						<!-- Related Offers End -->

					<?php } ?>

					<?php if ( comments_open() || get_comments_number() ) :?>

					<!-- Comments Start -->

					<?php comments_template(); ?>

					<!-- Comments End -->

					<?php endif; ?>

				</div>
				<div class="space-sidebar-section box-25 right relative">

					<?php get_sidebar(); ?>

				</div>
			</div>
		</div>

		<!-- Single Offer Page Section End -->

	</div>