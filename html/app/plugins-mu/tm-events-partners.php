<?php
/**
 * Must-Use Functions
 *
 * A class filled with functions that will never go away upon theme deactivation.
 *
 * @package WordPress
 * @subpackage TM
 */

class TM_Events_Partners {

	public $meta_prefix = '_tm_events_partners_';

	public function __construct() {

		add_action(
			'after_setup_theme',
			array( $this, 'define_constants' ),
			1
		);

		add_action(
			'init',
			array( $this, 'add_taxonomy' )
		);

		add_action(
			'init',
			array( $this, 'add_post_type' )
		);

		add_filter(
			'admin_post_thumbnail_html',
			array( $this, 'explain_feature_image' )
		);

		// @Todo: Check that CM2 is installed
		add_action(
			'cmb2_init',
			array( $this, 'metabox_add_award' )
		);

		// @Todo: Check that CM2 is installed
		add_action(
			'cmb2_init',
			array( $this, 'metabox_add_profile' )
		);

		add_action(
			'pre_get_posts',
			array( $this, 'change_archive_loop' )
		);

		add_action(
			'admin_menu',
			array( $this, 'settings_page' )
		);

		// @Todo: Check that CM2 is installed
		add_action(
			'cmb2_admin_init',
			array( $this, 'settings_page_fields' )
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

	public function add_post_type() {

		$labels = array(
			'name'                  => _x( 'Partners', 'Post Type General Name', 'tm-events-partners' ),
			'singular_name'         => _x( 'Partner', 'Post Type Singular Name', 'tm-events-partners' ),
			'menu_name'             => __( 'Partners', 'tm-events-partners' ),
			'name_admin_bar'        => __( 'Partners', 'tm-events-partners' ),
			'archives'              => __( 'Partner Archives', 'tm-events-partners' ),
			'parent_item_colon'     => __( 'Parent Item:', 'tm-events-partners' ),
			'all_items'             => __( 'All Partners', 'tm-events-partners' ),
			'add_new_item'          => __( 'Add New Item', 'tm-events-partners' ),
			'add_new'               => __( 'Add New', 'tm-events-partners' ),
			'new_item'              => __( 'New Item', 'tm-events-partners' ),
			'edit_item'             => __( 'Edit Item', 'tm-events-partners' ),
			'update_item'           => __( 'Update Item', 'tm-events-partners' ),
			'view_item'             => __( 'View Item', 'tm-events-partners' ),
			'search_items'          => __( 'Search Item', 'tm-events-partners' ),
			'not_found'             => __( 'Not found', 'tm-events-partners' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'tm-events-partners' ),
			'featured_image'        => __( 'Partner Logo', 'tm-events-partners' ),
			'set_featured_image'    => __( 'Set partner logo', 'tm-events-partners' ),
			'remove_featured_image' => __( 'Remove partner logo', 'tm-events-partners' ),
			'use_featured_image'    => __( 'Use as partner logo', 'tm-events-partners' ),
			'insert_into_item'      => __( 'Insert into item', 'tm-events-partners' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'tm-events-partners' ),
			'items_list'            => __( 'Items list', 'tm-events-partners' ),
			'items_list_navigation' => __( 'Items list navigation', 'tm-events-partners' ),
			'filter_items_list'     => __( 'Filter items list', 'tm-events-partners' ),
		);
		$args = array(
			'label'                 => __( 'Awards', 'tm-events-partners' ),
			'description'           => __( 'Post Type Description', 'tm-events-partners' ),
			'labels'                => $labels,
			'supports'              => array(
				'title',
				//'editor',
				'thumbnail',
				'revisions',
				'page-attributes',
			),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'menu_icon'							=> 'dashicons-networking',
			'rewrite'								=> array(
				'slug' => 'partners',
				'with_front' => false,
				'pages' => false,
			),
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'tm-events-partners', $args );

	}

	public function add_taxonomy() {

		$labels = array(
			'name'              => _x( 'Partner Levels', 'tm-events-partners' ),
			'singular_name'     => _x( 'Partner Level', 'tm-events-partners' ),
			'search_items'      => __( 'Search Partner Levels' , 'tm-events-partners' ),
			'all_items'         => __( 'All Partner Levels' , 'tm-events-partners' ),
			'parent_item'       => __( 'Parent Partner Level' , 'tm-events-partners' ),
			'parent_item_colon' => __( 'Parent Partner Level:' , 'tm-events-partners' ),
			'edit_item'         => __( 'Edit Partner Level' , 'tm-events-partners' ),
			'update_item'       => __( 'Update Partner Level' , 'tm-events-partners' ),
			'add_new_item'      => __( 'Add New Partner Level' , 'tm-events-partners' ),
			'new_item_name'     => __( 'New Partner Level Name' , 'tm-events-partners' ),
			'menu_name'         => __( 'Partner Level' , 'tm-events-partners' ),
		);

		$rewrite = array(
			'slug'                       => 'partner-levels',
			'with_front'                 => false,
			'hierarchical'               => true,
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'query_var'                  => true,
			'rewrite'                    => $rewrite,
		);

		register_taxonomy(
			'partner-levels',
			array( 'tm-events-partners' ),
			$args
		);

	}

	public function explain_feature_image( $content ) {

		if ( 'tm-events-partners' === get_post_type() ) {
			$content .= '<p>The Logo will be associated with this partner throughout the website.</p>';
			$content .= '<p><em>Recommended size for this image is&nbsp;800px&nbsp;&#215;&nbsp;300px.</em></p>';
		}

		return $content;

	}

	public function metabox_add_profile() {

		$metabox_profile = new_cmb2_box( array(
			'id'								=> $this->meta_prefix . 'profile',
			'title'							=> __( 'Profile', 'tm-events-partners' ),
			'object_types'			=> array( 'tm-events-partners' ),
			'context'						=> 'normal',
			'priority'					=> 'high',
			'show_names'				=> 'true',
		) );

		$metabox_profile->add_field( array(
			'id'								=> $this->meta_prefix . 'profile_name',
			'name'							=> __( 'Profile Name', 'tm-events-partners' ),
			'desc'							=> __( '', 'tm-events-partners' ),
			'type'							=> 'text',
		));

		$metabox_profile->add_field( array(
			'id'								=> $this->meta_prefix . 'profile_title',
			'name'							=> __( 'Profile Job Title', 'tm-events-partners' ),
			'desc'							=> __( '', 'tm-events-partners' ),
			'type'							=> 'text',
		));

		$metabox_profile->add_field( array(
			'id'								=> $this->meta_prefix . 'profile_quote',
			'name'							=> __( 'Profile Quote', 'tm-events-partners' ),
			'desc'							=> __( '', 'tm-events-partners' ),
			'type'							=> 'textarea',
		));

		$metabox_profile->add_field( array(
			'id'								=> $this->meta_prefix . 'profile_image',
			'name'							=> __( 'Profile Image', 'tm-events-partners' ),
			'desc'							=> __( 'Select profile image. Reccommended size for this image is 480px × 720px.', 'tm-events-partners' ),
			'type'							=> 'file',
			'options'						=> array(
			'url'								=> false,
			),
			'text'							=> array(
			'add_upload_file_text' => 'Add File'
			),
		) );

		$metabox_profile->add_field( array(
			'id'								=> $this->meta_prefix . 'partner_link',
			'name'							=> __( 'Partner Link', 'tm-events-partners' ),
			'desc'							=> __( 'The URL to the partners website.', 'tm-events-partners' ),
			'type'							=> 'text_url',
			'protocols'					=> array( 'http', 'https' ),
		));

	}

	public function metabox_add_award() {

		$metabox_award = new_cmb2_box( array(
			'id'								=> $this->meta_prefix . 'award',
			'title'							=> __( 'Associated Award', 'tm-events-partners' ),
			'object_types'			=> array( 'tm-events-partners' ),
			'context'						=> 'side',
			'priority'					=> 'low',
			'show_names'				=> 'true',
		) );

		$metabox_award->add_field( array(
			'id'								=> $this->meta_prefix . 'associated_award' ,
			'title'							=> __( 'Addociated Award', 'tm-events-partners' ),
			'description'				=> __( 'Choose the award associated with this partner.', 'tm-events-partners' ),
			'type'							=> 'select',
			'show_option_none' => true,
			'default'          => 'none',
			'show_names' => false,
			'options_cb' => array( $this, 'get_awards' ),
		) );

	}

	public function settings_page() {
		add_submenu_page(
			'edit.php?post_type=tm-events-partners',
			__( 'Awards Options', 'tm-events-partners' ),
			__( 'Options', 'tm-events-partners' ),
			'edit_pages',
			'tm-events-partners-options',
			array( $this, 'settings_page_content' )
		);
	}

	public function settings_page_content() {

		printf( '<h1>%1$s</h1>', esc_html( get_admin_page_title() ) );

		cmb2_metabox_form(
			$this->meta_prefix . 'options',
			'tm-events-partners-options',
			array(
			'save_button' => __( 'Save Settings', 'tm-events-partners' )
			)
		);

	}

	public function settings_page_fields() {

		$options = new_cmb2_box( array(
			'id'								=> $this->meta_prefix . 'options',
			'title'							=> __( 'Page Text', 'tm-events-partners' ),
			'show_on'						=> array(
			'key'							=> 'options-page',
			'value' 					=> array( 'tm-events-partners-options' )
			),
			'hookup'						=> false,
			'context'						=> 'normal',
			'priority'					=> 'high',
			'show_names'				=> 'true',
		));

		$options->add_field( array(
			'id'								=> $this->meta_prefix . 'options-description',
			'name'							=> __( 'Awards Descripiton', 'myprefix' ),
			'desc'							=> __( 'The text to be displayed above the partners list on the archive page.', 'tm-events-awards' ),
			'type'							=> 'wysiwyg',
			'options'						=> array(
			'wpautop'						=> true,
			'media_buttons'			=> true,
			'teeny'							=> true,
			)
		) );

	}

	public function get_awards(){
		$output = array();
		$args = array(
			'post_type' => 'tm-events-awards',
			'posts_per_page' => 500,
			'order' => 'ASC',
			'orderby' => 'menu_order title'
		);
		$awards_query = new WP_Query( $args );
		// Check query is not empty
		foreach ($awards_query->posts as $key ) {
			$output[$key->ID] = $key->post_title;
		}

		return $output;
	}

	/**
	 * Alter the default WP Query
	 */
	public function change_archive_loop( $query ) {
		if ( $query->is_main_query() && ! is_admin() && is_post_type_archive( 'tm-events-partners' ) ) {
			$query->set( 'posts_per_page', '30' );
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'menu_order title' );
		}
	}

}

function tm_events_partners_init() {
	$TM_Events_Partners = new TM_Events_Partners();
}

add_action( 'plugins_loaded', 'tm_events_partners_init' );
