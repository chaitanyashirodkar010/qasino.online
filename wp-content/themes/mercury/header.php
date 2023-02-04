<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=no" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<?php wp_head(); ?>
</head>
<body ontouchstart <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="space-box relative<?php if( get_theme_mod('mercury_boxed_layout') ) { ?> enabled<?php } ?>">

<!-- Header Start -->

<?php
	$header_style = get_theme_mod('mercury_header_style');

	if ($header_style == 2) {
		get_template_part( '/theme-parts/header/style-2' );
	} else {
		get_template_part( '/theme-parts/header/style-1' );
	}
?>

<div class="space-header-search-block fixed">
	<div class="space-header-search-block-ins absolute">
		<?php get_search_form(); ?>
	</div>
	<div class="space-close-icon desktop-search-close-button absolute">
		<div class="to-right absolute"></div>
		<div class="to-left absolute"></div>
	</div>
</div>

<!-- Header End -->