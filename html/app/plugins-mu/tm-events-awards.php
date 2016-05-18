<?php
/**
 * Must-Use Functions
 *
 * A class filled with functions that will never go away upon theme deactivation.
 *
 * @package WordPress
 * @subpackage TM
 */

class TM_Events_Awards {

	public $meta_prefix = '_tm_events_awards_';

	public function __construct() {

		add_action(
			'after_setup_theme',
			array( $this, 'define_constants' ),
			1
		);

		add_action(
			'init',
			array( $this, 'taxonomy_award_level' )
		);

		add_action(
			'init',
			array( $this, 'add_post_type' )
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

		add_action(
			'pre_get_posts',
			array( $this, 'change_archive_awards_loop' )
		);

	}

	public function define_constants() {
		// Path to the child theme directory
		/*$this->ba_override_constant(
			'GRD_DIR',
			get_stylesheet_directory_uri()
		);*/

	}

	public function ba_override_constant( $constant, $value ) {

		if ( ! defined( $constant ) ) {
			define( $constant, $value ); // Constants can be overidden via wp-config.php
		}

	}

	public function enqueue_scripts() {

	}

	public function add_post_type() {

		$labels = array(
			'name'                  => _x( 'Awards', 'Post Type General Name', 'tm-events-awards' ),
			'singular_name'         => _x( 'Award', 'Post Type Singular Name', 'tm-events-awards' ),
			'menu_name'             => __( 'Awards', 'tm-events-awards' ),
			'name_admin_bar'        => __( 'Awards', 'tm-events-awards' ),
			'archives'              => __( 'Award Archives', 'tm-events-awards' ),
			'parent_item_colon'     => __( 'Parent Item:', 'tm-events-awards' ),
			'all_items'             => __( 'All Awards', 'tm-events-awards' ),
			'add_new_item'          => __( 'Add New Item', 'tm-events-awards' ),
			'add_new'               => __( 'Add New', 'tm-events-awards' ),
			'new_item'              => __( 'New Item', 'tm-events-awards' ),
			'edit_item'             => __( 'Edit Item', 'tm-events-awards' ),
			'update_item'           => __( 'Update Item', 'tm-events-awards' ),
			'view_item'             => __( 'View Item', 'tm-events-awards' ),
			'search_items'          => __( 'Search Item', 'tm-events-awards' ),
			'not_found'             => __( 'Not found', 'tm-events-awards' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'tm-events-awards' ),
			'featured_image'        => __( 'Award Icon', 'tm-events-awards' ),
			'set_featured_image'    => __( 'Set award icon', 'tm-events-awards' ),
			'remove_featured_image' => __( 'Remove award icon', 'tm-events-awards' ),
			'use_featured_image'    => __( 'Use as award icon', 'tm-events-awards' ),
			'insert_into_item'      => __( 'Insert into item', 'tm-events-awards' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'tm-events-awards' ),
			'items_list'            => __( 'Items list', 'tm-events-awards' ),
			'items_list_navigation' => __( 'Items list navigation', 'tm-events-awards' ),
			'filter_items_list'     => __( 'Filter items list', 'tm-events-awards' ),
		);
		$args = array(
			'label'                 => __( 'Awards', 'tm-events-awards' ),
			'description'           => __( 'Post Type Description', 'tm-events-awards' ),
			'labels'                => $labels,
			'supports'              => array(
				'title',
				'editor',
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
			'menu_icon'							=> 'dashicons-awards',
			'rewrite'								=> array(
				'slug' => 'awards',
				'with_front' => false,
				'pages' => false,
			),
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'tm-events-awards', $args );

	}

	public function taxonomy_award_level() {

		$labels = array(
			'name'              => _x( 'Award Levels', 'tm-events-partners' ),
			'singular_name'     => _x( 'Award Level', 'tm-events-partners' ),
			'search_items'      => __( 'Search Award Levels' , 'tm-events-partners' ),
			'all_items'         => __( 'All Award Levels' , 'tm-events-partners' ),
			'parent_item'       => __( 'Parent Award Level' , 'tm-events-partners' ),
			'parent_item_colon' => __( 'Parent Award Level:' , 'tm-events-partners' ),
			'edit_item'         => __( 'Edit Award Level' , 'tm-events-partners' ),
			'update_item'       => __( 'Update Award Level' , 'tm-events-partners' ),
			'add_new_item'      => __( 'Add New Award Level' , 'tm-events-partners' ),
			'new_item_name'     => __( 'New Award Level Name' , 'tm-events-partners' ),
			'menu_name'         => __( 'Award Level' , 'tm-events-partners' ),
		);

		$rewrite = array(
			'slug'                       => 'awards/levels',
			'with_front'                 => false,
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
			'awards-levels',
			array( 'tm-events-awards' ),
			$args
		);

	}

	public function settings_page() {
		add_submenu_page(
			'edit.php?post_type=tm-events-awards',
			__( 'Awards Options', 'tm-events-awards' ),
			__( 'Options', 'tm-events-awards' ),
			'edit_pages',
			'tm-events-awards-options',
			array( $this, 'settings_page_content' )
		);
	}

	public function settings_page_content() {

		printf( '<h1>%1$s</h1>', esc_html( get_admin_page_title() ) );

		cmb2_metabox_form(
			$this->meta_prefix . 'options',
			'tm-events-awards-options',
			array(
			'save_button' => __( 'Save Settings', 'tm-events-awards' )
			)
		);

	}

	public function settings_page_fields() {

		$options = new_cmb2_box( array(
			'id'								=> $this->meta_prefix . 'options',
			'title'							=> __( 'Page Text', 'tm-events-awards' ),
			'show_on'						=> array(
			'key'							=> 'options-page',
			'value' 					=> array( 'tm-events-awards-options' )
			),
			'hookup'						=> false,
			'context'						=> 'normal',
			'priority'					=> 'high',
			'show_names'				=> 'true',
		));

		$options->add_field( array(
			'id'								=> $this->meta_prefix . 'options-description',
			'name'							=> __( 'Awards Descripiton', 'myprefix' ),
			'desc'							=> __( 'The text to be displayed above the awards list on the archive page.', 'tm-events-awards' ),
			'type'							=> 'wysiwyg',
			'options'						=> array(
			'wpautop'					=> true,
			'media_buttons'		=> true,
			'teeny'						=> true,
			)
		) );

	}

	public function explain_feature_image( $content ) {

		if ( 'tm-events-awards' === get_post_type() ) {

			$content .= '<p>The Award Icon will be associated with this award throughout the website.</p>';
			$content .= '<p><em>Recommended site for this image is&nbsp;200px&nbsp;&#215;&nbsp;200px.</em></p>';

		}

		return $content;

	}

	/**
	 * Alter the default WP Query
	 */
	function change_archive_awards_loop( $query ) {
		if ( $query->is_main_query() && ! is_admin() && is_post_type_archive( 'tm-events-awards' ) ) {
			$query->set( 'posts_per_page', '30' );
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'menu_order' );
		}
	}

	public function print_header_scripts() {

	}

	public function print_footer_scripts() {

	}

}


function tm_events_awards_init() {
	$TM_Events_Awards = new TM_Events_Awards();
}

add_action( 'plugins_loaded', 'tm_events_awards_init' );
