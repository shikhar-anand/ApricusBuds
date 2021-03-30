( function( api ) {

	// Extends our custom "tafri-travel" section.
	api.sectionConstructor['tafri-travel'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );