<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use HQLib\Utils;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Archive_Product_Add_To_Cart extends Widget_Button {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script('hq-woocommerce-archive-product-add-to-cart', PLUGIN_URL . 'assets/widgets/woocommerce/archive-product-add-to-cart/script.js', ['elementor-frontend'], VERSION, true);
        wp_register_style('hq-woocommerce-archive-product-add-to-cart', PLUGIN_URL . 'assets/widgets/woocommerce/archive-product-add-to-cart/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-woocommerce-archive-product-add-to-cart';
    }

    public function get_title() {
        return __('Woo Archive Product Add To Cart', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-archive-product-add-to-cart';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'archive', 'cart', 'product', 'button', 'add to cart'];
    }

    public function get_script_depends() {
        return ['hq-woocommerce-archive-product-add-to-cart'];
    }

    public function get_style_depends() {
        return ['hq-woocommerce-archive-product-add-to-cart'];
    }

    public function disable_esc_html($safe_text, $text) {
        return $text;
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

        // Test Post Type Section
        $this->start_controls_section(
                'section_test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Explanation
        $this->add_control(
                'test_post_item_alert', [
            'raw' => __('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        $args = [
            'post_type' => 'product'
        ];
        // Test Post Item
        $this->add_control(
                'test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'label_block' => true,
            'default' => [],
            'options' => Utils::get_posts($args),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_quantity', [
            'label' => __('Texts & Quantity', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'button_text_simple', [
            'label' => __('Simple Product', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Add to cart', 'hq-widgets-for-elementor'),
            'placeholder' => __('Add to cart', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'button_text_variable', [
            'label' => __('Variable Product', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Select options', 'hq-widgets-for-elementor'),
            'placeholder' => __('Select options', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'button_text_grouped', [
            'label' => __('Grouped Product', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('View products', 'hq-widgets-for-elementor'),
            'placeholder' => __('View products', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'button_text_external', [
            'label' => __('External/Affiliate Product', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Buy product', 'hq-widgets-for-elementor'),
            'placeholder' => __('Buy product', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'quantity', [
            'label' => __('Quantity', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 1,
            'separator' => 'before'
                ]
        );

        $this->end_controls_section();

        parent::_register_controls();

        $this->remove_control('button_type');
        $this->remove_control('link');
        $this->remove_control('text');
        $this->remove_control('selected_icon');
        $this->remove_control('icon_align');

        $this->update_control(
                'size', [
            'frontend_available' => true,
                ]
        );

        $this->start_controls_section(
                'section_button_view_cart', [
            'label' => __('View Cart Button', 'hq-widgets-for-elementor'),
                ]
        );

        // Explanation
        $this->add_control(
                'view_cart_description', [
            'raw' => __('View cart button is available only if AJAX add to cart behaviour is enabled.', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        $this->add_control(
                'show_view_cart', [
            'label' => __('Show View Cart Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'show-view-cart-',
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'default' => 'yes'
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_view_cart_button', [
            'label' => __('View Cart Button', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_view_cart' => 'yes'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'view_cart_typography',
            'selector' => '{{WRAPPER}} a.added_to_cart',
                ]
        );

        $this->start_controls_tabs('tabs_view_cart_button_style');

        $this->start_controls_tab(
                'tab_view_cart_button_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'view_cart_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'view_cart_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_view_cart_button_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'view_cart_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart:hover, {{WRAPPER}} a.added_to_cart:focus' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'view_cart_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart:hover, {{WRAPPER}} a.added_to_cart:focus' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'view_cart_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart:hover, {{WRAPPER}} a.added_to_cart:focus' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'view_cart_border',
            'selector' => '{{WRAPPER}} a.added_to_cart',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'view_cart_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'view_cart_box_shadow',
            'selector' => '{{WRAPPER}} a.added_to_cart',
                ]
        );

        $this->add_responsive_control(
                'view_cart_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings_for_display();

        global $product;
        $product = wc_get_product();

        // Prepare test item for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            if (!$settings['test_post_item']) {
                ?>
                <div class="elementor-alert elementor-alert-info" role="alert">
                    <span class="elementor-alert-title">
                        <?php esc_html_e('Please select Test Item', 'hq-widgets-for-elementor'); ?>
                    </span>
                    <span class="elementor-alert-description">
                        <?php esc_html_e('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'); ?>
                    </span>
                </div>
                <?php
                return;
            }
            Plugin::instance()->db->switch_to_post($settings['test_post_item']);

            $product = wc_get_product($settings['test_post_item']);
        }

        if (!$product) {
            return;
        }
        setup_postdata($product->get_id());

        $this->render_form_button($product);
    }

    public function hq_woocommerce_product_add_to_cart_text() {
        $settings = $this->get_settings_for_display();

        global $product;
        $product_type = $product->get_type();
        switch ($product_type) {
            case 'external':
                return !empty($settings['button_text_external']) ? __($settings['button_text_external'], 'hq-widgets-for-elementor') : __('Buy product', 'hq-widgets-for-elementor');
                break;
            case 'grouped':
                return !empty($settings['button_text_grouped']) ? __($settings['button_text_grouped'], 'hq-widgets-for-elementor') : __('View products', 'hq-widgets-for-elementor');
                break;
            case 'simple':
                return !empty($settings['button_text_simple']) ? __($settings['button_text_simple'], 'hq-widgets-for-elementor') : __('Add to cart', 'hq-widgets-for-elementor');
                break;
            case 'variable':
                return !empty($settings['button_text_variable']) ? __($settings['button_text_variable'], 'hq-widgets-for-elementor') : __('Select options', 'hq-widgets-for-elementor');
                break;
            default:
                return __('Read more', 'hq-widgets-for-elementor');
        }
    }

    protected function render_form_button($product) {
        $settings = $this->get_settings_for_display();
        if (!$product && current_user_can('manage_options')) {
            _e('Please set a product', 'hq-widgets-for-elementor');
            return;
        }

        $args = [
            'class' => implode(
                    ' ', array_filter(
                            array(
                                'elementor-button' . (!empty($settings['size']) ? ' ' . 'elementor-size-' . $settings['size'] : ''),
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            )
                    )
            ),
        ];
        if (!empty($settings['quantity'])) {
            $args['quantity'] = $settings['quantity'];
        }

        add_filter('woocommerce_product_add_to_cart_text', [$this, 'hq_woocommerce_product_add_to_cart_text'], 10, 2);

        woocommerce_template_loop_add_to_cart($args);

        remove_filter('woocommerce_product_add_to_cart_text', [$this, 'hq_woocommerce_product_add_to_cart_text'], 10, 2);
    }

    protected function _content_template() {
        
    }

}
