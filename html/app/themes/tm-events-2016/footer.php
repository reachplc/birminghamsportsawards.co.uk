<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-events-2016
 */

?>

	</div><!-- #content -->

<?php get_sidebar( 'partners' ); ?>

<section class="footer__sub wrapper cf">

    <div class="wrapper__sub">

    <div class="ss1-ss4 ms1-ms2 ls1-ls4">
      <h4 id="nav-footer">Site Map</h4>
			<?php function events_nav_wrap(){
					$wrap  = '<ul id="%1$s" class="%2$s">';
			    $wrap .= '<li>';
			    $wrap .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
			    $wrap .= 'Home';
			    $wrap .= '</a>';
			    $wrap .= '</li>';
			    $wrap .= '%3$s';
			    $wrap .= '</ul>';
			    return $wrap;
}?>
		<?php wp_nav_menu(
			array(
	  		'theme_location' => 'primary',
	  		//'menu_id' => '' ,
	  		'menu_class' => 'footer__sub--links list',
	  		'container' => '',
	  		'items_wrap' => events_nav_wrap()
			)
		);
		?>
    </div>

    <div class="grid__seperator--dark ss1-ss4 ms3-ms4 ls5-ls8">
      <h4>Categories</h4>
      <ul class="footer__sub--links list">
		<?php // WP_Query arguments

		$args = array(
		'posts_per_page'   => 50,
		'offset'           => 0,
		'orderby'          => 'menu_order',
		'order'            => 'ASC',
		'post_type'        => 'tm-events-awards',
		'post_status'      => 'publish',
		);
		$category_array = get_posts( $args );

		foreach ( $category_array as $post ) {
				setup_postdata( $post );?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php
		}

		wp_reset_postdata();

?>

      </ul>
    </div>

    <div class="grid__seperator--dark ss1-ss4 ms5-ms6 ls9-ls12">
		<h4>Event Sites</h4>

		<?php wp_nav_menu(
			array(
				'menu'		=> 'Event Sites',
	  		'theme_location' => 'events',
	  		'menu_id' => '',
	  		'menu_class' => 'footer__sub--links list',
	  		'container' => '',
				'fallback_cb' => false,
			)
		);
		?>

    </div>

  </div>

</section>

	<footer id="colophon" class="footer__main wrapper cf" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

	  <div class="wrapper__sub">

	    <p class="copyright ss1-ss4 ms1-ms6 ls1-ls12">&copy; 2016 Trinity Mirror Midlands. All rights reserved. <a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms&nbsp;&amp;&nbsp;Conditions</a> | <a href="<?php echo esc_url( home_url( '/cookies/' ) ); ?>">Cookies</a></p>

	  </div>

	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
