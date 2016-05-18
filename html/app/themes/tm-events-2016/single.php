<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tm-events-2016
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="box__large content__main wrapper cf">
		  <div class="wrapper__sub">
		    <article class="content__main ss1-ss4 ms1-ms6 ls1-ls8 separator">
		     		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'content-parts/content', get_post_format() );

			#the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		    </article>

				<aside id="secondary" class="content__aside widget-area ss1-ss4 ms1-ms6 ls9-ls12">
		      <?php get_sidebar(); ?>
		    </aside>

		  </div>
		</main>

	</div><!-- #primary -->

<?php

get_footer();
