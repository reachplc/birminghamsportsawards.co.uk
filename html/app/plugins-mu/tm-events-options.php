<?php
/**
 * Must-Use Functions
 *
 * Site wide settings.
 *
 * @package WordPress
 * @subpackage TM
 */

class TM_Events_Options {

	public $meta_prefix = '_tm_events_options_';

	public function __construct() {

		add_action(
			'after_setup_theme',
			array( $this, 'define_constants' ),
			1
		);

		add_action(
			'admin_menu',
			array( $this, 'options_page' )
		);

		// @Todo: Check that CM2 is installed
		add_action(
			'cmb2_admin_init',
			array( $this, 'options_page_fields' )
		);

	}

	public function define_constants() {
		// Path to the child theme directory
		/*$this->override_constant(
			'GRD_DIR',
			get_stylesheet_directory_uri()
		);*/

	}

	public function override_constant( $constant, $value ) {

		if ( ! defined( $constant ) ) {
			define( $constant, $value ); // Constants can be overidden via wp-config.php
		}

	}


	public function options_page() {

		add_menu_page(
			__( 'Site Options', 'tm-events-options' ),
			__( 'Site Options', 'tm-events-options' ),
			'edit_pages',
			'tm-events-options',
			array( $this, 'options_page_layout' ),
			'dashicons-admin-settings',
			3
		);

	}

	public function options_page_layout() {

		printf( '<h1>%1$s</h1>', esc_html( get_admin_page_title() ) );

		cmb2_metabox_form(
			$this->meta_prefix,
			'_tm-events-options',
			array(
			'save_button' => __( 'Save Settings', 'tm-events-partners' )
			)
		);

	}

	public function options_page_fields() {

		$options = new_cmb2_box( array(
			'id'								=>	$this->meta_prefix,
			'show_on'						=>	array(
			'key'								=>	'options-page',
			'value' 						=>	array( 'tm-events-partners-options' )
			),
			'hookup'						=>	false,
			'context'						=>	'normal',
			'priority'					=>	'high',
			'show_names'				=>	'true',
		));

		$options->add_field( array(
			'id'								=>	$this->meta_prefix . 'venue',
			'name'							=>	__( 'Venue', 'tm-events-options' ),
			'desc'							=>	__( 'Add the details of the event venue.', 'tm-events-options' ),
			'type'							=>	'title',
		) );

		$options->add_field( array(
			'id'								=>	$this->meta_prefix . 'venue_datetime',
			'name'							=>	__( 'Date and time of the event', 'tm-events-options' ),
			'desc'							=>	__( 'What day is the event on and what time does it start?', 'tm-events-options' ),
			'type'							=>	'text_datetime_timestamp',
		) );

		$options->add_field( array(
			'id'								=>	$this->meta_prefix . 'venue_location',
			'name'							=>	__( 'Address', 'tm-events-options' ),
			'desc'							=>	__( 'Where is the venue located?', 'tm-events-options' ),
			'type'							=>	'textarea_small',
		) );

		$options->add_field( array(
			'id'								=>	$this->meta_prefix . 'venue_image',
			'name'							=>	__( 'Venue Image', 'tm-events-options' ),
			'desc'							=>	__( 'Add an image of the event venue.', 'tm-events-options' ),
			'type'							=>	'file',
			'options'						=>	array(
				'url' => false,
			),
			'text'							=>	array(
				'add_upload_file_text' =>	'Add Image',
			),
		) );

		$options->add_field( array(
			'id'								=>	$this->meta_prefix . 'venue_info',
			'name'							=>	__( 'Information', 'tm-events-options' ),
			'desc'							=>	__( 'Any extra information about the venue.', 'tm-events-options' ),
			'type'							=>	'textarea_small',
		) );

		/*$options->add_field( array(
			'id'								=>	$this->meta_prefix . 'hero',
			'name'							=>	__( 'Hero Banner', 'tm-events-options' ),
			'desc'							=>	__( 'Global settings for the hero banner.', 'tm-events-options' ),
			'type'							=>	'title',
		) );*/

	}

}

function tm_events_has_venue() {

	$options = get_blog_option( get_current_blog_id(), '_tm-events-options', false );

	if ( ! empty( $options['_tm_events_options_venue_datetime'] ) && ! empty( $options['_tm_events_options_venue_location'] ) ) {
		return true;
	}
	return false;
}

function tm_events_has_venue_field( $field ) {
	$options = get_blog_option( get_current_blog_id(), '_tm-events-options', false );

	if ( ! empty( $options[ '_tm_events_options_venue_' . $field ] ) ) {
		return $options[ '_tm_events_options_venue_' . $field ];
	}
	return false;
}

function tm_events_the_venue_image() {
	if ( $attachment_id = tm_events_has_venue_field( 'image_id' ) ) {
		echo wp_get_attachment_image( $attachment_id, 'full', false, array( 'class' => 'image image__responsive' ) );
	}
	return false;
}

function tm_events_the_venue_date( $format = 'l, d F Y' ) {
	if ( $datetime = tm_events_has_venue_field( 'datetime' ) ) {
		$date = new DateTime();
		$date->setTimestamp($datetime);
		echo '<h4 itemprop="startDate" content="' . $date->format('Y-m-d') .'T'. $date->format('H:i') . '">' . $date->format($format) . '</h4>';
	}
	return false;
}

function tm_events_the_venue_location() {
	if ( $address = tm_events_has_venue_field( 'location' ) ) {

		$output  = '<p itemprop="location" itemscope itemtype="http://schema.org/Place">';
		$output .=  esc_html( $address );
		$output .= '</p>';


		echo wpautop( $output );
	}
	return false;
}


function tm_events_the_venue_info() {
	if ( $info = tm_events_has_venue_field( 'info' ) ) {
		$output =  esc_html( $info );
		echo wpautop( $output );
	}
	return false;
}

function tm_events_options_init() {
	$TM_Events_Options = new TM_Events_Options();
}

add_action( 'plugins_loaded', 'tm_events_options_init' );
