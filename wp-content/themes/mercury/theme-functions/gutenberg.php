<?php

add_theme_support( 'editor-styles' );
add_theme_support( 'align-wide' );
add_editor_style( 'style-editor.css' );

function mercury_block_editor_styles() {
	wp_enqueue_style( 'mercury-googlefonts', '//fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap', array(), null );
    wp_enqueue_style( 'mercury-block-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), false, $GLOBALS['mercury_version'], 'all' );
    wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.12.0/css/all.css', array(), '5.12.0' );
}

add_action( 'enqueue_block_editor_assets', 'mercury_block_editor_styles' );

function mercury_gutenberg_color_palette() {

	add_theme_support( 'editor-color-palette', array(

		array(
			'name'  => esc_html__( 'mercury Main Color', 'mercury' ),
			'slug'  => 'mercury-main',
			'color' => esc_html( get_theme_mod( 'main_color', '#be2edd' ) ),
		),

		array(
			'name'  => esc_html__( 'mercury Second Color', 'mercury' ),
			'slug'  => 'mercury-second',
			'color' => esc_html( get_theme_mod( 'second_color', '#ff2453' ) ),
		),

		array(
			'name'  => esc_html__( 'mercury White', 'mercury' ),
			'slug'  => 'mercury-white',
			'color' => '#fff',
		),

		array(
			'name'  => esc_html__( 'mercury Gray', 'mercury' ),
			'slug'  => 'mercury-gray',
			'color' => '#263238',
		),

		array(
			'name'  => esc_html__( 'mercury Emerald', 'mercury' ),
			'slug'  => 'mercury-emerald',
			'color' => '#2edd6c',
		),

		array(
			'name'  => esc_html__( 'mercury Alizarin', 'mercury' ),
			'slug'  => 'mercury-alizarin',
			'color' => '#e74c3c',
		),

		array(
			'name'  => esc_html__( 'mercury Wisteria', 'mercury' ),
			'slug'  => 'mercury-wisteria',
			'color' => '#8e44ad',
		),

		array(
			'name'  => esc_html__( 'mercury Peter River', 'mercury' ),
			'slug'  => 'mercury-peter-river',
			'color' => '#3498db',
		),

		array(
			'name'  => esc_html__( 'mercury Clouds', 'mercury' ),
			'slug'  => 'mercury-clouds',
			'color' => '#ecf0f1',
		)
	) );
}

add_action( 'after_setup_theme', 'mercury_gutenberg_color_palette' );