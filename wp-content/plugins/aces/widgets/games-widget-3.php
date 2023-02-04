<?php

/*  #3 Games Homepage Widget  */

class aces_games_home_widget_3 extends WP_Widget {

/*  #3 Games Homepage Widget Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#Aces Games-3', 'aces' ), array(
			'description' => esc_html__('#3 Games widget for the HOMEPAGE (Mercury theme).', 'aces' )
		));
	}

/*  Display #3 Games Homepage Widget  */

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
				'post_type'        => 'game',
				'no_found_rows'    => true,
				'post_status'      => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'game-category',
						'field'    => 'id',
						'terms'    => $categories
					)
				)
			) ) );

		} else {

			$first_query = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'   => $number,
				'post_type'        => 'game',
				'no_found_rows'    => true,
				'post_status'      => 'publish'
			) ) );

		}

		if ($first_query->have_posts()) :

			if ( get_option( 'aces_game_rating_stars_number' ) ) {
				$game_rating_stars_number_value = get_option( 'aces_game_rating_stars_number' );
			} else {
				$game_rating_stars_number_value = '5';
			}

	?>

	<div class="space-units-home-3-widget homepage-block box-100 relative"<?php if ( $margin_bottom ) { ?> style="margin-bottom: <?php echo esc_attr($margin_bottom); ?>;"<?php } ?>>
		<div class="space-units-home-3-widget-ins space-page-wrapper relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-units-3-archive-items box-100 relative">
				
			<?php while ( $first_query->have_posts() ) : $first_query->the_post();
				global $post;
				$game_allowed_html = array(
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

				$game_external_link = esc_url( get_post_meta( get_the_ID(), 'game_external_link', true ) );
				$game_button_title = esc_html( get_post_meta( get_the_ID(), 'game_button_title', true ) );
				$game_button_notice = wp_kses( get_post_meta( get_the_ID(), 'game_button_notice', true ), $game_allowed_html );
				$game_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'game_permalink_button_title', true ) );
				$game_rating = esc_html( get_post_meta( get_the_ID(), 'game_rating_one', true ) );

				if ($game_button_title) {
					$button_title = $game_button_title;
				} else {
					if ( get_option( 'games_play_now_title') ) {
						$button_title = esc_html( get_option( 'games_play_now_title') );
					} else {
						$button_title = esc_html__( 'Play Now', 'aces' );
					}
				}

				if ($external_link) {
					if ($game_external_link) {
						$external_link_url = $game_external_link;
					} else {
						$external_link_url = get_the_permalink();
					}
				} else {
					$external_link_url = get_the_permalink();
				}

				if ($game_permalink_button_title) {
					$permalink_button_title = $game_permalink_button_title;
				} else {
					if ( get_option( 'games_read_review_title') ) {
						$permalink_button_title = esc_html( get_option( 'games_read_review_title') );
					} else {
						$permalink_button_title = esc_html__( 'Read Review', 'aces' );
					}
				}

				$terms = get_the_terms( $post->ID, 'game-category' );
			?>

				<div class="space-units-3-archive-item box-25 relative">
					<div class="space-units-3-archive-item-ins relative">
						<div class="space-units-3-archive-item-img-wrap box-100 relative">
							<?php
							$post_title_attr = the_title_attribute( 'echo=0' );
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
							<?php } ?>
							<div class="space-units-3-archive-item-overlay space-overlay absolute">

								<?php if ($game_rating) {
									if( function_exists('aces_star_rating') ){
								?>

									<div class="space-units-3-archive-item-rating absolute">
										<div class="space-rating-star-wrap relative">
											<div class="space-rating-star-background absolute"></div>
											<div class="space-rating-star-icon absolute">
												<i class="fas fa-star"></i>
											</div>
										</div>
										<strong><?php echo esc_html( number_format( round( $game_rating, 1 ), 1, '.', ',') ); ?></strong>/<?php echo esc_html( $game_rating_stars_number_value ); ?>
									</div>

								<?php
									}
								} ?>

								<div class="space-units-3-archive-item-central text-center relative">

									<?php if ($terms) { ?>
									<div class="space-units-3-archive-item-category relative">
										<?php foreach ( $terms as $term ) { ?>
									        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
									    <?php } ?>
									</div>
									<?php } ?>

									<div class="space-units-3-archive-item-title relative">
										<?php the_title(); ?>
									</div>

									<?php if ($external_link) { ?>

									<div class="space-units-3-archive-item-button1 relative">
										<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
									</div>

									<?php } ?>

									<div class="space-units-3-archive-item-button2 relative">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
									</div>
								</div>

								<?php if ($game_button_notice) { ?>

								<div class="space-units-3-archive-item-tac absolute">
									
									<?php echo wp_kses( $game_button_notice, $game_allowed_html ); ?>

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

/*  Update #3 Games Homepage Widget  */

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['margin_bottom'] = sanitize_text_field( $new_instance['margin_bottom'] );
		$instance['term_taxonomy_id'] = (int) $new_instance['term_taxonomy_id'];
		$instance['external_link'] = isset( $new_instance['external_link'] ) ? (bool) $new_instance['external_link'] : false;
		return $instance;
	}

/*  #3 Games Homepage Widget Settings Form  */

	public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 8;
		$margin_bottom    = isset( $instance['margin_bottom'] ) ? esc_attr( $instance['margin_bottom'] ) : '';
		$args = array(
			'type'         => 'game',
			'orderby'      => 'name',
			'hide_empty'   => 1,
			'taxonomy'     => 'game-category'
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

add_action( 'widgets_init', 'aces_games_home_widget_3' );

function aces_games_home_widget_3() {
	register_widget( 'aces_games_home_widget_3' );
}