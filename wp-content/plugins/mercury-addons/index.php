<?php
/*
Plugin Name: Mercury Addons
Plugin URI: https://mercurytheme.com/
Description: Addons for the Mercury Theme by mercurytheme.com.
Version: 2.6.1
Author: MercuryTheme.com
Author URI: https://mercurytheme.com/
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: spacethemes
*/

global $spacethemes_options, $spacethemes_plugin_dir, $spacethemes_plugin_url;

$spacethemes_plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
$spacethemes_plugin_url = untrailingslashit( plugin_dir_url( __FILE__ ) );

function spacethemes_init() {
    load_plugin_textdomain( 'spacethemes', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_filter( 'init', 'spacethemes_init' );

/*  Post template style Start */

function spacethemes_register_post_style() {
    add_meta_box( 'meta-box-id', esc_html__( 'Post Template', 'spacethemes' ), 'spacethemes_post_style_callback', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'spacethemes_register_post_style' );

function spacethemes_post_style_callback( $post ) {
	wp_nonce_field( 'post_style_box', 'post_style_nonce' );
    $post_style = get_post_meta( $post->ID, 'post_style', true );
?>
    <?php $selected = ' selected'; ?>
    <select id="post_style" name="post_style" style="width: calc(100% - 32px);">
     <option value="1"<?php if ( $post_style == '1') echo esc_html( $selected ); ?>><?php esc_html_e( 'Style 1', 'spacethemes' ); ?></option>
     <option value="2"<?php if ( $post_style == '2') echo esc_html( $selected ); ?>><?php esc_html_e( 'Style 2 (Without Sidebar)', 'spacethemes' ); ?></option>
     <option value="3"<?php if ( $post_style == '3') echo esc_html( $selected ); ?>><?php esc_html_e( 'Style 3', 'spacethemes' ); ?></option>
     <option value="4"<?php if ( $post_style == '4') echo esc_html( $selected ); ?>><?php esc_html_e( 'Style 4 (Without Sidebar)', 'spacethemes' ); ?></option>
     <option value="5"<?php if ( $post_style == '5') echo esc_html( $selected ); ?>><?php esc_html_e( 'Empty Template', 'spacethemes' ); ?></option>
     <option value="6"<?php if ( $post_style == '6') echo esc_html( $selected ); ?>><?php esc_html_e( 'Empty Template + Right Sidebar', 'spacethemes' ); ?></option>
    </select>
<?php
}

function spacethemes_post_style_save( $post_id ) {

        if ( ! isset( $_POST['post_style_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['post_style_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'post_style_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $post_style_data = sanitize_text_field( $_POST['post_style'] );

        update_post_meta( $post_id, 'post_style', $post_style_data );
}
add_action( 'save_post', 'spacethemes_post_style_save' );

/*  Post template style End */

/*  Post Views Count Start  */

if( get_theme_mod('mercury_post_views_counter') ) {

    // Get Post Views

    function spacethemes_get_post_views($postID){

        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);

        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count.'';

    }

    // Set Post Views

    function spacethemes_set_post_views($postID) {
        
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);

        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }

    }

}

/*  Post Views Count End  */

/*  Add a featured post image column in the admin panel - Start  */

function spacethemes_featured_image_column_post( $column_ars ) {

    $column_ars = array_slice( $column_ars, 0, 1, true )
    + array('mercury_featured_image' => 'Image')
    + array_slice( $column_ars, 1, NULL, true );
    return $column_ars;
}

add_filter('manage_post_posts_columns', 'spacethemes_featured_image_column_post');

/*  ---  Display image column  ---  */

function spacethemes_display_featured_image_column( $column_name, $post_id ) {
 
    if( $column_name == 'mercury_featured_image' ) {
        if( has_post_thumbnail( $post_id ) ) {
            $image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail');
            $image_id = get_post_thumbnail_id( $post_id );
            echo '<img data-id="' . $image_id . '" src="' . esc_url($image_src[0]) . '" />';
        }
    }
 
}

add_action('manage_posts_custom_column', 'spacethemes_display_featured_image_column', 10, 2);

/* --- Add CSS styles for the custom featured image column --- */

function spacethemes_custom_featured_image_css(){
 
    echo '<style>
        #mercury_featured_image {
            width: 100px;
        }
        td.mercury_featured_image.column-mercury_featured_image img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>';
 
}

add_action( 'admin_head', 'spacethemes_custom_featured_image_css' );

/*  Add a featured post column in the admin panel - End  */

/*  The Casino page style - Start */

function spacethemes_casino_register_post_style() {
    add_meta_box( 'casino_style_meta_box',
        esc_html__( 'Template for this page', 'spacethemes' ),
        'spacethemes_casino_post_style_callback',
        'casino', 'side', 'high'
    );
}
add_action( 'admin_init', 'spacethemes_casino_register_post_style' );

function spacethemes_casino_post_style_callback( $casino ) {
    wp_nonce_field( 'casino_style_box', 'casino_style_nonce' );
    $casino_style = get_post_meta( $casino->ID, 'casino_style', true );
?>
    <?php $selected = ' selected'; ?>
    <select id="casino_style" name="casino_style" style="width: calc(100% - 32px);">
        <option value="1"<?php if ( $casino_style == '1') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 1', 'spacethemes' ); ?></option>
        <option value="3"<?php if ( $casino_style == '3') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 1 (Without Sidebar)', 'spacethemes' ); ?></option>
        <option value="2"<?php if ( $casino_style == '2') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 2', 'spacethemes' ); ?></option>
        <option value="4"<?php if ( $casino_style == '4') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 2 (Without Sidebar)', 'spacethemes' ); ?></option>
        <option value="5"<?php if ( $casino_style == '5') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 3', 'spacethemes' ); ?></option>
        <option value="6"<?php if ( $casino_style == '6') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 3 (Without Sidebar)', 'spacethemes' ); ?></option>
        <option value="7"<?php if ( $casino_style == '7') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Empty Template', 'spacethemes' ); ?></option>
        <option value="8"<?php if ( $casino_style == '8') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Empty Template + Right Sidebar', 'spacethemes' ); ?></option>
    </select>
<?php
}

function spacethemes_casino_post_style_save( $post_id ) {

        if ( ! isset( $_POST['casino_style_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['casino_style_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'casino_style_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'casino' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $casino_style = sanitize_text_field( $_POST['casino_style'] );
        update_post_meta( $post_id, 'casino_style', $casino_style );
}
add_action( 'save_post', 'spacethemes_casino_post_style_save' );

/*  The Casino page style - End */

/*  The Game page style - Start */

function spacethemes_game_register_post_style() {
    add_meta_box( 'game_style_meta_box',
        esc_html__( 'Template for this page', 'spacethemes' ),
        'spacethemes_game_post_style_callback',
        'game', 'side', 'high'
    );
}
add_action( 'admin_init', 'spacethemes_game_register_post_style' );

function spacethemes_game_post_style_callback( $game ) {
    wp_nonce_field( 'game_style_box', 'game_style_nonce' );
    $game_style = get_post_meta( $game->ID, 'game_style', true );
?>
    <?php $selected = ' selected'; ?>
    <select id="game_style" name="game_style" style="width: calc(100% - 32px);">
        <option value="1"<?php if ( $game_style == '1') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 1', 'spacethemes' ); ?></option>
        <option value="2"<?php if ( $game_style == '2') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 1 (Without Sidebar)', 'spacethemes' ); ?></option>
        <option value="3"<?php if ( $game_style == '3') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 2', 'spacethemes' ); ?></option>
        <option value="4"<?php if ( $game_style == '4') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 2 (Without Sidebar)', 'spacethemes' ); ?></option>
        <option value="5"<?php if ( $game_style == '5') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 3', 'spacethemes' ); ?></option>
        <option value="6"<?php if ( $game_style == '6') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 3 (Without Sidebar)', 'spacethemes' ); ?></option>
        <option value="7"<?php if ( $game_style == '7') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Empty Template', 'spacethemes' ); ?></option>
        <option value="8"<?php if ( $game_style == '8') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Empty Template + Right Sidebar', 'spacethemes' ); ?></option>
    </select>
<?php
}

function spacethemes_game_post_style_save( $post_id ) {

        if ( ! isset( $_POST['game_style_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['game_style_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'game_style_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'game' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $game_style = sanitize_text_field( $_POST['game_style'] );
        update_post_meta( $post_id, 'game_style', $game_style );
}
add_action( 'save_post', 'spacethemes_game_post_style_save' );

/*  The Game page style - End */

/*  The Bonus page style - Start */

function spacethemes_offer_register_post_style() {
    add_meta_box( 'offer_style_meta_box',
        esc_html__( 'Template for this psage', 'spacethemes' ),
        'spacethemes_offer_post_style_callback',
        'bonus', 'side', 'high'
    );
}
add_action( 'admin_init', 'spacethemes_offer_register_post_style' );

function spacethemes_offer_post_style_callback( $bonus ) {
    wp_nonce_field( 'offer_style_box', 'offer_style_nonce' );
    $mercury_offer_style = get_post_meta( $bonus->ID, 'mercury_offer_style', true );
?>
    <?php $selected = ' selected'; ?>
    <select id="mercury_offer_style" name="mercury_offer_style" style="width: calc(100% - 32px);">
        <option value="1"<?php if ( $mercury_offer_style == '1') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Style 1', 'spacethemes' ); ?></option>
        <option value="2"<?php if ( $mercury_offer_style == '2') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Empty Template', 'spacethemes' ); ?></option>
        <option value="3"<?php if ( $mercury_offer_style == '3') echo esc_attr( $selected ); ?>><?php esc_html_e( 'Empty Template + Right Sidebar', 'spacethemes' ); ?></option>
    </select>
<?php
}

function spacethemes_offer_post_style_save( $post_id ) {

        if ( ! isset( $_POST['offer_style_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['offer_style_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'offer_style_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $mercury_offer_style = sanitize_text_field( $_POST['mercury_offer_style'] );
        update_post_meta( $post_id, 'mercury_offer_style', $mercury_offer_style );
}
add_action( 'save_post', 'spacethemes_offer_post_style_save' );

/*  The Bonus page style - End */

/*  Custom Mercury Theme Widgets Start  */

include_once $spacethemes_plugin_dir . '/widgets/widget-1.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-2.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-3.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-4.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-5.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-6.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-7.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-8.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-9.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-10.php';
include_once $spacethemes_plugin_dir . '/widgets/widget-11.php';

/*  Custom Mercury Theme Widgets End  */

/*  Custom Mercury Theme Shortcodes Start  */

include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-1.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-2.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-3.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-4.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-5.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-6.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-7.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-8.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-9.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-10.php';
include_once $spacethemes_plugin_dir . '/shortcodes/posts-shortcode-11.php';
include_once $spacethemes_plugin_dir . '/shortcodes/mercury-content-1.php';

/*  Custom Mercury Theme Shortcodes End  */