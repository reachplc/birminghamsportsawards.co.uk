(function( $ ) {

	/**
	 * Add Message
	 */

	 function addMessage( location, name, type, heading, message ) {

		// Set default values if not supplied
		type = ( 'undefined' !== typeof type ? type : 'warning' );
		heading = ( 'undefined' !== typeof heading ? heading : 'Oops' );
		message = ( 'undefined' !== typeof message ? message : 'Looks like something has gone wrong' );

		$( '#bpba-alert' )
			.clone()
			.prependTo( location )
			.attr( 'id', name )
			.addClass( 'alert--' + type )
			.html( '<p><strong>' + heading + '</strong> ' + message + '</p>' )
			.attr( 'data-state', 'visible' );

	 }

	/**
	 * Remove Message
	 */

	function removeMessage( id ) {

		// Check if message is in DOM
		if ( $( id ).length ) {
			$( id ).remove();
		}
		return false;
	}

	/**
	 * Limit selection of categories to 3
	 * @TODO Add option to control max number of categories
	 */

	function limitCategoriesSelection() {

		// Get the ammount of categories checked
		var categories = $( '.cmb2-id-bpba-entries-2016-categories .cmb2-checkbox-list input:checked' ).length;

		// Check if 3 catergoies are chosen
		if ( 3 <= categories ) {
			$( '.cmb2-id-bpba-entries-2016-categories  .cmb2-checkbox-list input:checkbox:not( :checked )' ).attr( 'disabled', true );
			addMessage( '.cmb2-id-bpba-entries-2016-categories', 'alert-category-limit', 'info', 'Info', 'Entry&rsquo;s are limited to 3 categories.' );
		}

		// Check if less than 3 catergoies are chosen
		if ( 3 > categories ) {
			$( '.cmb2-id-bpba-entries-2016-categories .cmb2-checkbox-list input:checkbox:not( :checked )' ).attr( 'disabled', false );
			removeMessage( '#alert-category-limit' );
		}

	}

	/**
	 * Toggle Category display on multi checkbox
	 */

	function toggleCategoryDisplay() {

		// Get all check boxes that are not checked
		var checkedValues = $( '.cmb2-id-bpba-entries-2016-categories .cmb2-option:not( :checked )' )
												 .map(function() {
														return this.value;
												 }).get();

		// Hide all categories not checked
		$.each( checkedValues, function( key, value ) {
			$( '#' + value ).attr( 'data-state', 'hidden' );
		});

		// Checkbox clicked function
		$( '.cmb2-id-bpba-entries-2016-categories .cmb2-checkbox-list input' ).click(function() {

			// Get value from input box
			var _catid = $( this ).val();

			// Show question id from value checked
			if ( $( this ).is( ':checked' ) ) {
				$( '#' + _catid ).attr( 'data-state', 'visible' );
			}

			// Hide question id from value unchecked
			if ( ! $( this ).is( ':checked' ) ) {
				$( '#' + _catid ).attr( 'data-state', 'hidden' );
			}
		});
	}

	$( document ).ready( toggleCategoryDisplay() );

	$( document ).ready( limitCategoriesSelection() );

	$( '.cmb2-id-bpba-entries-2016-categories .cmb2-checkbox-list input' )
		.on( 'click', limitCategoriesSelection );

} )( jQuery );
