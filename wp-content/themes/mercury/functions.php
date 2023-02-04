<?php

/*  Mercury - 3.9.2  */

global $mercury_version;
$mercury_version = '3.9.2';

add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-formats',
	array(
		'image',
		'video',
		'gallery',
	)
);

function mercury_comments_reply() {
	if( get_option( 'thread_comments' ) )  {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'mercury_comments_reply' );

function mercury_remove_caption_extra_width($width) {
   return $width - 10;
}
add_filter('img_caption_shortcode_width', 'mercury_remove_caption_extra_width');

/*  Content Width Start  */

function mercury_content_width() {

	$content_width = 1170;
	$GLOBALS['content_width'] = apply_filters( 'mercury_content_width', $content_width );
}
add_action( 'after_setup_theme', 'mercury_content_width', 0 );

/*  Content Width End  */

/*  Pingback Start  */

function mercury_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'mercury_pingback_header' );

/*  Pingback End  */

/*  Navigation Markup Template Start  */

add_filter('navigation_markup_template', 'mercury_navigation_template', 10, 2 );
			function mercury_navigation_template( $template, $class ){
			return '
			<div class="space-archive-navigation box-100 relative">
				<nav class="navigation %1$s">
					<div class="nav-links">%3$s</div>
				</nav>
			</div>
			';
}

/*  Navigation Markup Template End  */

/*  Menus, Languages and Thumbnails Start  */

function mercury_setup() {
	
	load_theme_textdomain( 'mercury', get_template_directory() . '/languages' );
	
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'mercury-custom-logo', 9999, 40);
	add_image_size( 'mercury-50-50', 50, 50, true );
	add_image_size( 'mercury-100-100', 100, 100, true );
	add_image_size( 'mercury-120-120', 120, 120, true );
	add_image_size( 'mercury-135-135', 135, 135, true );
	add_image_size( 'mercury-270-270', 270, 270, true );
	add_image_size( 'mercury-270-430', 270, 430, true );
	add_image_size( 'mercury-340-447', 340, 447, true );
	add_image_size( 'mercury-450-254', 450, 254, true );
	add_image_size( 'mercury-450-317', 450, 317, true );
	add_image_size( 'mercury-450-338', 450, 338, true );
	add_image_size( 'mercury-450-450', 450, 450, true );
	add_image_size( 'mercury-450-600', 450, 600, true );
	add_image_size( 'mercury-450-717', 450, 717, true );
	add_image_size( 'mercury-479-479', 479, 479, true );
	add_image_size( 'mercury-570-270', 570, 270, true );
	add_image_size( 'mercury-570-430', 570, 430, true );
	add_image_size( 'mercury-570-570', 570, 570, true );
	add_image_size( 'mercury-585-505', 585, 505, true );
	add_image_size( 'mercury-737-556', 737, 556, true );
	add_image_size( 'mercury-737-983', 737, 983, true );
	add_image_size( 'mercury-767-767', 767, 767, true );
	add_image_size( 'mercury-768-576', 768, 576, true );
	add_image_size( 'mercury-900-675', 900, 675, true );
	add_image_size( 'mercury-994-559', 994, 559, true );
	add_image_size( 'mercury-1170-505', 1170, 505, true );
	add_image_size( 'mercury-2000-400', 2000, 400, true );
	add_image_size( 'mercury-9999-32', 9999, 32);
	add_image_size( 'mercury-9999-80', 9999, 80);
	add_image_size( 'mercury-9999-135', 9999, 135);
	
	add_theme_support( 'gutenberg', array( 'wide-images' => true ));
	
	register_nav_menus( array(
		'main-menu'   => esc_html__( 'Main Menu', 'mercury' ),
		'footer-menu' => esc_html__( 'Footer Menu', 'mercury' ),
		'top-menu' => esc_html__( 'Top Bar Menu', 'mercury' ),
	) );
	
}
add_action( 'after_setup_theme', 'mercury_setup' );

/*  Menus, Languages and Thumbnails End  */

/*  Widgets Setup Start  */

function mercury_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mercury' ),
		'id'            => 'right-sidebar',
		'description'   => esc_html__( 'Add widgets here so that it appears on the sidebar.', 'mercury' ),
		'before_widget' => '<div id="%1$s" class="space-widget space-default-widget relative %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="space-widget-title relative"><span>',
		'after_title'   => '</span></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Central Block (Old)', 'mercury' ),
		'id'            => 'homepage-central-block',
		'description'   => esc_html__( 'For widgets in the homepage central block.', 'mercury' ),
		'before_widget' => '<div id="%1$s" class="space-widget relative %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="space-widget-title relative"><span>',
		'after_title'   => '</span></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Right Sidebar (Old)', 'mercury' ),
		'id'            => 'homepage-right-sidebar',
		'description'   => esc_html__( 'Add widgets here so that it appears on the homepage right sidebar.', 'mercury' ),
		'before_widget' => '<div id="%1$s" class="space-widget relative %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="space-widget-title relative"><span>',
		'after_title'   => '</span></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'mercury' ),
		'id'            => 'footer-center-sidebar',
		'description'   => esc_html__( 'For text and images only.', 'mercury' ),
		'before_widget' => '<div id="%1$s" class="space-widget space-footer-area relative %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="space-widget-title relative"><span>',
		'after_title'   => '</span></div>',
	) );

}
add_action( 'widgets_init', 'mercury_widgets_init' );

