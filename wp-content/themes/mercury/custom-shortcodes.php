<?php
 function dotiavatar_function($atts) {
    ob_start();
?>

<?php 
				if( get_theme_mod('mercury_category_navigation_bonuses') ) {
				$args = array(
					'hide_empty'=> 1,
					'type' => 'bonus',
					'orderby' => 'name',
					'taxonomy' => 'bonus-category',
					'order' => 'ASC'
				);
				$categories = get_categories($args);

				if( $categories ){
			 ?>
<div class="bonus_title white_color">
    <h2>Bonus Types</h2>
</div>
<ul class="right-sidebar">
    <?php if (get_theme_mod( 'mercury_bonuses_list_page_id')) { ?>
    <li>
        <a
            href="<?php echo esc_url( get_permalink(get_theme_mod( 'mercury_bonuses_list_page_id')) ); ?>"><?php esc_html_e( 'All', 'mercury' ); ?></a>
    </li>
    <?php } ?>
    <?php
						$current_tax = get_queried_object();

						foreach($categories as $category) {

							if( $current_tax->slug == $category->slug ) { ?>

    <li class="active">
        <?php echo esc_html($category->name); ?>
    </li>

    <?php } else { ?>

    <li>
        <a href="<?php echo esc_url( get_term_link($category->slug, 'bonus-category') ); ?>"
            title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?></a>
    </li>

    <?php
							}
						}
					?>
</ul>
<?php }
			} ?>

<?php
	wp_reset_postdata();
	$casino_items = ob_get_clean();
	return $casino_items;
	}


add_shortcode('dotiavatar', 'dotiavatar_function');
 ?>