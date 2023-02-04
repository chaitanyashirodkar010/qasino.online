<?php

/*  Bonuses Homepage Widget  */

class aces_bonuses_home_widget extends WP_Widget {

/*  Bonuses Homepage Widget Setup  */

	public function __construct() {
		parent::__construct(false, $name = esc_html__('#Aces Bonuses Homepage', 'aces' ), array(
			'description' => esc_html__('Bonuses widget for the HOMEPAGE (Mercury theme).', 'aces' )
		));
	}

/*  Display Bonuses Homepage Widget  */

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
		$categories = isset( $instance['term_taxonomy_id'] ) ? $instance['term_taxonomy_id'] : '';

		if ( ! empty( $categories ) ) {

			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'post_type' => 'bonus',
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'bonus-category',
						'field'    => 'id',
						'terms'    => $categories
					)
				)
			) ) );

		} else {

			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'post_type' => 'bonus',
				'no_found_rows'       => true,
				'post_status'         => 'publish'
			) ) );

		}

		if ($r->have_posts()) :
		?>

	<div class="space-offers-home-widget homepage-block box-100 relative"<?php if ( $margin_bottom ) { ?> style="margin-bottom: <?php echo esc_attr($margin_bottom); ?>;"<?php } ?>>
		<div class="space-offers-home-widget-ins space-page-wrapper relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-offers-archive-items box-100 relative">

				<?php while ( $r->have_posts() ) : $r->the_post();
					global $post;
					$bonus_allowed_html = array(
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
					$bonus_short_desc = wp_kses( get_post_meta( get_the_ID(), 'bonus_short_desc', true ), $bonus_allowed_html );
					$bonus_external_link = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );
					$bonus_button_title = esc_html( get_post_meta( get_the_ID(), 'bonus_button_title', true ) );
					$bonus_button_notice = wp_kses( get_post_meta( get_the_ID(), 'bonus_button_notice', true ), $bonus_allowed_html );
					$bonus_code = esc_html( get_post_meta( get_the_ID(), 'bonus_code', true ) );
					$bonus_valid_date = esc_html( get_post_meta( get_the_ID(), 'bonus_valid_date', true ) );
					$bonus_dark_style = esc_attr( get_post_meta( get_the_ID(), 'bonus_dark_style', true ) );

					if ($bonus_button_title) {
						$button_title = $bonus_button_title;
					} else {
						if ( get_option( 'bonuses_get_bonus_title') ) {
							$button_title = esc_html( get_option( 'bonuses_get_bonus_title') );
						} else {
							$button_title = esc_html__( 'Get Bonus', 'aces' );
						}
					}

					if ($external_link) {
						if ($bonus_external_link) {
							$external_link_url = $bonus_external_link;
						} else {
							$external_link_url = get_the_permalink();
						}
					} else {
						$external_link_url = get_the_permalink();
					}

					$terms = get_the_terms( $post->ID, 'bonus-category' );
				?>

				<div class="space-offers-archive-item box-25 left relative<?php if ($bonus_dark_style == true ) { ?> space-dark-style<?php } ?>">
					<div class="space-offers-archive-item-ins relative">
						<div class="space-offers-archive-item-wrap text-center relative">

							<?php if ($terms) { ?>
							<div class="space-offers-archive-item-cat relative">

								<?php foreach ( $terms as $term ) { ?>
							        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
							    <?php } ?>
								
							</div>
							<?php } ?>

							<div class="space-offers-archive-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>

							<?php if ($bonus_code) { ?>
							<div class="space-offers-archive-item-code relative">
								<div class="space-offers-archive-item-code-value relative">
									<?php echo esc_html( $bonus_code ); ?>
								</div>
								<div class="space-offers-archive-item-code-title absolute">
									<span><?php esc_html_e( 'Bonus Code', 'aces' ); ?></span>
								</div>
							</div>

								<?php if ($bonus_valid_date) { ?>
								<div class="space-offers-archive-item-code-date relative">
									<?php esc_html_e( 'Valid Until:', 'aces' ); ?> <span><?php echo esc_html( date_i18n('M d, Y',strtotime($bonus_valid_date))); ?></span>
								</div>
								<?php } ?>
								
							<?php } ?>

							<?php if ($bonus_short_desc) { ?>
							<div class="space-offers-archive-item-short-desc relative">
								<?php echo wp_kses( $bonus_short_desc, $bonus_allowed_html ); ?>
							</div>
							<?php } ?>

							<div class="space-offers-archive-item-button relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
							</div>

							<?php if ($bonus_button_notice) { ?>

							<div class="space-offers-archive-item-button-notice relative">
								<?php echo wp_kses( $bonus_button_notice, $bonus_allowed_html ); ?>
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

/*  Update Bonuses Homepage Widget  */

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['margin_bottom'] = sanitize_text_field( $new_instance['margin_bottom'] );
		$instance['term_taxonomy_id'] = (int) $new_instance['term_taxonomy_id'];
		$instance['external_link'] = isset( $new_instance['external_link'] ) ? (bool) $new_instance['external_link'] : false;
		return $instance;
	}

/*  Bonuses Homepage Widget Settings Form  */

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$margin_bottom    = isset( $instance['margin_bottom'] ) ? esc_attr( $instance['margin_bottom'] ) : '';
		$args = array(
			'type'         => 'bonus',
			'orderby'      => 'name',
			'hide_empty'   => 1,
			'taxonomy'     => 'bonus-category'
		);
		$external_link = isset( $instance['external_link'] ) ? (bool) $instance['external_link'] : false;
		$cats = get_categories($args);
		$categories = isset( $instance['term_taxonomy_id'] ) ? $instance['term_taxonomy_id'] : '';
?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'aces' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $external_link ); ?> id="<?php echo esc_attr($this->get_field_id( 'external_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'external_link' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'external_link' )); ?>"><?php esc_html_e( 'Use external link for the button', 'aces' ); ?></label></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of items to show:', 'aces' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>"><?php esc_html_e( 'Margin bottom for the block (in pixels):', 'aces' ); ?></label>
		<input class="small-text" id="<?php echo esc_attr($this->get_field_id( 'margin_bottom' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'margin_bottom' )); ?>" type="text" value="<?php echo esc_attr($margin_bottom); ?>" size="3" /></p>

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

add_action( 'widgets_init', 'aces_bonuses_home_widget' );

function aces_bonuses_home_widget() {
	register_widget( 'aces_bonuses_home_widget' );
}