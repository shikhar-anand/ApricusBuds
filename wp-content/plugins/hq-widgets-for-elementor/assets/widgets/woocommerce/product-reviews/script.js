class HQWidgetWoocommerceProductReviews extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                //carousel: '.elementor-carousel'
            }
        };
    }

    getDefaultElements() {
        let selectors = this.getSettings('selectors');
        return {
            //$carousel: this.$element.find(selectors.carousel)
        };
    }

    onInit() {
        jQuery('body')
                // Star ratings for comments
                .on('init', '#rating', function () {
                    jQuery('#rating').hide();
                    if (!jQuery('p.stars').length) {
                        jQuery('#rating').before(
                                '<p class="stars">\
                                <span>\
                                    <a class="star-1" href="#">1</a>\
                                    <a class="star-2" href="#">2</a>\
                                    <a class="star-3" href="#">3</a>\
                                    <a class="star-4" href="#">4</a>\
                                    <a class="star-5" href="#">5</a>\
                                </span>\
                            </p>'
                                );
                    }
                })
                .on('click', '#respond p.stars a', function () {
                    var $star = jQuery(this),
                            $rating = jQuery(this).closest('#respond').find('#rating'),
                            $container = jQuery(this).closest('.stars');

                    $rating.val($star.text());
                    $star.siblings('a').removeClass('active');
                    $star.addClass('active');
                    $container.addClass('selected');

                    return false;
                })
                .on('click', '#respond #submit', function () {
                    var $rating = jQuery(this).closest('#respond').find('#rating'),
                            rating = $rating.val();

                    if ($rating.length > 0 && !rating && wc_single_product_params.review_rating_required === 'yes') {
                        window.alert(wc_single_product_params.i18n_required_rating_text);

                        return false;
                    }
                });

        // Init Tabs and Star Ratings
        jQuery('#rating').trigger('init');
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetWoocommerceProductReviews, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-reviews.default', addHandler);
});