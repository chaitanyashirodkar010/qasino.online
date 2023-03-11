<!-- Footer Start -->
<?php
$categories = get_categories( array(
    'type' => 'casino',
    'orderby' => 'name',
    'taxonomy' => 'casino-category',
    'order' => 'ASC'
) );
?>



<div class="space-footer box-100 relative">
    <?php if ( is_active_sidebar( 'footer-center-sidebar' ) ) { ?>
    <div class="space-footer-top box-100 relative">
        <div class="space-footer-ins relative">
            <div class="space-footer-top-center box-100 relative">
                <?php dynamic_sidebar( 'footer-center-sidebar' ); ?>
            </div>
        </div>
    </div>

    <div class="categoty-footer footer">
        <div class="container">
            <div class="all-categories">
                All categories
            </div>
            <div class="d-flex">
                <div class="col">
                    <div class="icon-title">
                        <div class="icon">
                            <i class="fa fa-fire" aria-hidden="true"></i>
                        </div>
                        <h6>Most popular</h6>
                    </div>
                    <div class="category-list">
                       <?php  foreach( $categories as $category ) { ?>
                        <?php 
                            echo '<a href="' . get_category_link($category->term_id) . '">' .
                            $category->name . '</a>';
                            ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <div class="icon">
                            <i class="fa fa-money" aria-hidden="true"></i>
                        </div>
                        <h6>Real money guides</h6>
                    </div>
                    <div class="category-list">
                        <a href="#">The current link item</a>
                        <a href="#">A second link item</a>
                        <a href="#">A third link item</a>
                        <a href="#">A fourth link item</a>
                        <a href="#">A disabled link item</a>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <div class="icon">
                            <i class="fas fa-book-open    "></i>

                        </div>
                        <h6>Most popular</h6>
                    </div>
                    <div class="category-list">
                        <a href="#">The current link item</a>
                        <a href="#">A second link item</a>
                        <a href="#">A third link item</a>
                        <a href="#">A fourth link item</a>
                        <a href="#">A disabled link item</a>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <div class="icon">
                            <i class="fas fa-dice    "></i>
                        </div>
                        <h6> Casino games</h6>
                    </div>
                    <div class="category-list">
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
    <div class="links-footer footer">
        <div class="container">
            <div class="all-categories">
                All categories
            </div>
            <div class="d-flex">
                <div class="col">
                    <div class="icon-title">
                        <h6>About us</h6>
                    </div>
                    <div class="category-list">
                        <a href="#">The current link item</a>
                        <a href="#">A second link item</a>
                        <a href="#">A third link item</a>
                        <a href="#">A fourth link item</a>
                        <a href="#">A disabled link item</a>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <h6>Casino reviews</h6>
                    </div>
                    <div class="category-list">
                        <a href="#">The current link item</a>
                        <a href="#">A second link item</a>
                        <a href="#">A third link item</a>
                        <a href="#">A fourth link item</a>
                        <a href="#">A disabled link item</a>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <h6>Game guides</h6>
                    </div>
                    <div class="category-list">
                        <a href="#">The current link item</a>
                        <a href="#">A second link item</a>
                        <a href="#">A third link item</a>
                        <a href="#">A fourth link item</a>
                        <a href="#">A disabled link item</a>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <h6>News</h6>
                    </div>
                    <div class="category-list">
                        <a href="#">The current link item</a>
                        <a href="#">A second link item</a>
                        <a href="#">A third link item</a>
                        <a href="#">A fourth link item</a>
                        <a href="#">A disabled link item</a>
                    </div>
                </div>
                <div class="col">
                    <div class="icon-title">
                        <h6>Other</h6>
                    </div>
                    <div class="category-list">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>