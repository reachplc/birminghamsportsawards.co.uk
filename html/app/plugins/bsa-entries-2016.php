<?php
/**
 * Plugin Name: BSA Entries 2016
 * Plugin URI:
 * Description:
 * Author: Michael Bragg
 * Author URI:
 * Version: 0.1.0
*/

class BSA_Entries_2016 {

	/**
	 * Maintain the single instance of BSA_Entries_2016
	 *
	 * @var bool
	 */
	private static $instance = false;

	protected $user;

	public $meta_prefix = '_bsa_entries_2016_';

	/**
	 * Add required hooks
	 */
	function __construct() {

		add_action(
			'cmb2_init',
			array( $this, 'add_entry_form' )
		);

		add_action(
			'cmb2_after_init',
			array( $this, 'form_submission' )
		);

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new BSA_Entries_2016();
		}
		return self::$instance;
	}

	/**
	 * Register the form and fields for our front-end submission form
	 */
	public function add_entry_form() {

		$entry = new_cmb2_box( array(
			'id'								=> $this->meta_prefix,
			'title'							=> __( 'Entries', 'bsa-entries-2016' ),
			'object_types'			=> array( 'tm-events-entries', ),
			'context'						=> 'normal',
			'priority'					=> 'high',
			'show_names'				=> 'true',
		) );

		$entry->add_field( array(
			'id'								=> 'submitted_post_title',
			'name'							=> __( 'Nominee&rsquo;s Name', 'bsa-entries-2016' ),
			'type'							=> 'text',
			'default'						=> array( $this, 'set_title' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'eg, Jane Bloggs', 'bsa-entries-2016' ),
			'required'					=> 'required',
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominee_email',
			'name'							=> __( 'Nominee&rsquo;s Email', 'bsa-entries-2016' ),
			'type'							=> 'text_email',
			'default'						=> array( $this, 'set_default' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'eg, jane.bloggs@example.com', 'bsa-entries-2016' ),
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominee_phone',
			'name'							=> __( 'Nominee&rsquo;s Phone Number', 'bsa-entries-2016' ),
			'type'							=> 'text',
			'default'						=> array( $this, 'set_default' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'eg, 0121 123 4567', 'bsa-entries-2016' ),
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominee_award',
			'name'							=> __( 'Awards Category', 'bsa-entries-2016' ),
			'desc'							=> __( 'Choose the award(s) to enter.', 'bsa-entries-2016' ),
			'type'							=> 'multicheck',
			'select_all_button'	=> false,
			'attributes'				=> array(),
			'options_cb'				=> array( $this, 'get_awards' ),
		));

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominee_reason',
			'name'							=> __( 'I would like to nominate the nominee for this award because&hellip;', 'bsa-entries-2016' ),
			'description'				=> __( 'Maximum of 250 words.', 'bsa-entries-2016' ),
			'type'							=> 'textarea',
			'default'						=> array( $this, 'set_default' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'I would like to nominate the nominee for this award because&hellip;', 'bsa-entries-2016' ),
			'required'					=> 'required',
			'max'								=> 2000,
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominator_name',
			'name'							=> __( 'Your Name', 'bsa-entries-2016' ),
			'type'							=> 'text',
			'default'						=> array( $this, 'set_default' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'eg, Jane Bloggs', 'bsa-entries-2016' ),
			'required'					=> 'required',
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominator_email',
			'name'							=> __( 'Your Email', 'bsa-entries-2016' ),
			'type'							=> 'text_email',
			'default'						=> array( $this, 'set_default' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'eg, jane.bloggs@example.com', 'bsa-entries-2016' ),
			'required'					=> 'required',
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'nominator_phone',
			'name'							=> __( 'Your Phone Number', 'bsa-entries-2016' ),
			'type'							=> 'text',
			'default'						=> array( $this, 'set_default' ),
			'attributes'				=> array(
			'placeholder'				=> __( 'eg, 0121 123 4567', 'bsa-entries-2016' ),
			),
		) );

		$entry->add_field( array(
			'id'								=> $this->meta_prefix . 'hidden_check',
			'name'							=> __( 'Please do not check this box', 'bsa-entries-2016' ),
			'type'							=> 'checkbox',
			'select_all_button'	=> false,
			'row_classes'				=> 'hidden',
			'options'						=> array(
			true								=> 'check',
			),
			'attributes'				=> array(
			'hidden'					=> 'hidden',
			'class'						=> 'hidden',
			)
		) );

	}

	/**
	 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
	 *
	 * @return void
	 */
	public function form_submission() {

		// Check to see if this is a new post or has already been created
		if ( isset( $_POST['object_id'] ) && ( get_post_type( $_POST['object_id'] ) !== 'tm-events-entries' ) && ( $_POST['object_id'] < 0 ) ) {
			remove_query_arg( 'entry' );
			wp_redirect( home_url( $path = 'nominate/entry' ) );
		}

		// If no form submission, bail
		if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
			return false;
		}

		// Check if hidden form is present
		// If it is then this has been submitted by a bot
		if ( empty( $_POST ) || isset( $_POST['_bsa_entries_2016_hidden_check'] ) ) {
			return false;
		}

		// Get CMB2 metabox object
		$cmb = $this->get_current_form( $this->meta_prefix, 'fake-object-id' );
		$post_data = array();

		// Check security nonce
		if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
			return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
		}

		// Check hidden box is NOT ticked
		if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
			return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
		}

		// Check Post ID is valid
		/*if ( (! is_int( $_POST['object_id'] ) ) || ( ! $_POST['object_id'] >= 0 ) || floor( $_POST['object_id'] ) !== $_POST['object_id']  ) {
			return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Cannot submit your entry. Please try again' ) ) );
		}*/

		/**
		 * Fetch sanitized values
		 */
		$sanitized_values = $cmb->get_sanitized_values( $_POST );

		// Set our post data arguments

		// If we are updating a post supply the id from our hidden field.
		$post_data['ID'] = absint( $_POST['object_id'] );

		$post_data['post_title']   = $sanitized_values['submitted_post_title'];
		unset( $sanitized_values['submitted_post_title'] );
		$post_data['post_content'] = '';

		// Set the post type we want to submit.
		$post_data['post_type'] = 'tm-events-entries';
		// Set the status of of post
		$post_data['post_status'] = 'publish';

		// Create the new post
		$new_submission_id = wp_insert_post( $post_data, true );

		// If we hit a snag, update the user
		if ( is_wp_error( $new_submission_id ) ) {
			return $cmb->prop( 'submission_error', $new_submission_id );
		} else {

			// Loop through remaining (sanitized) data, and save to post-meta
			foreach ( $sanitized_values as $key => $value ) {
				if ( is_array( $value ) ) {
					$value = array_filter( $value );
					if ( ! empty( $value ) ) {
						update_post_meta( $new_submission_id, $key, $value );
					}
				} else {
					update_post_meta( $new_submission_id, $key, $value );
				}
			}

			// Remove any previous entry query arguments
			remove_query_arg( 'entry' );

			// Send confirmation email out
			$confirm_email = $this->send_confirmation( $post_data['post_title'], $sanitized_values );

			/**
			 * Redirect back to the form page with a query variable with the new post ID.
			 * This will help double-submissions with browser refreshes
			 */
			wp_redirect(
				esc_url_raw(
					add_query_arg(
						array(
							'entry' => $new_submission_id,
						),
						home_url( '/nominate/confirm/' )
					)
				)
			);
			exit;
		}

	}

	/**
	 * Gets the front-end-post-form cmb instance
	 *
	 * @return CMB2 object
	 */
	function get_current_form( $metabox_id, $object_id ) {
		// Get CMB2 metabox object
		return cmb2_get_metabox( $metabox_id, $object_id );
	}

	/**
	 *
	 */
	public function set_title( $field_args, $field ){
		$entry = get_query_var( 'entry' );
		$value = get_the_title( $entry );
		return $value;
	}

	/**
	 *	Get field values
	 */
	public function set_default( $field_args, $field ) {
			$entry = get_query_var( 'entry' );
			$value = get_post_meta( (int) $entry, $field_args['id'], true );
			return $value;
	}

	/**
	 *
	 */
	public function set_entry_id( $field_args, $field ) {
		if ( isset( $entry ) ) {
			$object_id = $entry;
		} else {
			$object_id = '0';
		}
		return $object_id;
	}

	/**
	 *
	 */
	public function get_awards(){
		$output = array();
		$args = array(
			'post_type' => 'tm-events-awards',
			'posts_per_page' => 50,
			'order' => 'ASC',
			'orderby' => 'menu_order title',
		);
		$awards_query = new WP_Query( $args );
		// Check query is not empty
		foreach ( $awards_query->posts as $key ) {
			$output[ $key->ID ] = $key->post_title;
		}

		return $output;
	}

	/**
	 * Send out confirmation email
	 */
	public function send_confirmation( $nominee, $data ) {

		$awards = array();

		foreach ( $data[ $this->meta_prefix . 'nominee_award' ] as $value ) {
			array_push( $awards, get_the_title( intval( $value ) ) );
		}

		$message    = '<strong>Birmingham Sports Awards 2016</strong><br><br>';
		$message   .= '<strong>Nominee:</strong><br>';
		$message   .= 'Name: ' . $nominee . '<br>';
		$message   .= 'Email: ' . $data[ $this->meta_prefix . 'nominee_email' ] . '<br>';
		$message   .= 'Phone: ' . $data[ $this->meta_prefix . 'nominee_phone' ] . '<br>';
		$message   .= '<br>';
		$message   .= 'Award: ' . implode( ', ', $awards ) . '.<br>';
		$message   .= 'Reason: <br>' . $data[ $this->meta_prefix . 'nominee_reason' ] . '<br>';
		$message   .= '<br>';
		$message   .= '<strong>Nominator:</strong><br>';
		$message   .= 'Name: ' . $data[ $this->meta_prefix . 'nominator_name' ] . '<br>';
		$message   .= 'Email: ' . $data[ $this->meta_prefix . 'nominator_email' ] . '<br>';
		$message   .= 'Phone: ' . $data[ $this->meta_prefix . 'nominator_phone' ] . '<br>';

		$headers = array(
			"From: Birmingham Sports Awards <no.reply@birminghamsportsawards.co.uk>\r\n",
			"Reply-To: Birmingham Sports Awards <no.reply@birminghamsportsawards.co.uk>\r\n",
			"Bcc: tmcreative@trinitymirror.com \r\n",
			"Bcc: vperry@championsukplc.com \r\n",
			"Content-Type: text/html; charset=UTF-8\r\n",
		);

		$subject = 'Birmingham Sports Awards 2016 - Nominations';

		wp_mail( $data['_bsa_entries_2016_nominator_email'], $subject, $message, $headers );
	}

}

/**
 * Get instance
 */

function bsa_entries_2016() {
	BSA_Entries_2016::get_instance();
}

add_action( 'plugins_loaded', 'bsa_entries_2016' );
