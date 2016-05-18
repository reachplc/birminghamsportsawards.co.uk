<?php
/**
 * Plugin Name: TI Core Functions
 * Plugin URI:
 * Description: Functions that perform some core functionality that we would love to live inside of WordPress one day.
 * Author: Michael Bragg
 * Author URI:
 * Version: 0.1.0
 */

class TI_Core_Functions {

	/**
	 * Maintain the single instance of TI_Core_Functions
	 *
	 * @var bool
	 */
	private static $instance = false;

	/**
	 * Add required hooks
	 */
	function __construct() {

		add_action(
			'admin_menu',
			array( $this, 'ti_add_home_to_menu' )
		);

		if ( 'development' === WP_ENV ) {

			add_action(
				'wp_head',
				array( $this, 'ti_development_admin_bar' )
			);

			add_action(
				'admin_head',
				array( $this, 'ti_development_admin_bar' )
			);
		}

		if ( 'staging' === WP_ENV ) {

			add_action(
				'wp_head',
				array( $this, 'ti_staging_admin_bar' )
			);

			add_action(
				'admin_head',
				array( $this, 'ti_staging_admin_bar' )
			);
		}

		if ( 'production' === WP_ENV ) {

			add_action(
				'wp_head',
				array( $this, 'ti_production_admin_bar' )
			);

			add_action(
				'admin_head',
				array( $this, 'ti_production_admin_bar' )
			);
		}

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new TI_Core_Functions();
		}
		return self::$instance;
	}

	/**
		* Add link to front page in admin menu
	* @since 0.1.0
	*/
	public function ti_add_home_to_menu() {

		$homepage_id = get_option( 'page_on_front' );

		add_menu_page(
			'Home Page',
			'Home Page',
			'edit_pages',
			'post.php?post=' . $homepage_id . '&action=edit',
			false,
			'dashicons-admin-home',
			4
		);

	}

	/**
	 * Change admin bar colour for development site
	 */
	public function ti_development_admin_bar() {
		printf(
			'<style>' .
			'#wpcontent #wpadminbar{ background: %1$s; }' .
			'#adminmenuwrap { background: repeating-linear-gradient(45deg, #23282d, #23282d 15px, %1$s 15px, %1$s 30px);}' .
			'</style>',
			'#f44336',
			'#d32f2f'
		);
	}

	/**
	 * Change admin bar colour for development site
	 */
	public function ti_staging_admin_bar() {
		printf(
			'<style>' .
			'#wpcontent #wpadminbar{ background: %1$s; }' .
			'#adminmenuwrap { background: repeating-linear-gradient(45deg, #23282d, #23282d 15px, %1$s 15px, %1$s 30px);}' .
			'</style>',
			'#ff9800',
			'#f57c00'
		);
	}

	/**
	 * Change admin bar colour for production site
	 */
	public function ti_production_admin_bar() {
		printf(
			'<style>' .
			'#wpcontent #wpadminbar{ background: %1$s; }' .
			'#adminmenuwrap { background: repeating-linear-gradient(45deg, #23282d, #23282d 15px, %1$s 15px, %1$s 30px);}' .
			'</style>',
			'#009688',
			'#00796B'
		);
	}

}

function ti_core_functions_init() {
	TI_Core_Functions::get_instance();
}

add_action( 'plugins_loaded', 'ti_core_functions_init' );
