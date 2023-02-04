<?php

/*  #1 Casinos Homepage Widget  */

class aces_casinos_home_widget extends WP_Widget {

/*  #1 Casinos Homepage Widget Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#Aces Casinos-1', 'aces' ), array(
			'description' => esc_html__('#1 Casinos widget for the HOMEPAGE (Mercury theme).', 'aces' )
		));
	}

/*  Display #1 Casinos Homepage Widget  */

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 4;
		if ( ! $number ) {
			$number = 4;
		}

		$margin_bottom = ( ! empty( $instance['margin_bottom'] ) ) ? esc_attr( $instance['margin_bottom'] ) : '';
		if ( ! $margin_bottom ) {
			$margin_bottom = '';
		} 

		$external_link = isset( $instance['external_link'] ) ? $instance['external_link'] : false;
		$big_thumbnail = isset( $instance['big_thumbnail'] ) ? $instance['big_thumbnail'] : false;

		$categories = isset( $instance['term_taxonomy_id'] ) ? $instance['term_taxonomy_id'] : '';

		if ( ! empty( $categories ) ) {

			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'post_type' => 'casino',
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'casino-category',
						'field'    => 'id',
						'terms'    => $categories
					)
				)
			) ) );

		} else {

			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'post_type' => 'casino',
				'no_found_rows'       => true,
				'post_status'         => 'publish'
			) ) );

		}

		if ($r->have_posts()) :

			if ( get_option( 'aces_rating_stars_number' ) ) {
				$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
			} else {
				$casino_rating_stars_number_value = '5';
			}

		?>

	<div class="space-companies-home-widget homepage-block box-100 relative"<?php if ( $margin_bottom ) { ?> style="margin-bottom: <?php echo esc_attr($margin_bottom); ?>px;"<?php } ?>>
		<div class="space-companies-home-widget-ins space-page-wrapper relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-companies-archive-items box-100 relative">

				<?php while ( $r->have_posts() ) : $r->the_post();
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

					$casino_short_desc = wp_kses( get_post_meta( get_the_ID(), 'casino_short_desc', true ), $casino_allowed_html );
					$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
					$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
					$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
					$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

					if ($casino_button_title) {
						$button_title = $casino_button_title;
					} else {
						if ( get_option( 'casinos_play_now_title') ) {
							$button_title = esc_html( get_option( 'casinos_play_now_title') );
						} else {
							$button_title = esc_html__( 'Play Now', 'aces' );
						}
					}

					if ($external_link) {
						if ($casino_external_link) {
							$external_link_url = $casino_external_link;
						} else {
							$external_link_url = get_the_permalink();
						}
					} else {
						$external_link_url = get_the_permalink();
					}

					$terms = get_the_terms( $post->ID, 'casino-category' );
					$post_title_attr = the_title_attribute( 'echo=0' );
				?>

				<div class="space-companies-archive-item box-25 relative">
					<div class="space-companies-archive-item-ins relative">
						<?php if ($big_thumbnail) {
							if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
							<div class="space-companies-archive-item-big-img text-center relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-317', "", array( "alt" => $post_title_attr ) ); ?>
								</a>
							</div>
							<?php }
						} ?>

						<div class="space-companies-archive-item-wrap text-center relative<?php if ($big_thumbnail) { ?> big<?php } ?>">
							<?php
							if (!$big_thumbnail) {
								if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
								<div class="space-companies-archive-item-img relative">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-120-120', "", array( "alt" => $post_title_attr ) ); ?>
									</a>
								</div>
								<?php }
							} ?>

							<div class="space-companies-archive-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>

							</div>
							
							<?php if( function_exists('aces_star_rating') ){ ?>
								<div class="space-companies-archive-item-rating relative">
									<?php aces_star_rating(
										array(
											'rating' => $casino_overall_rating,
											'type' => 'rating',
											'stars_number' => $casino_rating_stars_number_value
										)
									); ?>
								</div>
							<?php } ?>

							<?php if ($casino_short_desc) { ?>
							<div class="space-companies-archive-item-short-desc relative">
								<?php echo wp_kses( $casino_short_desc, $casino_allowed_html ); ?>
							</div>
							<?php } ?>

							<div class="space-companies-archive-item-button relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
							</div>

							<?php if ($casino_button_notice) { ?>

							<div class="space-organizations-archive-item-button-notice relative">
								<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>
							</div>

							<?php } ?>

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

/*  Update #1 Casinos Homepage Widget  */

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['margin_bottom'] = sanitize_text_field( $new_instance['margin_bottom'] );
		$instance['term_taxonomy_id'] = (int) $new_instance['term_taxonomy_id'];
		$instance['external_link'] = isset( $new_instance['external_link'] ) ? (bool) $new_instance['external_link'] : false;
		$instance['big_thumbnail'] = isset( $new_instance['big_thumbnail'] ) ? (bool) $new_instance['big_thumbnail'] : false;
		return $instance;

	}

/*  #1 Casinos Homepage Widget Settings Form  */

	public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$margin_bottom    = isset( $instance['margin_bottom'] ) ? esc_attr( $instance['margin_bottom'] ) : '';
		$args = array(
			'type'         => 'casino',
			'orderby'      => 'name',
			'hide_empty'   => 1,
			'taxonomy'     => 'casino-category'
		);
		$external_link = isset( $instance['external_link'] ) ? (bool) $instance['external_link'] : false;
		$big_thumbnail = isset( $instance['big_thumbnail'] ) ? (bool) $instance['big_thumbnail'] : false;
		$cats = get_categories($args);
		$categories = isset( $instance['term_taxonomy_id'] ) ? $instance['term_taxonomy_id'] : '';
?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'aces' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $external_link ); ?> id="<?php echo esc_attr($this->get_field_id( 'external_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'external_link' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'external_link' )); ?>"><?php esc_html_e( 'Use external link for the button', 'aces' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $big_thumbnail ); ?> id="<?php echo esc_attr($this->get_field_id( 'big_thumbnail' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'big_thumbnail' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'big_thumbnail' )); ?>"><?php esc_html_e( 'Show big thumbnail', 'aces' ); ?></label></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of items to show:', 'aces' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>"><?php esc_html_e( 'Value "margin-bottom" for the block (in pixels):', 'aces' ); ?></label>
		<input class="small-text" id="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'margin_bottom' )); ?>" type="text" value="<?php echo esc_attr($margin_bottom); ?>" size="3" /> px.</p>

		<hr>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'term_taxonomy_id' )); ?>"><?php esc_html_e('Category:' , 'aces' );?></label>
		<select id="<?php echo esc_attr($this->get_field_id( 'term_taxonomy_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'term_taxonomy_id' )); ?>">
 		<option value=""><?php esc_html_e('All' , 'aces' );?></option>

			<?php foreach ( $cats as $cat ) {?>
			<option value="<?php echo esc_attr($cat->term_id); ?>"<?php echo selected( $categories, $cat->term_id, false ) ?>> <?php echo esc_html( $cat->name ) ?></option>
			<?php }?>

 		</select></p>

<?php
	}
}

add_action( 'widgets_init', 'aces_casinos_home_widget' );

function aces_casinos_home_widget() {
	register_widget( 'aces_casinos_home_widget' );
}