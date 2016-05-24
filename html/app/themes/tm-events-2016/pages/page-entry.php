<?php /* Template Name: Entry */

/*if ( ! is_user_logged_in() ) {
	wp_redirect( home_url( $path = 'login' ) );
	exit;
}*/

$entry = get_query_var( 'entry' );
$object_id = ( get_query_var( 'entry' ) !== '' ? $entry : 0 );

// Check to see if the current entry was made by the current user
global $current_user;
get_currentuserinfo();

if ( $current_user->ID !== get_post_field( 'post_author', $object_id ) && ( 0 !== $object_id ) ) {
		remove_query_arg( 'entry' );
		wp_redirect( home_url( $path = 'nominate/entry' ) );
}


get_header(); ?>

<div id="primary" class="content-area">

<main id="main" class="content__main wrapper cf" role="main">
  <div class="wrapper__sub">
    <article class="ss1-ss4 ms1-ms6 ls1-ls12">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content-parts/content', 'entry' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>
    </article>
  </div>
</main>

</div><!-- .content-area -->

<?php get_footer(); ?>
