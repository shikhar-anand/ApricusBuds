class HQWidgetWoocommerceProductImages extends elementorModules.frontend.handlers.Base {

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
        var wc_single_product_params = {"i18n_required_rating_text":"Please select a rating","review_rating_required":"yes","flexslider":{"rtl":false,"animation":"slide","smoothHeight":true,"directionNav":false,"controlNav":"thumbnails","slideshow":false,"animationSpeed":500,"animationLoop":false,"allowOneSlide":false},"zoom_enabled":"1","zoom_options":[],"photoswipe_enabled":"1","photoswipe_options":{"shareEl":false,"closeOnScroll":false,"history":false,"hideAnimationDuration":0,"showAnimationDuration":0},"flexslider_enabled":"1"};
        /**
         * Product gallery class.
         */
        var ProductGallery = function ($target, args) {
            this.$target = $target;
            this.$images = jQuery('.woocommerce-product-gallery__image', $target);

            // No images? Abort.
            if (0 === this.$images.length) {
                this.$target.css('opacity', 1);
                return;
            }

            // Make this object available.
            $target.data('product_gallery', this);

            // Pick functionality to initialize...
            this.flexslider_enabled = jQuery.isFunction(jQuery.fn.flexslider);
            this.zoom_enabled = jQuery.isFunction(jQuery.fn.zoom);
            this.photoswipe_enabled = typeof PhotoSwipe !== 'undefined';

            // ...also taking args into account.
            if (args) {
                this.flexslider_enabled = false === args.flexslider_enabled ? false : this.flexslider_enabled;
                this.zoom_enabled = false === args.zoom_enabled ? false : this.zoom_enabled;
                this.photoswipe_enabled = false === args.photoswipe_enabled ? false : this.photoswipe_enabled;
            }

            // ...and what is in the gallery.
            if (1 === this.$images.length) {
                this.flexslider_enabled = false;
            }

            // Bind functions to this.
            this.initFlexslider = this.initFlexslider.bind(this);
            this.initZoom = this.initZoom.bind(this);
            this.initZoomForTarget = this.initZoomForTarget.bind(this);
            this.initPhotoswipe = this.initPhotoswipe.bind(this);
            this.onResetSlidePosition = this.onResetSlidePosition.bind(this);
            this.getGalleryItems = this.getGalleryItems.bind(this);
            this.openPhotoswipe = this.openPhotoswipe.bind(this);

            if (this.flexslider_enabled) {
                this.initFlexslider(args.flexslider);
                $target.on('woocommerce_gallery_reset_slide_position', this.onResetSlidePosition);
            } else {
                this.$target.css('opacity', 1);
            }

            if (this.zoom_enabled) {
                this.initZoom();
                $target.on('woocommerce_gallery_init_zoom', this.initZoom);
            }

            if (this.photoswipe_enabled) {
                this.initPhotoswipe();
            }
        };

        /**
         * Initialize flexSlider.
         */
        ProductGallery.prototype.initFlexslider = function (args) {
            var $target = this.$target,
                    gallery = this;

            var options = jQuery.extend({
                selector: '.woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image',
                start: function () {
                    $target.css('opacity', 1);
                },
                after: function (slider) {
                    gallery.initZoomForTarget(gallery.$images.eq(slider.currentSlide));
                }
            }, args);

            $target.flexslider(options);

            // Trigger resize after main image loads to ensure correct gallery size.
            jQuery('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:eq(0) .wp-post-image').one('load', function () {
                var $image = jQuery(this);

                if ($image) {
                    setTimeout(function () {
                        var setHeight = $image.closest('.woocommerce-product-gallery__image').height();
                        var $viewport = $image.closest('.flex-viewport');

                        if (setHeight && $viewport) {
                            $viewport.height(setHeight);
                        }
                    }, 100);
                }
            }).each(function () {
                if (this.complete) {
                    jQuery(this).trigger('load');
                }
            });
        };

        /**
         * Init zoom.
         */
        ProductGallery.prototype.initZoom = function () {
            this.initZoomForTarget(this.$images.first());
        };

        /**
         * Init zoom.
         */
        ProductGallery.prototype.initZoomForTarget = function (zoomTarget) {
            if (!this.zoom_enabled) {
                return false;
            }

            var galleryWidth = this.$target.width(),
                    zoomEnabled = false;

            jQuery(zoomTarget).each(function (index, target) {
                var image = jQuery(target).find('img');

                if (image.data('large_image_width') > galleryWidth) {
                    zoomEnabled = true;
                    return false;
                }
            });

            // But only zoom if the img is larger than its container.
            if (zoomEnabled) {
                var zoom_options = jQuery.extend({
                    touch: false
                }, {});

                if ('ontouchstart' in document.documentElement) {
                    zoom_options.on = 'click';
                }

                zoomTarget.trigger('zoom.destroy');
                zoomTarget.zoom(zoom_options);

                setTimeout(function () {
                    if (zoomTarget.find(':hover').length) {
                        zoomTarget.trigger('mouseover');
                    }
                }, 100);
            }
        };

        /**
         * Init PhotoSwipe.
         */
        ProductGallery.prototype.initPhotoswipe = function () {
            if (this.zoom_enabled && this.$images.length > 0) {
                this.$target.prepend('<a href="#" class="woocommerce-product-gallery__trigger">🔍</a>');
                this.$target.on('click', '.woocommerce-product-gallery__trigger', this.openPhotoswipe);
                this.$target.on('click', '.woocommerce-product-gallery__image a', function (e) {
                    e.preventDefault();
                });

                // If flexslider is disabled, gallery images also need to trigger photoswipe on click.
                if (!this.flexslider_enabled) {
                    this.$target.on('click', '.woocommerce-product-gallery__image a', this.openPhotoswipe);
                }
            } else {
                this.$target.on('click', '.woocommerce-product-gallery__image a', this.openPhotoswipe);
            }
        };

        /**
         * Reset slide position to 0.
         */
        ProductGallery.prototype.onResetSlidePosition = function () {
            this.$target.flexslider(0);
        };

        /**
         * Get product gallery image items.
         */
        ProductGallery.prototype.getGalleryItems = function () {
            var $slides = this.$images,
                    items = [];

            if ($slides.length > 0) {
                $slides.each(function (i, el) {
                    var img = jQuery(el).find('img');

                    if (img.length) {
                        var large_image_src = img.attr('data-large_image'),
                                large_image_w = img.attr('data-large_image_width'),
                                large_image_h = img.attr('data-large_image_height'),
                                item = {
                                    src: large_image_src,
                                    w: large_image_w,
                                    h: large_image_h,
                                    title: img.attr('data-caption') ? img.attr('data-caption') : img.attr('title')
                                };
                        items.push(item);
                    }
                });
            }

            return items;
        };

        /**
         * Open photoswipe modal.
         */
        ProductGallery.prototype.openPhotoswipe = function (e) {
            e.preventDefault();

            var pswpElement = jQuery('.pswp')[0],
                    items = this.getGalleryItems(),
                    eventTarget = jQuery(e.target),
                    clicked;

            if (eventTarget.is('.woocommerce-product-gallery__trigger') || eventTarget.is('.woocommerce-product-gallery__trigger img')) {
                clicked = this.$target.find('.flex-active-slide');
            } else {
                clicked = eventTarget.closest('.woocommerce-product-gallery__image');
            }

            var options = jQuery.extend({
                index: jQuery(clicked).index(),
                addCaptionHTMLFn: function (item, captionEl) {
                    if (!item.title) {
                        captionEl.children[0].textContent = '';
                        return false;
                    }
                    captionEl.children[0].textContent = item.title;
                    return true;
                }
            }, {});

            // Initializes and opens PhotoSwipe.
            var photoswipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            photoswipe.init();
        };

        /**
         * Function to call wc_product_gallery on jquery selector.
         */
        jQuery.fn.wc_product_gallery = function (args) {
            new ProductGallery(this, args);
            return this;
        };

        /*
         * Initialize all galleries on page.
         */
        jQuery('.woocommerce-product-gallery').each(function () {
            //jQuery(this).trigger('wc-product-gallery-before-init', [this, wc_single_product_params]);
            jQuery(this).wc_product_gallery(wc_single_product_params);
            //jQuery(this).trigger('wc-product-gallery-after-init', [this, wc_single_product_params]);
        });
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(HQWidgetWoocommerceProductImages, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/hq-woocommerce-product-images.default', addHandler);
});