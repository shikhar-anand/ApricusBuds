class HQWidgetWoocommerceProductDataTabs extends elementorModules.frontend.handlers.Base {

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
                // Tabs
                .on('init', '.wc-tabs-wrapper, .woocommerce-tabs', function () {
                    jQuery('.wc-tab, .woocommerce-tabs .panel:not(.panel .panel)').hide();

                    var hash = window.location.hash;
                    var url = window.location.href;
                    var $tabs = jQuery(this).find('.wc-tabs, ul.tabs').first();

                    if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews') {
                        $tabs.find('li.reviews_tab a').click();
                    } else if (url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0) {
                        $tabs.find('li.reviews_tab a').click();
                    } else if (hash === '#tab-additional_information') {
                        $tabs.find('li.additional_information_tab a').click();
                    } else {
                        $tabs.find('li:first a').click();
                    }
                })
                .on('click', '.wc-tabs li a, ul.tabs li a', function (e) {
                    e.preventDefault();
                    var $tab = jQuery(this);
                    var $tabs_wrapper = $tab.closest('.wc-tabs-wrapper, .woocommerce-tabs');
                    var $tabs = $tabs_wrapper.find('.wc-tabs, ul.tabs');

                    $tabs.find('li').removeClass('active');
                    $tabs_wrapper.find('.wc-tab, .panel:not(.panel .panel)').hide();

                    $tab.closest('li').addClass('active');
                    $tabs_wrapper.find($tab.attr('href')).show();
                })
                // Review link
                .on('click', 'a.woocommerce-review-link', function () {
                    jQuery('.reviews_tab a').click();
                    return true;
                })
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
        jQuery('.wc-tabs-wrapper, .woocommerce-tabs, #rating').trigger('init');
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetWoocommerceProductDataTabs, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-data-tabs.default', addHandler);
});