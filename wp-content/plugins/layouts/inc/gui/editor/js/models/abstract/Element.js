DDLayout.models.abstract.Element = Backbone.Model.extend({
    defaults:{
        name: ''
        , cssClass: 'span1'
        , cssId: ''
        , tag: 'div'
        , kind: 'Element'
        , width: 1
        , row_divider: 1
        , additionalCssClasses: ''
        , editorVisualTemplateID: ''
        , id:0
    }
    /**
     * makes available for all child classes the Backbone
     * event object to trigger and listen to custom events
     */
    , initialize: function(){
        this.set_unique_id();
        this.setWidthToInt();
    },
    /**
     * cast all widths to integer
     * @return:integer
     */
    setWidthToInt:function()
    {
        var self = this, int = 1;
        int = parseInt( self.get('width') );
        self.set('width', int );
        return self.get('width');
    },
    set_unique_id:function()
    {

        // the layout has id from DB leave it alone
        if( this instanceof DDLayout.models.cells.Layout )
        {
            return this.get('id');
        }

        // if id already set don't do nothing
        if( this.get('id') && this.get('id') !== 0 )
        {
            return this.get('id');
        }

        // if id is not already set please do it
        else if( !this.get('id') || this.get('id') == 0 )
        {
            if( this.get('cell_type') != 'spacer' ){

                if (this instanceof DDLayout.models.cells.Cell) {
                    DDLayout.unique_id_created = true;
                }

                // create the id, unique id generated by underscore
                this.set('id', _.uniqueId( ) );
                return this.get('id');

            } else {

                this.set('id', _.uniqueId( 's' ) );
                return this.get('id');

            }
        }

        return 0;
    },
    getIntWidth:function()
    {
        return parseInt( this.get('width') );
    },
    hasRows:function()
    {
        return this.has("Rows");
    }
    , hasContent:function()
    {
        return this.has("Content");
    },
    hasSomeContent:function()
    {
        return this.hasRows() || this.hasContent();
    }
    , isSpacer:function()
    {
        return this instanceof DDLayout.models.cells.Spacer;
    },
    isEmpty:function()
    {
        return true;
    },
    set:function(attributes, options)
    {
        if( _.isObject(attributes) ){
            this.trigger('layout_element_model_change', this, attributes, options );
            return Backbone.Model.prototype.set.call(this, attributes, options);
        }

        if( attributes == 'width')
        {
            if(options) options = parseInt( options );
        }
        else if( attributes == 'name' ){
            if(options){
                // Since Views 2.7.0 the sanitization of the View, the Content Template or the Wordpress Archive is handled
                // by Wordpress itself as it's done for native posts. So, for the cases of the Views cells (View,
                // Content Template or Wordpress Archive) the cell name is returned un-escaped.
                var viewsCells = [ 'views-content-grid-cell', 'post-loop-views-cell', 'cell-content-template' ];
                if ( ! _.includes( viewsCells, this.attributes.cell_type ) ) {
                    options = this instanceof DDLayout.models.cells.Layout ? _.escape(options) : DDLayout.models.abstract.Element._strip_tags_and_preserve_text( options );
                }
            }
        }
        else if( attributes === 'additionalCssClasses' && options && _.isString( options )  )
        {
                options = options.replace(/,/g, ' ').trim();
                options = WPV_Toolset.Utils._strip_scripts( options );
                options = WPV_Toolset.Utils._strip_tags_and_preserve_text( options );

        }else if( attributes === 'additionalCssClasses' && options && _.isArray( options )  )
        {
            options = options.join(' ');
            options = options.replace(/,/g, ' ').trim();
            options = WPV_Toolset.Utils._strip_scripts( options );
            options = WPV_Toolset.Utils._strip_tags_and_preserve_text( options );
        }
        else if( attributes === 'cssId' ){
            if( options ){
                options = WPV_Toolset.Utils._strip_scripts( options );
                options = WPV_Toolset.Utils._strip_tags_and_preserve_text( options );
            }
        }  else if( attributes === 'content' && options &&  _.isObject(options) ){
            options = _.mapObject( options, function(val, key) {
                if( _.isString( val ) ){
                    val = WPV_Toolset.Utils._strip_scripts( val );
                    // if we are dealing with Element.content.content property do not strip other tags (WYSIWYG / HTML Editor content)
                    if( 'content' !== key ){
                        // preserve special chars and do not convert to entities
                        val = _.unescape( WPV_Toolset.Utils._strip_tags_and_preserve_text( val ) );
                    }
                }
                return val;
            });
        }

        if( _.isString( options ) ){
            options = WPV_Toolset.Utils._strip_scripts( options );
        }
        else if( _.isObject(options) ){
            _.each(options, function( value, key, list ){
                if( value && _.isFunction( value.replace ) ){
                    options[key] = WPV_Toolset.Utils._strip_scripts( value );
                }
            });
        }

        this.trigger('layout_element_model_change', this, attributes, options );
        return Backbone.Model.prototype.set.call(this, attributes, options);
    },
    get:function( attribute )
    {
        if( attribute === 'name' ){
            try{
                this.attributes[attribute] = he.decode( this.attributes[attribute] );
                this.attributes[attribute] = unescape( this.attributes[attribute] );
            } catch(e){
                //console.log('Not a string');
            }

        }
        if( attribute === 'additionalCssClasses' ){
            this.attributes[attribute] = null !== this.attributes[attribute] ? this.attributes[attribute].replace(/[ ]/g, ' ').trim() : '';
        }
        return Backbone.Model.prototype.get.call(this, attribute );
    },
    get_id: function () {
        return this.get('id');
    },
    get_name: function () {
        return this.get('name');
    },
    get_width: function () {
        return this.get('width');
    },
    get_max_id : function () {
        var self = this;
        var max_id = 0;

        var cells = self.get('Cells');

        if( !cells ) return 1;

        for (var i = 0; i < cells.length; i++) {
            var test_cell = cells.at(i);
            var cell_id = test_cell.get('id');

            cell_id = cell_id.replace(/[^0-9\.]+/g, ""); // keep only numbers
            cell_id = parseInt(cell_id);

            if (cell_id > max_id) {
                max_id = cell_id;
            }
        }

        return max_id;
    }
});

DDLayout.models.abstract.Element._strip_tags_and_preserve_text = function (option) {
    if ( WPV_Toolset.Utils && WPV_Toolset.Utils.hasOwnProperty('_strip_tags_and_preserve_text') ) {
        return WPV_Toolset.Utils._strip_tags_and_preserve_text(option);
    }
    return option;
};
