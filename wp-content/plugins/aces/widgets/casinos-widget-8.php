<?php

/*  #8 Casinos Homepage Widget  */

class aces_casinos_home_8_widget extends WP_Widget {

/*  #8 Casinos Homepage Widget Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#Aces Casinos-8', 'aces' ), array(
			'description' => esc_html__('#8 Casinos widget for the HOMEPAGE (Mercury theme).', 'aces' )
		));
	}

/*  Display #8 Casinos Homepage Widget  */

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 8;
		if ( ! $number ) {
			$number = 8;
		}

		$margin_bottom = ( ! empty( $instance['margin_bottom'] ) ) ? esc_attr( $instance['margin_bottom'] ) : '';
		if ( ! $margin_bottom ) {
			$margin_bottom = '';
		} 

		$external_link = isset( $instance['external_link'] ) ? $instance['external_link'] : false;
		$categories = isset( $instance['term_taxonomy_id'] ) ? $instance['term_taxonomy_id'] : '';

		if ( ! empty( $categories ) ) {

			$first_query = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'   => $number,
				'post_type'        => 'casino',
				'no_found_rows'    => true,
				'post_status'      => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'casino-category',
						'field'    => 'id',
						'terms'    => $categories
					)
				)
			) ) );

		} else {

			$first_query = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'   => $number,
				'post_type'        => 'casino',
				'no_found_rows'    => true,
				'post_status'      => 'publish'
			) ) );

		}

		if ($first_query->have_posts()) :

			if ( get_option( 'aces_rating_stars_number' ) ) {
				$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
			} else {
				$casino_rating_stars_number_value = '5';
			}
			
	?>

	<div class="space-organizations-home-6-widget homepage-block box-100 relative"<?php if ( $margin_bottom ) { ?> style="margin-bottom: <?php echo esc_attr($margin_bottom); ?>;"<?php } ?>>
		<div class="space-organizations-home-6-widget-ins space-page-wrapper relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-organizations-6-archive-items box-100 relative">
			<?php while ( $first_query->have_posts() ) : $first_query->the_post();
				global $post;
				$casino_allowed_html = array(
					'a' => array(
						'href' => true,
						'title' => true,
						'target' => true,
						'rel' => true
					),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
					'span' => array(
						'class' => true
					),
					'div' => array(
						'class' => true
					),
					'p' => array()
				);

				$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
				$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
				$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
				$casino_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_permalink_button_title', true ) );
				$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
				$overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

				if ($external_link) {
					if ($casino_external_link) {
						$external_link_url = $casino_external_link;
					} else {
						$external_link_url = get_the_permalink();
					}
				} else {
					$external_link_url = get_the_permalink();
				}

				if ($casino_button_title) {
					$button_title = $casino_button_title;
				} else {
					if ( get_option( 'casinos_play_now_title') ) {
						$button_title = esc_html( get_option( 'casinos_play_now_title') );
					} else {
						$button_title = esc_html__( 'Play Now', 'aces' );
					}
				}

				if ($casino_permalink_button_title) {
					$permalink_button_title = $casino_permalink_button_title;
				} else {
					if ( get_option( 'casinos_read_review_title') ) {
						$permalink_button_title = esc_html( get_option( 'casinos_read_review_title') );
					} else {
						$permalink_button_title = esc_html__( 'Read Review', 'aces' );
					}
				}

				$terms = get_the_terms( $post->ID, 'casino-category' );
			?>

				<div class="space-organizations-6-archive-item box-25 relative">
					<div class="space-organizations-6-archive-item-ins relative">
						<div class="space-organizations-6-archive-item-img-wrap box-100 relative">
							<?php
							$post_title_attr = the_title_attribute( 'echo=0' );
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
							<?php } ?>
							<div class="space-organizations-6-archive-item-overlay space-overlay absolute">

								<?php if( function_exists('aces_star_rating') ){ ?>

									<div class="space-organizations-6-archive-item-rating absolute">
										<div class="space-rating-star-wrap relative">
											<div class="space-rating-star-background absolute"></div>
											<div class="space-rating-star-icon absolute">
												<i class="fas fa-star"></i>
											</div>
										</div>
										<strong><?php echo esc_html( number_format( round( $overall_rating, 1 ), 1, '.', ',') ); ?></strong>/<?php echo esc_html( $casino_rating_stars_number_value ); ?>
									</div>

								<?php } ?>

								<div class="space-organizations-6-archive-item-central text-center relative">

									<?php if ($terms) { ?>
									<div class="space-organizations-6-archive-item-category relative">
										<?php foreach ( $terms as $term ) { ?>
									        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
									    <?php } ?>
									</div>
									<?php } ?>

									<div class="space-organizations-6-archive-item-title relative">
										<?php the_title(); ?>
									</div>

									<?php if ($external_link) { ?>

									<div class="space-organizations-6-archive-item-button1 relative">
										<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
									</div>

									<?php } ?>

									<div class="space-organizations-6-archive-item-button2 relative">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
									</div>
								</div>

								<?php if ($casino_button_notice) { ?>

								<div class="space-organizations-6-archive-item-tac absolute">
									
									<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>

								</div>

								<?php } ?>

							</div>
						</div>
					</div>
				</div>

			<?php endwhile; ?>

			</div>
		</div>
	</div>

		<?php
		wp_reset_postdata();
		endif;
	}

