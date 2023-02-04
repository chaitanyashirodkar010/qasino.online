<?php get_header(); ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "image": "<?php echo esc_url( get_avatar_url( get_the_author_meta('user_email'), ['size' => '200'] )); ?>",
  "name": "<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>",
  "url": "<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>"
}
</script>

<!-- Title Box Start -->

<div class="space-archive-title-box box-100 relative">
	<div class="space-archive-title-box-ins space-page-wrapper relative">
		<div class="space-archive-title-box-h1 relative">
			<h1><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h1>

			<?php if (get_the_author_meta('description')) { ?>
				<div class="space-page-content-excerpt box-100 relative">
					<p>
						<?php echo esc_html( get_the_author_meta( 'description' ) ); ?>
					</p>
				</div>
			<?php } ?>
			
			<!-- Breadcrumbs Start -->

			<?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

			<!-- Breadcrumbs End -->
		</div>
	</div>
</div>

<!-- Title Box End -->

<!-- Archive Section Start -->

<div class="space-archive-section box-100 relative">
	<div class="space-archive-section-ins space-page-wrapper relative">
		<div class="space-content-section box-75 left relative">

			<div class="space-archive-loop box-100 relative">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( '/theme-parts/archive/loop' ); ?>

				<?php endwhile; ?>

				<!-- Archive Navigation Start -->

				<?php
					the_posts_pagination( array(
						'end_size' => 2,
						'prev_text'    => esc_html__('&laquo;', 'mercury'),
						'next_text'    => esc_html__('&raquo;', 'mercury'),
					));
				?>

				<!-- Archive Navigation End -->

				<?php else : ?>

				<!-- Posts not found Start -->

				<div class="space-page-content-wrap relative">
					<div class="space-page-content page-template box-100 relative">
						<h2><?php esc_html_e( 'Posts not found', 'mercury' ); ?></h2>
						<p>
							<?php esc_html_e( 'No posts has been found. Please return to the homepage.', 'mercury' ); ?>
						</p>
					</div>
				</div>

				<!-- Posts not found End -->

				<?php endif; ?>

			</div>
		</div>
		<div class="space-sidebar-section box-25 left relative">

			<?php get_sidebar(); ?>

		</div>
	</div>
</div>

<!-- Archive Section End -->

<?php get_footer(); ?>