<?php

/*  Games - Post Type Start */

add_action('init', 'aces_games', 0 );

function aces_games() {
	
	$game_slug = 'game';
	if ( get_option( 'games_section_slug') ) {
		$game_slug = get_option( 'games_section_slug', 'game' );
	}

	$game_name = esc_html__('Games', 'aces');
	if ( get_option( 'games_section_name') ) {
		$game_name = get_option( 'games_section_name', 'Games' );
	}

	$args = array(
        'labels' => array(
			'name' => $game_name,
			'add_new' => esc_html__('Add New', 'aces'),
            'edit_item' => esc_html__('Edit Item', 'aces'),
            'add_new_item' => esc_html__('Add New', 'aces'),
            'view_item' => esc_html__('View Item', 'aces'),
        ),
        'singular_label' => __('game'),
        'public' => true,
		'publicly_queryable' => true,
        'show_ui' => true,
		'show_in_rest' => true,
		'menu_icon' => plugins_url( 'aces/images/icon.png' ),
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
        	'title',
        	'editor',
        	'author',
        	'comments',
        	'thumbnail',
        	'excerpt',
        	'revisions'
        ),
		'has_archive' => false,
		'rest_base' => 'unit',
		'rewrite' => array(
			'slug' => $game_slug,
			'with_front' => false
		)
    );

register_post_type( 'game' , $args );

/* --- Category: Custom Taxonomy --- */

$games_category_title = esc_html__('Categories', 'aces');
if ( get_option( 'games_category_title') ) {
	$games_category_title = get_option( 'games_category_title', 'Categories' );
}

$labels = array(
	'name' => $games_category_title,
	'singular_name' => $games_category_title,
	'search_items' => esc_html__('Find Taxonomy', 'aces'),
	'all_items' => esc_html__('All ', 'aces') . $games_category_title,
	'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
	'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
	'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
	'view_item' => esc_html__('View Taxonomy', 'aces'),
	'update_item' => esc_html__('Update Taxonomy', 'aces'),
	'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
	'new_item_name' => esc_html__('Taxonomy', 'aces'),
	'menu_name' => $games_category_title
); 

$args = array(
	'labels' => $labels,
	'public' => true,
	'show_in_nav_menus' => true,
	'show_ui' => true,
	'show_in_rest' => true,
	'show_tagcloud' => true,
	'show_admin_column' => true,
	'hierarchical' => true,
	'update_count_callback' => '',
	'rewrite' => true,
	'query_var' => '',
	'capabilities' => array(),
	'_builtin' => false
);

register_taxonomy('game-category', 'game', $args);

/* --- Vendor: Custom Taxonomy --- */

$games_vendor_title = esc_html__('Vendors', 'aces');
if ( get_option( 'games_vendor_title') ) {
	$games_vendor_title = get_option( 'games_vendor_title', 'Vendors' );
}

$labels = array(
	'name' => $games_vendor_title,
	'singular_name' => $games_vendor_title,
	'search_items' => esc_html__('Find Taxonomy', 'aces'),
	'all_items' => esc_html__('All ', 'aces') . $games_vendor_title,
	'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
	'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
	'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
	'view_item' => esc_html__('View Taxonomy', 'aces'),
	'update_item' => esc_html__('Update Taxonomy', 'aces'),
	'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
	'new_item_name' => esc_html__('Taxonomy', 'aces'),
	'menu_name' => $games_vendor_title
); 

$args = array(
	'labels' => $labels,
	'public' => true,
	'show_in_nav_menus' => true,
	'show_ui' => true,
	'show_in_rest' => true,
	'show_tagcloud' => true,
	'show_admin_column' => true,
	'hierarchical' => true,
	'update_count_callback' => '',
	'rewrite' => true,
	'query_var' => '',
	'capabilities' => array(),
	'_builtin' => false
);

register_taxonomy('vendor', 'game', $args);

}

/* --- Add custom slug for taxonomy 'game-category' --- */

