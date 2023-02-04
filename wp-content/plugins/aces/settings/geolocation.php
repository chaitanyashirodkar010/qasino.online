<?php

function aces_geolocation_settings_init() {

    /*  Geolocation settings tab - Start  */

    /*  --- The setting sections ---  */

    add_settings_section(
        'aces_geolocation_tab_enable',
        esc_html__( 'Enable geolocation', 'aces' ),
        'aces_geolocation_tab_enable_callback',
        'aces_geolocation_tab'
    );

    add_settings_section(
        'aces_geolocation_tab_api',
        esc_html__( 'API key', 'aces' ),
        'aces_geolocation_tab_api_callback',
        'aces_geolocation_tab'
    );

    add_settings_section(
        'aces_geolocation_tab_messages',
        esc_html__( 'Messages', 'aces' ),
        'aces_geolocation_tab_messages_callback',
        'aces_geolocation_tab'
    );

    /*  --- Descriptions ---  */

    function aces_geolocation_tab_enable_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <a href="<?php echo esc_url( __( 'https://ipdata.co/', 'aces' ) ); ?>" target="_blank"><?php esc_html_e( 'ipdata.co', 'aces' ); ?></a> <?php esc_html_e( 'provides API for the geolocation service.', 'aces' ); ?> <strong><?php esc_html_e( 'The Free API is limited to 1,500 daily requests.', 'aces' ); ?></strong>
        </p>
        <?php
    }

    function aces_geolocation_tab_api_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <strong><?php esc_html_e( 'You can get a free API key (for non-commercial usage only) on the', 'aces' ); ?> <a href="<?php echo esc_url( __( 'https://ipdata.co/', 'aces' ) ); ?>" target="_blank"><?php esc_html_e( 'ipdata.co', 'aces' ); ?></a> <?php esc_html_e( 'website after registration.', 'aces' ); ?></strong>
        </p>
        <?php
    }

    function aces_geolocation_tab_messages_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <?php esc_html_e( 'You can change the message texts to your own.', 'aces' ); ?> <strong><?php esc_html_e( 'IMPORTANT!', 'aces' ); ?></strong> <?php esc_html_e( 'Where you need to display the name of the country, please add this expression:', 'aces' ); ?> <strong><?php esc_html_e( '%s', 'aces' ); ?></strong>
        </p>
        <?php
    }

    /*  ----------------

    Enable geolocation setting checkbox

    ----------------  */

    add_settings_field(
        'aces_geolocation_enable',
        esc_html__( 'Enable geolocation', 'aces' ),
        'aces_geolocation_enable_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_enable',
        array(
            'id' => 'aces_geolocation_enable', 
            'option_name' => 'aces_geolocation_enable'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_enable', 'esc_attr');

    function aces_geolocation_enable_callback($args) {
        $option = get_option( 'aces_geolocation_enable' );
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="checkbox" name="aces_geolocation_enable" value="1" <?php checked(1, get_option('aces_geolocation_enable'), true); ?> />
        <?php
    }

    /*  ----------------

    Enable the Allowed mode setting checkbox

    ----------------  */

    add_settings_field(
        'aces_geolocation_allowed_mode',
        esc_html__( 'Enable the Allowed mode', 'aces' ),
        'aces_geolocation_allowed_mode_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_enable',
        array(
            'id' => 'aces_geolocation_allowed_mode', 
            'option_name' => 'aces_geolocation_allowed_mode'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_allowed_mode', 'esc_attr');

    function aces_geolocation_allowed_mode_callback($args) {
        $option = get_option( 'aces_geolocation_allowed_mode' );
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="checkbox" name="aces_geolocation_allowed_mode" value="1" <?php checked(1, get_option('aces_geolocation_allowed_mode'), true); ?> />
        <?php
    }

    /*  ----------------

    API key setting field

    ----------------  */

    /*  --- API key ---  */

    add_settings_field(
        'aces_geolocation_api_key',
        esc_html__( 'API key (Required)*', 'aces' ),
        'aces_geolocation_api_key_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_api',
        array(
            'id' => 'aces_geolocation_api_key', 
            'option_name' => 'aces_geolocation_api_key'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_api_key', 'esc_attr');

    function aces_geolocation_api_key_callback($args) {
        $option = esc_attr(get_option($args['option_name']));
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="text" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($option_name); ?>" value="<?php echo esc_attr($option); ?>" class="regular-text" style="width: 35em;" />
        <?php
    }

    /*  ----------------

    Messages setting field

    ----------------  */

    /*  --- Allowed Message ---  */

    add_settings_field(
        'aces_geolocation_allowed_message',
        esc_html__( 'Allowed Message', 'aces' ),
        'aces_geolocation_allowed_message_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_messages',
        array(
            'id' => 'aces_geolocation_allowed_message', 
            'option_name' => 'aces_geolocation_allowed_message'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_allowed_message', 'esc_attr');

    function aces_geolocation_allowed_message_callback($args) {
        $option = esc_attr(get_option($args['option_name']));
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="text" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($option_name); ?>" value="<?php echo esc_attr($option); ?>" placeholder="<?php echo esc_attr( 'Users from %s are accepted', 'aces' ); ?>" class="regular-text" style="width: 35em;" />
        <?php
    }

    /*  --- Restricted Message ---  */

    add_settings_field(
        'aces_geolocation_restricted_message',
        esc_html__( 'Restricted Message', 'aces' ),
        'aces_geolocation_restricted_message_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_messages',
        array(
            'id' => 'aces_geolocation_restricted_message', 
            'option_name' => 'aces_geolocation_restricted_message'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_restricted_message', 'esc_attr');

    function aces_geolocation_restricted_message_callback($args) {
        $option = esc_attr(get_option($args['option_name']));
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="text" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($option_name); ?>" value="<?php echo esc_attr($option); ?>" placeholder="<?php echo esc_attr( 'Users from %s are not accepted', 'aces' ); ?>" class="regular-text" style="width: 35em;" />
        <?php
    }

    /*  Geolocation settings tab - End  */

}

add_action( 'admin_init', 'aces_geolocation_settings_init' );