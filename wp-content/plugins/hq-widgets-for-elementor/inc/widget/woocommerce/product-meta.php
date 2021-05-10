<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Product_Meta extends Widget_Base {

    public function get_name() {
        return 'hq-woocommerce-product-meta';
    }

    public function get_title() {
        return __('Woo Product Meta', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-metadata';
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'meta', 'data', 'product'];
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
                'section_product_meta_style',
                [
                    'label' => __('Style', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'wc_style_warning',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __('The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'hq-widgets-for-elementor'),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        $this->add_control(
                'view',
                [
                    'label' => __('View', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => false,
                    'default' => 'inline',
                    'options' => [
                        'table' => __('Table', 'hq-widgets-for-elementor'),
                        'stacked' => __('Stacked', 'hq-widgets-for-elementor'),
                        'inline' => __('Inline', 'hq-widgets-for-elementor'),
                    ],
                    'prefix_class' => 'elementor-woo-meta--view-',
                ]
        );

        $this->add_responsive_control(
                'space_between',
                [
                    'label' => __('Space Between', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}:not(.elementor-woo-meta--view-inline) .product_meta .detail-container:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
                        '{{WRAPPER}}:not(.elementor-woo-meta--view-inline) .product_meta .detail-container:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
                        '{{WRAPPER}}.elementor-woo-meta--view-inline .product_meta .detail-container' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
                        '{{WRAPPER}}.elementor-woo-meta--view-inline .product_meta' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
                        'body:not(.rtl) {{WRAPPER}}.elementor-woo-meta--view-inline .detail-container:after' => 'right: calc( (-{{SIZE}}{{UNIT}}/2) + (-{{divider_weight.SIZE}}px/2) )',
                        'body:not.rtl {{WRAPPER}}.elementor-woo-meta--view-inline .detail-container:after' => 'left: calc( (-{{SIZE}}{{UNIT}}/2) - ({{divider_weight.SIZE}}px/2) )',
                    ],
                ]
        );

        $this->add_control(
                'divider',
                [
                    'label' => __('Divider', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __('Off', 'hq-widgets-for-elementor'),
                    'label_on' => __('On', 'hq-widgets-for-elementor'),
                    'selectors' => [
                        '{{WRAPPER}} .product_meta .detail-container:not(:last-child):after' => 'content: ""',
                    ],
                    'return_value' => 'yes',
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'divider_style',
                [
                    'label' => __('Style', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'solid' => __('Solid', 'hq-widgets-for-elementor'),
                        'double' => __('Double', 'hq-widgets-for-elementor'),
                        'dotted' => __('Dotted', 'hq-widgets-for-elementor'),
                        'dashed' => __('Dashed', 'hq-widgets-for-elementor'),
                    ],
                    'default' => 'solid',
                    'condition' => [
                        'divider' => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}}:not(.elementor-woo-meta--view-inline) .product_meta .detail-container:not(:last-child):after' => 'border-top-style: {{VALUE}}',
                        '{{WRAPPER}}.elementor-woo-meta--view-inline .product_meta .detail-container:not(:last-child):after' => 'border-left-style: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'divider_weight',
                [
                    'label' => __('Weight', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 1,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 20,
                        ],
                    ],
                    'condition' => [
                        'divider' => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}}:not(.elementor-woo-meta--view-inline) .product_meta .detail-container:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}; margin-bottom: calc(-{{SIZE}}{{UNIT}}/2)',
                        '{{WRAPPER}}.elementor-woo-meta--view-inline .product_meta .detail-container:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_responsive_control(
                'divider_width',
                [
                    'label' => __('Width', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['%', 'px'],
                    'default' => [
                        'unit' => '%',
                    ],
                    'condition' => [
                        'divider' => 'yes',
                        'view!' => 'inline',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .product_meta .detail-container:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_control(
                'divider_height',
                [
                    'label' => __('Height', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['%', 'px'],
                    'default' => [
                        'unit' => '%',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    'condition' => [
                        'divider' => 'yes',
                        'view' => 'inline',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .product_meta .detail-container:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_control(
                'divider_color',
                [
                    'label' => __('Color', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ddd',
                    'condition' => [
                        'divider' => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .product_meta .detail-container:not(:last-child):after' => 'border-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'heading_text_style',
                [
                    'label' => __('Text', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'selector' => '{{WRAPPER}}',
                ]
        );

        $this->add_control(
                'text_color',
                [
                    'label' => __('Color', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'heading_link_style',
                [
                    'label' => __('Link', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'link_typography',
                    'selector' => '{{WRAPPER}} a',
                ]
        );

        $this->add_control(
                'link_color',
                [
                    'label' => __('Color', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_product_meta_captions',
                [
                    'label' => __('Captions', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'heading_category_caption',
                [
                    'label' => __('Category', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'category_caption_single',
                [
                    'label' => __('Singular', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __('Category', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'category_caption_plural',
                [
                    'label' => __('Plural', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __('Categories', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'heading_tag_caption',
                [
                    'label' => __('Tag', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'tag_caption_single',
                [
                    'label' => __('Singular', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __('Tag', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'tag_caption_plural',
                [
                    'label' => __('Plural', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __('Tags', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'heading_sku_caption',
                [
                    'label' => __('SKU', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'sku_caption',
                [
                    'label' => __('SKU', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __('SKU', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'sku_missing_caption',
                [
                    'label' => __('Missing', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __('N/A', 'hq-widgets-for-elementor'),
                ]
        );

        $this->end_controls_section();
    }

    private function get_plural_or_single($single, $plural, $count) {
        return 1 === $count ? $single : $plural;
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }
        
        global $product;

        $product = wc_get_product();

        if (empty($product)) {
            return;
        }

        $sku = $product->get_sku();

        $settings = $this->get_settings_for_display();
        $sku_caption = !empty($settings['sku_caption']) ? $settings['sku_caption'] : __('SKU', 'hq-widgets-for-elementor');
        $sku_missing = !empty($settings['sku_missing_caption']) ? $settings['sku_missing_caption'] : __('N/A', 'hq-widgets-for-elementor');
        $category_caption_single = !empty($settings['category_caption_single']) ? $settings['category_caption_single'] : __('Category', 'hq-widgets-for-elementor');
        $category_caption_plural = !empty($settings['category_caption_plural']) ? $settings['category_caption_plural'] : __('Categories', 'hq-widgets-for-elementor');
        $tag_caption_single = !empty($settings['tag_caption_single']) ? $settings['tag_caption_single'] : __('Tag', 'hq-widgets-for-elementor');
        $tag_caption_plural = !empty($settings['tag_caption_plural']) ? $settings['tag_caption_plural'] : __('Tags', 'hq-widgets-for-elementor');
        ?>
        <div class="product_meta">

            <?php do_action('woocommerce_product_meta_start'); ?>

            <?php if (wc_product_sku_enabled() && ( $sku || $product->is_type('variable') )) : ?>
                <span class="sku_wrapper detail-container"><span class="detail-label"><?php echo esc_html($sku_caption); ?></span> <span class="sku"><?php echo $sku ? $sku : esc_html($sku_missing); ?></span></span>
            <?php endif; ?>

            <?php if (count($product->get_category_ids())) : ?>
                <span class="posted_in detail-container"><span class="detail-label"><?php echo esc_html($this->get_plural_or_single($category_caption_single, $category_caption_plural, count($product->get_category_ids()))); ?></span> <span class="detail-content"><?php echo get_the_term_list($product->get_id(), 'product_cat', '', ', '); ?></span></span>
            <?php endif; ?>

            <?php if (count($product->get_tag_ids())) : ?>
                <span class="tagged_as detail-container"><span class="detail-label"><?php echo esc_html($this->get_plural_or_single($tag_caption_single, $tag_caption_plural, count($product->get_tag_ids()))); ?></span> <span class="detail-content"><?php echo get_the_term_list($product->get_id(), 'product_tag', '', ', '); ?></span></span>
                <?php endif; ?>

            <?php do_action('woocommerce_product_meta_end'); ?>

        </div>
        <?php
    }

    public function render_plain_content() {
        
    }

}