if ( get_option( 'game_category_slug') ) {

	function aces_change_game_category_slug( $taxonomy, $object_type, $args ) {

		$game_category_slug = 'game-category';

		if ( get_option( 'game_category_slug') ) {
			$game_category_slug = get_option( 'game_category_slug', 'game-category' );
		}

	    if( 'game-category' == $taxonomy ) {
	        remove_action( current_action(), __FUNCTION__ );
	        $args['rewrite'] = array( 'slug' => $game_category_slug );
	        register_taxonomy( $taxonomy, $object_type, $args );
	    }

	}
	add_action( 'registered_taxonomy', 'aces_change_game_category_slug', 10, 3 );

}

/* --- Add custom slug for taxonomy 'vendor' --- */

if ( get_option( 'game_vendor_slug') ) {

	function aces_change_game_vendor_slug( $taxonomy, $object_type, $args ) {

		$game_vendor_slug = 'vendor';

		if ( get_option( 'game_vendor_slug') ) {
			$game_vendor_slug = get_option( 'game_vendor_slug', 'vendor' );
		}

	    if( 'vendor' == $taxonomy ) {
	        remove_action( current_action(), __FUNCTION__ );
	        $args['rewrite'] = array( 'slug' => $game_vendor_slug );
	        register_taxonomy( $taxonomy, $object_type, $args );
	    }

	}
	add_action( 'registered_taxonomy', 'aces_change_game_vendor_slug', 10, 3 );

}

/*  Games - Post Type End */

/*  Games - Short Description Start */

add_action( 'admin_init', 'aces_units_short_desc_fields' );

function aces_units_short_desc_fields() {
    add_meta_box( 'aces_units_short_desc_meta_box',
        esc_html__( 'Short description', 'aces' ),
        'aces_units_short_desc_display_meta_box',
        'game', 'normal', 'high'
    );
}

function aces_units_short_desc_display_meta_box( $game ) {

	wp_nonce_field( 'aces_units_short_desc_box', 'aces_units_short_desc_nonce' );
	$game_short_desc = get_post_meta( $game->ID, 'game_short_desc', false );
	
	$editor_args = array(
	    'tinymce'       => array(
	        'toolbar1'  => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'
	    ),
	    'quicktags'     => array(
	    	'buttons'   => 'em,strong,link,ul,li,ol,close'
	    ),
	    'media_buttons' => false,
	    'textarea_rows' => 6
	);

?>

<div class="components-base-control game_short_desc">
	<div class="components-base-control__field">
		<?php
		if ( empty($game_short_desc[0]) ) {
			$game_short_desc[0] = '';
		}
		wp_editor( $game_short_desc[0], 'game_short_desc', $editor_args );
		?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_units_short_desc_save_fields', 10, 2 );

function aces_units_short_desc_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_units_short_desc_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_units_short_desc_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_units_short_desc_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'game' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$game_short_desc = $_POST['game_short_desc'];
        update_post_meta( $post_id, 'game_short_desc', $game_short_desc );
}

/*  Games - Short Description End */

/*  Games - Detailed T&Cs Start */

add_action( 'admin_init', 'aces_units_detailed_tc_fields' );

function aces_units_detailed_tc_fields() {
    add_meta_box( 'aces_units_detailed_tc_meta_box',
        esc_html__( 'Detailed T&Cs', 'aces' ),
        'aces_units_detailed_tc_display_meta_box',
        'game', 'normal', 'high'
    );
}

