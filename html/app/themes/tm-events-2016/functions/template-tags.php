<?php

if ( ! function_exists( 'tm_events_2016_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function tm_events_2016_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'bpba' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'bpba' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ba_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ba_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'bpba' ) );
			if ( $categories_list && tm_events_2016_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'bpba' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'bpba' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'bpba' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'bpba' ), esc_html__( '1 Comment', 'bpba-' ), esc_html__( '% Comments', 'bpba-2016' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'bpba' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function tm_events_2016_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'tm_events_2016_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'tm_events_2016_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so tm_events_2016_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so tm_events_2016_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in tm_events_2016_categorized_blog.
 */
function tm_events_2016_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'tm_events_2016_categories' );
}
add_action( 'edit_category', 'tm_events_2016_category_transient_flusher' );
add_action( 'save_post',     'tm_events_2016_category_transient_flusher' );

/**
 * Get users entries
 * @TODO Add offset option for pagination
 */
function get_entry( $user_id ) {

	$custom_query = new WP_Query(
		array(
			'author'						=> $user_id,
			'post_type'					=> 'ba-entries',
			'post_status'				=> array(
				'publish',
				'pending',
			),
			'posts_per_page'		=> 25,
		)
	);

	return $custom_query;

}

/**
 * Return entries status as string
 */
function the_post_status() {

	if ( 'publish' === get_post_status( get_the_ID() ) ) {
		esc_html_e( 'Submitted', 'bpba' );
	} else {
		esc_html_e( 'Pending', 'bpba' );
	}
}

/* Return entered categories as comma seperated string */
function get_entered_categories( ) {
	// Key Value array of categories and their titles
	// @TODO extract this out some how. Reducing the duplication throughout the site
	$output = array();

	$categories = array(
		'_bpba_entries_2016_companyyear'	=> __( 'Company of the Year', 'bpba' ),
		'_bpba_entries_2016_smallbusiness'	=> __( 'Small Business of the Year', 'bpba' ),
		'_bpba_entries_2016_newbusiness'	=> __( 'New Business of the Yeare', 'bpba' ),
		'_bpba_entries_2016_entrepreneur'	=> __( 'Business Entrepreneur of the Year', 'bpba' ),
		'_bpba_entries_2016_legal'	=> __( 'Legal Services', 'bpba' ),
		'_bpba_entries_2016_financial'	=> __( 'Financial Services', 'bpba' ),
		'_bpba_entries_2016_marketing'	=> __( 'Sales and Marketing', 'bpba' ),
		'_bpba_entries_2016_manufacturing'	=> __( 'Excellence in Manufacturing', 'bpba' ),
		'_bpba_entries_2016_technology'	=> __( 'Excellence in Science and Technology', 'bpba' ),
		'_bpba_entries_2016_retail'	=> __( 'Retail Business of the Year', 'bpba' ),
		'_bpba_entries_2016_creative'	=> __( 'Creative Communications &amp; Digital Business of the Year', 'bpba' ),
		'_bpba_entries_2016_export'	=> __( 'Export', 'bpba' ),
		'_bpba_entries_2016_community'	=> __( 'Contribution to the Community', 'bpba' ),
		'_bpba_entries_2016_notforprofit'	=> __( 'Not-for-profit Organisation', 'bpba' ),
	);

	$data = get_post_meta( get_the_ID(), 'bpba_entries_2016_categories', true );

	if ( is_array( $data ) || is_object( $data ) ) {
		foreach ( $data as $key ) {
			array_push( $output, $categories[ $key ] );
		}
	}
	return implode( ', ', $output );

}

/**
 * Build our edit link by apending the post id to the entries url
 */
function edit_entries_link() {
	$query = site_url( '/nominate/entry/' );
	$new_query = add_query_arg( array(
		'entry' => get_the_ID(),
	), $query );
	return $new_query;
}
