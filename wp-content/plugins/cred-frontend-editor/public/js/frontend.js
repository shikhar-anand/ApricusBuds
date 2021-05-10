/**
 * Forms main frontend script.
 *
 * @package CRED
 * @todo Clarify the order for initializing elements and firing cred_form_ready.
 * @todo Get rid of the credFrontEndViewModel.
 * @todo Turn the whole code into a proper Module.
 */

var Toolset = Toolset || {};

Toolset.CRED = Toolset.CRED || {};

Toolset.CRED.Frontend = Toolset.CRED.Frontend || {};

var credFrontEndViewModel = {
    /**
     * @var string[] List of Toolset Forms IDs in the currnet page.
     */
    credForms: [],
    /**
     * @var string[] List of Toolset Form IDs ready for third-party actions.
     */
    readyCREDForms: [],

    /**
     * @var string Loading Spinner class
     */
    loadingSpinnerClass: "loading-spinner",

    /**
     * @var string Loading spinner image for ajax forms
     */
    loadingSpinnerImagePath: "/wp-admin/images/wpspin_light-2x.gif",

    /**
     * @var mixed[] Recaptcha widget id list for each cred form belongs to
     */
    recaptcha_widget_ids: [],

    /**
     * Reload and init reCaptha component after a cred form ajax call
     *
     * @param $current_form
     * @since 1.9.3
     */
    tryToReloadReCAPTCHA: function ($current_form) {
        if (typeof grecaptcha !== 'undefined') {
            var formID = $current_form.attr('id');
            var $recaptcha_selector = $current_form.find('div.g-recaptcha');
            if ($recaptcha_selector.length) {
                var _sitekey = $recaptcha_selector.data('sitekey');
                if (typeof _sitekey !== 'undefined') {
                    var recaptcha_widget_id = grecaptcha.render($recaptcha_selector.attr('id'), {sitekey: _sitekey});
                    //init current recaptcha widget id
                    if (typeof this.recaptcha_widget_ids[formID] === 'undefined') {
                        this.recaptcha_widget_ids[formID] = [];
                    }
                    this.recaptcha_widget_ids[formID] = recaptcha_widget_id;
                }
            }
        }
    },

    /**
     * Show and Hide the ReCAPTHA error messsage at run time
     *
     * @param $form
     * @return bool
     * @since 1.9.3
     */
    handleReCAPTCHAErrorMessage: function ($form) {
        if (typeof grecaptcha !== 'undefined') {
            var $error_selector = $form.find('div.recaptcha_error');
            var formID = $form.attr('id');
            if (typeof this.recaptcha_widget_ids[formID] !== 'undefined') {
                if (grecaptcha.getResponse(this.recaptcha_widget_ids[formID]) == '') {
                    $error_selector.show();
                    setTimeout(function () {
                        $error_selector.hide();
                    }, 5000);
                    return false;
                } else {
                    //reset recapatcha widget_id
                    this.recaptcha_widget_ids[formID] = undefined;
                }
            }
            $error_selector.hide();
        }
        return true;
    },

    /**
     * Set disabled the submit button
     *
     * @param $form
     * @since 1.9.3
     */
    disableSubmitForm: function (formID, isValidForm, credSettings) {
        var $form = jQuery(formID);
        if (isValidForm) {
            $form.find( '.wpt-form-submit' ).prop( 'disabled', true );
        }
    },

    /**
     * Enable the submit form
     *
     * @param $form
     * @since 1.9.3
     */
    enableSubmitForm: function ($form) {
        $form.find('.wpt-form-submit').prop('disabled', false);
    },

    /** @var null|bool */
    isWpEditorAvailable: null,

    /**
     * Check whether wp.editor is available.
     *
     * @return bool
     */
    checkWpEditorAvailable: function() {
        if ( null == this.isWpEditorAvailable ) {
            this.isWpEditorAvailable = (
                _.has( window, 'wp' )
                && _.has( window.wp, 'editor' )
                && _.has( window.wp.editor, 'remove' )
                && _.has( window.wp.editor, 'initialize' )
            );
        }
        return this.isWpEditorAvailable;
    },

    /** @var null|bool */
    isMceInitAvailable: null,

    /**
     * Check whether window.tinyMCEPreInit.mceInit is available.
     *
     * @return bool
     */
    checkMceInitAvailable: function() {
        if ( null === this.isMceInitAvailable ) {
            this.isMceInitAvailable = (
                _.has( window, 'tinyMCEPreInit' )
                && _.has( window.tinyMCEPreInit, 'mceInit' )
            );
        }
        return this.isMceInitAvailable;
    },

    /** @var null|bool */
    isQInitAvailable: null,

    /**
     * Check whether window.tinyMCEPreInit.qtInit is available.
     *
     * @return bool
     */
    checkQInitAvailable: function() {
        if ( null === this.isQInitAvailable ) {
            this.isQInitAvailable = (
                _.has( window, 'tinyMCEPreInit' )
                && _.has( window.tinyMCEPreInit, 'qtInit' )
            );
        }
        return this.isQInitAvailable;
    },

    /**
     * Reload and re-init tinyMCE after a cred form ajax call
     *
     * @param object $container Node to reload inner tinyMCE editors
     * @since 1.9.3
     */
    reloadTinyMCE: function( $container ) {
        $container = ( typeof $container !== 'undefined' ) ? $container : jQuery( document );
        var currentInstance = this;
        jQuery( 'textarea.wpt-wysiwyg', $container ).each( function( index ) {
            var $area = jQuery( this ),
                area_id = $area.prop('id');

            if ( currentInstance.checkWpEditorAvailable() ) {
                // WordPress over 4.8, hence wp.editor is available and included
                wp.editor.remove( area_id );
                var tinymceSettings = (
                        currentInstance.checkMceInitAvailable()
                        && _.has( window.tinyMCEPreInit.mceInit, area_id )
                    ) ? window.tinyMCEPreInit.mceInit[ area_id ] : true,
                    qtSettings = (
                        currentInstance.checkQInitAvailable()
                        && _.has( window.tinyMCEPreInit.qtInit, area_id )
                    ) ? window.tinyMCEPreInit.qtInit[ area_id ] : true,
                    hasMediaButton = ! jQuery( 'textarea#' + area_id ).hasClass( 'js-toolset-wysiwyg-skip-media' ),
                    hasToolsetButton = ! jQuery( 'textarea#' + area_id ).hasClass( 'js-toolset-wysiwyg-skip-toolset' ),
                    mediaButtonsSettings = ( hasMediaButton || hasToolsetButton );

                wp.editor.initialize( area_id, { tinymce: tinymceSettings, quicktags: qtSettings, mediaButtons: mediaButtonsSettings } );

                if ( mediaButtonsSettings ) {
                    var $mediaButtonsContainer = jQuery( '#wp-' + area_id + '-wrap .wp-media-buttons' );
                    $mediaButtonsContainer.attr( 'id', 'wp-' + area_id + '-media-buttons' );

                    if ( ! hasMediaButton ) {
                        $mediaButtonsContainer.find( '.insert-media.add_media' ).remove();
                    }
                    if ( hasToolsetButton ) {
                        /**
                         * Broadcasts that the WYSIWYG field initialization was completed,
                         * only if the WYSIWYG field should include Toolset buttons.
                         *
                         * @param {string} area_id The underlying textarea id attribute
                         *
                         * @event toolset:forms:wysiwygFieldInited
                         *
                         * @since 2.1.2
                         */
                        jQuery( document ).trigger( 'toolset:forms:wysiwygFieldInited', [ area_id ] );
                    }
                }

            } else {
                // WordPress below 4.8, hence wp-editor is not available
                // so we turn those fields into simple textareas
                jQuery( '#wp-' + area_id + '-editor-tools' ).remove();
                jQuery( '#wp-' + area_id + '-editor-container' )
                    .removeClass( 'wp-editor-container' )
                    .find( '.mce-container' )
                    .remove();
                jQuery( '#qt_' + area_id + '_toolbar' ).remove();
                jQuery( '#' + area_id )
                    .removeClass( 'wp-editor-area' )
                    .show()
                    .css( { width: '100%' } );
            }
        });
    },

    /**
     * Manage the form submission when validation succeded:
     * - If it an AJAX form, submit it.
     * - if it is not an AJAX form, disable the submit button while the form reloads the page.
     *
     * @param string formID
     * @param bool isAjaxForm
     * @param object credSettings
     * @since 1.9.3
     * @since 2.4 Manage both AJAX and non AJAX submission for valid forms
     */
    onValidatedSubmitForm: function( formID, isAjaxForm, credSettings ) {
        var thiz = this;
        var $form = jQuery( formID );
        var site_url = credSettings.site_url;

        if ( isAjaxForm ) {
            jQuery( '<input value="true" name="form_submit">' ).attr( 'type', 'hidden' ).appendTo( formID );

            thiz.startLoading( $form.find( '.wpt-form-submit' ), site_url );

            if (
                _.has( window, 'tinyMCE' )
                && _.has( window.tinyMCE, 'triggerSave' )
            ) {
                // This will refresh the value of all tinyMCE instances of the page:
                // better too much than too little!
                window.tinyMCE.triggerSave();
            }

            jQuery( formID ).ajaxSubmit({
                url: cred_frontend_i18n.ajaxurl,
                data: {
                    action: cred_frontend_i18n.submit.action,
                    wpnonce: cred_frontend_i18n.submit.nonce,
                    lang: cred_frontend_i18n.lang
                },
                dataType: 'json',
                success: function( response ) {
                    $form.replaceWith( response.data.output );
                    if ( 'ok' === response.data.result ) {
                        /**
                         * The AJAX form was successfully submitted.
                         *
                         * @param string formID
                         * @since 1.9.3
                         */
                        Toolset.hooks.doAction( 'cred_form_ajax_success', formID );
                    } else {
                        /**
                         * The AJAX form failed to submit.
                         *
                         * @param string formID
                         * @since 1.9.3
                         */
                        Toolset.hooks.doAction( 'cred_form_ajax_error', formID );
                    }
                },
                error: function() {
                    /**
                     * The AJAX form failed to submit.
                     *
                     * @param string formID
                     * @since 1.9.3
                     */
                    Toolset.hooks.doAction( 'cred_form_ajax_error', formID );
                },
                complete: function (response) {
                    thiz.stopLoading();
                    /**
                     * The AJAX form submission was completed, either successfully or failing.
                     *
                     * @param string formID
                     * @since 1.9.3
                     */
                    Toolset.hooks.doAction( 'cred_form_ajax_completed', formID );
                }
            });
        } else {
            // Non AJAX form already validated and ready to be submitted:
            // flag the submit button so it can not trigger the process again
            // and we avoid multiple form submission on fast clicks.
            $form
                .find( '.wpt-form-submit' )
                .addClass( 'js-wpt-form-submitting' );
        }
    },

    /**
     * Append wp native spinner next to a selector (by defualt is submit button)
     *
     * @param object $selector_to_append
     * @param string site_url
     * @since 1.9.3
     */
    startLoading: function( $selector_to_append, site_url ) {
        var $body = jQuery("body");
        $body.addClass("wpt-loading");
        var loading_icon = site_url + this.loadingSpinnerImagePath;
        $selector_to_append.after('<span class="' + this.loadingSpinnerClass + '" style="margin-left:5px;"><img class="cred-form-loading-spinner-image" src="' + loading_icon + '"></span>');
    },

    /**
     * @since 1.9.3
     */
    stopLoading: function () {
        var $body = jQuery("body");
        $body.removeClass("wpt-loading");
        jQuery('.' + this.loadingSpinnerClass).remove();
    },

    /**
     * Function called when an Ajax Form is validated and submitted
     *
     * @param string formID
     * @since 1.9.3
     */
    onAjaxFormSubmit: function( formID ) {
        $form_selector = jQuery(formID);
        this.enableSubmitForm($form_selector);
        this.initColorPicker($form_selector);

        this.setFormsReady();
        this.activatePreviewMode();
        this.reloadTinyMCE( $form_selector );
        this.tryToReloadReCAPTCHA($form_selector);
    },

    /**
     * Gather all Toolset Forms in document.
     *
     * @return string[]
     */
    getAllForms: function() {
        var thiz = this;
        jQuery('.cred-form, .cred-user-form', document ).each( function() {
            thiz.credForms.push( jQuery( this ).attr('id') );
        });

        return thiz.credForms;
    },

    /**
     * Gather a uniqueID.
     *
     * @return string
     */
    uniqueID: function () {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    },

    /**
     * Add IDs for both labels and inputs for accessibility support.
     *
     * @since 1.8.6
     */
    addAccessibilityIDs: function () {
        var $cred_form_labels = jQuery('.cred-form .form-group label');
        for (var form_label_index in $cred_form_labels) {
            if (isNaN(form_label_index)) {
                break;
            }

            var $form_label = jQuery($cred_form_labels[form_label_index]);
            var accessibility_id = this.uniqueID();

            $input_array = [];

            $input_array.push($form_label.parent().find(':input:not(:button)'));
            $input_array.push($form_label.parent().find('select')[0]);
            $input_array.push($form_label.parent().find('textarea')[0]);

            if ($input_array.length > 0) {
                for (var input in $input_array) {
                    if ($input_array[input] !== undefined) {
                        $input_array[input] = jQuery($input_array[input]);
                        if ($input_array[input].attr('id') !== undefined && $input_array[input].attr('id') !== null && $input_array[input].attr('id') != "") {
                            $form_label.attr('for', $input_array[input].attr('id'));
                        } else {
                            $input_array[input].attr('id', accessibility_id);
                            $form_label.attr('for', accessibility_id);
                        }
                    }
                }
            }
        }
    },

    /**
     * Declare all forms in the page as ready.
     */
    setFormsReady: function () {
        var thiz = this;
        this.getAllForms();
        this.readyCREDForms = [];

        _.each( thiz.credForms, function( item, index, list ) {
            thiz.readyCREDForms.push( item );

            jQuery( '.js-wpt-validate', '#' + item ).removeClass( 'js-wpt-validate' );
            jQuery( document ).trigger('cred_form_ready', {
                form_id: item
            });
        });
    },

    /**
     * Disable file inputs while the form is in preview mode.
     *
     * @since 1.9
     */
    activatePreviewMode: function () {
        //disable media buttons in preview mode
        if (window.hasOwnProperty('cred_form_preview_mode') && window.cred_form_preview_mode == true) {
            jQuery('#insert-media-button').prop('disabled', true);
            jQuery('.insert-media').prop('disabled', true);
            jQuery('.cred-form input[type="file"]').attr('onclick', 'return false');
            jQuery('.cred-user-form input[type="file"]').attr('onclick', 'return false');

            jQuery(document).on('toolset_repetitive_field_added', function () {
                jQuery('input[type="file"]', $parent).attr('onclick', 'return false');
                jQuery('input[type="file"]', $parent).attr('onclick', 'return false');
            });

        }
    },

    /**
     * Init Color Picker.
     *
     * @param object $form
     */
    initColorPicker: function ($form) {
        if (typeof(wptColorpicker) !== 'undefined') {
            wptColorpicker.init($form);
        }
    }
};


