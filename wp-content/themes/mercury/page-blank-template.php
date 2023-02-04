<?php
/*
Template Name: Blank Page Template
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<?php wp_head(); ?>
</head>
<body ontouchstart <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="space-box relative<?php if( get_theme_mod('mercury_boxed_layout') ) { ?> enabled<?php } ?>">

<!-- Page Section Start -->

<div class="space-page-section box-100 space-page-without-title relative">
	<div class="space-page-section-ins space-page-wrapper relative">
		<div class="space-content-section box-100 relative">
			<div class="space-page-content-wrap relative">

				<?php if(have_posts()) : ?>
				<?php while(have_posts()) : the_post(); ?>

				<div class="space-page-content-box-wrap relative">
					<div class="space-page-content page-template box-100 relative">

						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="clear"></div><div class="page-links">' . esc_html__( 'Pages:', 'mercury' ),
								'after'       => '</div>',
								'link_before' => '<span class="page-number">',
								'link_after'  => '</span>',
							));
						?>

					</div>
				</div>

				<?php endwhile; ?>
				<?php endif; ?>

			</div>

			<?php if (comments_open()) { ?>

			<!-- Comments Start -->

			<?php comments_template(); ?>

			<!-- Comments End -->

			<?php } else {} ?>

		</div>
	</div>
</div>

<!-- Page Section End -->

</div>

<?php wp_footer(); ?>

</body>
</html>