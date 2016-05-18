<?php
/**
 * Plugin Name: TI Widgets
 * Plugin URI: http://www.thoughtsandideas.co.uk
 * Description: Update the user dashboard with support details and remove widgets not needed.
 * Author: Michael Bragg
 * Author URI:
 * Version: 0.1.0
 */

/* Remove the welcome panel from showing on the first login */
remove_action('welcome_panel', 'wp_welcome_panel');

add_action( 'wp_dashboard_setup', 'adjust_default_dashboard_widgets', 11);

function adjust_default_dashboard_widgets() {

	global $wp_meta_boxes;

	// WordPress News Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	// We want our users to take their time over their posts
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    // Quick Press Widget

	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);    // Right Now Widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        // Activity Widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Comments Widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);  // Incoming Links Widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);         // Plugins Widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);     // Recent Drafts Widget

}

/**
 * Change Admin Footer Text
 */

function modify_footer_admin(){
  echo 'Created by Trinity Mirror Creative.';
}
add_filter( 'admin_footer_text', 'modify_footer_admin' );

/**
 * De-register Site Widgets
 */
function remove_default_widgets() {

	// We will use custom menus to only show pages we want
  unregister_widget('WP_Widget_Pages');
	// We will use custom menus to only show pages we want
  unregister_widget('WP_Widget_Calendar');
  // We will use custom menus to only show categories we want
  unregister_widget('WP_Widget_Archives');
  // Feature depreciated
  unregister_widget('WP_Widget_Links');
  // Remove Site Admin, Login, RSS Feeds and WP link
  unregister_widget('WP_Widget_Meta');
	// We will use custom menus to only show posts we want
  unregister_widget('WP_Widget_Recent_Posts');
  // As most sites don't use the comments feature
  unregister_widget('WP_Widget_Recent_Comments');
  // Remove tag cloud as its ugly
  unregister_widget('WP_Widget_Tag_Cloud');

}

add_action('widgets_init', 'remove_default_widgets', 11);

function remove_footer_admin_wordpress_version() {
	if ( !current_user_can( 'manage_options' ) ) {
		remove_filter( 'update_footer', 'core_update_footer' );
	}
}
	add_action( 'admin_menu', 'remove_footer_admin_wordpress_version' );

function remove_admin_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
}

add_action( 'admin_bar_menu', 'remove_admin_logo', 11 );