(function () {
    jQuery(function () {
        credFrontEndViewModel.setFormsReady();
        credFrontEndViewModel.addAccessibilityIDs();
        credFrontEndViewModel.activatePreviewMode();

        /**
         * @description: JS code to fix attachment post_id when media upload (up to wysiwyg fields) is opened
         * Each media attached will referrer to the post_id created by the cred form
         * @since 1.9.1
         */
        jQuery(document.body).on('click', 'form.cred-form .wp-media-buttons > .button.insert-media.add_media, form.cred-user-form .wp-media-buttons > .button.insert-media.add_media', function () {
            if (wp && wp.hasOwnProperty('media')) {
                var $current_form = jQuery(this).closest('form');
                var current_cred_form_post_id = jQuery("input[name='_cred_cred_prefix_post_id']", $current_form).val();
                if ($current_form
                    && current_cred_form_post_id
                    && wp.media.model.settings.post.id !== current_cred_form_post_id
                ) {
                    wp.media.model.settings.post.id = current_cred_form_post_id;
                }
            }
        });
    });

    //Once the cred form is ready
    jQuery(document).on('cred_form_ready', function ( evt, form_data ) {
        var $form = jQuery("#" + form_data.form_id);

        //uncheck generic checkboxes
        jQuery('input[type="checkbox"][cred_generic="1"]').each(function (index, checkbox) {
            if (jQuery(checkbox).attr('default_checked') != 1) {
                jQuery(checkbox).prop('checked', false);
            } else {
                jQuery(checkbox).prop('checked', true);
            }
        });

        //Queue after conditional and validation init
        setTimeout(function () {
            jQuery('.form-submit', $form).attr('disabled', false);
        }, 4);

        credFrontEndViewModel.initColorPicker($form);

        $form.on('submit', function () {
            //If recaptcha is not valid stops the submit
            if (!credFrontEndViewModel.handleReCAPTCHAErrorMessage(jQuery(this))) {
                return false;
            }
        });

    });

    jQuery( document ).on( 'js_event_wpv_pagination_completed js_event_wpv_parametric_search_results_updated', function( event, data ) {
        jQuery( '.cred-form, .cred-user-form', data.layout ).each( function() {
            var $form = jQuery( this );
            credFrontEndViewModel.initColorPicker( $form );
            credFrontEndViewModel.reloadTinyMCE( $form );
            credFrontEndViewModel.tryToReloadReCAPTCHA( $form );
        });
    });

    /**
     * Halt multiple clicks on validated non AJAX forms,
     * by halting the submit button click.
     *
     * @since 2.4
     */
    jQuery( document ).on( 'click', '.js-wpt-form-submitting', function( e ) {
        e.preventDefault();
    });

    //bounding onAjaxFormSubmit
    var boundOnAjaxFormSubmit = _.bind(credFrontEndViewModel.onAjaxFormSubmit, credFrontEndViewModel);
    //After Ajax submit form call is completed (with success or error)
    Toolset.hooks.addAction('cred_form_ajax_completed', boundOnAjaxFormSubmit);

    //bounding onValidatedSubmitForm
    var boundOnValidatedSubmitForm = _.bind(credFrontEndViewModel.onValidatedSubmitForm, credFrontEndViewModel);
    //After cred form submit validation success
    Toolset.hooks.addAction('toolset-form-onsubmit-validation-success', boundOnValidatedSubmitForm);

    //bounding boundDisableSubmitForm
    // todo: check this, binding does nto seem required.
    var boundDisableSubmitForm = _.bind(credFrontEndViewModel.disableSubmitForm, credFrontEndViewModel);
    //If Form is ajax disable submit button on toolset-ajax-submit event
    Toolset.hooks.addAction('toolset-ajax-submit', boundDisableSubmitForm);

})();

