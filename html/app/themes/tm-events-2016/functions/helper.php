<?php

/**
 * Checks if paramater(s) are in the post type
 *
 * @param    int/string/array   $post_types   Post type name(s) or id
 * @return   boolean                          if in post type
 * @version  0.1.0
 * @since    0.1.0
 */
if ( ! function_exists( 'is_post_type' ) ) :

	function is_post_type( $post_types = null ) {
		// If our variable is not set stop as soon as possible
		if ( ! isset( $post_types ) ) {
			return false;
		}

		$array = array();
		if ( get_post_type() === $post_types ) {
			array_push( $array, $post_types );
			return true;
		}
		if ( is_array( $post_types ) ) {
			foreach ( $post_types as $value ) {

				if ( get_post_type() === $value ) {
					array_push( $array, $value );
					return true;
				}
			}
		}
		return false;
	}

endif;
