<!-- Footer Start -->



<div class="space-footer box-100 relative">
    <?php if ( is_active_sidebar( 'footer-center-sidebar' ) ) { ?>
    <div class="space-footer-top box-100 relative">
        <div class="space-footer-ins relative">
            <div class="space-footer-top-center box-100 relative">
                <?php dynamic_sidebar( 'footer-center-sidebar' ); ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="space-footer-copy box-100 relative">
        <div class="space-footer-ins relative">
            <div class="space-footer-copy-left box-50 left relative">
                <?php if(get_theme_mod('footer_copyright') == '') { ?>
                <?php esc_html_e( '&copy; Copyright', 'mercury' ); ?> <?php echo esc_html( date( 'Y' ) ) ?>
                <?php echo esc_html( get_bloginfo( 'name' ) ) ?> | <?php esc_html_e( 'Powered by', 'mercury' ); ?> <a
                    href="<?php echo esc_url( __( 'https://wordpress.org', 'mercury' ) ); ?>" target="_blank"
                    title="<?php esc_attr_e( 'WordPress', 'mercury' ); ?>"><?php esc_html_e( 'WordPress', 'mercury' ); ?></a>
                | <a href="<?php echo esc_url( __( 'https://mercurytheme.com', 'mercury' ) ); ?>" target="_blank"
                    title="<?php esc_attr_e( 'Affiliate Marketing WordPress Theme. Reviews and Top Lists', 'mercury' ); ?>"><?php esc_html_e( 'Mercury Theme', 'mercury' ); ?></a>
                <?php } else { ?>
                <?php 
						$allowed_html = array(
							'a' => array(
								'href' => true,
								'title' => true,
								'target' => true,
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
							'span' => array(),
							'p' => array()
						);
						echo wp_kses( get_theme_mod( 'footer_copyright' ), $allowed_html );
					?>
                <?php } ?>
            </div>
            <div class="space-footer-copy-menu box-50 left relative">
                <?php
					if (has_nav_menu('footer-menu')) {
						wp_nav_menu( array( 'container' => 'ul', 'menu_class' => 'space-footer-menu', 'theme_location' => 'footer-menu', 'depth' => 1, 'fallback_cb' => '__return_empty_string' ) );
					}
				?>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="all-categories">
            All categories
        </div>
        <div class="d-flex">
            <div class="col">
                <h6>Most popular</h6>
                <div>
                    <a href="#">The current link item</a>
                    <a href="#">A second link item</a>
                    <a href="#">A third link item</a>
                    <a href="#">A fourth link item</a>
                    <a href="#">A disabled link item</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer End -->

</div>

<!-- Mobile Menu Start -->

<?php get_template_part( '/theme-parts/mobile-menu' ); ?>

<!-- Mobile Menu End -->

<!-- Back to Top Start -->

<div class="space-to-top">
    <a href="#" id="scrolltop" title="<?php esc_attr_e( 'Back to Top', 'mercury' ); ?>"><i
            class="far fa-arrow-alt-circle-up"></i></a>
</div>

<!-- Back to Top End -->

<?php wp_footer(); ?>

</body>

</html>