//Method recaptcha callback
var onLoadRecaptcha = function () {
    //Init of all recaptcha
    jQuery.each(jQuery('.g-recaptcha'), function (i, recaptcha_selector) {
        var $current_form = jQuery(recaptcha_selector).closest('form');
        credFrontEndViewModel.tryToReloadReCAPTCHA($current_form);
    });
};

/**
 * Manager for frontend delete links.
 */
Toolset.CRED.Frontend.Delete = function( $ ) {

    var self = this;

    self.i18n = cred_frontend_i18n;

    self.selector = '.js-cred-delete-post';

    $( document ).on( 'click', self.selector, function( e ) {
        e.preventDefault();

        var $handle = $( this ),
            ajaxData = {
                action: self.i18n.deletePost.action,
                wpnonce: self.i18n.deletePost.nonce,
                credPostId: $handle.data( 'postid' ),
                credAction: $handle.data( 'action' ),
                credOnSuccess: $handle.data( 'onsuccess' )
            };

        var $spinner = $( '<span class=""><img src="' + self.i18n.spinner + '" /></span>' );
        $handle.replaceWith( $spinner );

        $.ajax({
            url: self.i18n.ajaxurl,
            data: ajaxData,
            dataType: 'json',
            type: "POST",
            success:  function( originalResponse ) {
                var response = WPV_Toolset.Utils.Ajax.parseResponse( originalResponse );
                if ( response.success ) {
                    self.doSuccess( response.data.onsuccess, $spinner );
                } else {
                    self.doError( $spinner );
                }
            },
            error: function ( ajaxContext ) {
                self.doError( $spinner );
            }
        });
    });

    /**
     * Perform the success action after deleting.
     *
     * @param string onsuccess Action to perform.
     * @param $handle Reference to the object to act upon, if needed.
     */
    self.doSuccess = function( onsuccess, $handle ) {
        switch ( onsuccess ) {
            case 'self':
                window.location.reload( true );
                break;
            case 'none':
            case '':
                $handle.hide();
                break;
            default:
                window.location = onsuccess;
                break;
        }
    }

    /**
     * Perform the error action after deleting failed.
     *
     * @param $handle Reference to the object to act upon.
     */
    self.doError = function( $handle ) {
        var $error = $( '<span class="cred-delete-post-error">' + self.i18n.deletePost.messages.error + '</span>' );
        $handle.replaceWith( $error );
    }

};

jQuery( function(){
    Toolset.CRED.Frontend.deleteInstance = new Toolset.CRED.Frontend.Delete( jQuery );
});
