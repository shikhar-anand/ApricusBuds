<?php

namespace HQWidgetsForElementor\Widget;

defined('ABSPATH') || exit;

/**
 * Controls widgets
 * 
 * @since 1.0.0
 */
class Widgets_Control {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Widgets_Control 
     */
    private static $_instance = null;

    /**
     * Core widgets
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public static $core_widgets = [
        'theme' => [
            // General
            'breadcrumbs' => [
                'type' => 'free',
                'name' => 'Breadcrumbs',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-arrows',
            //'demo_url' => 'https://marmot.hqwebs.net/',
            ],
            'countdown-timer' => [
                'type' => 'free',
                'name' => 'Countdown Timer',
                'default_activation' => 'off',
                'icon_class' => 'hq-icon-chronometer',
            ],
            'elementor-global-template' => [
                'type' => 'free',
                'name' => 'Elementor Global Template',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-global-template',
            ],
            'flip-box' => [
                'type' => 'free',
                'name' => 'Flip Box',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-flip',
            ],
            'modal-box' => [
                'type' => 'free',
                'name' => 'Modal Box',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-send',
            ],
            'nav-menu' => [
                'type' => 'free',
                'name' => 'Navigation Menu',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-navigation-menu',
            ],
            'social-share' => [
                'type' => 'free',
                'name' => 'Social Share',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-social-share',
            ],
            // Blog
            'archive-posts' => [
                'type' => 'free',
                'name' => 'Archive Posts',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-list',
            ],
            'archive-title' => [
                'type' => 'free',
                'name' => 'Archive Title',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-text-tool',
            ],
            'posts-grid' => [
                'type' => 'free',
                'name' => 'Posts Grid',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-wireframe-list',
            ],
            'posts-slider' => [
                'type' => 'free',
                'name' => 'Posts Slider',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-layer-slider',
            ],
            'search-results' => [
                'type' => 'free',
                'name' => 'Search Results',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-grid-bordered',
            ],
            'author-box' => [
                'type' => 'free',
                'name' => 'Author Box',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-author-box',
            ],
            'post-comments' => [
                'type' => 'free',
                'name' => 'Post Comments',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-conversation',
            ],
            'post-content' => [
                'type' => 'free',
                'name' => 'Post Content',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-content-writing',
            ],
            'post-excerpt' => [
                'type' => 'free',
                'name' => 'Post Excerpt',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-document-add',
            ],
            'post-featured-image' => [
                'type' => 'free',
                'name' => 'Post Featured Image',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-adjust',
            ],
            'post-link' => [
                'type' => 'free',
                'name' => 'Post Link',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-link',
            ],
            'post-meta-data' => [
                'type' => 'free',
                'name' => 'Post Meta Data',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-menu-dots-horizontal',
            ],
            'post-navigation' => [
                'type' => 'free',
                'name' => 'Post Navigation',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-transfer',
            ],
            'post-taxonomies' => [
                'type' => 'free',
                'name' => 'Post Taxonomies',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-price-tag',
            ],
            'post-title' => [
                'type' => 'free',
                'name' => 'Post Title',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-title',
            ],
            'post-related-posts-slider' => [
                'type' => 'free',
                'name' => 'Post Related Posts Slider',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-carousel',
            ],
            'post-related-posts-grid' => [
                'type' => 'free',
                'name' => 'Post Related Posts Grid',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-posts-grid',
            ],
        ],
    ];

    /**
     * Third Party Widgets
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public static $third_party_widgets = [
        'theme' => [
            'contact-form-7' => [
                'type' => 'free',
                'name' => 'Contact Form 7',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-contact',
                'requires' => [
                    'contact-form-seven' => [
                        'type' => 'plugin',
                        'plugin_file' => 'contact-form-7/wp-contact-form-7.php',
                        'plugin_name' => 'contact-form-7',
                        'label' => 'Contact Form 7',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'polylang-switcher' => [
                'type' => 'free',
                'name' => 'Polylang Switcher',
                'default_activation' => 'off',
                'icon_class' => 'hq-icon-translator',
                'requires' => [
                    'polylang' => [
                        'type' => 'plugin',
                        'plugin_file' => 'polylang/polylang.php',
                        'plugin_name' => 'polylang',
                        'label' => 'Polylang',
                        'link' => 'https://wordpress.org/plugins/polylang/',
                    ],
                ]
            ],
            'wpforms' => [
                'type' => 'free',
                'name' => 'WPForms',
                'default_activation' => 'off',
                'icon_class' => 'hq-icon-message',
                'requires' => [
                    'wp-forms' => [
                        'type' => 'plugin',
                        'plugin_file' => 'wpforms-lite/wpforms.php',
                        'plugin_name' => 'wpforms-lite',
                        'label' => 'WPForms Lite',
                        'link' => 'https://wordpress.org/plugins/wpforms-lite/',
                    ],
                ]
            ],
        ],
        'woocommerce' => [
            'archive-products' => [
                'type' => 'free',
                'name' => 'Woo Archive Products',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-products-layout',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'archive-description' => [
                'type' => 'free',
                'name' => 'Woo Archive Description',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-quill',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'archive-product-add-to-cart' => [
                'type' => 'free',
                'name' => 'Woo Archive Product Add To Cart',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-archive-product-add-to-cart',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'category-image' => [
                'type' => 'free',
                'name' => 'Woo Category Image',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-document',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'notices' => [
                'type' => 'free',
                'name' => 'Woo Notices',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-warning',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'add-to-cart' => [
                'type' => 'free',
                'name' => 'Woo Add To Cart',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-add-to-cart',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-add-to-cart' => [
                'type' => 'free',
                'name' => 'Woo Product Add To Cart',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-product-add-to-cart',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-additional-information' => [
                'type' => 'free',
                'name' => 'Woo Product Additional Information',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-product-additional-information',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-categories-grid' => [
                'type' => 'free',
                'name' => 'Woo Product Categories Grid',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-grid',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-content' => [
                'type' => 'free',
                'name' => 'Woo Product Content',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-product-content',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-data-tabs' => [
                'type' => 'free',
                'name' => 'Woo Product Data Tabs',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-tabs',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-featured-image' => [
                'type' => 'free',
                'name' => 'Woo Product Featured Image',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-add-photo',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-images' => [
                'type' => 'free',
                'name' => 'Woo Product Images',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-wireframe-featured',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-link' => [
                'type' => 'free',
                'name' => 'Woo Product Link',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-add',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-meta' => [
                'type' => 'free',
                'name' => 'Woo Product Meta',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-metadata',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-price' => [
                'type' => 'free',
                'name' => 'Woo Product Price',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-price-label',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-rating' => [
                'type' => 'free',
                'name' => 'Woo Product Rating',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-product-rating',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-reviews' => [
                'type' => 'free',
                'name' => 'Woo Product Reviews',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-feedback',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-short-description' => [
                'type' => 'free',
                'name' => 'Woo Product Short Description',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-text-image',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-stock' => [
                'type' => 'free',
                'name' => 'Woo Product Stock',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-vote',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-title' => [
                'type' => 'free',
                'name' => 'Woo Product Title',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-transform-text',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-related-products-grid' => [
                'type' => 'free',
                'name' => 'Woo Product Related Products Grid',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-wireframe-list-mix',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-related-products-slider' => [
                'type' => 'free',
                'name' => 'Woo Product Related Products Slider',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-slider-2',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-upsells-grid' => [
                'type' => 'free',
                'name' => 'Woo Product Upsells Grid',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-advertisement',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'product-upsells-slider' => [
                'type' => 'free',
                'name' => 'Woo Product Upsells Slider',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-product-upsell-slider',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'products-slider' => [
                'type' => 'free',
                'name' => 'Woo Products Slider',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-slider',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
            'products-grid' => [
                'type' => 'free',
                'name' => 'Woo Products Grid',
                'default_activation' => 'on',
                'icon_class' => 'hq-icon-pixels',
                'requires' => [
                    'woocommerce' => [
                        'type' => 'plugin',
                        'plugin_file' => 'woocommerce/woocommerce.php',
                        'plugin_name' => 'woocommerce',
                        'label' => 'Woocommerce',
                        'link' => 'https://wordpress.org/plugins/woocommerce/',
                    ],
                ]
            ],
        ],
    ];

    /**
     * Pro Widgets
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public static $pro_widgets = [
        'core' => [
            'theme' => [
                'advanced-flip-box' => [
                    'name' => 'Advanced Flip Box',
                    'categories' => ['hq-widgets-for-elementor'],
                    'icon_class' => 'hq-icon-flip-box',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'advanced-icon-box' => [
                    'name' => 'Advanced Icon Box',
                    'categories' => ['hq-widgets-for-elementor'],
                    'icon_class' => 'hq-icon-advanced-icon-box',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'advanced-nav-menu' => [
                    'name' => 'Advanced Navigation Menu',
                    'categories' => ['hq-widgets-for-elementor'],
                    'icon_class' => 'hq-icon-menu',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
            ],
        ],
        'third_party' => [
            'theme' => [
                'advanced-contact-form-7' => [
                    'name' => 'Advanced Contact Form 7',
                    'categories' => ['hq-widgets-for-elementor'],
                    'icon_class' => 'hq-icon-email',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'advanced-open-table' => [
                    'name' => 'Advanced OpenTable Reservations',
                    'categories' => ['hq-widgets-for-elementor'],
                    'icon_class' => 'hq-icon-open-table-reservations',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'easy-appointments' => [
                    'name' => 'Easy Appointments',
                    'categories' => ['hq-widgets-for-elementor'],
                    'icon_class' => 'hq-icon-easy-appointments',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
            ],
            'woocommerce' => [
                'cart' => [
                    'name' => 'Woo Cart',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-shopping-basket',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'cart-cross-sell' => [
                    'name' => 'Woo Cart Cross Sell',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-woo-product-cross-sell',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'cart-table' => [
                    'name' => 'Woo Cart Table',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-online-payment',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'cart-totals' => [
                    'name' => 'Woo Cart Totals',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-purchasing',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'checkout-form' => [
                    'name' => 'Woo Checkout Form',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-checkout-flow',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'checkout-page' => [
                    'name' => 'Woo Checkout Page',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-woo-sale',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
                'checkout-thankyou' => [
                    'name' => 'Woo Checkout Thank You',
                    'categories' => ['hq-widgets-for-elementor-woo'],
                    'icon_class' => 'hq-icon-online-shopping-3',
                    'requires' => [
                        'marmot-enhancer-pro' => [
                            'type' => 'plugin',
                            'plugin_file' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                            'plugin_name' => 'marmot-enhancer-pro',
                            'label' => 'Marmot Enhancer Pro',
                            'link' => 'https://marmot.hqwebs.net/marmot-theme-pro/',
                        ],
                    ]
                ],
            ],
        ],
    ];

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Widgets_Control
     */
    public static function instance() {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Class constructor
     *
     * @since 1.0.0
     */
    private function __construct() {
        
    }

    public function hqt_widgets_control_get_all($widgets) {
        foreach ($widgets as $group_key => $group_widgets) {
            if (property_exists(__CLASS__, $group_key)) {
                foreach (self::${$group_key} as $module_key => $module_widgets) {
                    $widgets_arr = !empty($widgets[$group_key]) ? $widgets[$group_key] : [];
                    $widgets[$group_key] = array_merge($widgets_arr, $module_widgets);
                }
            }
        }
        return $widgets;
    }

    /**
     * Loads Activated Widgets
     * 
     * @since 1.0.0
     */
    public function load_active_widgets() {
        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

        $options = \HQLib\hq_get_option('core_widgets');
        foreach (self::$core_widgets as $module_key => $module_widgets) {
            foreach ($module_widgets as $widget_key => $widget_config) {
                if (\HQLib\Helper::is_widget_active($widget_key, $options)) {
                    $widget_class_name = '\\' . __NAMESPACE__ . '\\' . ucfirst($module_key) . '\\' . str_replace('-', '_', ucwords($widget_key, '-'));
                    $widgets_manager->register_widget_type(new $widget_class_name);
                }
            }
        }

        $options = \HQLib\hq_get_option('third_party_widgets');
        foreach (self::$third_party_widgets as $module_key => $module_widgets) {
            foreach ($module_widgets as $widget_key => $widget_config) {
                if (\HQLib\Helper::is_widget_active($widget_key, $options)) {
                    $widget_class_name = '\\' . __NAMESPACE__ . '\\' . ucfirst($module_key) . '\\' . str_replace('-', '_', ucwords($widget_key, '-'));
                    $widgets_manager->register_widget_type(new $widget_class_name);
                }
            }
        }
    }

    /**
     * List pro widgets
     * @since 1.0.9
     */
    public function promote_pro_elements($config) {
        if (\HQLib\License::is_activated()) {
            return $config;
        }

        $promotion_widgets = [];

        if (!empty($config['promotionWidgets'])) {
            $promotion_widgets = $config['promotionWidgets'];
        }

        $hq_promotional_widgets = [];
        foreach (self::$pro_widgets as $group_type) {
            foreach ($group_type as $group_widgets) {
                foreach ($group_widgets as $widget_key => $widget_config) {
                    $hq_promotional_widgets[] = [
                        'name' => $widget_key,
                        'title' => $widget_config['name'],
                        'icon' => $widget_config['icon_class'],
                        'categories' => json_encode($widget_config['categories']),
                    ];
                }
            }
        }

        $config['promotionWidgets'] = array_merge($promotion_widgets, $hq_promotional_widgets);

        return $config;
    }

}
