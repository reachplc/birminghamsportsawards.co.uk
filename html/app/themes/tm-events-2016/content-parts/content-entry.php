<?php
/**
 * The template used for displaying dashboard content
 *
 * @package WordPress
 * @subpackage tm-events-2016
 */

$entry = get_query_var( 'entry' );
$object_id = ( get_query_var( 'entry' ) !== '' ? $entry : 0 );
// Check if the login failed
$entry_status = ( get_query_var( 'status' ) === 'saved' ? true : false );
?>

<article id="entry-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="gamma heading--main entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( true === $entry_status ) : ?>
			<section class="alert alert--message alert--positive alert--type box" role="alert">
				<!--<a class="alert__close" href="#">×</a>-->
				<p>
				<?php printf(
					'<strong>%1$s!</strong> %2$s</p>',
					esc_html__( 'Saved', 'bpba' ),
					esc_html__( 'Your entry has been saved. Feel free to come back and edited it before submitting.', 'bpba' )
				); ?>
				</p>

			</section>
		<?php endif; ?>

		<?php the_content(); ?>

<?php

echo '<form class="cmb-form" method="post" id="bpba-2016-entries-form" enctype="multipart/form-data">' .
			'<input type="hidden" name="object_id" value="'. esc_attr( $object_id ) .'">';

$args = array(
	'form_format' => '%3$s',
	'save_fields' => false,
);

cmb2_metabox_form( '_bsa_entries_2016_', $object_id, $args );

?>

<div class="submit-button">
<input type="submit" name="submit-cmb" value="Submit" class="btn btn--primary">
</div>
</form>

	</div><!-- .entry-content -->

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
				get_the_title()
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
	?>

</article><!-- #entry-<?php the_ID(); ?> -->

<section id="bpba-alert" class="alert alert--message alert--type box" role="alert" data-state="hidden">
	<!--<a class="alert__close" href="#">×</a>-->
	<p>
	<?php printf(
		'<strong>%1$s</strong> %2$s</p>',
		esc_html__( 'Info', 'bpba' ),
		esc_html__( 'Entry&rsquo;s are limited to 3 categories.', 'bpba' )
	); ?>
	</p>

</section>
