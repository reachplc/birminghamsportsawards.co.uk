<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-events-2016
 */

$associate_array = new WP_Query(
	array(
		'post_type'		=> 'tm-events-partners',
		'post_status' => array(
			'publish',
		),
		'nopaging'    => true,
		'orderby'   => 'title',
		'order'     => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'partner-levels',
				'field'    => 'slug',
				'terms'    => array( 'associate' ),
			),
		),
	)
);

$supporter_array = new WP_Query(
	array(
		'post_type'		=> 'tm-events-partners',
		'post_status' => array(
			'publish',
		),
		'nopaging'    => true,
		'orderby'   => 'menu_order title',
		'order'     => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'partner-levels',
				'field'    => 'slug',
				'terms'    => array( 'supporter' ),
			),
		),
	)
);

?>

<section class="wrapper partners-bar box__large c cf">

	<div class="wrapper__sub">

<?php if ( $associate_array->have_posts() ) : ?>
		<section class="grid ss1-ss4 ms1-6 ls1-ls4">

	<!-- pagination here -->
	<h3 class="gamma heading--sub">In association with:</h3>

	<!-- the loop -->
	<?php while ( $associate_array->have_posts() ) : $associate_array->the_post(); ?>
		<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php the_post_thumbnail(
				'logo-partner',
				array(
					'class' => 'image__responsive',
				)
			); ?>
		</a>
		<?php endif; ?>
	<?php endwhile; ?>
	<!-- end of the loop -->

	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>
	</section>

<?php endif; ?>

<?php if ( $supporter_array->have_posts() ) : ?>
	<section class="ss1-ss4 ms1-ms6 ls5-ls12">
		<h3 class="gamma heading--main">Supported by:</h3>
		<ul class="list gallery cf">

		<?php while ( $supporter_array->have_posts() ) : $supporter_array->the_post(); ?>
		<?php if ( has_post_thumbnail() ) : ?>
			<li class="gallery__item">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail(
					'logo-partner',
					array(
						'class' => 'image__responsive',
					)
				); ?>
				</a>
			</li>
		<?php endif; ?>
		<?php endwhile; ?>
		</ul>
	</section>
<?php endif; ?>
	</div><!--/ wrapper__sub  -->

</section>