/*  Widgets Setup End  */

/*  Mobile Browser Bar Color Start  */

function mercury_header_bar_color() {

	if( !$mobile_header_background_color = get_theme_mod( 'topbar_background_color' ) ) {
		$mobile_header_background_color = '#f5f6fa';
	} else {
		$mobile_header_background_color = get_theme_mod( 'topbar_background_color' );
	}
?>
<meta name="theme-color" content="<?php echo esc_attr($mobile_header_background_color); ?>" />
<meta name="msapplication-navbutton-color" content="<?php echo esc_attr($mobile_header_background_color); ?>" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo esc_attr($mobile_header_background_color); ?>" />
<?php }

add_action('wp_head', 'mercury_header_bar_color');

/*  Mobile Browser Bar Color End  */

/*  Register Fonts Start  */
/* 
function mercury_google_fonts() {
    $font_url = '';

    if ( 'off' !== _x( 'on', 'Google font: on or off', 'mercury' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Roboto:300,400,700,900&display=swap' ), "//fonts.googleapis.com/css" );
    }

    return $font_url;
}
  */
function mercury_fonts() {
    //wp_enqueue_style( 'mercury-fonts', mercury_google_fonts(), array(), $GLOBALS['mercury_version'] );
    wp_enqueue_style( 'mercury-googlefonts', '//fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'mercury_fonts' );

/*  Register Fonts End  */

/*  Convert HEX to RGB Start  */

function mercury_rgb($hexStr, $returnAsString = false, $seperator = ',') {

    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
    $rgbArray = array();

    if (strlen($hexStr) == 6) {
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) {
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false;
    }

    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray;
}

/*  Convert HEX to RGB End  */

/*  Register Scripts & Colors Start  */

function mercury_scripts() {
	
	if( get_theme_mod('mercury_sticky_sidebar') ) {
		wp_enqueue_script( 'theia-sticky-sidebar', get_theme_file_uri( '/js/theia-sticky-sidebar.min.js' ), array( 'jquery' ), '1.7.0', true );
		wp_enqueue_script( 'mercury-enable-sticky-sidebar-js', get_theme_file_uri( '/js/enable-sticky-sidebar.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
	}

	if( !get_theme_mod('mercury_disable_floating_header') ) {
		wp_enqueue_script( 'mercury-floating-header', get_theme_file_uri( '/js/floating-header.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
	}

	wp_enqueue_script( 'owl-carousel', get_theme_file_uri( '/js/owl.carousel.min.js' ), array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'mercury-global-js', get_theme_file_uri( '/js/scripts.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
	wp_enqueue_script( 'fontawesome', '//kit.fontawesome.com/23b8c66013.js', array( 'jquery' ), '5.15.4', true );

	//wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.12.0/css/all.css', array(), '5.12.0' );
	wp_enqueue_style( 'owl-carousel', get_theme_file_uri( '/css/owl.carousel.min.css' ), array(), '2.3.4');
	wp_enqueue_style( 'owl-carousel-animate', get_theme_file_uri( '/css/animate.css' ), array(), '2.3.4');
	wp_enqueue_style( 'mercury-style', get_stylesheet_uri(), array(), $GLOBALS['mercury_version']);
	wp_enqueue_style( 'mercury-media', get_theme_file_uri( '/css/media.css' ), array(), $GLOBALS['mercury_version']);
	
	global $mercury_data; 
			
	// Custom Colors
			
	if( !$main_custom_color = get_theme_mod( 'main_color' ) ) {
		$main_custom_color = '#be2edd';
		$main_custom_shadow_color = mercury_rgb($main_custom_color, true);
	} else {
		$main_custom_color = get_theme_mod( 'main_color' );
		$main_custom_shadow_color = mercury_rgb($main_custom_color, true);
	}

	if( !$second_custom_color = get_theme_mod( 'second_color' ) ) {
		$second_custom_color = '#ff2453';
		$second_custom_shadow_color = mercury_rgb($second_custom_color, true);
	} else {
		$second_custom_color = get_theme_mod( 'second_color' );
		$second_custom_shadow_color = mercury_rgb($second_custom_color, true);
	}

	if( !$stars_custom_color = get_theme_mod( 'stars_color' ) ) {
		$stars_custom_color = '#ffd32a';
	} else {
		$stars_custom_color = get_theme_mod( 'stars_color' );
	}

	// Header layout colors

	if( !$header_background_color = get_theme_mod( 'header_background_color' ) ) {
		$header_background_color = '#ffffff';
	} else {
		$header_background_color = get_theme_mod( 'header_background_color' );
	}

	if( !$topbar_background_color = get_theme_mod( 'topbar_background_color' ) ) {
		$topbar_background_color = '#f5f6fa';
	} else {
		$topbar_background_color = get_theme_mod( 'topbar_background_color' );
	}

	if( !$topbar_link_color = get_theme_mod( 'topbar_link_color' ) ) {
		$topbar_link_color = '#7f8c8d';
	} else {
		$topbar_link_color = get_theme_mod( 'topbar_link_color' );
	}

	if( !$topbar_hover_color = get_theme_mod( 'topbar_hover_color' ) ) {
		$topbar_hover_color = '#151515';
	} else {
		$topbar_hover_color = get_theme_mod( 'topbar_hover_color' );
	}

	if( !$header_logo_color = get_theme_mod( 'header_logo_color' ) ) {
		$header_logo_color = '#2d3436';
	} else {
		$header_logo_color = get_theme_mod( 'header_logo_color' );
	}

	if( !$header_slogan_color = get_theme_mod( 'header_slogan_color' ) ) {
		$header_slogan_color = '#7f8c8d';
	} else {
		$header_slogan_color = get_theme_mod( 'header_slogan_color' );
	}

	if( !$header_menu_color = get_theme_mod( 'header_menu_color' ) ) {
		$header_menu_color = '#151515';
	} else {
		$header_menu_color = get_theme_mod( 'header_menu_color' );
	}

	if( !$header_hover_menu_color = get_theme_mod( 'header_hover_menu_color' ) ) {
		$header_hover_menu_color = '#be2edd';
	} else {
		$header_hover_menu_color = get_theme_mod( 'header_hover_menu_color' );
	}

	if( !$header_sub_menu_background_color = get_theme_mod( 'header_sub_menu_background_color' ) ) {
		$header_sub_menu_background_color = '#ffffff';
	} else {
		$header_sub_menu_background_color = get_theme_mod( 'header_sub_menu_background_color' );
	}

	if( !$header_sub_menu_color = get_theme_mod( 'header_sub_menu_color' ) ) {
		$header_sub_menu_color = '#34495e';
	} else {
		$header_sub_menu_color = get_theme_mod( 'header_sub_menu_color' );
	}

	if( !$header_hover_sub_menu_color = get_theme_mod( 'header_hover_sub_menu_color' ) ) {
		$header_hover_sub_menu_color = '#b2bec3';
	} else {
		$header_hover_sub_menu_color = get_theme_mod( 'header_hover_sub_menu_color' );
	}

	// Labels for the main menu items

	// --- "New" ---

	if( !$label_title_new = get_theme_mod( 'label_title_new' ) ) {
		$label_title_new = 'New';
	} else {
		$label_title_new = get_theme_mod( 'label_title_new' );
	}

	if( !$label_text_color_new = get_theme_mod( 'label_text_color_new' ) ) {
		$label_text_color_new = '#4f8237';
	} else {
		$label_text_color_new = get_theme_mod( 'label_text_color_new' );
	}

	if( !$label_background_color_new = get_theme_mod( 'label_background_color_new' ) ) {
		$label_background_color_new = '#badc58';
	} else {
		$label_background_color_new = get_theme_mod( 'label_background_color_new' );
	}

	// --- "Best" ---

	if( !$label_title_best = get_theme_mod( 'label_title_best' ) ) {
		$label_title_best = 'Best';
	} else {
		$label_title_best = get_theme_mod( 'label_title_best' );
	}

	if( !$label_text_color_best = get_theme_mod( 'label_text_color_best' ) ) {
		$label_text_color_best = '#7248b5';
	} else {
		$label_text_color_best = get_theme_mod( 'label_text_color_best' );
	}

	if( !$label_background_color_best = get_theme_mod( 'label_background_color_best' ) ) {
		$label_background_color_best = '#b0aaff';
	} else {
		$label_background_color_best = get_theme_mod( 'label_background_color_best' );
	}

	// --- "Hot" ---

	if( !$label_title_hot = get_theme_mod( 'label_title_hot' ) ) {
		$label_title_hot = 'Hot';
	} else {
		$label_title_hot = get_theme_mod( 'label_title_hot' );
	}

	if( !$label_text_color_hot = get_theme_mod( 'label_text_color_hot' ) ) {
		$label_text_color_hot = '#a33632';
	} else {
		$label_text_color_hot = get_theme_mod( 'label_text_color_hot' );
	}

	if( !$label_background_color_hot = get_theme_mod( 'label_background_color_hot' ) ) {
		$label_background_color_hot = '#ff7979';
	} else {
		$label_background_color_hot = get_theme_mod( 'label_background_color_hot' );
	}

	// --- "Top" ---

	if( !$label_title_top = get_theme_mod( 'label_title_top' ) ) {
		$label_title_top = 'Top';
	} else {
		$label_title_top = get_theme_mod( 'label_title_top' );
	}

	if( !$label_text_color_top = get_theme_mod( 'label_text_color_top' ) ) {
		$label_text_color_top = '#a88817';
	} else {
		$label_text_color_top = get_theme_mod( 'label_text_color_top' );
	}

	if( !$label_background_color_top = get_theme_mod( 'label_background_color_top' ) ) {
		$label_background_color_top = '#f6e58d';
	} else {
		$label_background_color_top = get_theme_mod( 'label_background_color_top' );
	}

	// --- "Fair" ---

	if( !$label_title_fair = get_theme_mod( 'label_title_fair' ) ) {
		$label_title_fair = 'Fair';
	} else {
		$label_title_fair = get_theme_mod( 'label_title_fair' );
	}

	if( !$label_text_color_fair = get_theme_mod( 'label_text_color_fair' ) ) {
		$label_text_color_fair = '#ffffff';
	} else {
		$label_text_color_fair = get_theme_mod( 'label_text_color_fair' );
	}

	if( !$label_background_color_fair = get_theme_mod( 'label_background_color_fair' ) ) {
		$label_background_color_fair = '#8c14fc';
	} else {
		$label_background_color_fair = get_theme_mod( 'label_background_color_fair' );
	}

	// Play Now - The button color

	if( !$play_now_title_color = get_theme_mod( 'play_now_title_color' ) ) {
		$play_now_title_color = '#ffffff';
	} else {
		$play_now_title_color = get_theme_mod( 'play_now_title_color' );
	}

	if( !$play_now_background_color = get_theme_mod( 'play_now_background_color' ) ) {
		$play_now_background_color = '#2ecc71';
		$play_now_shadow_color = mercury_rgb($play_now_background_color, true);
	} else {
		$play_now_background_color = get_theme_mod( 'play_now_background_color' );
		$play_now_shadow_color = mercury_rgb($play_now_background_color, true);
	}

	// Read Review - The button color

	if( !$read_review_title_color = get_theme_mod( 'read_review_title_color' ) ) {
		$read_review_title_color = '#ffffff';
	} else {
		$read_review_title_color = get_theme_mod( 'read_review_title_color' );
	}

	if( !$read_review_background_color = get_theme_mod( 'read_review_background_color' ) ) {
		$read_review_background_color = '#7f8c8d';
		$read_review_shadow_color = mercury_rgb($read_review_background_color, true);
	} else {
		$read_review_background_color = get_theme_mod( 'read_review_background_color' );
		$read_review_shadow_color = mercury_rgb($read_review_background_color, true);
	}
			
$custom_css = '

/* Main Color */

.has-mercury-main-color,
.home-page .textwidget a:hover,
.space-header-2-top-soc a:hover,
.space-header-menu ul.main-menu li a:hover,
.space-header-menu ul.main-menu li:hover a,
.space-header-2-nav ul.main-menu li a:hover,
.space-header-2-nav ul.main-menu li:hover a,
.space-page-content a:hover,
.space-pros-cons ul li a:hover,
.space-pros-cons ol li a:hover,
.space-companies-2-archive-item-desc a:hover,
.space-organizations-3-archive-item-terms-ins a:hover,
.space-organizations-7-archive-item-terms a:hover,
.space-organizations-8-archive-item-terms a:hover,
.space-comments-form-box p.comment-notes span.required,
form.comment-form p.comment-notes span.required {
	color: ' . esc_attr ($main_custom_color) . ';
}

input[type="submit"],
.has-mercury-main-background-color,
.space-block-title span:after,
.space-widget-title span:after,
.space-companies-archive-item-button a,
.space-companies-sidebar-item-button a,
.space-organizations-3-archive-item-count,
.space-organizations-3-archive-item-count-2,
.space-units-archive-item-button a,
.space-units-sidebar-item-button a,
.space-aces-single-offer-info-button-ins a,
.space-offers-archive-item-button a,
.home-page .widget_mc4wp_form_widget .space-widget-title::after,
.space-content-section .widget_mc4wp_form_widget .space-widget-title::after {
	background-color: ' . esc_attr ($main_custom_color) . ';
}

.space-header-menu ul.main-menu li a:hover,
.space-header-menu ul.main-menu li:hover a,
.space-header-2-nav ul.main-menu li a:hover,
.space-header-2-nav ul.main-menu li:hover a {
	border-bottom: 2px solid ' . esc_attr ($main_custom_color) . ';
}
.space-header-2-top-soc a:hover {
	border: 1px solid ' . esc_attr ($main_custom_color) . ';
}
.space-companies-archive-item-button a:hover,
.space-units-archive-item-button a:hover,
.space-offers-archive-item-button a:hover,
.space-aces-single-offer-info-button-ins a:hover {
    box-shadow: 0px 8px 30px 0px rgba(' . esc_attr ($main_custom_shadow_color) . ', 0.60) !important;
}

/* Second Color */

.has-mercury-second-color,
.space-page-content a,
.space-pros-cons ul li a,
.space-pros-cons ol li a,
.space-page-content ul li:before,
.home-page .textwidget ul li:before,
.space-widget ul li a:hover,
.space-page-content ul.space-mark li:before,
.home-page .textwidget a,
#recentcomments li a:hover,
#recentcomments li span.comment-author-link a:hover,
h3.comment-reply-title small a,
.space-shortcode-wrap .space-companies-sidebar-item-title p a,
.space-companies-sidebar-2-item-desc a,
.space-companies-sidebar-item-title p a,
.space-companies-archive-item-short-desc a,
.space-companies-2-archive-item-desc a,
.space-organizations-3-archive-item-terms-ins a,
.space-organizations-7-archive-item-terms a,
.space-organizations-8-archive-item-terms a,
.space-organization-content-info a,
.space-organization-style-2-calltoaction-text-ins a,
.space-organization-details-item-title span,
.space-organization-style-2-ratings-all-item-value i,
.space-organization-style-2-calltoaction-text-ins a,
.space-organization-content-short-desc a,
.space-organization-header-short-desc a,
.space-organization-content-rating-stars i,
.space-organization-content-rating-overall .star-rating .star,
.space-companies-archive-item-rating .star-rating .star,
.space-organization-content-logo-stars i,
.space-organization-content-logo-stars .star-rating .star,
.space-companies-2-archive-item-rating .star-rating .star,
.space-organizations-3-archive-item-rating-box .star-rating .star,
.space-organizations-4-archive-item-title .star-rating .star,
.space-companies-sidebar-2-item-rating .star-rating .star,
.space-comments-list-item-date a.comment-reply-link,
.space-categories-list-box ul li a,
.space-news-10-item-category a,
.small .space-news-11-item-category a,
#scrolltop,
.widget_mc4wp_form_widget .mc4wp-response a,
.space-header-height.dark .space-header-menu ul.main-menu li a:hover,
.space-header-height.dark .space-header-menu ul.main-menu li:hover a,
.space-header-2-height.dark .space-header-2-nav ul.main-menu li a:hover,
.space-header-2-height.dark .space-header-2-nav ul.main-menu li:hover a,
.space-header-2-height.dark .space-header-2-top-soc a:hover,
.space-organization-header-logo-rating i {
	color: ' . esc_attr ($second_custom_color) . ';
}

.space-title-box-category a,
.has-mercury-second-background-color,
.space-organization-details-item-links a:hover,
.space-news-2-small-item-img-category a,
.space-news-2-item-big-box-category span,
.space-block-title span:before,
.space-widget-title span:before,
.space-news-4-item.small-news-block .space-news-4-item-img-category a,
.space-news-4-item.big-news-block .space-news-4-item-top-category span,
.space-news-6-item-top-category span,
.space-news-7-item-category span,
.space-news-3-item-img-category a,
.space-news-8-item-title-category span,
.space-news-9-item-info-category span,
.space-archive-loop-item-img-category a,
.space-organizations-3-archive-item:first-child .space-organizations-3-archive-item-count,
.space-organizations-3-archive-item:first-child .space-organizations-3-archive-item-count-2,
.space-single-offer.space-dark-style .space-aces-single-offer-info-button-ins a,
.space-offers-archive-item.space-dark-style .space-offers-archive-item-button a,
nav.pagination a,
nav.comments-pagination a,
nav.pagination-post a span.page-number,
.widget_tag_cloud a,
.space-footer-top-age span.age-limit,
.space-footer-top-soc a:hover,
.home-page .widget_mc4wp_form_widget .mc4wp-form-fields .space-subscribe-filds button,
.space-content-section .widget_mc4wp_form_widget .mc4wp-form-fields .space-subscribe-filds button {
	background-color: ' . esc_attr ($second_custom_color) . ';
}

.space-footer-top-soc a:hover,
.space-header-2-height.dark .space-header-2-top-soc a:hover,
.space-categories-list-box ul li a {
	border: 1px solid ' . esc_attr ($second_custom_color) . ';
}

.space-header-height.dark .space-header-menu ul.main-menu li a:hover,
.space-header-height.dark .space-header-menu ul.main-menu li:hover a,
.space-header-2-height.dark .space-header-2-nav ul.main-menu li a:hover,
.space-header-2-height.dark .space-header-2-nav ul.main-menu li:hover a {
	border-bottom: 2px solid ' . esc_attr ($second_custom_color) . ';
}

.space-offers-archive-item.space-dark-style .space-offers-archive-item-button a:hover,
.space-single-offer.space-dark-style .space-aces-single-offer-info-button-ins a:hover {
    box-shadow: 0px 8px 30px 0px rgba(' . esc_attr ($second_custom_shadow_color) . ', 0.60) !important;
}

.space-text-gradient {
	background: ' . esc_attr ($main_custom_color) . ';
	background: -webkit-linear-gradient(to right, ' . esc_attr ($main_custom_color) . ' 0%, ' . esc_attr ($second_custom_color) . ' 100%);
	background: -moz-linear-gradient(to right, ' . esc_attr ($main_custom_color) . ' 0%, ' . esc_attr ($second_custom_color) . ' 100%);
	background: linear-gradient(to right, ' . esc_attr ($main_custom_color) . ' 0%, ' . esc_attr ($second_custom_color) . ' 100%);
}

/* Stars Color */

.star,
.fa-star {
	color: ' . esc_attr ($stars_custom_color) . '!important;
}

.space-rating-star-background {
	background-color: ' . esc_attr ($stars_custom_color) . ';
}

/* Custom header layout colors */

/* --- Header #1 Style --- */

.space-header-height .space-header-wrap {
	background-color: ' . esc_attr ($header_background_color) . ';
}
.space-header-height .space-header-top,
.space-header-height .space-header-logo-ins:after {
	background-color: ' . esc_attr ($topbar_background_color) . ';
}
.space-header-height .space-header-top-soc a,
.space-header-height .space-header-top-menu ul li a {
	color: ' . esc_attr ($topbar_link_color) . ';
}
.space-header-height .space-header-top-soc a:hover ,
.space-header-height .space-header-top-menu ul li a:hover {
	color: ' . esc_attr ($topbar_hover_color) . ';
}
.space-header-height .space-header-logo a {
	color: ' . esc_attr ($header_logo_color) . ';
}
.space-header-height .space-header-logo span {
	color: ' . esc_attr ($header_slogan_color) . ';
}
.space-header-height .space-header-menu ul.main-menu li,
.space-header-height .space-header-menu ul.main-menu li a,
.space-header-height .space-header-search {
	color: ' . esc_attr ($header_menu_color) . ';
}
.space-header-height .space-mobile-menu-icon div {
	background-color: ' . esc_attr ($header_menu_color) . ';
}
.space-header-height .space-header-menu ul.main-menu li a:hover,
.space-header-height .space-header-menu ul.main-menu li:hover a {
	color: ' . esc_attr ($header_hover_menu_color) . ';
	border-bottom: 2px solid ' . esc_attr ($header_hover_menu_color) . ';
}

.space-header-height .space-header-menu ul.main-menu li ul.sub-menu {
	background-color: ' . esc_attr ($header_sub_menu_background_color) . ';
}

.space-header-height .space-header-menu ul.main-menu li ul.sub-menu li.menu-item-has-children:after,
.space-header-height .space-header-menu ul.main-menu li ul.sub-menu li a {
	color: ' . esc_attr ($header_sub_menu_color) . ';
	border-bottom: 1px solid transparent;
}
.space-header-height .space-header-menu ul.main-menu li ul.sub-menu li a:hover {
	border-bottom: 1px solid transparent;
	color: ' . esc_attr ($header_hover_sub_menu_color) . ';
	text-decoration: none;
}

/* --- Header #2 Style --- */

.space-header-2-height .space-header-2-wrap,
.space-header-2-height .space-header-2-wrap.fixed .space-header-2-nav {
	background-color: ' . esc_attr ($header_background_color) . ';
}
.space-header-2-height .space-header-2-top-ins {
	border-bottom: 1px solid ' . esc_attr ($topbar_background_color) . ';
}
.space-header-2-height .space-header-2-top-soc a,
.space-header-2-height .space-header-search {
	color: ' . esc_attr ($topbar_link_color) . ';
}
.space-header-2-height .space-header-2-top-soc a {
	border: 1px solid ' . esc_attr ($topbar_link_color) . ';
}
.space-header-2-height .space-mobile-menu-icon div {
	background-color: ' . esc_attr ($topbar_link_color) . ';
}
.space-header-2-height .space-header-2-top-soc a:hover {
	color: ' . esc_attr ($topbar_hover_color) . ';
	border: 1px solid ' . esc_attr ($topbar_hover_color) . ';
}
.space-header-2-height .space-header-2-top-logo a {
	color: ' . esc_attr ($header_logo_color) . ';
}
.space-header-2-height .space-header-2-top-logo span {
	color: ' . esc_attr ($header_slogan_color) . ';
}
.space-header-2-height .space-header-2-nav ul.main-menu li,
.space-header-2-height .space-header-2-nav ul.main-menu li a {
	color: ' . esc_attr ($header_menu_color) . ';
}
.space-header-2-height .space-header-2-nav ul.main-menu li a:hover,
.space-header-2-height .space-header-2-nav ul.main-menu li:hover a {
	color: ' . esc_attr ($header_hover_menu_color) . ';
	border-bottom: 2px solid ' . esc_attr ($header_hover_menu_color) . ';
}
.space-header-2-height .space-header-2-nav ul.main-menu li ul.sub-menu {
	background-color: ' . esc_attr ($header_sub_menu_background_color) . ';
}
.space-header-2-height .space-header-2-nav ul.main-menu li ul.sub-menu li a,
.space-header-2-height .space-header-2-nav ul.main-menu li ul.sub-menu li.menu-item-has-children:after {
	color: ' . esc_attr ($header_sub_menu_color) . ';
	border-bottom: 1px solid transparent;
}
.space-header-2-height .space-header-2-nav ul.main-menu li ul.sub-menu li a:hover {
	border-bottom: 1px solid transparent;
	color: ' . esc_attr ($header_hover_sub_menu_color) . ';
	text-decoration: none;
}

/* --- Mobile Menu Style --- */

.space-mobile-menu .space-mobile-menu-block {
	background-color: ' . esc_attr ($header_background_color) . ';
}
.space-mobile-menu .space-mobile-menu-copy {
	border-top: 1px solid ' . esc_attr ($topbar_background_color) . ';
}
.space-mobile-menu .space-mobile-menu-copy {
	color: ' . esc_attr ($topbar_link_color) . ';
}
.space-mobile-menu .space-mobile-menu-copy a {
	color: ' . esc_attr ($topbar_link_color) . ';
}
.space-mobile-menu .space-mobile-menu-copy a:hover {
	color: ' . esc_attr ($topbar_hover_color) . ';
}
.space-mobile-menu .space-mobile-menu-header a {
	color: ' . esc_attr ($header_logo_color) . ';
}
.space-mobile-menu .space-mobile-menu-header span {
	color: ' . esc_attr ($header_slogan_color) . ';
}
.space-mobile-menu .space-mobile-menu-list ul li {
	color: ' . esc_attr ($header_menu_color) . ';
}
.space-mobile-menu .space-mobile-menu-list ul li a {
	color: ' . esc_attr ($header_menu_color) . ';
}
.space-mobile-menu .space-close-icon .to-right,
.space-mobile-menu .space-close-icon .to-left {
	background-color: ' . esc_attr ($header_menu_color) . ';
}

/* --- New - Label for the main menu items --- */

ul.main-menu > li.new > a:before,
.space-mobile-menu-list > ul > li.new:before {
	content: "' . esc_attr ($label_title_new) . '";
    color: ' . esc_attr ($label_text_color_new) . ';
    background-color: ' . esc_attr ($label_background_color_new) . ';
}

/* --- Best - Label for the main menu items --- */

ul.main-menu > li.best > a:before,
.space-mobile-menu-list > ul > li.best:before {
	content: "' . esc_attr ($label_title_best) . '";
    color: ' . esc_attr ($label_text_color_best) . ';
    background-color: ' . esc_attr ($label_background_color_best) . ';
}

/* --- Hot - Label for the main menu items --- */

ul.main-menu > li.hot > a:before,
.space-mobile-menu-list > ul > li.hot:before {
	content: "' . esc_attr ($label_title_hot) . '";
    color: ' . esc_attr ($label_text_color_hot) . ';
    background-color: ' . esc_attr ($label_background_color_hot) . ';
}

/* --- Top - Label for the main menu items --- */

ul.main-menu > li.top > a:before,
.space-mobile-menu-list > ul > li.top:before {
	content: "' . esc_attr ($label_title_top) . '";
    color: ' . esc_attr ($label_text_color_top) . ';
    background-color: ' . esc_attr ($label_background_color_top) . ';
}

/* --- Fair - Label for the main menu items --- */

ul.main-menu > li.fair > a:before,
.space-mobile-menu-list > ul > li.fair:before {
	content: "' . esc_attr ($label_title_fair) . '";
    color: ' . esc_attr ($label_text_color_fair) . ';
    background-color: ' . esc_attr ($label_background_color_fair) . ';
}

/* Play Now - The button color */

.space-organization-content-button a,
.space-unit-content-button a,
.space-organizations-3-archive-item-button-ins a,
.space-organizations-4-archive-item-button-two-ins a,
.space-shortcode-wrap .space-organizations-3-archive-item-button-ins a,
.space-shortcode-wrap .space-organizations-4-archive-item-button-two-ins a {
    color: ' . esc_attr ($play_now_title_color) . ' !important;
    background-color: ' . esc_attr ($play_now_background_color) . ' !important;
}

.space-organization-content-button a:hover,
.space-unit-content-button a:hover,
.space-organizations-3-archive-item-button-ins a:hover,
.space-organizations-4-archive-item-button-two-ins a:hover {
    box-shadow: 0px 0px 15px 0px rgba(' . esc_attr ($play_now_shadow_color) . ', 0.55) !important;
}

.space-organization-header-button a.space-style-2-button,
.space-organization-style-2-calltoaction-button-ins a.space-calltoaction-button,
.space-style-3-organization-header-button a.space-style-3-button,
.space-organizations-7-archive-item-button-two a,
.space-organizations-8-archive-item-button-two a,
.space-organization-float-bar-button-wrap a {
    color: ' . esc_attr ($play_now_title_color) . ' !important;
    background-color: ' . esc_attr ($play_now_background_color) . ' !important;
    box-shadow: 0px 5px 15px 0px rgba(' . esc_attr ($play_now_shadow_color) . ', 0.55) !important;
}
.space-organization-header-button a.space-style-2-button:hover,
.space-organization-style-2-calltoaction-button-ins a.space-calltoaction-button:hover,
.space-style-3-organization-header-button a.space-style-3-button:hover,
.space-organizations-7-archive-item-button-two a:hover,
.space-organizations-8-archive-item-button-two a:hover,
.space-organization-float-bar-button-wrap a:hover {
    box-shadow: 0px 5px 15px 0px rgba(' . esc_attr ($play_now_shadow_color) . ', 0) !important;
}

.space-organizations-5-archive-item-button1 a,
.space-organizations-6-archive-item-button1 a,
.space-units-2-archive-item-button1 a,
.space-units-3-archive-item-button1 a {
    color: ' . esc_attr ($play_now_title_color) . ' !important;
    background-color: ' . esc_attr ($play_now_background_color) . ' !important;
    box-shadow: 0px 10px 15px 0px rgba(' . esc_attr ($play_now_shadow_color) . ', 0.5) !important;
}
.space-organizations-5-archive-item-button1 a:hover,
.space-organizations-6-archive-item-button1 a:hover,
.space-units-2-archive-item-button1 a:hover,
.space-units-3-archive-item-button1 a:hover {
    box-shadow: 0px 10px 15px 0px rgba(' . esc_attr ($play_now_shadow_color) . ', 0) !important;
}

/* Read Review - The button color */

.space-organizations-3-archive-item-button-ins a:last-child,
.space-organizations-4-archive-item-button-one-ins a,
.space-shortcode-wrap .space-organizations-4-archive-item-button-one-ins a {
    color: ' . esc_attr ($read_review_title_color) . ' !important;
    background-color: ' . esc_attr ($read_review_background_color) . ' !important;
}

.space-organizations-3-archive-item-button-ins a:last-child:hover,
.space-organizations-4-archive-item-button-one-ins a:hover {
    box-shadow: 0px 0px 15px 0px rgba(' . esc_attr ($read_review_shadow_color) . ', 0.55) !important;
}';

	//$custom_css .= esc_attr($mercury_data['custom_css']);
	$custom_css .= isset( $mercury_data['custom_css'] ) ? $mercury_data['custom_css'] : '';
	wp_add_inline_style( 'mercury-style', $custom_css );
	
}
add_action( 'wp_enqueue_scripts', 'mercury_scripts' );

/*  Register Scripts & Colors End  */

/*  Space-Themes Functions Start  */

require_once( get_template_directory() . '/theme-functions/custom-comments.php' );
require_once( get_template_directory() . '/theme-functions/customize.php' );
require_once( get_template_directory() . '/theme-functions/gutenberg.php' );
require_once( get_template_directory() . '/theme-functions/class-tgm-plugin-activation.php' );
require_once( get_template_directory() . '/theme-functions/index.php' );

/*  Space-Themes Functions End  */

/*  Mercury - Allow shortcodes in taxonomy descriptions Start */

add_filter( 'term_description', 'do_shortcode' );

/*  Mercury - Allow shortcodes in taxonomy descriptions End */

/*  Mercury - Disable automatic WordPress theme updates Start  */

add_filter( 'auto_update_theme', '__return_false' );

/*  Mercury - Disable automatic WordPress theme updates End  */

/*  Mercury - Remove empty paragraph tags from shortcodes Start  */

function mercury_remove_empty_p_tags( $content ) {

    $args = array( 
        '<p>['    => '[', 
        ']</p>'   => ']', 
        ']<br />' => ']'
    ); 
    return strtr( $content, $args );

}
add_filter( 'the_content', 'mercury_remove_empty_p_tags' );
include('custom-shortcodes.php');
add_theme_support( 'post-thumbnails' );

/*  Mercury - Remove empty paragraph tags from shortcodes End  */