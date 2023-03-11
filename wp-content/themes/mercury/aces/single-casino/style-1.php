<?php

/*  Mercury - 3.9.2  */

	
?>


<div class="space-single-organization relative">

    <!-- Breadcrumbs Start -->

    <?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

    <!-- Breadcrumbs End -->

    <!-- Single Organization Page Section Start -->

    <div class="space-page-section box-100 relative">
        <div class="space-page-section-ins space-page-wrapper relative">
            <div class="space-content-section box-75 left relative">


                <?php $post_id_related = '"'.$post->ID.'"'; ?>
                <?php
							$bonus_args = get_posts(
								array(
									'post_type' => 'bonus',
									'meta_query' => array(
								        array(
								            'key' => 'bonus_parent_casino',
								            'value' => $post_id_related,
								            'compare' => 'LIKE'
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
                                <?php the_title(); ?> <?php if ( get_option( 'bonuses_section_name') ) {
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
										get_template_part( '/aces/promotion-bonus' );

										}
										wp_reset_postdata();
									?>

                        </div>
                    </div>
                </div>

                <?php } ?>


            </div>
        </div>
    </div>
</div>