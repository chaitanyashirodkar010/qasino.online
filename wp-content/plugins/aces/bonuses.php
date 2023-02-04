<?php

/*  Bonuses - Post Type Start */

add_action('init', 'aces_bonuses', 0 );

function aces_bonuses() {

	$bonus_slug = 'bonus';
	if ( get_option( 'bonuses_section_slug') ) {
		$bonus_slug = get_option( 'bonuses_section_slug', 'bonus' );
	}

	$bonus_name = esc_html__('Bonuses', 'aces');
	if ( get_option( 'bonuses_section_name') ) {
		$bonus_name = get_option( 'bonuses_section_name', 'Bonuses' );
	}

	$args = array(
        'labels' => array(
			'name' => $bonus_name,
			'add_new' => esc_html__('Add New', 'aces'),
            'edit_item' => esc_html__('Edit Item', 'aces'),
            'add_new_item' => esc_html__('Add New', 'aces'),
            'view_item' => esc_html__('View Item', 'aces'),
        ),
        'singular_label' => __('bonus'),
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
		'rest_base' => 'offer',
		'rewrite' => array(
			'slug' => $bonus_slug,
			'with_front' => false
		)
    );

register_post_type( 'bonus' , $args );

/* --- Category: Custom Taxonomy --- */

$bonuses_category_title = esc_html__('Categories', 'aces');
if ( get_option( 'bonuses_category_title') ) {
	$bonuses_category_title = get_option( 'bonuses_category_title', 'Categories' );
}

$labels = array(
	'name' => $bonuses_category_title,
	'singular_name' => $bonuses_category_title,
	'search_items' => esc_html__('Find Taxonomy', 'aces'),
	'all_items' => esc_html__('All ', 'aces') . $bonuses_category_title,
	'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
	'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
	'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
	'view_item' => esc_html__('View Taxonomy', 'aces'),
	'update_item' => esc_html__('Update Taxonomy', 'aces'),
	'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
	'new_item_name' => esc_html__('Taxonomy', 'aces'),
	'menu_name' => $bonuses_category_title
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

register_taxonomy('bonus-category', 'bonus', $args);

}

/* --- Add custom slug for taxonomy 'bonus-category' --- */

if ( get_option( 'bonus_category_slug') ) {

	function aces_change_bonus_category_slug( $taxonomy, $object_type, $args ) {

		$bonus_category_slug = 'bonus-category';

		if ( get_option( 'bonus_category_slug') ) {
			$bonus_category_slug = get_option( 'bonus_category_slug', 'bonus-category' );
		}

	    if( 'bonus-category' == $taxonomy ) {
	        remove_action( current_action(), __FUNCTION__ );
	        $args['rewrite'] = array( 'slug' => $bonus_category_slug );
	        register_taxonomy( $taxonomy, $object_type, $args );
	    }

	}
	add_action( 'registered_taxonomy', 'aces_change_bonus_category_slug', 10, 3 );

}

/*  Bonuses - Post Type End */

/*  Bonuses - Short Description Start */

add_action( 'admin_init', 'aces_offers_short_desc_fields' );

function aces_offers_short_desc_fields() {
    add_meta_box( 'aces_offers_short_desc_meta_box',
        esc_html__( 'Short description', 'aces' ),
        'aces_offers_short_desc_display_meta_box',
        'bonus', 'normal', 'high'
    );
}

function aces_offers_short_desc_display_meta_box( $bonus ) {

	wp_nonce_field( 'aces_offers_short_desc_box', 'aces_offers_short_desc_nonce' );
	$bonus_short_desc = get_post_meta( $bonus->ID, 'bonus_short_desc', false );
	
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

<div class="components-base-control bonus_short_desc">
	<div class="components-base-control__field">
		<?php
		if ( empty($bonus_short_desc[0]) ) {
			$bonus_short_desc[0] = '';
		}
		wp_editor( $bonus_short_desc[0], 'bonus_short_desc', $editor_args );
		?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_offers_short_desc_save_fields', 10, 2 );

function aces_offers_short_desc_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_offers_short_desc_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_offers_short_desc_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_offers_short_desc_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$bonus_short_desc = $_POST['bonus_short_desc'];
        update_post_meta( $post_id, 'bonus_short_desc', $bonus_short_desc );
}

/*  Bonuses - Short Description End */

/*  Bonuses - Detailed T&Cs Start */

add_action( 'admin_init', 'aces_offers_detailed_tc_fields' );

function aces_offers_detailed_tc_fields() {
    add_meta_box( 'aces_offers_detailed_tc_meta_box',
        esc_html__( 'Detailed T&Cs', 'aces' ),
        'aces_offers_detailed_tc_display_meta_box',
        'bonus', 'normal', 'high'
    );
}

function aces_offers_detailed_tc_display_meta_box( $bonus ) {

	wp_nonce_field( 'aces_offers_detailed_tc_box', 'aces_offers_detailed_tc_nonce' );

	$custom = get_post_custom($bonus->ID);
	$offer_detailed_tc = get_post_meta( $bonus->ID, 'offer_detailed_tc', false );
	$aces_offer_popup_hide = isset($custom["aces_offer_popup_hide"][0]) ? stripslashes($custom["aces_offer_popup_hide"][0]) : '';
	$aces_offer_popup_title = get_post_meta( $bonus->ID, 'aces_offer_popup_title', true );
	
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

<div class="components-base-control offer_detailed_tc">
	<div class="components-base-control__field" style="padding-bottom: 30px;">
		<?php
		if ( empty($offer_detailed_tc[0]) ) {
			$offer_detailed_tc[0] = '';
		}
		wp_editor( $offer_detailed_tc[0], 'offer_detailed_tc', $editor_args );
		?>
	</div>
</div>

<div class="components-base-control aces_offer_popup_hide" style="padding: 5px 0 10px 0;">
	<div class="components-base-control__field">
		<input type="checkbox" name="aces_offer_popup_hide" <?php if( $aces_offer_popup_hide == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Hide the Detailed T&Cs in a popup box', 'aces' )?>
	</div>
</div>

<div class="components-base-control aces_offer_popup_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="aces_offer_popup_title-0"><?php esc_html_e( 'Custom link title for the', 'aces' ); ?> <strong><?php esc_html_e( 'popup box', 'aces' ); ?></strong></label>
		<input type="text" name="aces_offer_popup_title" id="aces_offer_popup_title-0" value="<?php echo esc_attr($aces_offer_popup_title); ?>" style="display: block; margin-top: 5px;" />
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_offers_detailed_tc_save_fields', 10, 2 );

function aces_offers_detailed_tc_save_fields( $post_id ) {

		if ( ! isset( $_POST['aces_offers_detailed_tc_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_offers_detailed_tc_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_offers_detailed_tc_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$offer_detailed_tc = $_POST['offer_detailed_tc'];
        update_post_meta( $post_id, 'offer_detailed_tc', $offer_detailed_tc );

        $aces_offer_popup_hide = sanitize_text_field( $_POST['aces_offer_popup_hide'] );
        update_post_meta( $post_id, 'aces_offer_popup_hide', $aces_offer_popup_hide );

        $aces_offer_popup_title = sanitize_text_field( $_POST['aces_offer_popup_title'] );
        update_post_meta( $post_id, 'aces_offer_popup_title', $aces_offer_popup_title );
}

/*  Bonuses - Detailed T&Cs End */

/*  Bonuses - Additional Fields Start */

add_action( 'admin_init', 'aces_bonuses_fields' );

function aces_bonuses_fields() {
    add_meta_box( 'aces_bonuses_meta_box',
        esc_html__( 'Additional information', 'aces' ),
        'aces_bonuses_display_meta_box',
        'bonus', 'side', 'high'
    );
}

function aces_bonuses_display_meta_box( $bonus ) {
	wp_nonce_field( 'aces_bonuses_box', 'aces_bonuses_nonce' );
	$custom = get_post_custom($bonus->ID);
	$bonus_external_link = get_post_meta( $bonus->ID, 'bonus_external_link', true );
	$bonus_button_title = get_post_meta( $bonus->ID, 'bonus_button_title', true );
	$bonus_button_notice = get_post_meta( $bonus->ID, 'bonus_button_notice', false );
	$bonus_code = get_post_meta( $bonus->ID, 'bonus_code', true );
	$bonus_valid_date = get_post_meta( $bonus->ID, 'bonus_valid_date', true );
	$bonus_dark_style = isset($custom["bonus_dark_style"][0]) ? stripslashes($custom["bonus_dark_style"][0]) : '';
	$offers_disable_more_block = isset($custom["offers_disable_more_block"][0]) ? stripslashes($custom["offers_disable_more_block"][0]) : '';

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

<div class="components-base-control bonus_external_link">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_external_link-0"><?php esc_html_e( 'External URL for the', 'aces' )?> <strong><?php esc_html_e( 'Get Bonus', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="url" name="bonus_external_link" id="bonus_external_link-0" value="<?php echo esc_url($bonus_external_link); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_button_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_button_title-0"><?php esc_html_e( 'Custom title for the', 'aces' )?> <strong><?php esc_html_e( 'Get Bonus', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="text" name="bonus_button_title" id="bonus_button_title-0" value="<?php echo esc_attr($bonus_button_title); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_code">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_code-0"><?php esc_html_e( 'Bonus Code:', 'aces' )?></label>
		<input type="text" name="bonus_code" id="bonus_code-0" value="<?php echo esc_attr($bonus_code); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_valid_date">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_valid_date-0"><?php esc_html_e( 'Valid until the date:', 'aces' )?></label>
		<input type="date" name="bonus_valid_date" id="bonus_valid_date-0" value="<?php echo esc_attr($bonus_valid_date); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_dark_style" style="padding-bottom:20px;">
	<div class="components-base-control__field">
		<input type="checkbox" name="bonus_dark_style" <?php if( $bonus_dark_style == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Dark Style', 'aces' )?>
	</div>
</div>

<div class="components-base-control bonus_button_notice">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_button_notice-0"><?php esc_html_e( 'Notification under the button', 'aces' ); ?></label>
		<?php
		if ( empty($bonus_button_notice[0]) ) {
			$bonus_button_notice[0] = '';
		}
		wp_editor( $bonus_button_notice[0], 'bonus_button_notice', $editor_args );
		?>
	</div>
</div>

<?php
$offers_section_name = esc_html__( 'Bonuses', 'aces' );
if ( get_option( 'bonuses_section_name') ) {
	$offers_section_name = esc_html__( get_option( 'bonuses_section_name' ) );
}
?>

<div class="components-base-control offers_disable_more_block" style="padding-top:15px;">
	<div class="components-base-control__field">
		<input type="checkbox" name="offers_disable_more_block" <?php if( $offers_disable_more_block == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Disable More', 'aces' )?> <?php esc_html_e( $offers_section_name );?> <?php esc_html_e( 'Block', 'aces' )?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_bonuses_save_fields', 10, 2 );

function aces_bonuses_save_fields( $post_id ) {
		if ( ! isset( $_POST['aces_bonuses_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_bonuses_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_bonuses_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$bonus_external_link = esc_url( $_POST['bonus_external_link'] );
        update_post_meta( $post_id, 'bonus_external_link', $bonus_external_link );

		$bonus_button_title = sanitize_text_field( $_POST['bonus_button_title'] );
        update_post_meta( $post_id, 'bonus_button_title', $bonus_button_title );

        $bonus_button_notice = $_POST['bonus_button_notice'];
        update_post_meta( $post_id, 'bonus_button_notice', $bonus_button_notice );

        $bonus_code = sanitize_text_field( $_POST['bonus_code'] );
        update_post_meta( $post_id, 'bonus_code', $bonus_code );

        $bonus_valid_date = sanitize_text_field( $_POST['bonus_valid_date'] );
        update_post_meta( $post_id, 'bonus_valid_date', $bonus_valid_date );

        $bonus_dark_style = sanitize_text_field( $_POST['bonus_dark_style'] );
        update_post_meta( $post_id, 'bonus_dark_style', $bonus_dark_style );

        $offers_disable_more_block = sanitize_text_field( $_POST['offers_disable_more_block'] );
        update_post_meta( $post_id, 'offers_disable_more_block', $offers_disable_more_block );
}

/*  Bonuses - Additional Fields End */

/*  Relationship of the Bonus and Casino Start  */

add_action( 'admin_init', 'aces_bonuses_casinos_list' );

function aces_bonuses_casinos_list() {

	$casinos_section_name = esc_html__( 'Casinos', 'aces' );
	if ( get_option( 'casinos_section_name') ) {
		$casinos_section_name = esc_html__( get_option( 'casinos_section_name' ) );
	}

    add_meta_box( 'aces_bonuses_casinos_list_meta_box',
        $casinos_section_name,
        'aces_bonuses_display_casinos_list_meta_box',
        'bonus', 'side', 'high'
    );
}

function aces_bonuses_display_casinos_list_meta_box( $bonus ) {
    wp_nonce_field( basename(__FILE__), 'bonus_custom_nonce' );

    $postmeta = get_post_meta( $bonus->ID, 'bonus_parent_casino', true );
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
	            <input type="checkbox" name="bonus_casino_item[]" value="<?php esc_attr_e($id);?>" <?php esc_attr_e($checked); ?>>
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

add_action( 'save_post', 'aces_bonuses_casinos_save_fields', 10, 2 );

function aces_bonuses_casinos_save_fields( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'bonus_custom_nonce' ] ) && wp_verify_nonce( $_POST[ 'bonus_custom_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // If the checkbox was not empty, save it as array in post meta
    if ( ! empty( $_POST['bonus_casino_item'] ) ) {
        update_post_meta( $post_id, 'bonus_parent_casino', $_POST['bonus_casino_item'] );

    // Otherwise just delete it if its blank value.
    } else {
        delete_post_meta( $post_id, 'bonus_parent_casino' );
    }

};

/*  Relationship of the Bonus and Casino End  */