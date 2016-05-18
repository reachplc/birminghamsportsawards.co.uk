<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-evetns-2016
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php if ( function_exists( 'tm_hero_has_hero' ) && tm_hero_has_hero() ) { body_class( 'has-hero' ); } else { body_class(); }; ?>>

	<?php if ( function_exists( 'HM_GTM\tag' ) ) { HM_GTM\tag(); } ?>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'tm-events-2016' ); ?></a>

		<header class="header__main site-header fixed cf" itemscope="itemscope" itemtype="http://schema.org/WPHeader" id="masthead">
			<div class="wrapper__sub">

				<?php tm_events_custom_logo(); ?>

				<nav id="site-navigation" class="nav__main" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

					<a href="#nav-footer" class="navicon navicon__right ls-hidden" aria-controls="site-navigation" aria-expanded="false">Menu</a>

					<?php wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id' => 'js-nav__main',
							'menu_class' => 'nav__main__right list menu',
							'container' => '',
						)
					);
					?>

				</nav>

			</div>
		</header>

<?php

if ( ! function_exists( 'tm_hero_has_hero' ) || ! tm_hero_has_hero() ) :
	return;
else : ?>
<section class="hero wrapper box__large hero--image" style="background-image: url(
<?php if ( tm_hero_has_field( 'image' ) ) {
	echo esc_url( wp_get_attachment_url( tm_hero_the_image() ) );
} else {
	echo esc_url( get_template_directory_uri() . '/gui/hero_default.jpg' ); }  ?>
)">

	<article class="wrapper__sub">

		<div class="hero__content">

<?php if ( tm_hero_has_field( 'tagline' ) ) { ?>
			<h4 class="hero__copy gamma"><?php echo esc_html( tm_hero_the_tagline() ); ?></h4>
		<?php
} else { ?>
			<h4 class="hero__copy gamma">Celebrate your success in business with the Birmingham Post.</h4>
		<?php } ?>

		<?php if ( tm_hero_has_field( 'btn_link' ) && tm_hero_has_field( 'btn_text' ) ) { ?>
			<a class="hero__btn btn btn--primary" href="<?php echo esc_url( tm_hero_the_btn_link() ); ?>">
				<?php echo esc_html( tm_hero_the_btn_text() ); ?>
			</a>
<?php } ?>

		</div>

	</article>

</section>
<?php endif; ?>

	<div id="content" class="site-content">
