class HQWidgetWoocommerceProductAddToCart extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                cart: 'form.cart',
                btn_add_to_cart: 'button.single_add_to_cart_button',
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $cart: this.$element.find(selectors.cart),
            $btn_add_to_cart: this.$element.find(selectors.btn_add_to_cart)
        };
    }

    bindEvents() {
        var $j = jQuery.noConflict();

        $j(window).on('load', this.wooQuantityButtons());
        //$j(document).ajaxComplete(this.wooQuantityButtons());
        $j(document.body).on('wc_cart_button_updated', this.wc_cart_button_updated);
        if (this.elements.$cart.is('.variations_form')) {
            this.elements.$btn_add_to_cart.on('click', this.onAddToCart.bind(this));
            this.elements.$cart.on('woocommerce_variation_has_changed', this.onVariationHasChanged.bind(this));
        }
    }

    onVariationHasChanged() {
        this.elements.$cart.find('.single_add_variation_message').remove();
    }

    onAddToCart(e) {
        if (this.elements.$btn_add_to_cart.is('.disabled')) {
            e.stopPropagation();
            e.preventDefault();
            let message;
            if (this.elements.$btn_add_to_cart.is('.wc-variation-is-unavailable')) {
                message = wc_add_to_cart_variation_params.i18n_unavailable_text;
            } else if (this.elements.$btn_add_to_cart.is('.wc-variation-selection-needed')) {
                message = wc_add_to_cart_variation_params.i18n_make_a_selection_text;
            }
            if (this.elements.$cart.find('.single_add_variation_message').length) {
                this.elements.$cart.find('.single_add_variation_message').html(message);
            } else {
                let $messageWrap = jQuery('<div class="single_add_variation_message" />').html(message);
                this.elements.$cart.find('.single_variation_wrap').before($messageWrap);
            }
        }
    }

    wc_cart_button_updated(button, target) {
        target.parent().find('.added_to_cart').addClass('elementor-button');
    }

    wooQuantityButtons($quantitySelector) {
        var $j = jQuery.noConflict();
        var $quantityBoxes;
        var $cart = this.elements.$cart;
        if (!$quantitySelector) {
            $quantitySelector = '.qty';
        }

        $quantityBoxes = $j('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').find($quantitySelector);

        if ($quantityBoxes && 'date' !== $quantityBoxes.prop('type') && 'hidden' !== $quantityBoxes.prop('type')) {

            if ($j('div.quantity .qty-button').length) {
                // Plus and Minus button already added from another source, just add the class
                $quantityBoxes.parent().addClass('buttons_added');
            } else {
                // Add plus and minus icons
                $quantityBoxes.parent().addClass('buttons_added').prepend('<a href="javascript:void(0)" class="qty-button minus">&minus;</a>');
                $quantityBoxes.after('<a href="javascript:void(0)" class="qty-button plus">&plus;</a>');
            }
            // Target quantity inputs on product pages
            $j('input' + $quantitySelector + ':not(.product-quantity input' + $quantitySelector + ')').each(function () {
                var $min = parseFloat($j(this).attr('min'));

                if ($min && $min > 0 && parseFloat($j(this).val()) < $min) {
                    $j(this).val($min);
                }
            });

            // Quantity input
            if ($j('body').hasClass('single-product') && !$cart.hasClass('grouped_form')) {
                var $quantityInput = $j('.woocommerce form input[type=number].qty');
                $quantityInput.on('keyup', function () {
                    var qty_val = $j(this).val();
                    $quantityInput.val(qty_val);
                });
            }

            $j('.plus, .minus').unbind('click');

            $j('.plus, .minus').on('click', function () {

                // Quantity
                var $quantityBox;

                // If floating bar is enabled
                if ($j('body').hasClass('single-product')
                        && !$cart.hasClass('grouped_form')
                        && !$cart.hasClass('cart_group')) {
                    $quantityBox = $j('.plus, .minus').closest('.quantity').find($quantitySelector);
                } else {
                    $quantityBox = $j(this).closest('.quantity').find($quantitySelector);
                }

                // Get values
                var $currentQuantity = parseFloat($quantityBox.val()),
                        $maxQuantity = parseFloat($quantityBox.attr('max')),
                        $minQuantity = parseFloat($quantityBox.attr('min')),
                        $step = $quantityBox.attr('step');

                // Fallback default values
                if (!$currentQuantity || '' === $currentQuantity || 'NaN' === $currentQuantity) {
                    $currentQuantity = 0;
                }
                if ('' === $maxQuantity || 'NaN' === $maxQuantity) {
                    $maxQuantity = '';
                }

                if ('' === $minQuantity || 'NaN' === $minQuantity) {
                    $minQuantity = 0;
                }
                if ('any' === $step || '' === $step || undefined === $step || 'NaN' === parseFloat($step)) {
                    $step = 1;
                }

                // Change the value
                if ($j(this).is('.plus')) {
                    if ($maxQuantity && ($maxQuantity == $currentQuantity || $currentQuantity > $maxQuantity)) {
                        $quantityBox.val($maxQuantity);
                    } else {
                        $quantityBox.val($currentQuantity + parseFloat($step));
                    }
                } else {
                    if ($minQuantity && ($minQuantity == $currentQuantity || $currentQuantity < $minQuantity)) {
                        $quantityBox.val($minQuantity);
                    } else if ($currentQuantity > 0) {
                        $quantityBox.val($currentQuantity - parseFloat($step));
                    }
                }

                // Trigger change event
                $quantityBox.trigger('change');
            });
        }
    }
}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetWoocommerceProductAddToCart, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-add-to-cart.default', addHandler);
});