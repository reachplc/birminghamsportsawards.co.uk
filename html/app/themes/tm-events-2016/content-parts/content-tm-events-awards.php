<?php
/**
 * Template part for displaying awards.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-events-2016
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'block category-item box grid__separator--horizontal' ); ?>>

	<header class="entry-header">
		<?php the_title( '<h3 class="heading--sub ' . get_awards_taxonomy_class( get_the_terms( get_the_ID(), 'awards-levels' ) ) . '">', '</h3>' );?>
	</header><!-- .entry-header -->

	<div class="entry-content block category-item box grid__separator--horizontal">

		<section class="block__content category-item__content ss1-ss4 ls1-ls8">
		<?php the_content(); ?>
		</section>

		<aside class="block__aside--right category-item__aside box ss1-ss4 ls9-ls12">
		<?php foreach ( find_award_partner( get_the_ID() ) as $key => $partner_id ) : ?>
			<?php $partner_link = get_post_meta( $partner_id, '_tm_events_partners_partner_link', true ); ?>

			<?php if ( $partner_link ) : ?><a class="outbound link" rel="nofollow" targert="_blank" href="<?php echo esc_html( $partner_link ); ?>"><?php endif; ?>
				<?php echo get_the_post_thumbnail( $partner_id, null, array( 'class' => 'image__responsive' ) ); ?>
			<?php if ( $partner_link ) : ?></a><?php endif; ?>



		<?php endforeach; ?>
		</aside>

		<?php	wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ctba-2016' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
