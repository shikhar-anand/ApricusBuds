class HQWidgetWoocommerceAddToCart extends elementorModules.frontend.handlers.Base {

    bindEvents() {
        let settings = this.getElementSettings();
        var $j = jQuery.noConflict();
        $j(document.body).on('wc_cart_button_updated', this.addToCartButtonUpdated.bind(this, settings));
    }

    addToCartButtonUpdated(settings, button, target) {
        let view_button_class = [
            'elementor-button',
            (settings.size ? 'elementor-size-' + settings.size : '')
        ];
        target.parent().find('.added_to_cart').addClass(view_button_class.join(' '));
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetWoocommerceAddToCart, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-add-to-cart.default', addHandler);
});