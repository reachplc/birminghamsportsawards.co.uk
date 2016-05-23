<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bpba
 */

$profile_name = get_post_meta( get_the_ID(), '_tm_events_partners_profile_name', true );
$profile_title = get_post_meta( get_the_ID(), '_tm_events_partners_profile_title', true );
$profile_image = get_post_meta( get_the_ID(), '_tm_events_partners_profile_image_id', true );
$profile_quote = get_post_meta( get_the_ID(), '_tm_events_partners_profile_quote', true );
$partner_link = get_post_meta( get_the_ID(), '_tm_events_partners_partner_link', true );
$associated_award = get_post_meta( get_the_ID(), '_tm_events_partners_associated_award', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'block sponsors-item box grid__separator--horizontal' ); ?>>
	<header class="entry-header">
		<h1 class="gamma heading--main entry-title">
		<?php
		if ( is_single() ) {
				the_title();
				echo '-&nbsp;' . esc_html( get_the_title( $associated_award ) );
		} else { ?>
			<a href="<?php esc_url( get_permalink() ); ?>" rel="bookmark">
				<?php	the_title(); ?>
			</a>
			<?php echo '-&nbsp;' . esc_html( get_the_title( $associated_award ) ); ?>
		<?php } ?>
		</h1>
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php ctba_2016_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<aside class="block__aside sponsors-item__aside box grid ss1-ss4 ls1-ls4">
			<?php if ( $profile_image ) : ?>
				<?php wp_get_attachment_image( $profile_image, 'profile', false, array( 'class' => 'image__responsive' ) ); ?>
			<?php endif; ?>
			<p>
				<?php if ( has_post_thumbnail() ) : ?>
					<?php if ( $partner_link ) : ?>
						<a class="outbound link" rel="nofollow" targert="_blank" href="<?php echo esc_html( $partner_link ); ?>">
					<?php endif; ?>
					<?php the_post_thumbnail(
						'logo-partner',
						array(
							'class' => 'image__responsive',
						)
					); ?>
					<?php if ( $partner_link ) : ?></a><?php endif; ?>
				<?php endif; ?>
			</p>
		</aside>

		<section class="block__content sponsors-item__content">
		<blockquote>
		<?php if ( $profile_quote ) : ?><?php echo wpautop( esc_html( $profile_quote ) );?><?php endif; ?>
		<?php if ( $profile_name ) : ?><p>- <b itemprop="name"><?php echo esc_html( $profile_name );?></b><?php if ( $profile_title ) : ?>, <span itemprop="jobTitle"><?php echo esc_html( $profile_title );?></span><?php endif; ?></p><?php endif; ?>
		</blockquote>
		</section>

		<?php	wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ctba-2016' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ba_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
