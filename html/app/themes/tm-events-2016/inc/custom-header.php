<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package tm-events-2016
 */

if ( ! function_exists( 'tm_events_custom_logo' ) ) {

	function tm_events_custom_logo() {

		$logo = printf(
			'<a href="%1$s" rel="home"><img class="" src="%2$s" alt="%3$s"></a>',
			esc_url( home_url( '/' ) ),
			esc_url( get_template_directory_uri() . '/gui/logo_awards.png' ),
			esc_html( get_bloginfo( 'name' ) )
		);

		if ( function_exists( 'get_custom_logo' ) ) {
			// Nothing in the output: Custom Logo is not supported, or there is no selected logo
			if ( has_custom_logo() ) {
				the_custom_logo();
			}
			return false;
		}
		echo esc_html( $logo );
	}

}
