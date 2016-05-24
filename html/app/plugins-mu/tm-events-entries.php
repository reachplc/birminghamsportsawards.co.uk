<?php
/**
 * Entires CPT
 *
 * @package WordPress
 * @subpackage TM
 */

class TM_Events_Entries {

	public function __construct() {

		add_action(
			'after_setup_theme',
			array(
				$this,
				'define_constants',
			),
			1
		);

		add_action(
			'init',
			array( $this, 'add_post_type' )
		);

		add_action(
			'map_meta_cap',
			array( $this, 'entries_add_role_caps' ),
			10,
			4
		);

		add_filter(
			'query_vars',
			array( $this, 'add_query_vars_filter' )
		);

	}

	public function define_constants() {
		// Path to the child theme directory
		/*$this->bpba_override_constant(
			'GRD_DIR',
			get_stylesheet_directory_uri()
		);*/

	}

	public function bpba_override_constant( $constant, $value ) {

		if ( ! defined( $constant ) ) {
			define( $constant, $value ); // Constants can be overidden via wp-config.php
		}

	}

	public function enqueue_scripts() {

	}

	public function add_post_type() {

		$labels = array(
			'name'                  => _x( 'Entries', 'Post Type General Name', 'tm-events-entries' ),
			'singular_name'         => _x( 'Entry', 'Post Type Singular Name', 'tm-events-entries' ),
			'menu_name'             => __( 'Entries', 'tm-events-entries' ),
			'name_admin_bar'        => __( 'Entries', 'tm-events-entries' ),
			'archives'              => __( 'Entry Archives', 'tm-events-entries' ),
			'parent_item_colon'     => __( 'Parent Item:', 'tm-events-entries' ),
			'all_items'             => __( 'All Entries', 'tm-events-entries' ),
			'add_new_item'          => __( 'Add New Item', 'tm-events-entries' ),
			'add_new'               => __( 'Add New', 'tm-events-entries' ),
			'new_item'              => __( 'New Item', 'tm-events-entries' ),
			'edit_item'             => __( 'Edit Item', 'tm-events-entries' ),
			'update_item'           => __( 'Update Item', 'tm-events-entries' ),
			'view_item'             => __( 'View Item', 'tm-events-entries' ),
			'search_items'          => __( 'Search Item', 'tm-events-entries' ),
			'not_found'             => __( 'Not found', 'tm-events-entries' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'tm-events-entries' ),
			'insert_into_item'      => __( 'Insert into item', 'tm-events-entries' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'tm-events-entries' ),
			'items_list'            => __( 'Items list', 'tm-events-entries' ),
			'items_list_navigation' => __( 'Items list navigation', 'tm-events-entries' ),
			'filter_items_list'     => __( 'Filter items list', 'tm-events-entries' ),
		);

		$args = array(
			'label'                 => __( 'Entries', 'tm-events-entries' ),
			'description'           => __( 'Post Type Description', 'tm-events-entries' ),
			'public'                => false,
			'publicly_queryable'    => false,
			'exclude_from_search'   => true,
			'show_in_nav_menus'     => false,
			'show_ui'               => true,
			'show_in_admin_bar'     => false,
			'menu_position'         => 5,
			'can_export'            => true,
			'delete_with_user'			=> false,
			'hierarchical'          => false,
			'has_archive'           => false,
			'menu_icon'							=> 'dashicons-tickets-alt',
			'query_var'           	=> true,
			'capability_type'       => 'page',
			'map_meta_cap'        	=> true,
			'rewrite'								=> array(
				'slug'			 => 'entries',
				'with_front' => false,
				'pages' 	 	 => false,
			),
			'supports'            	   => array(
				'title',
				'revisions',
				'author',
			),
			'labels'              	   => $labels,
		);

		register_post_type( 'tm-events-entries', $args );

	}

	public function print_header_scripts() {

	}

	public function print_footer_scripts() {

	}

	public function entries_add_role_caps( $caps, $cap, $user_id, $args ){
		$subRole = get_role( 'subscriber' );
		return $caps;
	}

	public function add_query_vars_filter( $vars ){
		$vars[] = 'entry';
		return $vars;
	}

}


function tm_events_entries_init() {
	$TM_Events_Entries = new TM_Events_Entries();
}

add_action( 'plugins_loaded', 'tm_events_entries_init' );