/*  Update #8 Casinos Homepage Widget  */

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['margin_bottom'] = sanitize_text_field( $new_instance['margin_bottom'] );
		$instance['term_taxonomy_id'] = (int) $new_instance['term_taxonomy_id'];
		$instance['external_link'] = isset( $new_instance['external_link'] ) ? (bool) $new_instance['external_link'] : false;
		return $instance;
	}

/*  #8 Casinos Homepage Widget Settings Form  */

	public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 8;
		$margin_bottom    = isset( $instance['margin_bottom'] ) ? esc_attr( $instance['margin_bottom'] ) : '';
		$args = array(
			'type'         => 'casino',
			'orderby'      => 'name',
			'hide_empty'   => 1,
			'taxonomy'     => 'casino-category'
		);
		$external_link = isset( $instance['external_link'] ) ? (bool) $instance['external_link'] : false;
		$cats = get_categories($args);
		$categories = isset( $instance['term_taxonomy_id'] ) ? $instance['term_taxonomy_id'] : '';
?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'aces' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $external_link ); ?> id="<?php echo esc_attr($this->get_field_id( 'external_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'external_link' )); ?>" />
			<label for="<?php echo esc_attr($this->get_field_id( 'external_link' )); ?>"><?php esc_html_e( 'Use external link for the Url', 'aces' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of items to show:', 'aces' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>"><?php esc_html_e( 'Margin bottom for the block (in pixels):', 'aces' ); ?></label>
			<input class="small-text" id="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'margin_bottom' )); ?>" type="text" value="<?php echo esc_attr($margin_bottom); ?>" size="3" />
		</p>

		<hr>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'term_taxonomy_id' )); ?>"><?php esc_html_e('Category:' , 'aces' );?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'term_taxonomy_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'term_taxonomy_id' )); ?>">
	 			<option value=""><?php esc_html_e('All' , 'aces' );?></option>
				<?php foreach ( $cats as $cat ) {?>
				<option value="<?php echo esc_attr($cat->term_id); ?>"<?php echo selected( $categories, $cat->term_id, false ) ?>> <?php echo esc_html( $cat->name ) ?></option>
				<?php }?>
	 		</select>
	 	</p>
<?php
	}
}

add_action( 'widgets_init', 'aces_casinos_home_8_widget' );

function aces_casinos_home_8_widget() {
	register_widget( 'aces_casinos_home_8_widget' );
}