<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Woocommerce\Product_Add_To_Cart;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Add_To_Cart extends Product_Add_To_Cart {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script('hq-woocommerce-add-to-cart', PLUGIN_URL . 'assets/widgets/woocommerce/add-to-cart/script.js', ['elementor-frontend'], VERSION, true);
        wp_register_style('hq-woocommerce-add-to-cart', PLUGIN_URL . 'assets/widgets/woocommerce/add-to-cart/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-woocommerce-add-to-cart';
    }

    public function get_title() {
        return __('Woo Add To Cart', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-add-to-cart';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'cart', 'product', 'button', 'add to cart'];
    }

    public function get_script_depends() {
        return ['hq-woocommerce-add-to-cart'];
    }

    public function get_style_depends() {
        return ['hq-woocommerce-add-to-cart'];
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
                'section_product_item', [
            'label' => __('Product Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $args = [
            'post_type' => 'product'
        ];
        // Test Post Item
        $this->add_control(
                'product_item', [
            'label' => __('Product', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'label_block' => true,
            'default' => [],
            'options' => Utils::get_posts($args),
                ]
        );

        $this->end_controls_section();

        parent::_register_controls();
        $this->update_control('alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'prefix_class' => 'elementor-align-',
            'condition' => [
                'button_stretch!' => 'yes',
            ],
        ]);
        $this->remove_control('section_test_post_item');
        $this->update_control('show_quantity', ['type' => Controls_Manager::HIDDEN, 'default' => '']);
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings_for_display();

        // Prepare test item for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            if (!$settings['product_item']) {
                ?>
                <div class="elementor-alert elementor-alert-info" role="alert">
                    <span class="elementor-alert-title">
                        <?php esc_html_e('Woo Add To Cart', 'hq-widgets-for-elementor'); ?>
                    </span>
                    <span class="elementor-alert-description">
                        <?php esc_html_e('Select Product Item.', 'hq-widgets-for-elementor'); ?>
                    </span>
                </div>
                <?php
                return;
            }
        }

        $product = wc_get_product($settings['product_item']);

        if (!$product) {
            return;
        }
        setup_postdata($product->get_id());

        parent::render_ajax_button($product);
    }

    protected function _content_template() {
        
    }

}
