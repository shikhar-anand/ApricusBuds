<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use HQLib\Utils;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Product_Categories_Grid extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-woocommerce-product-categories-grid', PLUGIN_URL . 'assets/widgets/woocommerce/product-categories-grid/style.css', [], VERSION);
    }

    protected $_has_template_content = false;

    public function get_name() {
        return 'hq-woocommerce-product-categories-grid';
    }

    public function get_title() {
        return __('Woo Product Categories Grid', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-grid';
    }

    public function get_style_depends() {
        return ['hqt-widgets', 'hq-woocommerce-product-categories-grid'];
    }

    public function get_keywords() {
        return ['woocommerce-elements', 'shop', 'store', 'categories', 'grid', 'product'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    protected function _register_controls() {
        if (!defined('WC_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Woocommerce', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('WooCommerce plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')), __('Install WooCommerce.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }
        
        $this->start_controls_section(
                'section_layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_responsive_control(
                'columns', [
            'label' => __('Columns', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'max' => 12,
                ]
        );

        $this->add_control(
                'number', [
            'label' => __('Categories Count', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
                ]
        );

        $this->add_control(
                'show_count', [
            'label' => __('Count', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => 'Show',
            'label_off' => 'Hide',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_filter', [
            'label' => __('Query', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'source', [
            'label' => __('Source', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => __('Show All', 'hq-widgets-for-elementor'),
                'by_id' => __('Manual Selection', 'hq-widgets-for-elementor'),
                'by_parent' => __('By Parent', 'hq-widgets-for-elementor'),
                'current_subcategories' => __('Current Subcategories', 'hq-widgets-for-elementor'),
            ],
            'label_block' => true,
                ]
        );

        // Get categories
        $categories = get_terms('product_cat');

        // Prepare options
        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }

        $this->add_control(
                'categories', [
            'label' => __('Categories', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'options' => $options,
            'default' => [],
            'label_block' => true,
            'multiple' => true,
            'condition' => [
                'source' => 'by_id',
            ],
                ]
        );

        $parent_options = ['0' => __('Only Top Level', 'hq-widgets-for-elementor')] + $options;
        $this->add_control(
                'parent', [
            'label' => __('Parent', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '0',
            'options' => $parent_options,
            'condition' => [
                'source' => 'by_parent',
            ],
                ]
        );

        $this->add_control(
                'orderby', [
            'label' => __('Order By', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'name',
            'options' => [
                'name' => __('Name', 'hq-widgets-for-elementor'),
                'slug' => __('Slug', 'hq-widgets-for-elementor'),
                'description' => __('Description', 'hq-widgets-for-elementor'),
                'count' => __('Count', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control(
                'order', [
            'label' => __('Order', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'desc',
            'options' => [
                'asc' => __('ASC', 'hq-widgets-for-elementor'),
                'desc' => __('DESC', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control(
                'hide_empty', [
            'label' => __('Hide Empty', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => 'Hide',
            'label_off' => 'Show',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_product_style', [
            'label' => __('Products', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'column_gap', [
            'label' => __('Columns Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 20,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ul.grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'row_gap', [
            'label' => __('Rows Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 40,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ul.grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .product' => 'text-align: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'product_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'product_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'product_border',
            'selector' => '{{WRAPPER}} .product',
                ]
        );

        $this->start_controls_tabs('product_tabs');

        $this->start_controls_tab(
                'tab_product_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'product_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'product_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .product',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_product_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );
        
        $this->add_control(
                'product_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'product_hover_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .product:hover',
                ]
        );

        $this->add_control(
                'product_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'section_image_style', [
            'label' => __('Image', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'image_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} a > img' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'image_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} a > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'image_border',
            'selector' => '{{WRAPPER}} a > img',
                ]
        );

        $this->start_controls_tabs('image_tabs');

        $this->start_controls_tab(
                'tab_image_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'image_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} a > img',
                ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
                'tab_image_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'image_hover_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} a > img:hover',
                ]
        );

        $this->add_control(
                'image_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a > img:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'section_title_style', [
            'label' => __('Title', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .woocommerce-loop-category__title',
                ]
        );

        $this->start_controls_tabs('title_tabs');

        $this->start_controls_tab(
                'tab_title_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'title_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-loop-category__title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_title_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'title_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-loop-category__title:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'heading_count_style', [
            'label' => __('Count', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'show_count' => 'yes'
            ]
                ]
        );

        $this->add_control(
                'count_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-loop-category__title .count' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'show_count' => 'yes'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'count_typography',
            'selector' => '{{WRAPPER}} .woocommerce-loop-category__title .count',
            'condition' => [
                'show_count' => 'yes'
            ]
                ]
        );

        $this->end_controls_section();
    }

    private function get_shortcode() {
        $settings = $this->get_settings();

        $attributes = [
            'number' => $settings['number'],
            'columns' => $settings['columns'],
            'hide_empty' => ( 'yes' === $settings['hide_empty'] ) ? 1 : 0,
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
        ];

        if ('by_id' === $settings['source']) {
            $attributes['ids'] = implode(',', $settings['categories']);
        } elseif ('by_parent' === $settings['source']) {
            $attributes['parent'] = $settings['parent'];
        } elseif ('current_subcategories' === $settings['source']) {
            $attributes['parent'] = get_queried_object_id();
        }

        $this->add_render_attribute('shortcode', $attributes);

        $shortcode = sprintf('[product_categories %s]', $this->get_render_attribute_string('shortcode'));

        return $shortcode;
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }
        
        $settings = $this->get_settings();

        if (!$settings['show_count']) {
            add_filter('woocommerce_subcategory_count_html', function() {
                return '';
            });
        }

        $attributes = [
            'number' => $settings['number'],
            'columns' => $settings['columns'],
            'hide_empty' => ( 'yes' === $settings['hide_empty'] ) ? 1 : 0,
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
        ];

        if ('by_id' === $settings['source']) {
            $attributes['ids'] = implode(',', $settings['categories']);
        } elseif ('by_parent' === $settings['source']) {
            $attributes['parent'] = $settings['parent'];
        } elseif ('current_subcategories' === $settings['source']) {
            $attributes['parent'] = get_queried_object_id();
        }

        if (isset($attributes['number'])) {
            $attributes['limit'] = $attributes['number'];
        }

        $atts = shortcode_atts(array(
            'limit' => '-1',
            'orderby' => 'name',
            'order' => 'ASC',
            'columns' => '4',
            'hide_empty' => 1,
            'parent' => '',
            'ids' => '',
                ), $attributes, 'product_categories');

        $ids = array_filter(array_map('trim', explode(',', $atts['ids'])));
        $hide_empty = ( true === $atts['hide_empty'] || 'true' === $atts['hide_empty'] || 1 === $atts['hide_empty'] || '1' === $atts['hide_empty'] ) ? 1 : 0;

        // Get terms and workaround WP bug with parents/pad counts.
        $args = array(
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'hide_empty' => $hide_empty,
            'include' => $ids,
            'pad_counts' => true,
            'child_of' => $atts['parent'],
        );

        $product_categories = apply_filters(
                'woocommerce_product_categories', get_terms('product_cat', $args)
        );

        if ('' !== $atts['parent']) {
            $product_categories = wp_list_filter($product_categories, array(
                'parent' => $atts['parent'],
            ));
        }

        if ($hide_empty) {
            foreach ($product_categories as $key => $category) {
                if (0 === $category->count) {
                    unset($product_categories[$key]);
                }
            }
        }

        $atts['limit'] = '-1' === $atts['limit'] ? null : intval($atts['limit']);
        if ($atts['limit']) {
            $product_categories = array_slice($product_categories, 0, $atts['limit']);
        }

        $columns = absint($atts['columns']);

        wc_set_loop_prop('columns', $columns);
        wc_set_loop_prop('is_shortcode', true);

        $this->add_render_attribute(
                'grid-container', 'class', [
            'grid-container',
            'columns-' . $settings['columns'],
            'columns-tablet-' . $settings['columns_tablet'],
            'columns-mobile-' . $settings['columns_mobile'],
                ]
        );

        Utils::editor_start_woocommerce_section();

        if ($product_categories) {
            ob_start();

            wc_set_loop_prop('loop', 0);
            ?>

            <ul <?php echo $this->get_render_attribute_string('grid-container'); ?>>

                <?php
                $loop_start = apply_filters('woocommerce_product_loop_start', ob_get_clean());
                echo $loop_start;

                foreach ($product_categories as $category) {
                    wc_get_template('content-product_cat.php', array(
                        'category' => $category,
                    ));
                }

                ob_start();
                ?>

            </ul>

            <?php
            $loop_end = apply_filters('woocommerce_product_loop_end', ob_get_clean());
            echo $loop_end;
        }

        woocommerce_reset_loop();

        Utils::editor_end_woocommerce_section();
    }

}