function aces_units_detailed_tc_display_meta_box( $game ) {

	wp_nonce_field( 'aces_units_detailed_tc_box', 'aces_units_detailed_tc_nonce' );

	$custom = get_post_custom($game->ID);
	$unit_detailed_tc = get_post_meta( $game->ID, 'unit_detailed_tc', false );
	$aces_unit_popup_hide = isset($custom["aces_unit_popup_hide"][0]) ? stripslashes($custom["aces_unit_popup_hide"][0]) : '';
	$aces_unit_popup_title = get_post_meta( $game->ID, 'aces_unit_popup_title', true );
	
	$editor_args = array(
	    'tinymce'       => array(
	        'toolbar1'  => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'
	    ),
	    'quicktags'     => array(
	    	'buttons'   => 'em,strong,link,ul,li,ol,close'
	    ),
	    'media_buttons' => false,
	    'textarea_rows' => 6
	);
?>

<div class="components-base-control unit_detailed_tc">
	<div class="components-base-control__field" style="padding-bottom: 30px;">
		<?php
		if ( empty($unit_detailed_tc[0]) ) {
			$unit_detailed_tc[0] = '';
		}
		wp_editor( $unit_detailed_tc[0], 'unit_detailed_tc', $editor_args );
		?>
	</div>
</div>

<div class="components-base-control aces_unit_popup_hide" style="padding: 5px 0 10px 0;">
	<div class="components-base-control__field">
		<input type="checkbox" name="aces_unit_popup_hide" <?php if( $aces_unit_popup_hide == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Hide the Detailed T&Cs in a popup box', 'aces' )?>
	</div>
</div>

<div class="components-base-control aces_unit_popup_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="aces_unit_popup_title-0"><?php esc_html_e( 'Custom link title for the', 'aces' ); ?> <strong><?php esc_html_e( 'popup box', 'aces' ); ?></strong></label>
		<input type="text" name="aces_unit_popup_title" id="aces_unit_popup_title-0" value="<?php echo esc_attr($aces_unit_popup_title); ?>" style="display: block; margin-top: 5px;" />
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_units_detailed_tc_save_fields', 10, 2 );

function aces_units_detailed_tc_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_units_detailed_tc_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_units_detailed_tc_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_units_detailed_tc_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'game' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$unit_detailed_tc = $_POST['unit_detailed_tc'];
        update_post_meta( $post_id, 'unit_detailed_tc', $unit_detailed_tc );

        $aces_unit_popup_hide = sanitize_text_field( $_POST['aces_unit_popup_hide'] );
        update_post_meta( $post_id, 'aces_unit_popup_hide', $aces_unit_popup_hide );

        $aces_unit_popup_title = sanitize_text_field( $_POST['aces_unit_popup_title'] );
        update_post_meta( $post_id, 'aces_unit_popup_title', $aces_unit_popup_title );
}

/*  Games - Detailed T&Cs End */

/*  Games - Ratings Start */

add_action( 'admin_init', 'aces_games_ratings_fields' );

function aces_games_ratings_fields() {

    add_meta_box( 'aces_games_ratings_meta_box',
        esc_html__( 'Item Rating', 'aces' ),
        'aces_games_ratings_display_meta_box',
        'game', 'normal', 'high'
    );
}

function aces_games_ratings_display_meta_box( $game ) {

	wp_nonce_field( 'aces_games_ratings_box', 'aces_games_ratings_nonce' );
	$meta = get_post_meta( $game->ID );

	$game_rating_one = ( isset( $meta['game_rating_one'][0] ) && '' !== $meta['game_rating_one'][0] ) ? $meta['game_rating_one'][0] : '';

	// Get the number of stars in the rating

	if ( get_option( 'aces_game_rating_stars_number' ) ) {
		$game_rating_stars_number_value = get_option( 'aces_game_rating_stars_number' );
	} else {
		$game_rating_stars_number_value = '5';
	}

?>

<style type="text/css">
	.aces-single-rating-box {
		padding-bottom: 10px;
	}
	.aces-single-rating-box label {
		padding-right: 12px;
	}
	.aces-single-rating-box label:last-child {
		padding-right: 0;
	}
	.aces-single-rating-box label input[type=radio] {
		margin-right: 0 !important;
	}
</style>

<div class="components-base-control game_rating_one">
	<div class="components-base-control__field">
		<label class="components-base-control__label">
			<?php esc_html_e( 'Rating', 'aces' ); ?>
		</label>
		<div class="aces-single-rating-box">
			<?php
			for ($i = 1; $i <= $game_rating_stars_number_value; $i++) {
				?>
				<label>
					<input type="radio" name="game_rating_one" value="<?php esc_attr_e( $i ); ?>" <?php checked( $game_rating_one, $i ); ?>>
						<?php esc_attr_e( $i ); ?>
				</label>
				<?php
			}
			?>
		</div>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_games_ratings_save_fields', 10, 2 );

function aces_games_ratings_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_games_ratings_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_games_ratings_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_games_ratings_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'game' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		if ( isset( $_POST['game_rating_one'] ) ) {
			update_post_meta( $post_id, 'game_rating_one', sanitize_text_field( wp_unslash( $_POST['game_rating_one'] ) ) );
		}

		/*  
		if ( !wp_is_post_revision( $post_id ) ) {

	        $game_rating_one = get_post_meta( $post_id, 'game_rating_one', true );
	        $game_rating_two = get_post_meta( $post_id, 'game_rating_two', true );
	        $game_rating_three = get_post_meta( $post_id, 'game_rating_three', true );
	        $game_rating_four = get_post_meta( $post_id, 'game_rating_four', true );

	        $game_ratings_all = array(
				$game_rating_one,
				$game_rating_two,
				$game_rating_three,
				$game_rating_four
			);

			$game_overall_rating = esc_html(array_sum($game_ratings_all)/count($game_ratings_all));

	        if (is_float($game_overall_rating)) { $game_overall_rating = number_format($game_overall_rating,1); }

	        update_post_meta($post_id, 'game_overall_rating', $game_overall_rating);

	    } 
	    */

}

/*  Games - Ratings End */

/*  Games - Additional Fields Start */

add_action( 'admin_init', 'aces_games_fields' );

function aces_games_fields() {
    add_meta_box( 'aces_games_meta_box',
        esc_html__( 'Additional information', 'aces' ),
        'aces_games_display_meta_box',
        'game', 'side', 'high'
    );
}

function aces_games_display_meta_box( $game ) {
	wp_nonce_field( 'aces_games_box', 'aces_games_nonce' );

	$game_id = get_post_custom($game->ID);
	$game_external_link = get_post_meta( $game->ID, 'game_external_link', true );
	$game_button_title = get_post_meta( $game->ID, 'game_button_title', true );
	$game_permalink_button_title = get_post_meta( $game->ID, 'game_permalink_button_title', true );
	$game_button_notice = get_post_meta( $game->ID, 'game_button_notice', false );
	$units_disable_more_block = isset($game_id["units_disable_more_block"][0]) ? stripslashes($game_id["units_disable_more_block"][0]) : '';

	$editor_args = array(
	    'tinymce'       => array(
	        'toolbar1'  => 'bold,italic,underline,link,unlink,undo,redo'
	    ),
	    'quicktags'     => array(
	    	'buttons'   => 'em,strong,link,close'
	    ),
	    'media_buttons' => false,
	    'textarea_rows' => 8
	);
?>

<div class="components-base-control game_external_link">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="game_external_link-0"><?php esc_html_e( 'External URL for the', 'aces' )?> <strong><?php esc_html_e( 'Play Now', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="url" name="game_external_link" id="game_external_link-0" value="<?php echo esc_url($game_external_link); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control game_button_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="game_button_title-0"><?php esc_html_e( 'Custom title for the', 'aces' ); ?> <strong><?php esc_html_e( 'Play Now', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="text" name="game_button_title" id="game_button_title-0" value="<?php echo esc_attr($game_button_title); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control game_permalink_button_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="game_permalink_button_title-0"><?php esc_html_e( 'Custom title for the', 'aces' ); ?> <strong><?php esc_html_e( 'Read Review', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="text" name="game_permalink_button_title" id="game_permalink_button_title-0" value="<?php echo esc_attr($game_permalink_button_title); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control game_button_notice">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="game_button_notice-0"><?php esc_html_e( 'Notification under the button', 'aces' ); ?></label>
		<?php
		if ( empty($game_button_notice[0]) ) {
			$game_button_notice[0] = '';
		}
		wp_editor( $game_button_notice[0], 'game_button_notice', $editor_args );
		?>
	</div>
</div>

<?php
$units_section_name = esc_html__( 'Games', 'aces' );
if ( get_option( 'games_section_name') ) {
	$units_section_name = esc_html__( get_option( 'games_section_name' ) );
}
?>

<div class="components-base-control units_disable_more_block" style="padding-top:15px;">
	<div class="components-base-control__field">
		<input type="checkbox" name="units_disable_more_block" <?php if( $units_disable_more_block == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Disable More', 'aces' )?> <?php esc_html_e( $units_section_name );?> <?php esc_html_e( 'Block', 'aces' )?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_games_save_fields', 10, 2 );

function aces_games_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_games_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_games_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_games_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'game' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$game_external_link = esc_url( $_POST['game_external_link'] );
        update_post_meta( $post_id, 'game_external_link', $game_external_link );

		$game_button_title = sanitize_text_field( $_POST['game_button_title'] );
        update_post_meta( $post_id, 'game_button_title', $game_button_title );

        $game_button_notice = $_POST['game_button_notice'];
        update_post_meta( $post_id, 'game_button_notice', $game_button_notice );

        $game_permalink_button_title = sanitize_text_field( $_POST['game_permalink_button_title'] );
        update_post_meta( $post_id, 'game_permalink_button_title', $game_permalink_button_title );

        $units_disable_more_block = sanitize_text_field( $_POST['units_disable_more_block'] );
        update_post_meta( $post_id, 'units_disable_more_block', $units_disable_more_block );
}

/*  Games - Additional Fields End  */

/*  Relationship of the Game and Casino Start  */

add_action( 'admin_init', 'aces_games_casinos_list' );

function aces_games_casinos_list() {

	$casinos_section_name = esc_html__( 'Casinos', 'aces' );
	if ( get_option( 'casinos_section_name') ) {
		$casinos_section_name = esc_html__( get_option( 'casinos_section_name' ) );
	}

    add_meta_box( 'aces_games_casinos_list_meta_box',
        $casinos_section_name,
        'aces_games_display_casinos_list_meta_box',
        'game', 'side', 'high'
    );
}

function aces_games_display_casinos_list_meta_box( $game ) {
    wp_nonce_field( basename(__FILE__), 'game_custom_nonce' );

    $postmeta = get_post_meta( $game->ID, 'parent_casino', true );
    $casinos = get_posts(array( 'post_type'=>'casino', 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ));

    if( $casinos ) {
    	$elements = [];
    	foreach( $casinos as $casino ) {
    		$elements[$casino->ID] = $casino->post_title;
        }
    ?>
	<div style="max-height:200px; overflow-y:auto;">
		<ul>
	    <?php foreach ( $elements as $id => $element) {

	        if ( is_array( $postmeta ) && in_array( $id, $postmeta ) ) {
	            $checked = 'checked=checked';
	        } else {
	            $checked = null;
	        }

	        ?>

	        <li>
				<label>
	            <input type="checkbox" name="casino_item[]" value="<?php esc_attr_e($id);?>" <?php esc_attr_e($checked); ?>>
	            <?php esc_html_e($element); ?>
	        	</label>
			</li>

	    <?php } ?>
		</ul>
	</div>
    <?php
	} else {
		esc_html_e( 'No items', 'aces' );
	}
}

add_action( 'save_post', 'aces_games_casinos_save_fields', 10, 2 );

function aces_games_casinos_save_fields( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'game_custom_nonce' ] ) && wp_verify_nonce( $_POST[ 'game_custom_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // If the checkbox was not empty, save it as array in post meta
    if ( ! empty( $_POST['casino_item'] ) ) {
        update_post_meta( $post_id, 'parent_casino', $_POST['casino_item'] );

    // Otherwise just delete it if its blank value.
    } else {
        delete_post_meta( $post_id, 'parent_casino' );
    }

};

/*  Relationship of the Game and Casino End  */

/*  Add vendors logo Start  */

/* --- Add custom taxonomy field --- */

function aces_add_vendor_taxonomy_image($taxonomy) {
?>
<div class="form-field term-group">
    <label for="taxonomy-image-id">
    	<?php esc_html_e('Logo', 'aces'); ?>
    </label>
    <input type="hidden" id="taxonomy-image-id" name="taxonomy-image-id" class="custom_media_url" value="">
    <div id="taxonomy-image-wrapper"></div>
    <p>
	    <input type="button" class="button button-secondary aces_media_button" id="aces_media_button" name="aces_media_button" value="<?php esc_attr_e( 'Add Logo', 'aces' ); ?>" />
	    <input type="button" class="button button-secondary aces_media_remove" id="aces_media_remove" name="aces_media_remove" value="<?php esc_attr_e( 'Remove Logo', 'aces' ); ?>" />
    </p>
</div>
<?php
}

add_action('vendor_add_form_fields', 'aces_add_vendor_taxonomy_image', 10, 2);

/* --- Save the custom taxonomy field --- */

function aces_save_vendor_taxonomy_image($term_id, $tt_id) {
	if( isset( $_POST['taxonomy-image-id'] ) && '' !== $_POST['taxonomy-image-id'] ){
    	$image = esc_attr( $_POST['taxonomy-image-id'] );
    	add_term_meta( $term_id, 'taxonomy-image-id', $image, true );
	}
}

add_action('created_vendor', 'aces_save_vendor_taxonomy_image', 10, 2);

/* --- Add custom taxonomy field for edit --- */

function aces_edit_vendor_image_upload($term, $taxonomy) {
?>
<tr class="form-field term-group-wrap">
    <th scope="row">
    	<label for="taxonomy-image-id">
    		<?php esc_html_e( 'Logo', 'aces' ); ?>
    	</label>
    </th>
    <td>
    	<?php $image_id = get_term_meta ( $term->term_id, 'taxonomy-image-id', true ); ?>
    	<input type="hidden" id="taxonomy-image-id" name="taxonomy-image-id" value="<?php echo esc_attr( $image_id ); ?>">
    	<div id="taxonomy-image-wrapper">
        <?php if ( $image_id ) { ?>
        	<?php echo wp_get_attachment_image ( $image_id, 'mercury-custom-logo' ); ?>
        <?php } ?>
       	</div>
       	<p>
	        <input type="button" class="button button-secondary aces_media_button" id="aces_media_button" name="aces_media_button" value="<?php esc_attr_e( 'Add Logo', 'aces' ); ?>" />
	        <input type="button" class="button button-secondary aces_media_remove" id="aces_media_remove" name="aces_media_remove" value="<?php esc_attr_e( 'Remove Logo', 'aces' ); ?>" />
    	</p>
    </td>
</tr>
<?php
}

add_action('vendor_edit_form_fields', 'aces_edit_vendor_image_upload', 10, 2);

/* --- Save the edited value of the custom taxonomy field --- */

function aces_update_vendor_image_upload($term_id, $tt_id) {
	if( isset( $_POST['taxonomy-image-id'] ) && '' !== $_POST['taxonomy-image-id'] ){
    	$image = esc_attr( $_POST['taxonomy-image-id'] );
    	update_term_meta ( $term_id, 'taxonomy-image-id', $image );
	} else {
    	update_term_meta ( $term_id, 'taxonomy-image-id', '' );
	}
}

add_action('edited_vendor', 'aces_update_vendor_image_upload', 10, 2);

/*  Add vendors logo End  */

/*  Upload Background image of game single page - Start  */

function aces_game_background_image_block() {
	add_meta_box('aces_game_background_image_box',
		esc_html__( 'Background Image', 'aces' ),
		'aces_game_background_image_block_show',
		'game', 'normal', 'core'
	);
}
add_action( 'admin_menu', 'aces_game_background_image_block' );

function aces_game_background_image_block_show( $game ) {

	wp_nonce_field( 'aces_game_background_box', 'aces_game_background_nonce' );
	$aces_single_game_background_image = 'aces_single_game_background_image';

	echo aces_background_image_uploader( $aces_single_game_background_image, get_post_meta($game->ID, $aces_single_game_background_image, true) );
}
 
function aces_game_background_image_block_save( $post_id ) {

	if ( ! isset( $_POST['aces_game_background_nonce'] ) ) {
        return $post_id;
    }

    $nonce = $_POST['aces_game_background_nonce'];

    if ( ! wp_verify_nonce( $nonce, 'aces_game_background_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'game' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    }

    $aces_single_game_background_image = 'aces_single_game_background_image';
    update_post_meta( $post_id, $aces_single_game_background_image, sanitize_text_field( $_POST[$aces_single_game_background_image] ) );

}
add_action('save_post', 'aces_game_background_image_block_save');

/*  Upload Background image of game single page - End  */