class HQWidgetModal extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                container: '.elementor-widget-container',
                modal: '.hq-modal-box',
                buttonOpenModal: '.btn-open-modal'
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $container: this.$element.find(selectors.container),
            $modal: this.$element.find(selectors.modal),
            $buttonOpenModal: this.$element.find(selectors.buttonOpenModal)
        };
    }

    setCookie(modalSettings) {
        let name = modalSettings.cookie_name.length ? modalSettings.cookie_name : 'cm-' + modalSettings.modal_id;
        let value = 1;
        let expires = new Date(modalSettings.cookie_time);
        let path = modalSettings.cookie_sitewide ? '; path=/' : '';

        document.cookie = name + '=' + value + '; expires=' + expires.toUTCString() + path;
    }

    bindCookieSetup(modalSettings) {
        if (modalSettings.cookie_event == 'on_open') {
            jQuery('#modal-' + modalSettings.modal_id).on(jQuery.modal.OPEN, () => this.setCookie(modalSettings));
        } else if (modalSettings.cookie_event == 'on_close') {
            jQuery('#modal-' + modalSettings.modal_id).on(jQuery.modal.CLOSE, () => this.setCookie(modalSettings));
        }
    }

    onEditorButtonClick(options, e) {
        e.preventDefault();
        if (jQuery('.hq-modal-box').length > 1) {
            this.elements.$buttonOpenModal.off('click');
            for (let i = 1; i <= jQuery('.hq-modal-box').length; i++) {
                jQuery('.hq-modal-box')[i].remove();
            }
            this.elements.$buttonOpenModal.on('click', this.onEditorButtonClick.bind(this, options));
        }
        this.elements.$buttonOpenModal.modal(options);
        return false;
    }

    onExitIntent(options) {
        this.elements.$modal.on(jQuery.modal.BEFORE_BLOCK, function (event, modal) {
            jQuery(document).off('mouseleave');
        });
        this.elements.$modal.modal(options);
    }

    bindEvents() {
        let modalSettings = this.getElementSettings();

        // Check for modal box blocking on frontend only
        if (!elementorFrontend.isEditMode()) {
            // Check if modal is disabled for any devices
            if (modalSettings.disable_on_mobile || modalSettings.disable_on_tablet || modalSettings.disable_on_desktop) {
                var md = new MobileDetect(window.navigator.userAgent);
                if (modalSettings.disable_on_mobile && md.mobile() && md.phone()) {
                    return false;
                }
                if (modalSettings.disable_on_tablet && md.mobile() && md.tablet()) {
                    return false;
                }
                if (modalSettings.disable_on_desktop && !md.mobile()) {
                    return false;
                }
            }

            // Check for Cookie which prevents the modal from triggering
            if (modalSettings.disable_trigger_cookie_name) {
                if (document.cookie.indexOf(modalSettings.disable_trigger_cookie_name) == !-1) {
                    return false;
                }
            }
        } else {
            // In Editor Mode, remove any opened modals in case of changing controls 
            // while the modal is opened, order to reload the changes
            if (jQuery('.hq-modal-blocker.blocker').length) {
                jQuery('.hq-modal-blocker.blocker').remove();
            }
        }

        // Set up a cookie if needed
        if (modalSettings.cookie_setup) {
            this.bindCookieSetup(modalSettings);
        }

        let $options = {
            blockerClass: 'hq-modal-blocker hq-modal-blocker__' + modalSettings.modal_id + ' modal-position__' + modalSettings.modal_position,
            showClose: (modalSettings.show_close_button ? true : false),
            closeText: (modalSettings.close_button_text ? modalSettings.close_button_text : '<i class="eicon-close"></i>'),
            closeExisting: false,
            clickClose: (modalSettings.close_overlay ? true : false),
            escapeClose: (modalSettings.close_esc ? true : false),
            fadeDuration: (modalSettings.fade_duration ? modalSettings.fade_duration : null)
        };

        if (elementorFrontend.isEditMode()) {
            this.elements.$buttonOpenModal.on('click', this.onEditorButtonClick.bind(this, $options));
        } else {
            if (modalSettings.trigger_type == 'click') {
                // Click on element to open the modal box
                if (modalSettings.click_selectors) {
                    let triggerSelectors = modalSettings.click_selectors.split(",");
                    // Loop over all the selectors
                    for (let i = 0; i < triggerSelectors.length; i++) {
                        let el = triggerSelectors[i];
                        if (jQuery(el).prop('tagName') == 'A') {
                            jQuery(el).attr('href', '#modal-' + modalSettings.modal_id);
                            jQuery(el).on('click', (e) => {
                                e.preventDefault();
                                jQuery(el).modal($options);
                            });
                        }
                    }
                }
            } else if (modalSettings.trigger_type == 'exit') {
                // Exit intent, on browser mouse leave
                jQuery(document).on('mouseleave', this.onExitIntent.bind(this, $options));
            } else {
                // In case of Time delay / Auto open - trigger the modal box from widget editor a.btn-open-modal button
                let timeout = modalSettings.time_delay ? modalSettings.time_delay : 0;
                setTimeout(() => {
                    this.elements.$modal.modal($options);
                }, timeout);
            }
        }
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetModal, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-modal-box.default', addHandler);
});