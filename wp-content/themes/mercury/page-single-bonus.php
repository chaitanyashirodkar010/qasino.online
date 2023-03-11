<?php
/*
Template Name: single child bonus
Template Post Type: casinos,casino
*/
?>
<div class="container">
    <div class="space-content-section w-100 left relative">
	<?php
    $children = get_children( array('post_parent' => get_the_ID()) );
    foreach ( $children as $children_id => $child ) {
        echo $child->post_title;
        echo str_replace( ']]>', ']]&gt;',apply_filters( 'the_content', $child->post_content )); //mimic the_content() filters
        //echo $child->post_content; // if you do not need to filter the content;
    }
?>

        <?php $post_id_related = '"'.$post->post_parent.'"'; ?>
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