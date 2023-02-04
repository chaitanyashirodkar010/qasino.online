<?php
 
/*  Aces Options Menu Item Start */

function aces_options_page() {
	add_menu_page(
		esc_html__( 'ACES', 'aces' ),
		esc_html__( 'ACES', 'aces' ),
		'manage_options',
		'aces',
		'aces_options_page_html',
		plugins_url( 'aces/images/menu-icon.png' ),
        59
	);
}
add_action( 'admin_menu', 'aces_options_page' );

/*  Aces Options Menu Item End */

/*  Aces Options Page Start */

function aces_options_page_html() {

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

if ( isset( $_GET['settings-updated'] ) ) {
	add_settings_error( 'aces_messages', 'aces_message', esc_html__( 'Settings Saved', 'aces' ), 'updated' );
}

settings_errors( 'aces_messages' );

if( isset( $_GET[ 'tab' ] ) ) {  
    $active_tab = $_GET[ 'tab' ];  
} else {
    $active_tab = 'casinos_tab';
}


$organizations_tab_name = esc_html__('Casinos', 'aces');
if ( get_option( 'casinos_section_name') ) {
    $organizations_tab_name = get_option( 'casinos_section_name' );
}

$units_tab_name = esc_html__('Games', 'aces');
if ( get_option( 'games_section_name') ) {
    $units_tab_name = get_option( 'games_section_name' );
}

$offers_tab_name = esc_html__('Bonuses', 'aces');
if ( get_option( 'bonuses_section_name') ) {
    $offers_tab_name = get_option( 'bonuses_section_name' );
}

?>

<div class="wrap">
    <style type="text/css">
        #aces_casinos_tab_titles,
        #aces_casinos_tab_slugs,
        #aces_casinos_tab_rating_titles,
        #aces_casinos_tab_other_settings,
        #aces_games_tab_titles,
        #aces_games_tab_slugs,
        #aces_games_tab_other_settings,
        #aces_bonuses_tab_titles,
        #aces_bonuses_tab_slugs,
        #aces_bonuses_tab_other_settings,
        #aces_geolocation_tab_title,
        #aces_geolocation_tab_api {
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        form h2 {
            color: #e74c3c;
        }
    </style>
	<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?><span class="title-count theme-count"><?php echo esc_html( $GLOBALS['aces_version'] ); ?></span></h1>
    <div style="padding-bottom: 10px;">
        <?php esc_html_e( 'ACES plugin by', 'aces' ); ?> <a href="<?php echo esc_url( __( 'https://mercurytheme.com/', 'aces' ) ); ?>" title="<?php esc_attr_e( 'MercuryTheme.com', 'aces' ); ?>" target="_blank"><?php esc_html_e( 'MercuryTheme.com', 'aces' ); ?></a>
    </div>
    
    <h2 class="nav-tab-wrapper">
        <a href="?page=aces&tab=casinos_tab" class="nav-tab <?php echo $active_tab == 'casinos_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Organizations', 'aces'); ?> (<?php echo esc_html( $organizations_tab_name ); ?>)</a>
        <a href="?page=aces&tab=games_tab" class="nav-tab <?php echo $active_tab == 'games_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Units', 'aces'); ?> (<?php echo esc_html( $units_tab_name ); ?>)</a>
        <a href="?page=aces&tab=bonuses_tab" class="nav-tab <?php echo $active_tab == 'bonuses_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Offers', 'aces'); ?> (<?php echo esc_html( $offers_tab_name ); ?>)</a>
        <a href="?page=aces&tab=geolocation_tab" class="nav-tab <?php echo $active_tab == 'geolocation_tab' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Geolocation', 'aces'); ?></a>
    </h2> 

	<form method="post" action="options.php">
    	<?php

        submit_button( esc_html__( 'Save Settings', 'aces' ) );

        if( $active_tab == 'casinos_tab' )  {

            settings_fields( 'aces_casinos_tab' );
            do_settings_sections( 'aces_casinos_tab' );

        } else if( $active_tab == 'games_tab' )  {

            settings_fields( 'aces_games_tab' );
            do_settings_sections( 'aces_games_tab' );

        } else if( $active_tab == 'bonuses_tab' )  {

            settings_fields( 'aces_bonuses_tab' );
            do_settings_sections( 'aces_bonuses_tab' );

        } else if( $active_tab == 'geolocation_tab' )  {

            settings_fields( 'aces_geolocation_tab' );
            do_settings_sections( 'aces_geolocation_tab' );

        }

    	submit_button( esc_html__( 'Save Settings', 'aces' ) );

    	?>
	</form>
</div>

<?php
}

/*  Aces Options Page End */