<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package tm-events-2016
 */

get_header(); ?>

	<section id="primary" class="content-area">

		<main id="main" class="box__large content__main wrapper cf">
		  <div class="wrapper__sub">
		    <article class="content__main ss1-ss4 ms1-ms6 ls1-ls8 separator">
		      		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'tm-events-2016' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content-parts/content', 'search' );

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

	</section><!-- #primary -->

<?php

get_footer();
