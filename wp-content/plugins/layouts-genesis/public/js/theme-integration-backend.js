;( function( $ ) {

    $( 'div.editor_addon_dropdown_content' ).each( function() {
        var genesisContainer = $( this ).find( "h4:contains('Genesis')" ).parent().detach(),
            directLinks      = $( this ).find( '.direct-links' ),
            directLinkGenesis= directLinks.find( ".editor-addon-top-link:contains('Genesis')" ).detach();


        directLinks.find( '.direct-links-label' ).after( directLinkGenesis );
        $( this ).find( '.direct-links-desc' ).after( genesisContainer );
    } );

} )( jQuery );