<?php
/**
 * Plugin Name: TI WordPress SEO
 * Plugin URI:
 * Description: Update default functionality of WordPress SEO plugin
 * Author: Michael Bragg <michael@michaelbragg.net>
 * Version: 0.1.0
*/


class TI_WordPress_SEO {

	/**
	 * Maintain the single instance of TI_WordPress_SEO
	 *
	 * @var bool
	 */
	private static $instance = false;

	protected $user;

	/**
	 * Add required hooks
	 */
	function __construct() {

		// Get current users details
		add_action(
			'init',
			array( $this, 'ti_get_user' )
		);

		// Run actions once WordPress has initialized
		add_action(
			'init',
			array( $this, 'ti_init' )
		);

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @since 0.1.0
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new TI_WordPress_SEO();
		}
		return self::$instance;
	}

	/**
	 * Get current users details
	 * @since 0.1.0
	 */

	public function ti_get_user() {
		// Get an instance of the current user
		$user_id = wp_get_current_user()->ID;
		$current_user = new WP_User( $user_id );
		// Set protected variable
		$this->user = $current_user;
	}

	/**
	 * Check users capabilities
	 * @since 0.1.0
	 */
	public function ti_has_user_capability( $capability ) {
		if ( $this->user->has_cap( $capability ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Hooks to run on WordPress initialization
	 * @since 0.1.0
	 */
	public function ti_init() {

		// For all users
		add_action(
			'wp_before_admin_bar_render',
			array( $this, 'ti_admin_bar_seo_cleanup' )
		);

		add_action(
			'wp_dashboard_setup',
			array( $this, 'ti_remove_dashboard_widgets' )
		);

		/* If user is Author or below */
		if ( ! $this->ti_has_user_capability( 'publish_pages' ) ) {

			add_filter(
				'wpseo_metabox_prio',
				array( $this, 'ti_set_metabox_context' )
			);

			add_action(
				'add_meta_boxes',
				array( $this, 'ti_remove_yoast_metabox' ),
				99
			);

			add_filter(
				'manage_edit-post_columns',
				array( $this, 'ti_remove_yoast_columns' )
			);

			add_filter(
				'manage_edit-page_columns',
				array( $this, 'ti_remove_yoast_columns' )
			);

		}

	}

	/**
	 * Removes the SEO item from the admin bar
	 *
	 * @since 0.1.0
	 * @uses remove_menu
	 */
	public function ti_admin_bar_seo_cleanup() {

		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wpseo-menu' );

	}

	/**
	 * Remove SEO dashboard widgets
	 *
	 *  @since 0.1.0
	 *  @uses  remove_meta_box
	 */
	public function ti_remove_dashboard_widgets() {

		global $wp_meta_boxes;
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );

	}

	/**
	 * Removes the WordPress SEO meta box from `$post_types`
	 *
	 * @since 0.1.0
	 * @uses remove_meta_box()
	 */
	public function ti_remove_yoast_metabox() {

		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			remove_meta_box( 'wpseo_meta', $post_type, 'normal' );
		}

	}

	/**
	 * Removes the extra columns on the post/page listing screens.
	 *
	 * @since 0.1.0
	 */
	public function ti_remove_yoast_columns( $columns ) {

		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );

		return $columns;

	}

	/**
	 * Reset the Yoast SEO metabox context
	 *
	 * @since 0.1.0
	 */
	public function ti_set_metabox_context() {
		// Accepts 'high', 'default', 'low'. Default is 'high'.
		return 'low';
	}

}

function ti_wordpress_seo_init() {
	if ( class_exists( 'WPSEO_Admin' ) ) {
		TI_WordPress_SEO::get_instance();
	}
}

add_action( 'plugins_loaded', 'ti_wordpress_seo_init' );
