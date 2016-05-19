<?php
/**
 * Plugin Name: TM Hero
 * Plugin URI:
 * Description: Adds a Hero banner meta box
 * Author: Michael Bragg
 * Author URI:
 * Version: 0.1.0
*/

class TM_Hero {

	/**
	 * Maintain the single instance of TM_Hero
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
			array( $this, 'tm_hero_get_user' )
		);

		// Run actions once WordPress has initialized
		add_action(
			'init',
			array( $this, 'tm_hero_init' )
		);

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new TM_Hero();
		}
		return self::$instance;
	}

	/**
	 * Get current users details
	 * @since 0.1.0
	 */

	public function tm_hero_get_user() {
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
	public function tm_hero_has_user_capability( $capability ) {
		if ( $this->user->has_cap( $capability ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Hooks to run on WordPress initialization
	 * @since 0.1.0
	 */
	public function tm_hero_init() {

		// @Todo: Check that CM2 is installed
		add_action(
			'cmb2_init',
			array( $this, 'tm_hero_add_fields' )
		);

	}

	/**
	 * Only show WordPress update message to administrator roles
	 * @since 0.1.0
	 */
	public function tm_hero_add_fields() {

		$prefix = '_tm_hero_';

		$tm_hero = new_cmb2_box( array(
			'id'								=> $prefix . 'common',
			'title'							=> __( 'Hero Banner', 'tm-hero' ),
			'description'				=> __( 'This controls the large, hero, banner at the top of each page. If a field is not entered the site wide default will be used.', 'tm-hero' ),
			'object_types'			=> array( 'page', ),
			'context'						=> 'normal',
			'priority'					=> 'high',
			'show_names'				=> 'true',
		) );

		$tm_hero->add_field( array(
			'description'				=> __( 'This controls the large, hero, banner at the top of each page. If a field is not entered the site wide default will be used.', 'tm-hero' ),
			'id'								=> $prefix . 'description',
			'type'							=> 'title',
		) );

		$tm_hero->add_field( array(
			'name'							=> __( 'Hide Banner', 'tm-hero' ),
			'description'				=> __( 'To hide the hero banner on this page. Check the tick box (this will override any global settings).', 'tm-hero' ),
			'id'								=> $prefix . 'hide',
			'type'							=> 'checkbox',
		) );

		$tm_hero->add_field( array(
			'id'								=> $prefix . 'image',
			'name'							=> __( 'Background', 'tm-hero' ),
			'desc'							=> 'Select or upload aa background',
			'type'							=> 'file',
			'options'						=> array(
			'url'		=> false,
			),
			'text'							=> array(
			'add_upload_file_text' => 'Add Background',
			),
		) );

		$tm_hero->add_field( array(
			'id'								=> $prefix . 'tagline',
			'name'							=> __( 'Tagline', 'tm-hero' ),
			'type'							=> 'textarea_small',
		) );

		$tm_hero->add_field( array(
			'id'								=> $prefix . 'btn_text',
			'name'							=> __( 'Button Text', 'tm-hero' ),
			'type'							=> 'text_medium',
		) );

		$tm_hero->add_field( array(
			'id'								=> $prefix . 'btn_link',
			'name'							=> __( 'Button Link', 'tm-hero' ),
			'type'							=> 'text_url',
			'protocols'					=> array( 'http', 'https', 'mailto' ),
		) );

	}

}

function tm_hero_init() {
	TM_Hero::get_instance();
}

add_action( 'plugins_loaded', 'tm_hero_init' );

function tm_hero_has_hero() {
	$options_global = get_blog_option( get_current_blog_id(), '_tm-events-options', false );
	// Check for local hero hide
	if ( get_post_meta( get_the_ID(), '_tm_hero_hide', true ) ) {
		return false;
	}
	// Check for global hero hide
	if ( ! empty( $options_global['_tm_events_options_hero_hide'] ) ) {
		return false;
	}
	// Check for local hero image
	if ( get_post_meta( get_the_ID(), '_tm_hero_image', true ) ) {
		return true;
	}
	// Check for global hero image
	if ( $options_global['_tm_events_options_hero_image'] ) {
		return true;
	}
	return false;
}

function tm_hero_has_field( $field ) {
	$options_global = get_blog_option( get_current_blog_id(), '_tm-events-options', false );
	// Local
	if ( $data = get_post_meta( get_the_ID(), '_tm_hero_' . sanitize_text_field( $field ), true ) ) {
		return $data;
	}
	// Global
	if ( $data = $options_global[ '_tm_events_options_hero_' . $field ] ) {
		return $data;
	}
	return false;
}

function tm_hero_the_image() {
	if ( $attachment_id = tm_hero_has_field( 'image_id' ) ) {
		 echo esc_html( 'background-image: url(' . wp_get_attachment_url( $attachment_id ) . '); ' );
	}
	return false;
}

function tm_hero_the_tagline( $before = '', $after = '', $echo = true ) {

	if ( $tagline = tm_hero_has_field( 'tagline' ) ) {

		$tagline = $before . esc_html( $tagline ) . $after;

		if ( $echo ) {
			echo $tagline; // WPCS: XSS ok. Content escaped previously
		} else {
			return $tagline;
		}
	}

	return false;
}

function tm_hero_the_btn_link() {
	if ( $btn_link = tm_hero_has_field( 'btn_link' ) ) {
		echo esc_url( $btn_link );
	}
	return false;
}

function tm_hero_the_btn_text() {
	if ( $btn_text = tm_hero_has_field( 'btn_text' ) ) {
		echo esc_html( $btn_text );
	}
	return false;
}
