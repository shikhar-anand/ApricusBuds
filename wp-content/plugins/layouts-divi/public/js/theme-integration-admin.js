var DDLayout = DDLayout || {};

DDLayout.LayoutsDivi = DDLayout.LayoutsDivi || {};

DDLayout.LayoutsDivi.LayoutsDiviAdminOverrides = function($){
        var self = this;

        self.init = function(){
            self.fix_addon_dropdown();
            self.fields_view_dialog_zindex_fix();
        };

        self.fix_addon_dropdown = function(){
            $( 'div.editor_addon_dropdown_content' ).each( function() {

                var diviContainer = $( this ).find( "h4:contains('Divi')" ).parent().detach(),
                    directLinks      = $( this ).find( '.direct-links' ),
                    directLinkDivi= directLinks.find( ".editor-addon-top-link:contains('Divi')" ).detach();

                directLinks.find( '.direct-links-label' ).after( directLinkDivi );
                $( this ).find( '.direct-links-desc' ).after( diviContainer );
            } );
        };

        self.fields_view_dialog_zindex_fix = function(){
            if( typeof adminpage === 'undefined' || adminpage != 'post-php' ) return;

            $( document ).on( 'js_event_wpv_fields_and_views_dialog_opened', function(event, data){
                if( data && data.hasOwnProperty('dialog') ){
                    $(data.dialog).parent().css('z-index', '1000000000000000');
                }
            } );

        };

    self.init();
};


;( function( $ ) {

    $(function(){
        DDLayout.LayoutsDivi.admin = new DDLayout.LayoutsDivi.LayoutsDiviAdminOverrides($);
    });

} ( jQuery ) );