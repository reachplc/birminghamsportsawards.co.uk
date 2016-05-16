<?php
/*
 * Plugin Name: Install Drop-In
 * Plugin URI:
 * Description: install.php drop-in to provide replacement functions for various install and upgrade features.
 * Author: Michael Bragg <michael@michaelbragg.net>
 * Author URI:
 * Version: 0.1.0
 */

/**
 * Modify the installation defaults when new sites are added.
 *
 * This is a drop in replacement to the default wp_install_defaults() in WordPress.
 *
 * @global wpdb       $wpdb
 * @global WP_Rewrite $wp_rewrite
 * @global string     $table_prefix
 *
 * @param int $user_id User ID.
 */
function wp_install_defaults( $user_id ) {
  global $wpdb, $wp_rewrite, $table_prefix;


  /* Create default categories and tags */
  $cat_name = __('Uncategorized');
  /* translators: Default category slug */
  $cat_slug = sanitize_title(_x('Uncategorized', 'Default category slug'));

  if ( global_terms_enabled() ) {
    $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT cat_ID FROM {$wpdb->sitecategories} WHERE category_nicename = %s", $cat_slug ) );
    if ( $cat_id == null ) {
      $wpdb->insert( $wpdb->sitecategories, array('cat_ID' => 0, 'cat_name' => $cat_name, 'category_nicename' => $cat_slug, 'last_updated' => current_time('mysql', true)) );
      $cat_id = $wpdb->insert_id;
    }
    update_option('default_category', $cat_id);
  } else {
    $cat_id = 1;
  }

  $wpdb->insert( $wpdb->terms, array('term_id' => $cat_id, 'name' => $cat_name, 'slug' => $cat_slug, 'term_group' => 0) );
  $wpdb->insert( $wpdb->term_taxonomy, array('term_id' => $cat_id, 'taxonomy' => 'category', 'description' => '', 'parent' => 0, 'count' => 1));
  $cat_tt_id = $wpdb->insert_id;

  /* Create default pages */
  $now = current_time( 'mysql' );
  $now_gmt = current_time( 'mysql', 1 );

  /* Create a static front page */
  $front_page = "";

  if( is_multisite() )
  	$front_page = get_site_option( 'front_page', $front_page );
  	$front_post_guid = get_option('home') . '/?page_id=1';
  	$wpdb->insert( $wpdb->posts, array(
	    'post_author' => $user_id,
	    'post_date' => $now,
	    'post_date_gmt' => $now_gmt,
	    'post_content' => $front_page,
	    'post_excerpt' => '',
	    'comment_status' => 'closed',
	    'post_title' => __( 'Home' ),
	    /* translators: Default page slug */
	    'post_name' => __( 'front-page' ),
	    'post_modified' => $now,
	    'post_modified_gmt' => $now_gmt,
	    'guid' => $front_post_guid,
	    'post_type' => 'page',
	    'to_ping' => '',
	    'pinged' => '',
	    'post_content_filtered' => ''
	  	)
	  );

  $wpdb->insert( $wpdb->postmeta, array( 'post_id' => 1, 'meta_key' => '_wp_page_template', 'meta_value' => 'default' ) );

	/* Create a static news page */

  $blog_page = "";

  if( is_multisite() )
  	$blog_page = get_site_option( 'blog_page', $blog_page );
  	$blog_post_guid = get_option('home') . '/?page_id=2';
  	$wpdb->insert( $wpdb->posts, array(
	    'post_author' => $user_id,
	    'post_date' => $now,
	    'post_date_gmt' => $now_gmt,
	    'post_content' => $blog_page,
	    'post_excerpt' => '',
	    'comment_status' => 'closed',
	    'post_title' => __( 'News' ),
	    /* translators: Default page slug */
	    'post_name' => __( 'news' ),
	    'post_modified' => $now,
	    'post_modified_gmt' => $now_gmt,
	    'guid' => $blog_post_guid,
	    'post_type' => 'page',
	    'to_ping' => '',
	    'pinged' => '',
	    'post_content_filtered' => '',
	  	)
	  );

  $wpdb->insert( $wpdb->postmeta, array( 'post_id' => 2, 'meta_key' => '_wp_page_template', 'meta_value' => 'default' ) );

  // Set up default widgets for default theme.
  update_option( 'widget_search', array ( 2 => array ( 'title' => '' ), '_multiwidget' => 1 ) );
  update_option( 'widget_recent-posts', array ( 2 => array ( 'title' => '', 'number' => 5 ), '_multiwidget' => 1 ) );
  update_option( 'widget_recent-comments', array ( 2 => array ( 'title' => '', 'number' => 5 ), '_multiwidget' => 1 ) );
  update_option( 'widget_archives', array ( 2 => array ( 'title' => '', 'count' => 0, 'dropdown' => 0 ), '_multiwidget' => 1 ) );
  update_option( 'widget_categories', array ( 2 => array ( 'title' => '', 'count' => 0, 'hierarchical' => 0, 'dropdown' => 0 ), '_multiwidget' => 1 ) );
  update_option( 'widget_meta', array ( 2 => array ( 'title' => '' ), '_multiwidget' => 1 ) );
  update_option( 'sidebars_widgets', array ( 'wp_inactive_widgets' => array (), 'sidebar-1' => array ( 0 => 'search-2', 1 => 'recent-posts-2', 2 => 'archives-2', 3 => 'categories-2', ), 'array_version' => 3 ) );

	/* Apply our WordPress default options */
	$default_options = array(
		'blogdescription'								=> '', // Make empty
		'users_can_register'						=> 0, // False
		'start_of_week'									=> 1, // Monday
		'use_smiles'										=> 0, // False
		'default_comment_status'				=> 'closed', // No comments
		'default_ping_status'						=> 'closed', // No ping
		'default_pingback_flag'					=> '',
		'date_format'										=> 'F j, Y',
		'time_format'										=> 'g:i a',
		'links_updated_date_format'			=> 'F j, Y g:i a',
		'permalink_structure'						=> '/news/%postname%/',
		'category_base'									=> 'news/categories',
		'uploads_use_yearmonth_folders' => 1, // True
		'upload_path'										=> realpath($_SERVER["DOCUMENT_ROOT"]) . '/media',
		'show_on_front'									=> 'page', // Use a page as Front page
		'tag_base'											=> 'news/tags',
		'show_avatars'									=> 0,
		'upload_url_path'								=> WP_HOME . '/media',
		'avatar_default'								=> 'blank',
		'timezone_string'								=> 'Etc/GMT',
	  'page_on_front'									=> 1, // Set Home to be used as Front page
	  'page_for_posts'								=> 2, // Set Blog to be used as Posts page
	);

	function ti_update_options( $options ) {

		foreach ( $options as $key => $value ) {
			update_option( $key, $value );
		}

	}

	ti_update_options( $default_options );

/* */

  if ( ! is_multisite() )
    update_user_meta( $user_id, 'show_welcome_panel', 1 );
  elseif ( ! is_super_admin( $user_id ) && ! metadata_exists( 'user', $user_id, 'show_welcome_panel' ) )
    update_user_meta( $user_id, 'show_welcome_panel', 2 );

  if ( is_multisite() ) {
    // Flush rules to pick up the new page.
    $wp_rewrite->init();
    $wp_rewrite->flush_rules();

    $user = new WP_User($user_id);
    $wpdb->update( $wpdb->options, array('option_value' => $user->user_email), array('option_name' => 'admin_email') );

    // Remove all perms except for the login user.
    $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE user_id != %d AND meta_key = %s", $user_id, $table_prefix.'user_level') );
    $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE user_id != %d AND meta_key = %s", $user_id, $table_prefix.'capabilities') );

    // Delete any caps that snuck into the previously active blog. (Hardcoded to blog 1 for now.) TODO: Get previous_blog_id.
    if ( !is_super_admin( $user_id ) && $user_id != 1 )
      $wpdb->delete( $wpdb->usermeta, array( 'user_id' => $user_id , 'meta_key' => $wpdb->base_prefix.'1_capabilities' ) );
  }

  // Flush rules to pick up the new page.
  $wp_rewrite->init();
  $wp_rewrite->flush_rules();

}
