<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-events-2016
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="box__large content__main wrapper cf">
		  <div class="wrapper__sub">
		    <article class="content__main ss1-ss4 ms1-ms6 ls1-ls8 separator">
		      <?php
		if ( have_posts() ) : ?>

				<header>
					<h1 class="gamma heading--main page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'content-parts/content', 'none' );

		endif; ?>
		    </article>

		    <aside id="secondary" class="content__aside widget-area ss1-ss4 ms1-ms6 ls9-ls12">
		      <?php get_sidebar(); ?>
		    </aside>

		  </div>
		</main>

	</div><!-- #primary -->

<?php

get_footer();
