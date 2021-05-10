class HQWidgetContactForm7 extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                container: '.wpcf7',
                submitBtn: 'input.wpcf7-submit',
                loader: '.ajax-loader'
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $container: this.$element.find(selectors.container),
            $submitBtn: this.$element.find(selectors.submitBtn),
            $loader: this.$element.find(selectors.loader)
        };
    }

    bindEvents() {
        let checkboxWrapper = this.elements.$container.find('.wpcf7-checkbox .wpcf7-list-item, .wpcf7-radio .wpcf7-list-item');
        checkboxWrapper.each(function () {
            if (!jQuery(this).children('label').length) {
                jQuery(this).find('input').nextAll().addBack().wrapAll('<label/>');
            }
        });
        this.elements.$submitBtn.wrap('<div class="submit-wrapper" />');
        this.elements.$loader.append('<span></span><span></span><span></span><span></span>');
        this.elements.$container.find('.submit-wrapper').append(this.elements.$loader);

        this.elements.$container.on('wpcf7submit', (e) => {
            var status = e.detail.status;
            if ('validation_failed' === status) {
                setTimeout(() => {
                    jQuery('html').stop().animate({
                        scrollTop: this.elements.$container.find('.wpcf7-not-valid').eq(0).offset().top - 50,
                    }, 500);
                }, 10);
            }
            if ('mail_sent' === status) {
                setTimeout(() => {
                    jQuery('html').stop().animate({
                        scrollTop: jQuery(window).scrollTop() + 100
                    }, 500);
                }, 10);
            }
        });
    }

}
;

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetContactForm7, {
            $element
        });
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-contact-form-7.default', addHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/hqpro-theme-advanced-contact-form-7.default', addHandler);
});