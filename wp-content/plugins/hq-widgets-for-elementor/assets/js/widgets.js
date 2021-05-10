(function ($) {
    "use strict";

    /**
     * Get settings from data attr
     * @param element
     * @param defaultSettings Array
     * @returns {Array|@var;defaultSettings}
     */

    const getSettings = function (element, defaultSettings = []) {
        if (elementorFrontend.isEditMode()) {
            let el_cid = element.data('model-cid');
            if (undefined !== elementorFrontend.config.elements.data[el_cid]) {
                var settings = elementorFrontend.config.elements.data[el_cid].attributes;
            }
        } else {
            var settings = element.data('settings');
        }

        if (undefined === settings) {
            return defaultSettings;
        }
        return settings;
    };

    // Slider Handler
    const HQWidgetSliderHandler = function ($scope, $) {

        const settings = getSettings($scope);

        let slidesPerView = +settings.slides_to_show || 3,
                slidesPerGroup = +settings.slides_to_scroll || 1,
                autoplay = false,
                breakpoints = elementorFrontend.config.breakpoints;
        let $swiper = $scope.find('.swiper-container').eq(0);
        if ('yes' === settings.autoplay) {
            autoplay = {
                delay: +settings.autoplay_speed || 3000,
                disableOnInteraction: 'yes' === settings.disable_on_interaction ? true : false
            };
        }

        let swiperOptions = {
            loop: 'yes' === settings.infinite ? true : false,
            autoplay: autoplay,
            speed: settings.speed,
            effect: settings.effect ? settings.effect : 'slide',
            autoHeight: 'yes' === settings.slider_auto_height ? true : false,
            grabCursor: true,
            navigation: {
                nextEl: (-1 !== ['arrows', 'both'].indexOf(settings.navigation) ? $scope.find('.swiper-button-next')[0] : ''),
                prevEl: (-1 !== ['arrows', 'both'].indexOf(settings.navigation) ? $scope.find('.swiper-button-prev')[0] : '')
            },
            pagination: {
                el: (-1 !== ['dots', 'both'].indexOf(settings.navigation) ? $scope.find('.swiper-pagination')[0] : ''),
                clickable: true
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: +settings.slides_to_show_mobile || 1,
                    slidesPerGroup: +settings.slides_to_scroll_mobile || 1,
                    spaceBetween: (slidesPerView > 1 && settings.slides_space_between_mobile) ? +settings.slides_space_between_mobile.size : 0
                },
                [breakpoints.md]: {
                    slidesPerView: +settings.slides_to_show_tablet || 1,
                    slidesPerGroup: +settings.slides_to_scroll_tablet || 1,
                    spaceBetween: (slidesPerView > 1 && settings.slides_space_between_tablet) ? +settings.slides_space_between_tablet.size : 0
                },
                [breakpoints.lg]: {
                    slidesPerView: slidesPerView,
                    slidesPerGroup: slidesPerGroup,
                    spaceBetween: (slidesPerView > 1 && settings.slides_space_between) ? +settings.slides_space_between.size : 0
                }
            }
        };
        let swiperElement = new Swiper($swiper[0], swiperOptions);

    };

    // Grid Handler
    const HQWidgetGridHandler = function ($scope, $) {
        const settings = getSettings($scope);
        const masonryGrid = settings.masonry_grid === 'yes' ? 1 : 0;
        const infinite = settings.pagination_type === 'infinite_scroll' ? 1 : 0;
        // Post listing normal, masonry, infinitescroll
        let $container = $scope.find('.articles').eq(0);

        if ($container.length) {
            var isoInstance = false,
                    itemSelector,
                    articlesWrapper = '#' + $container.data('articles-id');

            if ($(articlesWrapper).find(".articles > :first-child").hasClass('hentry')) {
                itemSelector = articlesWrapper + ' .hentry';
            } else if ($(articlesWrapper).find(".articles > :first-child").hasClass('product')) {
                itemSelector = articlesWrapper + ' .product';
            }
            if (masonryGrid) {
                var $grid = $container.isotope({
                    itemSelector: itemSelector,
                    masonry: {
                        columnWidth: '.layout-grid-masonry > *:not(.masonry-x2)',
                    }
                });
                // layout Isotope after each image loads
                $grid.imagesLoaded().progress(function () {
                    $grid.isotope('layout');
                });

                // get Isotope instance
                isoInstance = $grid.data('isotope');
            }
            // Do not run infinite scroll in edit mode
            if (infinite && !elementorFrontend.isEditMode()) {
                var path = $scope.find('.hqt-pagination a.page-numbers.next');
                if (path.length) {
                    var scrollThreshold = ('yes' === settings.load_more_btn ? false : 200);
                    var button = ('yes' === settings.load_more_btn ? articlesWrapper + ' .hqt-load-more-btn .archive-load-more' : false);
                    var history = ('' !== settings.infinite_history ? settings.infinite_history : false);
                    var loadOnScroll = ('yes' === settings.load_on_scroll ? true : false);
                    
                    $container.infiniteScroll({
                        path: articlesWrapper + ' .hqt-pagination a.page-numbers.next',
                        append: itemSelector,
                        scrollThreshold: scrollThreshold,
                        loadOnScroll: loadOnScroll,
                        button: button,
                        prefill: false,
                        history: history,
                        outlayer: isoInstance,
                        hideNav: articlesWrapper + ' .hqt-pagination',
                        status: articlesWrapper + ' .hqt-load-more-status',
                        checkLastPage: true,
                        debug: false
                    });
                }
            }
        }
    };

    $(window).on('elementor/frontend/init', function () {

        // Theme Sliders
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-posts-slider.default', HQWidgetSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-post-related-posts-slider.default', HQWidgetSliderHandler);
        // Woo Sliders 
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-products-slider.default', HQWidgetSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-related-products-slider.default', HQWidgetSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-upsells-slider.default', HQWidgetSliderHandler);
        // Theme Grids
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-archive-posts.default', HQWidgetGridHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-post-related-posts-grid.default', HQWidgetGridHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-theme-posts-grid.default', HQWidgetGridHandler);
        // Woo Grids
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-archive-products.default', HQWidgetGridHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-products-grid.default', HQWidgetGridHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-related-products-grid.default', HQWidgetGridHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-upsells-grid.default', HQWidgetGridHandler);
    });

})(jQuery);