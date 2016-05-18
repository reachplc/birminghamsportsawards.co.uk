<?php


function tm_events_2016_image_sizes() {

	// Main Logo
	add_image_size( 'logo-master', 528, 328, false );

	// Partner Logo
	add_image_size( 'logo-partner', 400, 150, false );

	// Profile image
	add_image_size( 'profile', 480, 720, false );

	// Judge profile image
	add_image_size( 'profile-judge', 480, 600, array( 'center', 'top' ) );

	// Category Icon
	add_image_size( 'icon-category', 176, 176, false );
	add_image_size( 'icon-category-small', 88, 88, false );

	// Hero
	add_image_size( 'hero', 1280, 720, false );
	add_image_size( 'hero-medium', 640, 360, false );
	add_image_size( 'hero-small', 480, 270, false );

}

add_action( 'after_setup_theme', 'tm_events_2016_image_sizes' );
